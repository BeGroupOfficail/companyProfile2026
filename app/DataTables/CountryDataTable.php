<?php

namespace App\DataTables;

use App\Models\Dashboard\Country;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CountryDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))

            ->addColumn('checkbox', function($row){
                return '<div class="form-check form-check-sm form-check-custom form-check-solid me-3"><input type="checkbox" name="checkbox" class="form-check-input" value="'. $row->id .'" /></div>';
            })

            // Render action-specific columns directly
            ->addColumn('actions', fn($row) => $this->renderActions($row))

            // Render language-specific columns directly (e.g., name_en, name_ar)
            ->addColumn('name_en', fn($row) => $row->getTranslation('name','en') ?? '')
            ->addColumn('name_ar', fn($row) => $row->getTranslation('name','ar') ?? '')

            ->filterColumn('name_en', function($query, $keyword) {
                $query->where('name->en', 'like', '%'.$keyword.'%');
            })

            ->filterColumn('name_ar', function($query, $keyword) {
                $query->where('name->ar', 'like', '%'.$keyword.'%');
            })

            // Make sure to treat columns as raw HTML
            ->rawColumns(['checkbox','actions', 'name_en', 'name_ar'])
            ->setRowId('id');
    }


    // Render Actions in a modular and reusable way
    protected function renderActions($row): string
    {
        $editUrl = route('settings.countries.edit', $row->id);
        $routeName = 'settings.countries';
        $modelName = 'countries';
        return view('components.dashboard.partials.html.edit_delete_dropdown', compact('editUrl','routeName','modelName'))->render();
    }


    public function query(Country $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder{
        return $this->builder()
            ->setTableId('countries-table')
            ->setTableHeadClass('table align-middle table-row-dashed fs-6 gy-5')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->pageLength(50)
            ->lengthMenu([
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, 'All']
            ])
            ->selectStyleSingle()
            ->responsive(true)
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 select-all-records')
            ->parameters([
                'dom' => '<"top-length"l><"top-buttons"B><"top-filter"f>rt<"bottom"ip>', // Corrected dom
                'lengthChange' => true, // Ensure length menu is enabled
                'buttons' => [
                    [
                        'extend' => 'excel',
                        'text' => '<i class="fas fa-file-excel"></i> '.__('dash.excel'),
                    ],
                    [
                        'extend' => 'pdf',
                        'text' => '<i class="fas fa-file-pdf"></i> '.__('dash.pdf'),
                    ],
                    [
                        'extend' => 'print',
                        'text' => '<i class="fas fa-print"></i> '.__('dash.print'),
                    ],
                    [
                        'extend' => 'reload',
                        'text' => '<i class="fas fa-sync-alt"></i> '.__('dash.reload'),
                    ],
                ],
                'language' => [
                    'url' => (app()->getLocale() === 'ar') ? 'https://cdn.datatables.net/plug-ins/1.13.3/i18n/ar.json' : 'https://cdn.datatables.net/plug-ins/1.13.3/i18n/en.json',
                    'buttons' => [
                        'copy' => __('dash.copy'),
                        'excel' => __('dash.excel'),
                        'pdf' => __('dash.pdf'),
                        'print' => __('dash.print'),
                        'reload' => __('dash.reload')
                    ]
                ],
                'responsive' => [
                    'details' => [
                        'type' => 'column',
                        'target' => -1
                    ]
                ],
                'autoWidth' => false,
                'fixedHeader' => true,
            ]);
    }

    // Define the columns to display in the table
    public function getColumns(): array
    {
        return [
            Column::make('checkbox')
                ->data('checkbox')
                ->title('<div class="form-check form-check-sm form-check-custom form-check-solid me-3"> <input type="checkbox" id="select-all" class="form-check-input select-all-records-checkbox"> </div>')
                ->orderable(false)
                ->exportable(false)
                ->printable(false),

            Column::make('id'),
            Column::make('name_en')->title(__('dash.name_en')),
            Column::make('name_ar')->title(__('dash.name_ar')),
            Column::make('actions')->title(__('dash.actions'))->addClass('text-end'),
        ];
    }



    protected function filename(): string
    {
        return 'Countries_' . date('YmdHis');
    }
}
