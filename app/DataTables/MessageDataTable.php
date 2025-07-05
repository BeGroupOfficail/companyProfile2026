<?php

namespace App\DataTables;

use App\Models\Dashboard\Category;
use App\Models\Dashboard\Crm\CrmClient;
use App\Models\Dashboard\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class MessageDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $lang = app()->getLocale();
        return (new EloquentDataTable($query))
            ->addColumn('index', function ($row) {
                return $this->rowIndex++ +1;
            })
            ->addColumn('training', fn($row) => $row->training?->course->getTranslation('name', $lang) . ' - ' . $row->training?->code)
            ->addColumn('type', fn($row) => __('dash.' . $row->type))
            ->addColumn('n_sent', fn($row) => $row->n_sent)
            ->addColumn('n_delivered', fn($row) => $row->n_delivered)
            ->addColumn('n_failed', fn($row) => $row->n_failed)
            ->setRowClass('text-nowrap')
            ->rawColumns(['checkbox', 'actions'])
            ->setRowId('id');
    }

    public function query(Message $model): QueryBuilder
    {
        return $model->newQuery()->with(['training'])->orderBy('id', 'desc');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('clients-table')
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


    public function getColumns(): array
    {
        return [
            Column::make('index')->title(__('dash.index')),
            Column::make('training')->title(__('dash.training')),
            Column::make('type')->title(__('dash.message_type')),
            Column::make('n_sent')->title(__('dash.n_sent')),
            Column::make('n_delivered')->title(__('dash.n_delivered')),
            Column::make('n_failed')->title(__('dash.n_failed')),
        ];
    }

    protected function filename(): string
    {
        return 'Clients_' . date('YmdHis');
    }
}
