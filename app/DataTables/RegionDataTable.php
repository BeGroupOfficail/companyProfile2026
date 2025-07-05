<?php

namespace App\DataTables;

use App\Models\Dashboard\Region;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class RegionDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))

            ->addColumn('checkbox', function($row){
                return '<input type="checkbox" name="checkbox" class="form-check-input" value="'. $row->id .'" />';
            })

            // Render action-specific columns directly
            ->addColumn('actions', fn($row) => $this->renderActions($row))

            // Render language-specific columns directly (e.g., name_en, name_ar)
            ->addColumn('name_en', fn($row) => $row->getTranslation('name','en') ?? '')
            ->addColumn('name_ar', fn($row) => $row->getTranslation('name','ar') ?? '')
            ->addColumn('country', fn($row) => $row->country->getTranslation('name','ar') ?? '')

            // Make sure to treat columns as raw HTML
            ->rawColumns(['checkbox','actions', 'name_en', 'name_ar'])
            ->setRowId('id');
    }


    // Render Actions in a modular and reusable way
    protected function renderActions($row): string
    {
        $editUrl = route('settings.regions.edit', $row->id);
        $routeName = 'settings.regions';
        $modelName = 'regions';
        return view('components.dashboard.partials.html.edit_delete_dropdown', compact('editUrl','routeName','modelName'))->render();
    }


    public function query(Region $model): QueryBuilder
    {
        return $model->newQuery()
            ->when(request()->has('search') && request('search')['value'], function ($query) {
                $search = request('search')['value'];

                $query->whereRaw("JSON_UNQUOTE(JSON_VALUE(name, '$.en')) LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("JSON_UNQUOTE(JSON_VALUE(name, '$.ar')) LIKE ?", ["%{$search}%"]);
            });
    }




    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('regions-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle()
            ->responsive(true)
            ->addTableClass('align-middle table-row-dashed fs-6 gy-5 select-all-records')
            ->parameters([
                'dom' => 'Bfrtip',
                'buttons' => ['copy', 'excel', 'pdf', 'print', 'reload'],
                'paging' => true,
                'searching' => true,
                'ordering' => true,
                'responsive' => true,
            ]);
    }

    // Define the columns to display in the table
    public function getColumns(): array
    {
        return [
            Column::make('checkbox')
                ->data('checkbox')
                ->title('<input type="checkbox" id="select-all" class="form-check-input select-all-records-checkbox">')
                ->orderable(false)
                ->exportable(false)
                ->printable(false),

            Column::make('id'),
            Column::make('name_en')->title(__('dash.name_en')),
            Column::make('name_ar')->title(__('dash.name_ar')),
            Column::make('country')->title(__('dash.country')),
            Column::make('actions')->title(__('dash.actions'))->addClass('text-end'),
        ];
    }



    protected function filename(): string
    {
        return 'Regions_' . date('YmdHis');
    }
}
