<?php

namespace App\Http\Controllers\Dashboard\Blog;

use App\DataTables\Blog\BlogDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Blogs\BlogRequest;
use App\Models\Dashboard\Blog\Blog;
use App\Models\Dashboard\Blog\BlogCategory;
use App\Models\Dashboard\Blog\BlogFaq;
use App\Services\Dashboard\Blog\BlogService;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    protected $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;

        $this->middleware('can:blogs.read')->only('index');
        $this->middleware('can:blogs.create')->only('store');
        $this->middleware('can:blogs.update')->only('update');
        $this->middleware('can:blogs.delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(BlogDataTable $dataTable)
    {
        return $dataTable->render('Dashboard.Blogs.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $blogCategories = $this->blogService->create();
        return view('Dashboard.Blogs.create', compact('blogCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogRequest $request)
    {
        try {
            $dataValidated = $request->validated();

            $blog = $this->blogService->store($dataValidated);

            return redirect()->route('blogs.edit', $blog->id)
                ->with(['success' => __('messages.your_item_added_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back ()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        $blogCategories = $this->blogService->edit();
                $blogFaq = Blog::with('blogFaqs')->find($blog->id);
                foreach ($blogFaq->dashboard_blogFaqs as $faq) {
                    $faq->question = $faq->getTranslation('question', app()->getLocale());
                    $faq->answer = $faq->getTranslation('answer', app()->getLocale());
                }
        return view('Dashboard.Blogs.edit', compact('blog','blogCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogRequest $request, Blog $blog)
    {
        try {
            $dataValidated = $request->validated();

            $this->blogService->update($request, $dataValidated, $blog);

            return redirect()->route('blogs.index')->with(['success' => __('messages.your_item_added_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' =>$e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $selectedIds = $request->input('selectedIds');

        $request->validate([
            'selectedIds' => ['array', 'min:1'],
            'selectedIds.*' => ['exists:blogs,id']
        ]);

        $deleted = $this->blogService->deleteBlogs($selectedIds);

        if (request()->ajax()) {
            if (!$deleted) {
                return response()->json(['message' => $deleted ?? __('messages.an messages.error entering data')], 422);
            }
            return response()->json(['success' => true, 'message' => trans('messages.your_items_deleted_successfully')]);
        }
        if (!$deleted) {
            return redirect()->back()->withErrors($delete ?? __('messages.an error has occurred. Please contact the developer to resolve the issue'));
        }
    }


    public function blogFaqDestroy(){
        try {
            $faq = BlogFaq::find($_POST['faqId']);
            $faq->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['message' => __('dashDelete failed')], 500);
        }
    }

    public function updateOrder(Request $request)
    {
        try {
            $order = $request->input('order');

            foreach ($order as $item) {
                Blog::where('id', $item['id'])
                    ->update(['order' => $item['order']]);
            }

            return response()->json(['success' => true, 'message' => __('dash.order_updated_successfully')]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => __('dash.error_updating_order')], 500);
        }
    }

}
