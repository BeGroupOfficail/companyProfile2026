<?php

namespace App\Services\Dashboard\Faq;

use App\Helper\Media;
use App\Models\Dashboard\Faq;
use Illuminate\Support\Facades\DB;

class FaqService
{
    public function update($request, $faqs){
        DB::beginTransaction();

        try {
            // Handle FAQs
            $this->processBlogFaqs($faqs, $request->all());

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    protected function processBlogFaqs($faqs, array $data)
    {
        $languages = config('languages');
        $faqIds = $data['faq_ids'] ?? [];
        $existingFaqIds = $faqs->pluck('id')->toArray();

        // Process each FAQ entry
        foreach ($faqIds as $index => $faqId) {
            $faqData = [
                'question' => [],
                'answer' => [],
                'status' => [],
            ];

            // Collect translations for each language
            foreach ($languages as $lang => $languageName) {
                $faqData['question'][$lang] = $data["question_{$lang}"][$index] ?? null;
                $faqData['answer'][$lang] = $data["answer_{$lang}"][$index] ?? null;
            }

            // Update existing or create new FAQ
            if (!empty($faqId)) {
                $faq = Faq::find($faqId);
                if ($faq) {
                    $this->updateFaq($faq, $faqData);
                }
            } else {
                $this->createFaq($faqData);
            }
        }

        // Delete FAQs that were removed
        $faqsToDelete = array_diff($existingFaqIds, array_filter($faqIds));
        if (!empty($faqsToDelete)) {
            Faq::whereIn('id', $faqsToDelete)->delete();
        }
    }

    protected function updateFaq(Faq $faq, array $data)
    {
        foreach ($data['question'] as $lang => $question) {
            $faq->setTranslation('question', $lang, $question);
        }

        foreach ($data['answer'] as $lang => $answer) {
            $faq->setTranslation('answer', $lang, $answer);
        }

        $faq->save();
    }

    protected function createFaq(Faq $faq, array $data)
    {
        $faq = new Faq(['id' => $faq->id]);

        foreach ($data['question'] as $lang => $question) {
            $faq->setTranslation('question', $lang, $question);
        }

        foreach ($data['answer'] as $lang => $answer) {
            $faq->setTranslation('answer', $lang, $answer);
        }

        foreach ($data['status'] as $status) {
            //
        }

        $faq->save();
    }

    protected function deleteRemovedFaqs(Faq $faq, array $currentFaqIds)
    {
        $existingFaqIds = $faq->pluck('id')->toArray();
        $idsToDelete = array_diff($existingFaqIds, $currentFaqIds);

        if (!empty($idsToDelete)) {
            Faq::whereIn('id', $idsToDelete)->delete();
        }
    }
}
