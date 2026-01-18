<?php

namespace App\Http\Controllers\Dashboard\Album;

use App\DataTables\Album\AlbumDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Albums\AlbumRequest;
use App\Models\Dashboard\Album\Album;
use App\Models\Dashboard\Course\Course;
use App\Models\Dashboard\Project\Project;
use App\Models\Dashboard\Service\Service;
use App\Services\Dashboard\Album\AlbumService;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    protected $albumService;

    public function __construct(AlbumService $albumService)
    {
        $this->albumService = $albumService;

        $this->middleware('can:albums.read')->only('index');
        $this->middleware('can:albums.create')->only('store');
        $this->middleware('can:albums.update')->only('update');
        $this->middleware('can:albums.delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(AlbumDataTable $dataTable, Request $request){
        $type = $request->input('type');
        if ($type) {
            $dataTable->setType($type);
        }
        return $dataTable->render('Dashboard.Albums.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $albums = $this->albumService->create();
        $albumTypes =Album::ALBUMTYPES;

        return view('Dashboard.Albums.create', compact('albums','albumTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AlbumRequest $request)
    {
        try {
            $dataValidated = $request->validated();

            $this->albumService->store($dataValidated);

            return redirect()->route('albums.index')->with(['success' => __('messages.your_item_added_successfully')]);
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
    public function edit(Album $album)
    {
        $albums = $this->albumService->create();
        $albumTypes =Album::ALBUMTYPES;
        $type = $album->type;
        $values =  $this->getAlbumTypesValues($type);

        return view('Dashboard.Albums.edit', compact('album', 'albums','albumTypes','type','values'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AlbumRequest $request, Album $album)
    {
        try {
            $dataValidated = $request->validated();

            $this->albumService->update($request, $dataValidated, $album);

            return redirect()->route('albums.index')->with(['success' => __('messages.your_item_added_successfully')]);
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
            'selectedIds.*' => ['exists:albums,id']
        ]);

        $deleted = $this->albumService->deleteAlbums($selectedIds);

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

    /**
     * get the specified type from ajax request.
     */
    public function getAlbumTypeValues(){
        $type=$_POST['type'];

        if($type == 'general'){
            return true;
        }else{
           $values =  $this->getAlbumTypesValues($type);
        }

        return response()->json([
            'html' => view('Dashboard.Albums.type_values', compact('values','type'))->render(),
        ]);
    }

    public function getAlbumTypesValues($type){
        $values = [];

        if($type == 'services'){
            $values = Service::select('id','name')->get();
        }

        if($type == 'projects'){
            $values = Project::select('id','name')->get();
        }
        // add here any new model you want//

        return $values;
    }

}
