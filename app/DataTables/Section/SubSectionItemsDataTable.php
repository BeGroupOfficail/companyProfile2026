<?php

namespace App\DataTables\Section;

use App\Models\Dashboard\Sections\CompanySubSectionItem;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SubSectionItemsDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('checkbox', function($row){
                return '<div class="form-check form-check-sm form-check-custom form-check-solid me-3"><input type="checkbox" name="checkbox" class="form-check-input" value="'. $row->id .'" /></div>';
            })
            ->addColumn('actions', fn($row) => $this->renderActions($row))
            ->addColumn('sub_section', fn($row) => $row->subSection ? $row->subSection->title : '')
            ->addColumn('title_en', fn($row) => $row->getTranslation('title','en') ?? '')
            ->addColumn('title_ar', fn($row) => $row->getTranslation('title','ar') ?? '')
            ->filterColumn('title_en', function($query, $keyword) {
                $query->where('title->en', 'like', '%'.$keyword.'%');
            })
            ->filterColumn('title_ar', function($query, $keyword) {
                $query->where('title->ar', 'like', '%'.$keyword.'%');
            })
            ->rawColumns(['checkbox','actions', 'title_en', 'title_ar', 'sub_section'])
            ->setRowId('id');
    }

    protected function renderActions($row): string
    {
        $editUrl = route('sub-section-items.edit', $row->id);
        $routeName = 'sub-section-items';
        $modelName = 'sub_section_items';
        return view('components.dashboard.partials.actions_dropdown', compact('editUrl','routeName','modelName'))->render();
    }

    public function query(CompanySubSectionItem $model): QueryBuilder
    {
        return $model->newQuery()->with('subSection');
    }

    public function html(): HtmlBuilder{
        return $this->builder()
            ->setTableId('sub-section-items-table')
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
                'dom' => '<"top-length"l><"top-buttons"B><"top-filter"f>rt<"bottom"ip>',
                'lengthChange' => true,
                'buttons' => [
                    ['extend' => 'excel', 'text' => '<i class="fas fa-file-excel"></i> '.__('dash.excel')],
                    ['extend' => 'pdf', 'text' => '<i class="fas fa-file-pdf"></i> '.__('dash.pdf')],
                    ['extend' => 'print', 'text' => '<i class="fas fa-print"></i> '.__('dash.print')],
                    ['extend' => 'reload', 'text' => '<i class="fas fa-sync-alt"></i> '.__('dash.reload')],
                ],
                'language' => [
                    'url' => (app()->getLocale() === 'ar') ? 'https://cdn.datatables.net/plug-ins/1.13.3/i18n/ar.json' : 'https://cdn.datatables.net/plug-ins/1.13.3/i18n/en.json',
                ],
                'responsive' => [
                    'details' => ['type' => 'column', 'target' => -1]
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
                ->orderable(false)->exportable(false)->printable(false),
            Column::make('id'),
            Column::make('title_en')->title(__('dash.title_en')),
            Column::make('title_ar')->title(__('dash.title_ar')),
            Column::make('sub_section')->title(__('dash.sub_section'))->name('subSection.title'),
            Column::make('sort_order')->title(__('dash.sort_order')),
            Column::make('actions')->title(__('dash.actions'))->addClass('text-end'),
        ];
    }

    protected function filename(): string
    {
        return 'SubSectionItems_' . date('YmdHis');
    }
}
