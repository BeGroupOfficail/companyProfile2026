<?php
namespace App\DataTables\Video;

use App\Models\Dashboard\Video\Video;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class VideoDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('checkbox', function ($row) {
                return '<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                <input type="checkbox" name="checkbox" class="form-check-input" value="' . $row->id . '" /></div>';
            })
            ->addColumn('actions', fn($row) => $this->renderActions($row))
            ->addColumn('image', fn($row) => $this->renderImage($row->image, 'videos', 100))

            ->rawColumns(['checkbox', 'actions', 'image'])
            ->setRowId('id');
    }


    // Render Actions in a modular and reusable way
    protected function renderActions($row): string
    {
        $editUrl = route('videos.edit', $row->id);
        $routeName = 'videos';
        $modelName = 'videos';
        $has_status= false;
        return view('components.dashboard.partials.actions_dropdown', compact('editUrl','has_status', 'routeName', 'modelName'))->render();
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
    // protected function renderImage($imageName, $imageType, $width = 40): string
    // {
    //     $imageUrl = $imageName ? asset("uploads/$imageType/$imageName") : asset('assets/dashboard/media/noimage.png');
    //     return '<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
    //                 <div class="symbol-label">
    //                     <img src="' . $imageUrl . '" width="' . $width . '" class="img-rounded" />
    //                 </div>
    //             </div>';
    // }

    public function query(Video $model): QueryBuilder
    {
        return $model->newQuery();

    }
     public function html(): HtmlBuilder{
        return $this->builder()
            ->setTableId('videos-table')
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
            Column::make('image')->title(__('dash.image')), // Explicitly display name in English
            Column::make('actions')->title(__('dash.actions'))->addClass('text-end'),
        ];
    }



    protected function filename(): string
    {
        return 'videos_' . date('YmdHis');
    }

}
