<?php

namespace App\DataTables\Service;

use App\Models\Dashboard\Service\Service;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ServiceDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))

            ->addColumn('checkbox', function($row){
                return '<div class="form-check form-check-sm form-check-custom form-check-solid me-3"><input type="checkbox" name="checkbox" class="form-check-input" value="'. $row->id .'" /></div>';
            })

            // Render action-specific columns directly
            ->addColumn('actions', fn($row) => $this->renderActions($row))

            // Render status-specific columns directly
            ->addColumn('status', fn($row) => $this->renderStatus($row))

            // Render language-specific columns directly (e.g., name_en, name_ar)
            ->addColumn('name', fn($row) => $row->name?? '')
            ->addColumn('parent', fn($row) => $row->parent?->name ?? '')
            ->addColumn('home', fn($row) => $this->renderhome($row))
            ->addColumn('menu', fn($row) => $this->rendermenu($row))

            // Render image columns directly (e.g., image, icon)
            ->addColumn('image', function($row){
                return $this->renderImage($row->image, 'services', 100);
            })

            ->filterColumn('name', function($query, $keyword) {
                $query->where('name->en', 'like', '%'.$keyword.'%')->orWhere('name->ar', 'like', '%'.$keyword.'%');
            })


            ->filterColumn('status', function($query, $keyword) {
                $query->where(function ($query) use ($keyword) {
                    $words = explode(' ', $keyword);
                    foreach ($words as $word) {
                        $query->orWhere(function ($query) use ($word) {
                            if (str_contains('%published%', $word) || str_contains('%منشور%', $word)) {
                                $query->where('status', 'published');
                            }
                            elseif (str_contains('%inactive%', $word) || str_contains('%غير نشط%', $word)) {
                                $query->where('status', 'inactive');
                            }
                        });
                    }
                });
            })

            // Make sure to treat columns as raw HTML
            ->rawColumns(['checkbox','actions', 'name_en', 'name_ar','image','status','home','menu','view'])
            ->setRowId('id');
    }


    // Render Actions in a modular and reusable way
    protected function renderActions($row): string
    {
        $editUrl = route('services.edit', $row->id);
        $routeName = 'services';
        $modelName = 'services';
        $showUrl = route( 'website.service-details',$row->slug);
        return view('components.dashboard.partials.actions_dropdown', compact('editUrl','showUrl','routeName','modelName'))->render();
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
    protected function renderhome($row)
    {
        if ($row->home) {
            return '<div class="badge badge-light-success">' . __('dash.published') . '</div>';
        } else{
            return '<div class="badge badge-light-danger">' . __('dash.inactive') . '</div>';
        }
    }
    protected function rendermenu($row)
    {
        if ($row->menu) {
            return '<div class="badge badge-light-success">' . __('dash.published') . '</div>';
        } else{
            return '<div class="badge badge-light-danger">' . __('dash.inactive') . '</div>';
        }
    }

    public function query(Service $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder{
        return $this->builder()
            ->setTableId('services-table')
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
            Column::make('name')->title(__('dash.name')),
            Column::make('parent')->title(__('dash.parent')), // Explicitly display name in Arabic
            Column::make('image')->title(__('dash.image')),
            Column::make('status')->title(__('dash.status'))->addClass('status-cell'),
            Column::make('home')->title(__('dash.home_publish'))->addClass('status-cell'),
            Column::make('menu')->title(__('dash.menu_publish'))->addClass('status-cell'),
            Column::make('actions')->title(__('dash.actions'))->addClass('text-end'),
        ];
    }

    protected function filename(): string
    {
        return 'services_' . date('YmdHis');
    }

}
