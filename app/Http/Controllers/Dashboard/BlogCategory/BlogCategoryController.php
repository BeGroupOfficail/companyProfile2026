<?php

namespace App\Http\Controllers\Dashboard\BlogCategory;

use App\DataTables\Blog\BlogCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\BlogCategories\BlogCategoryRequest;
use App\Models\Dashboard\Blog\BlogCategory;
use App\Services\Dashboard\BlogCategory\BlogCategoryService;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    protected $blogCategoryService;

    public function __construct(BlogCategoryService $blogCategoryService)
    {
        $this->blogCategoryService = $blogCategoryService;

        $this->middleware('can:blog_categories.read')->only('index');
        $this->middleware('can:blog_categories.create')->only('store');
        $this->middleware('can:blog_categories.update')->only('update');
        $this->middleware('can:blog_categories.delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(BlogCategoryDataTable $dataTable)
    {
        return $dataTable->render('Dashboard.BlogCategories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->blogCategoryService->create();
        return view('Dashboard.BlogCategories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogCategoryRequest $request)
    {
        try {
            $dataValidated = $request->validated();

            $this->blogCategoryService->store($dataValidated);

            return redirect()->route('blog-categories.index')->with(['success' => __('messages.your_item_added_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
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
    public function edit(BlogCategory $blogCategory)
    {
        $this->blogCategoryService->create();
        return view('Dashboard.BlogCategories.edit', compact('blogCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogCategoryRequest $request, BlogCategory $blogCategory)
    {
        try {
            $dataValidated = $request->validated();

            $this->blogCategoryService->update($request, $dataValidated, $blogCategory);

            return redirect()->route('blog-categories.index')->with(['success' => __('messages.your_item_added_successfully')]);
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
            'selectedIds.*' => ['exists:categories,id']
        ]);

        $deleted = $this->blogCategoryService->deleteBlogCategories($selectedIds);

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

}
