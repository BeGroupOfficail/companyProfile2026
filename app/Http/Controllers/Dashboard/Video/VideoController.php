<?php

namespace App\Http\Controllers\Dashboard\Video;

use App\DataTables\Video\VideoDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Video\VideoRequest;
use App\Models\Dashboard\Video\Video;
use App\Services\Dashboard\Video\VideoService;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    protected $videoService;

    public function __construct(VideoService $videoService)
    {
        $this->videoService = $videoService;

        $this->middleware('can:videos.read')->only('index');
        $this->middleware('can:videos.create')->only('store');
        $this->middleware('can:videos.update')->only('update');
        $this->middleware('can:videos.delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(VideoDataTable $dataTable)
    {
        return $dataTable->render('Dashboard.Videos.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Dashboard.Videos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VideoRequest $request)
    {
        try {
            $dataValidated = $request->validated();

            $this->videoService->store($dataValidated);

            return redirect()->route('videos.index')->with(['success' => __('messages.your_item_added_successfully')]);
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
    public function edit(Video $video)
    {
        return view('Dashboard.Videos.edit', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VideoRequest $request, Video $video)
    {
        try {
            $dataValidated = $request->validated();
            $this->videoService->update($request, $dataValidated, $video);

            return redirect()->route('videos.index')->with(['success' => __('messages.your_item_added_successfully')]);
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
            'selectedIds.*' => ['exists:videos,id']
        ]);

        $deleted = $this->videoService->deleteVideos($selectedIds);

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
