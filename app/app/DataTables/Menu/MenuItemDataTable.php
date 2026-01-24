<?php

namespace App\DataTables\Menu;

use App\Models\Dashboard\Menu\MenuItem;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class MenuItemDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $lang = app()->getLocale();
        return (new EloquentDataTable($query))
            ->addColumn('checkbox', function ($row) {
                return '<div class="form-check form-check-sm form-check-custom form-check-solid me-3"><input type="checkbox" name="checkbox" class="form-check-input" value="' . $row->id . '" /></div>';
            })

            // Render action-specific columns directly
            ->addColumn(
                'drag_handle',
                fn($row) =>
                '<div class="drag-handle" style="cursor: move; text-align: center; padding: 8px;">
                    <i class="fas fa-grip-vertical text-muted" style="font-size: 14px;"></i>
                </div>'
            )
            ->addColumn('order', fn($row) => '<span class="badge badge-light-primary fw-bold">' . $row->order . '</span>')
            ->addColumn('actions', fn($row) => $this->renderActions($row))

            // Render status-specific columns directly
            ->addColumn('status', fn($row) => $this->renderStatus($row))

            // Render language-specific columns directly (e.g., name_en, name_ar)
            ->addColumn('name_en', fn($row) => $row->getTranslation('name', 'en') ?? '')
            ->addColumn('name_ar', fn($row) => $row->getTranslation('name', 'ar') ?? '')
            ->addColumn('type', fn($row) => $row->types ?? '')
            ->addColumn('menu_type', fn($row) => $row->menu->getTranslation('name', $lang) ?? '')

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
            ->rawColumns(['checkbox', 'order', 'drag_handle', 'actions', 'name_en', 'name_ar', 'status'])
            ->setRowId(function($row) {
                return 'row-' . $row->id; // Add prefix to avoid conflicts
            })
            ->setRowAttr([
                'data-id' => function ($row) {
                    return $row->id;
                },
                'data-order' => function ($row) {
                    return $row->order;
                }
            ]);
    }

    // Rest of your methods remain the same...
    protected function renderActions($row): string
    {
        $editUrl = route('menu-items.edit', $row->id);
        $routeName = 'menu-items';
        $modelName = 'menu_items';
        return view('components.dashboard.partials.actions_dropdown', compact('editUrl', 'routeName', 'modelName'))->render();
    }

    protected function renderStatus($row)
    {
        if ($row->status == 'published') {
            return '<div class="badge badge-light-success">' . __('dash.published') . '</div>';
        } elseif ($row->status == 'inactive') {
            return '<div class="badge badge-light-danger">' . __('dash.inactive') . '</div>';
        }
    }

    public function query(MenuItem $model): QueryBuilder
    {
        return $model->orderBy('order', 'asc')->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('menu-items-table')
            ->setTableHeadClass('table align-middle table-row-dashed fs-6 gy-5')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(2) // Change from 1 to 2 since drag handle is now column 1
            ->pageLength(50)
            ->lengthMenu([
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, 'All']
            ])
            ->selectStyleSingle()
            ->responsive(false)
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 select-all-records sortable-table')
            ->parameters([
                'dom' => '<"top-length"l><"top-buttons"B><"top-filter"f>rt<"bottom"ip>',
                'lengthChange' => true,
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
                'autoWidth' => false,
                'fixedHeader' => true,
                // Remove DataTables rowReorder since we're using jQuery UI sortable
                'ordering' => false, // Disable DataTables sorting to avoid conflicts
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
                ->printable(false)
                ->width('50px'),
            Column::make('drag_handle')
                ->data('drag_handle')
                ->title('<i class="fas fa-sort"></i>')
                ->orderable(false)
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center')
                ->width('50px'),
            Column::make('order')
                ->orderable(false),
            Column::make('name_en')
                ->title(__('dash.name_en'))
                ->orderable(false),
            Column::make('name_ar')
                ->title(__('dash.name_ar'))
                ->orderable(false),
            Column::make('status')
                ->title(__('dash.status'))
                ->addClass('status-cell')
                ->orderable(false),
            Column::make('type')
                ->title(__('dash.type'))
                ->orderable(false),
            Column::make('menu_type')
                ->title(__('dash.menu_type'))
                ->orderable(false),
            Column::make('actions')
                ->title(__('dash.actions'))
                ->addClass('text-end')
                ->orderable(false),
        ];
    }

    protected function filename(): string
    {
        return 'Menus_Items_' . date('YmdHis');
    }
}
