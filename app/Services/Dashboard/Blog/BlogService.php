<?php

namespace App\Services\Dashboard\Blog;

use App\Helper\Media;
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
        $blogCategories = BlogCategory::select('id','name')->get();
        return $blogCategories;
    }

    public function edit()
    {
        $blogCategories = BlogCategory::select('id','name')->get();
        return $blogCategories;
    }

    public function store($dataValidated){
        DB::beginTransaction();

        try {
            // Add other non-translatable fields here
            $data = [
                'status' => $dataValidated['status'],
                'home' => $dataValidated['home']??0,
                'menu' => $dataValidated['menu']??0,
                'blog_category_id' => $dataValidated['blog_category_id'],
            ];

            $blog = Blog::create($data);

            // Handle translations for fields (name, slug, meta_title, meta_desc, desc)
            $blog->handleTranslations(
                $dataValidated,
                ['name', 'slug', 'meta_title', 'meta_desc', 'short_desc','long_desc'], // custom fields
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

    public function update($request, $dataValidated, $blog){
        DB::beginTransaction();

        try {
            // Update the category data (status, index, etc.)
            $data = [
                'status' => $dataValidated['status'],
                'blog_category_id' => $dataValidated['blog_category_id'],
                'index' => $dataValidated['index']?? 0,
                'home' => $dataValidated['home']??0,
                'menu' => $dataValidated['menu']??0,
            ];

            // Update the category with the new validated data
            $blog->update($data);

            // Handle translations for fields (name, slug, meta_title, meta_desc, desc)
            $blog->handleTranslations(
                $dataValidated,
                ['name', 'slug', 'meta_title', 'meta_desc', 'short_desc','long_desc'], // custom fields
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

    public function deleteBlogs($selectedIds){
        $blogs = Blog::whereIn('id', $selectedIds)->get();

        DB::beginTransaction();
        try {
            foreach ($blogs as $blog) {
                // Delete associated image if it exists
                if ($blog->image) {
                    Media::removeFile('blogs', $blog->image);
                }
            }
            $deleted = Blog::whereIn('id', $selectedIds)->delete();

            DB::commit();

            return $deleted > 0;

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

        // Process each FAQ entry
        foreach ($faqIds as $index => $faqId) {
            $faqData = [
                'blog_id' => $blog->id,
                'question' => [],
                'answer' => []
            ];

            // Collect translations for each language
            foreach ($languages as $lang => $languageName) {
                $faqData['question'][$lang] = $data["question_{$lang}"][$index] ?? null;
                $faqData['answer'][$lang] = $data["answer_{$lang}"][$index] ?? null;
            }

            // Update existing or create new FAQ
            if (!empty($faqId)) {
                $faq = BlogFaq::find($faqId);
                if ($faq) {
                    $this->updateFaq($faq, $faqData);
                }
            } else {
                $this->createFaq($blog, $faqData);
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
