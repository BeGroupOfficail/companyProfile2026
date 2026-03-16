<?php

namespace App\Http\Controllers\Dashboard\Album;

use App\DataTables\Album\AlbumDataTable;
use App\Helper\Media;
use App\Http\Controllers\Controller;
use App\Models\Dashboard\Album\Album;
use App\Services\Dashboard\Album\AlbumVideoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlbumVideoController extends Controller
{
    protected $albumVideoService;

    public function __construct(AlbumVideoService $albumVideoService)
    {
        $this->albumVideoService = $albumVideoService;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $album = Album::find($id);
        return view('Dashboard.AlbumVideos.upload_videos', compact('album'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        try {
            $this->albumVideoService->store($request ,$id);

            return redirect()->back()
                ->with([
                    'success' => __('messages.your_item_added_successfully'),
                    'reload' => true
                ]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,$id){

        try {
            $this->albumVideoService->deleteVideo($id);

            return response()->json([
                'success' => true,
                'message' => __('dash.video_deleted_successfully')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'success' => false,
                'message' => $e->getMessage(),
                'exception' => get_class($e)
            ], 500);
        }
    }

    /**
     * change status the specified resource from storage.
     */
    public function changeStatus(Request $request,$id){

        try {
            $result = $this->albumVideoService->changeStatus($request, $id);

            return response()->json([
                'success' => true,
                'message' => __('dash.status_updated_successfully'),
                'new_status' => $result['new_status'],
                'status_label' => $result['status_label'],
                'status_class' => $result['status_class']

            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'success' => false,
                'message' => $e->getMessage(),
                'exception' => get_class($e)
            ], 500);
        }
    }

    public function updateOrder(Request $request, $id)
    {
        $this->albumVideoService->updateOrder($request, $id);
    }

}
