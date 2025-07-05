<?php

namespace App\Http\Controllers\Dashboard\Client;

use App\DataTables\Client\ClientDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Clients\ClientRequest;
use App\Models\Dashboard\Client\Client;
use App\Services\Dashboard\Client\ClientService;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    protected $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;

        $this->middleware('can:clients.read')->only('index');
        $this->middleware('can:clients.create')->only('store');
        $this->middleware('can:clients.update')->only('update');
        $this->middleware('can:clients.delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(ClientDataTable $dataTable)
    {
        return $dataTable->render('Dashboard.Clients.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = $this->clientService->create();
        return view('Dashboard.Clients.create',compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientRequest $request)
    {
        try {
            $dataValidated = $request->validated();

            $this->clientService->store($dataValidated);

            return redirect()->route('clients.index')->with(['success' => __('messages.your_item_added_successfully')]);
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
    public function edit(Client $client)
    {
        $types = $this->clientService->edit($client);
        return view('Dashboard.Clients.edit', compact('client','types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientRequest $request, Client $client)
    {
        try {
            $dataValidated = $request->validated();

            $this->clientService->update($request, $dataValidated, $client);

            return redirect()->route('clients.index')->with(['success' => __('messages.your_item_added_successfully')]);
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
            'selectedIds.*' => ['exists:clients,id']
        ]);

        $deleted = $this->clientService->deleteClients($selectedIds);

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
