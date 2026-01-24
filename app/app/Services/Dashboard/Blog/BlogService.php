<?php

namespace App\Services\Dashboard\Blog;

use App\Helper\Media;
use App\Helper\SoftDeleteHelper;
use App\Models\Dashboard\Blog\Blog;
use App\Models\Dashboard\Blog\BlogCategory;
use App\Models\Dashboard\Blog\BlogFaq;
use Illuminate\Support\Facades\DB;

class BlogService
{
    public function index()
    {
        return Blog::with('blogCategory')->get();
    }
    public function create()
    {
        $blogCategories = BlogCategory::select('id', 'name')->get();
        return $blogCategories;
    }

    public function edit()
    {
        $blogCategories = BlogCategory::select('id', 'name')->get();
        return $blogCategories;
    }

    public function store($dataValidated)
    {
        DB::beginTransaction();

        try {
            // Add other non-translatable fields here
            $data = [
                'status' => $dataValidated['status'],
                'home' => $dataValidated['home'] ?? 0,
                'menu' => $dataValidated['menu'] ?? 0,
                'order_date'=> $dataValidated['order_date'] ?? now(),
                'blog_category_id' => $dataValidated['blog_category_id'],
            ];

            $blog = Blog::create($data);

            // Handle translations for fields (name, slug, meta_title, meta_desc, desc)
            $blog->handleTranslations(
                $dataValidated,
                ['name', 'slug', 'short_desc', 'long_desc'], // custom fields
                true // auto-generate slug
            );

            // Handle media uploads (icon and image)
            $blog->handleMedia(
                request(), // Pass the current request
                $dataValidated,
                'blogs', // media type (storage folder)
                ['image'] // optional - specify which media fields to handle
            );

            DB::commit();

            return $blog;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($request, $dataValidated, $blog)
    {
        DB::beginTransaction();

        try {
            // Update the category data (status, index, etc.)
            $data = [
                'status' => $dataValidated['status'],
                'blog_category_id' => $dataValidated['blog_category_id'],
                'order_date'=> $dataValidated['order_date'] ?? now(),
                'home' => $dataValidated['home'] ?? 0,
                'menu' => $dataValidated['menu'] ?? 0,
            ];

            // Update the category with the new validated data
            $blog->update($data);

            // Handle translations for fields (name, slug, meta_title, meta_desc, desc)
            $blog->handleTranslations(
                $dataValidated,
                ['name', 'slug', 'short_desc', 'long_desc'], // custom fields
                true // auto-generate slug
            );

            // Handle media uploads (icon and image)
            $blog->handleMedia(
                request(), // Pass the current request
                $dataValidated,
                'blogs', // media type (storage folder)
                ['image'] // optional - specify which media fields to handle
            );

            // Handle FAQs
            $this->processBlogFaqs($blog, $request->all());

            DB::commit();

            return $blog;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteBlogs($selectedIds)
    {

        DB::beginTransaction();
        try {
            $trashedBlogs = Blog::onlyTrashed()->whereIn('id', $selectedIds)->get();
            $activeBlogs = Blog::whereIn('id', $selectedIds)->get();
            if ($trashedBlogs->isNotEmpty()) {
                foreach ($trashedBlogs as $blog) {
                    if ($blog->image) {
                        Media::removeFile('blogs', $blog->image);
                    }
                }
                Blog::onlyTrashed()->whereIn('id', $trashedBlogs->pluck('id'))->forceDelete();
            }
            if ($activeBlogs->isNotEmpty()) {
                SoftDeleteHelper::deleteWithEvents(Blog::class, $activeBlogs->pluck('id')->toArray());
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }



    protected function processBlogFaqs(Blog $blog, array $data)
    {
        $languages = config('languages');
        $faqIds = $data['faq_ids'] ?? [];
        $existingFaqIds = $blog->blogFaqs()->pluck('id')->toArray();

        foreach ($faqIds as $index => $faqId) {
            $faqData = [
                'blog_id' => $blog->id,
                'question' => [],
                'answer' => []
            ];

            // Collect translations for each language
            foreach ($languages as $lang => $languageName) {
                $faqData['question'][$lang] = trim($data["question_{$lang}"][$index] ?? '');
                $faqData['answer'][$lang] = trim($data["answer_{$lang}"][$index] ?? '');
            }

            // Check if all questions & answers are empty
            $allEmpty = empty(array_filter($faqData['question'])) && empty(array_filter($faqData['answer']));

            if (!empty($faqId)) {
                $faq = BlogFaq::find($faqId);
                if ($faq) {
                    // Update only if not completely empty
                    if (!$allEmpty) {
                        $this->updateFaq($faq, $faqData);
                    } else {
                        // Delete if it exists but user cleared it
                        $faq->delete();
                    }
                }
            } else {
                // Create only if not empty
                if (!$allEmpty) {
                    $this->createFaq($blog, $faqData);
                }
            }
        }

        // Delete FAQs that were removed
        $faqsToDelete = array_diff($existingFaqIds, array_filter($faqIds));
        if (!empty($faqsToDelete)) {
            BlogFaq::whereIn('id', $faqsToDelete)->delete();
        }
    }


    protected function updateFaq(BlogFaq $faq, array $data)
    {
        foreach ($data['question'] as $lang => $question) {
            $faq->setTranslation('question', $lang, $question);
        }

        foreach ($data['answer'] as $lang => $answer) {
            $faq->setTranslation('answer', $lang, $answer);
        }

        $faq->save();
    }

    protected function createFaq(Blog $blog, array $data)
    {
        $faq = new BlogFaq(['blog_id' => $blog->id]);

        foreach ($data['question'] as $lang => $question) {
            $faq->setTranslation('question', $lang, $question);
        }

        foreach ($data['answer'] as $lang => $answer) {
            $faq->setTranslation('answer', $lang, $answer);
        }

        $faq->save();
    }

    protected function deleteRemovedFaqs(Blog $blog, array $currentFaqIds)
    {
        $existingFaqIds = $blog->faqs()->pluck('id')->toArray();
        $idsToDelete = array_diff($existingFaqIds, $currentFaqIds);

        if (!empty($idsToDelete)) {
            BlogFaq::whereIn('id', $idsToDelete)->delete();
        }
    }
}
