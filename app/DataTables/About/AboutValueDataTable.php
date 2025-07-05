<?php

namespace App\DataTables\About;

use App\Models\Dashboard\About\AboutValue;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AboutValueDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('checkbox', function($row){
                return '<div class="form-check form-check-sm form-check-custom form-check-solid me-3"><input type="checkbox" name="checkbox" class="form-check-input" value="'. $row->id .'" /></div>';
            })
            ->addColumn('actions', fn($row) => $this->renderActions($row))
            ->addColumn('status', fn($row) => $this->renderStatus($row))
            ->addColumn('title_en', fn($row) => $row->getTranslation('title','en') ?? '')
            ->addColumn('title_ar', fn($row) => $row->getTranslation('title','ar') ?? '')
            ->addColumn('type', fn($row) => $row->type ?? '')
            ->addColumn('image', function($row) {
                return $this->renderImage($row->image, 'about_values', 100);
            })
            ->addColumn('icon', function($row) {
                return $this->renderImage($row->icon, 'about_values', 80);
            })
            ->filterColumn('title_en', function($query, $keyword) {
                $query->where('title->en', 'like', '%'.$keyword.'%');
            })

            ->filterColumn('title_ar', function($query, $keyword) {
                $query->where('title->ar', 'like', '%'.$keyword.'%');
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

            ->rawColumns(['checkbox','actions', 'title_en', 'title_ar','type','image','icon','status'])
            ->setRowId('id');
    }

    protected function renderActions($row): string
    {
        $editUrl = route('about-values.edit', $row->id);
        $routeName = 'about-values';
        $modelName = 'about_values';
        return view('components.dashboard.partials.actions_dropdown', compact('editUrl','routeName','modelName'))->render();
    }

    protected function renderImage($imageName, $imageType, $width = 40)
    {
        $imageUrl = $imageName ? asset("uploads/$imageType/$imageName"): asset('assets/dashboard/media/noimage.png');
        return '<div class="symbol symbol-circle symbol-50px overflow-hidden me-3"><div class="symbol-label"><img src="' . $imageUrl . '" border="0" width="' . $width . '" class="img-rounded" />  </div> </div>';
    }

    protected function renderStatus($row)
    {
        if ($row->status == 'published') {
            return '<div class="badge badge-light-success">' . __('dash.published') . '</div>';
        } elseif ($row->status == 'inactive') {
            return '<div class="badge badge-light-danger">' . __('dash.inactive') . '</div>';
        }
    }

    public function query(AboutValue $model): QueryBuilder
    {

        return $model->newQuery();
    }

    public function html(): HtmlBuilder{
        return $this->builder()
            ->setTableId('about-values-table')
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
            Column::make('title_en')
                ->title(__('dash.title_en'))
                ->searchable(true),
            Column::make('title_ar')
                ->title(__('dash.title_ar'))
                ->searchable(true),
            Column::make('type')
                ->title(__('dash.type'))
                ->searchable(true),
            Column::make('image')
                ->title(__('dash.image')),
            Column::make('icon')
                ->title(__('dash.icon')),
            Column::make('status')
                ->title(__('dash.status'))
                ->addClass('status-cell')
                ->searchable(true),
            Column::make('actions')
                ->title(__('dash.actions'))
                ->addClass('text-end'),
        ];
    }

    protected function filename(): string
    {
        return 'AboutValues_' . date('YmdHis');
    }
}
