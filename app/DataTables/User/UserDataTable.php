<?php

namespace App\DataTables\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
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

            ->addColumn('name', fn($row) => $row->getNameAttribute())

            // Render image columns directly (e.g., image, icon)
            ->addColumn('image', function($row){
                return $this->renderImage($row->image, 'categories', 100);
            })

            // Make sure to treat columns as raw HTML
            ->rawColumns(['checkbox','actions','name','image','status'])
            ->setRowId('id');
    }

    // Render Actions in a modular and reusable way
    protected function renderActions($row): string
    {
        $editUrl = route('users.users.edit', $row->id);
        $routeName = 'users.users';
        $modelName = 'users';
        $has_status = 'no';
        return view('components.dashboard.partials.actions_dropdown', compact('editUrl','routeName','modelName','has_status'))->render();
    }


    // Render images in a modular and reusable way
    protected function renderImage($imageName, $imageType, $width = 40)
    {
        $imageUrl = $imageName ? asset("uploads/$imageType/$imageName"): asset('assets/dashboard/media/noimage.png');
        return '<div class="symbol symbol-circle symbol-50px overflow-hidden me-3"><div class="symbol-label"><img src="' . $imageUrl . '" border="0" width="' . $width . '" class="img-rounded" />  </div> </div>';
    }


    protected function renderStatus($row)
    {
        if ($row->status == 'active') {
            return '<div class="badge badge-light-success">' . __('dash.active') . '</div>';
        } elseif ($row->status == 'inactive') {
            return '<div class="badge badge-light-warning">' . __('dash.inactive') . '</div>';
        } elseif ($row->status == 'blocked') {
            return '<div class="badge badge-light-danger">' . __('dash.blocked') . '</div>';
        }
    }

    public function setType($type){
        $this->type = $type;
        return $this;
    }

    public function query(User $model): QueryBuilder
    {
        $query = $model->newQuery()->where('id','!=',1);

        if ($this->type) {
            $query = $query->where('job_role', $this->type);
        }
        return  $query;
    }

    public function html(): HtmlBuilder{
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
            Column::make('email')->title(__('dash.email')),
            Column::make('phone')->title(__('dash.phone')),
            Column::make('image')->title(__('dash.image')),
            Column::make('status')->title(__('dash.status'))->addClass('status-cell'),
            Column::make('job_role')->title(__('dash.job_role'))->addClass('status-cell'),
            Column::make('actions')->title(__('dash.actions'))->addClass('text-end'),
        ];
    }



    protected function filename(): string
    {
        return 'Users_' . date('YmdHis');
    }

}
