<?php

namespace App\DataTables\Page;

use App\Models\Dashboard\Album\Album;
use App\Models\Dashboard\Page\Page;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PageDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('checkbox', function ($row) {
                return '<div class="form-check form-check-sm form-check-custom form-check-solid me-3"><input type="checkbox" name="checkbox" class="form-check-input" value="' . $row->id . '" /></div>';
            })

            // Render action-specific columns directly
            ->addColumn('actions', fn($row) => $this->renderActions($row))

            // Render status-specific columns directly
            ->addColumn('status', fn($row) => $this->renderStatus($row))

            // Render language-specific columns directly (e.g., name_en, name_ar)
            ->addColumn('name_en', fn($row) => $row->getTranslation('name', 'en') ?? '')
            ->addColumn('name_ar', fn($row) => $row->getTranslation('name', 'ar') ?? '')
            ->filterColumn('name_en', function ($query, $keyword) {
                $query->where('name->en', 'like', '%' . $keyword . '%');
            })

            ->filterColumn('name_ar', function ($query, $keyword) {
                $query->where('name->ar', 'like', '%' . $keyword . '%');
            })

            ->filterColumn('status', function ($query, $keyword) {
                $query->where(function ($query) use ($keyword) {
                    $words = explode(' ', $keyword);
                    foreach ($words as $word) {
                        $query->orWhere(function ($query) use ($word) {
                            if (str_contains('%published%', $word) || str_contains('%منشور%', $word)) {
                                $query->where('status', 'published');
                            } elseif (str_contains('%inactive%', $word) || str_contains('%غير نشط%', $word)) {
                                $query->where('status', 'inactive');
                            }
                        });
                    }
                });
            })

            // Make sure to treat columns as raw HTML
            ->rawColumns(['checkbox', 'actions', 'title_en', 'title_ar', 'status'])
            ->setRowId('id');
    }


    // Render Actions in a modular and reusable way
    protected function renderActions($row): string
    {
        $editUrl = route('pages.edit', $row->id);
        $routeName = 'pages';
        $modelName = 'pages';
        $showUrl = route( 'website.page',$row->slug);
        return view('components.dashboard.partials.actions_dropdown', compact('editUrl','showUrl', 'routeName', 'modelName'))->render();
    }

    protected function renderView($row): string
    {
        $url = route('website.page', $row->slug);
        $title= __('dash.view');
        return "<a href='{$url}' title='{$title}' target='_blank'><i class='ki-outline ki-eye fs-2'></i></a>";
    }


    protected function renderStatus($row)
    {
        if ($row->status == 'published') {
            return '<div class="badge badge-light-success">' . __('dash.published') . '</div>';
        } elseif ($row->status == 'inactive') {
            return '<div class="badge badge-light-danger">' . __('dash.inactive') . '</div>';
        }
    }

    public function query(Page $model): QueryBuilder
    {
        return $model->newQuery();

    }
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('pages-table')
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
                        'text' => '<i class="fas fa-file-excel"></i> ' . __('dash.excel'),
                    ],
                    [
                        'extend' => 'pdf',
                        'text' => '<i class="fas fa-file-pdf"></i> ' . __('dash.pdf'),
                    ],
                    [
                        'extend' => 'print',
                        'text' => '<i class="fas fa-print"></i> ' . __('dash.print'),
                    ],
                    [
                        'extend' => 'reload',
                        'text' => '<i class="fas fa-sync-alt"></i> ' . __('dash.reload'),
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
            Column::make('name_en')->title(__('dash.name_en')), // Explicitly display name in English
            Column::make('name_ar')->title(__('dash.name_ar')), // Explicitly display name in Arabic
            Column::make('status')->title(__('dash.status'))->addClass('status-cell'),
            Column::make('actions')->title(__('dash.actions'))->addClass('text-end'),
        ];
    }



    protected function filename(): string
    {
        return 'Pages_' . date('YmdHis');
    }

}
