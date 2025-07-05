<?php

namespace App\Http\Controllers\Dashboard\Album;

use App\DataTables\Album\AlbumDataTable;
use App\Helper\Media;
use App\Http\Controllers\Controller;
use App\Models\Dashboard\Album\Album;
use App\Services\Dashboard\Album\AlbumImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlbumImageController extends Controller
{
    protected $albumImageService;

    public function __construct(AlbumImageService $albumImageService)
    {
        $this->albumImageService = $albumImageService;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $album = Album::find($id);
        $this->albumImageService->edit();
        return view('Dashboard.AlbumImages.upload_images', compact('album'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        try {
            $this->albumImageService->store($id);

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
            $this->albumImageService->deleteImage($id);

            return response()->json([
                'success' => true,
                'message' => __('dash.image_deleted_successfully')
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
            $result = $this->albumImageService->changeStatus($request, $id);

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


    public function uploadImages(Request $request){
        $this->albumImageService->uploadImages($request);
    }

    public function removeUploadImages(Request $request){
        $this->albumImageService->removeUploadImages($request);
    }

    public function updateOrder(Request $request, $id)
    {
        $this->albumImageService->updateOrder($request, $id);
    }

}
