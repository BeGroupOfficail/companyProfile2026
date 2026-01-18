<?php

namespace App\DataTables\Blog;

use App\Models\Dashboard\Blog\BlogCategory;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BlogCategoryDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))

            ->addColumn('checkbox', function ($row) {
                return '<div class="form-check form-check-sm form-check-custom form-check-solid me-3"><input type="checkbox" name="checkbox" class="form-check-input" value="' . $row->id . '" /></div>';
            })
            ->addColumn('drag_handle', fn($row) =>
                '<div class="drag-handle" style="cursor: move; text-align: center;">
                    <i class="fas fa-grip-vertical text-muted"></i>
                </div>'
            )
            // Render action-specific columns directly
            ->addColumn('actions', fn($row) => $this->renderActions($row))

            // Render status-specific columns directly
            ->addColumn('status', fn($row) => $this->renderStatus($row))

            // Render language-specific columns directly (e.g., name_en, name_ar)
            ->addColumn('name_en', fn($row) => $row->getTranslation('name', 'en') ?? '')
            ->addColumn('name_ar', fn($row) => $row->getTranslation('name', 'ar') ?? '')

            // Render image columns directly (e.g., image, icon)
            ->addColumn('image', function ($row) {
                return $this->renderImage($row->image, 'blog_categories', 100);
            })

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
            ->rawColumns(['checkbox', 'actions','drag_handle', 'name_en', 'name_ar', 'image', 'status'])
            ->setRowId('id')
            ->setRowAttr(['data-id' => function($row) { return $row->id; }]);

    }


    // Render Actions in a modular and reusable way
    protected function renderActions($row): string
    {
        $editUrl = route('blog-categories.edit', $row->id);
        $routeName = 'blog-categories';
        $modelName = 'blog_categories';
        return view('components.dashboard.partials.actions_dropdown', compact('editUrl', 'routeName', 'modelName'))->render();
    }

    protected function renderImage($imageName, $imageType, $width = 100): string
    {
        $imageUrl = $imageName ? asset("uploads/$imageType/$imageName") : asset('assets/dashboard/media/noimage.png');
        $modalId = 'img-preview-' . md5($imageUrl);
        return '
            <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                <div class="symbol-label">
                    <img src="' . $imageUrl . '" width="' . $width . '" class="img-rounded cursor-pointer" style="cursor:pointer" onclick="document.getElementById(\'' . $modalId . '\').style.display = ' . "'block'" . '" />
                </div>
            </div>
            <div id="' . $modalId . '" style="display:none;position:fixed;z-index:9999;left:0;top:0;width:100vw;height:100vh;background:rgba(0,0,0,0.7);text-align:center;" onclick="this.style.display=\'none\'">
                <img src="' . $imageUrl . '" style="max-width:90vw;max-height:90vh;margin-top:5vh;border-radius:10px;box-shadow:0 0 20px #000;" />
            </div>';
    }
    // Render images in a modular and reusable way
    // protected function renderImage($imageName, $imageType, $width = 40)
    // {
    //     $imageUrl = $imageName ? asset("uploads/$imageType/$imageName"): asset('assets/dashboard/media/noimage.png');
    //     return '<div class="symbol symbol-circle symbol-50px overflow-hidden me-3"><div class="symbol-label"><img src="' . $imageUrl . '" border="0" width="' . $width . '" class="img-rounded" />  </div> </div>';
    // }


    protected function renderStatus($row)
    {
        if ($row->status == 'published') {
            return '<div class="badge badge-light-success">' . __('dash.published') . '</div>';
        } elseif ($row->status == 'inactive') {
            return '<div class="badge badge-light-danger">' . __('dash.inactive') . '</div>';
        }
    }

    public function query(BlogCategory $model): QueryBuilder
    {
        return $model->orderBy('order', 'asc')->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('blog-categories-table')
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
            ->responsive(false)
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 select-all-records sortable-table')
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
                'rowReorder' => [
                    'selector' => '.drag-handle',
                    'dataSrc' => 'order'
                ]
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

            Column::make('drag_handle')
                ->data('drag_handle')
                ->title('<i class="fas fa-sort"></i>')
                ->orderable(false)
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center')
                ->width('50px'),

            Column::make('id'),
            Column::make('name_en')->title(__('dash.name_en')), // Explicitly display name in English
            Column::make('name_ar')->title(__('dash.name_ar')), // Explicitly display name in Arabic
            Column::make('image')->title(__('dash.image')),
            Column::make('status')->title(__('dash.status'))->addClass('status-cell'),
            Column::make('actions')->title(__('dash.actions'))->addClass('text-end'),
        ];
    }



    protected function filename(): string
    {
        return 'BlogCategories_' . date('YmdHis');
    }

}
