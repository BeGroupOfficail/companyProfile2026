<?php

namespace App\Http\Controllers\Dashboard\Project;

use App\DataTables\Project\ProjectDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Project\ProjectRequest;
use App\Models\Dashboard\Project\Project;
use App\Services\Dashboard\Project\ProjectService;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;

        $this->middleware('can:projects.read')->only('index');
        $this->middleware('can:projects.create')->only('store');
        $this->middleware('can:projects.update')->only('update');
        $this->middleware('can:projects.delete')->only('destroy');
    }

    public function index(ProjectDataTable $dataTable)
    {
        return $dataTable->render('Dashboard.Projects.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = $this->projectService->create();
        return view('Dashboard.Projects.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectRequest $request)
    {
        try {
            $dataValidated = $request->validated();
            $this->projectService->store($dataValidated);
            return redirect()->route('projects.index')->with(['success' => __('messages.your_item_added_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $services = $this->projectService->edit($project);
        return view('Dashboard.Projects.edit', compact('project', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectRequest $request, Project $project)
    {
        try {
            $dataValidated = $request->validated();
            $this->projectService->update($request, $dataValidated,  $project);

            return redirect()->route('projects.index')->with(['success' => __('messages.your_item_added_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
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
            'selectedIds.*' => ['exists:projects,id']
        ]);

        $deleted = $this->projectService->deleteProjects($selectedIds);

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
