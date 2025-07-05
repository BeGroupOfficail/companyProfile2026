<?php

namespace App\DataTables\Album;

use App\Models\Dashboard\Album\Album;
use App\Models\Dashboard\Category;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AlbumDataTable extends DataTable
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

            // Render status-specific columns directly
            ->addColumn('upload_files', fn($row) => $this->renderUploadFiles($row))

            // Render status-specific columns directly
            ->addColumn('album_type', fn($row) => $this->renderAlbumType($row))


            // Render language-specific columns directly (e.g., name_en, name_ar)
            ->addColumn('title_en', fn($row) => $row->getTranslation('title','en') ?? '')
            ->addColumn('title_en', fn($row) => $row->getTranslation('title','ar') ?? '')

            // Make sure to treat columns as raw HTML
            ->rawColumns(['checkbox','actions', 'title_en', 'title_ar','status','album_type','upload_files'])
            ->setRowId('id');
    }


    // Render Actions in a modular and reusable way
    protected function renderActions($row): string
    {
        $editUrl = route('albums.edit', $row->id);
        $routeName = 'albums';
        $modelName = 'albums';
        return view('components.dashboard.partials.actions_dropdown', compact('editUrl','routeName','modelName'))->render();
    }


    protected function renderStatus($row){
        if ($row->status == 'published') {
            return '<div class="badge badge-light-success">' . __('dash.published') . '</div>';
        } elseif ($row->status == 'inactive') {
            return '<div class="badge badge-light-danger">' . __('dash.inactive') . '</div>';
        }
    }

    protected function renderAlbumType($row) {
        if ($row->album_type == 'images') {
            return '<div class="badge badge-light-warning"> ' . __('dash.images') . '</div>';
        } elseif ($row->album_type == 'videos') {
            return '<div class="badge badge-light-warning">' . __('dash.videos') . '</div>';
        }
    }


    protected function renderUploadFiles($row)
    {
        $routes = [
            'images' => route('albums.album-images.edit', $row->id),
            'videos' => route('albums.album-videos.edit', $row->id),
        ];
        $albumUrl = $routes[$row->album_type] ?? null;

        $icon = '<i class="ki-outline ki-some-files fs-2x text-primary me-4"></i>';

        $link = $albumUrl
            ? '<a href="'.e($albumUrl).'" class="text-gray-800 text-hover-primary">'.__('Upload Files').'</a>'
            : '<span class="text-muted">'.__('Upload Files').'</span>';

        return '<div class="d-flex align-items-center">'
            . '<span class="icon-wrapper">'.$icon.'</span>'
            . $link
            . '</div>';
    }

    protected $type;

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function query(Album $model): QueryBuilder
    {
        $query = $model->newQuery();
        if ($this->type) {
            $query = $query->where('album_type', $this->type);
        }
        $search = request()->input('search.value');
        $statusFilter = request()->input('status'); // Get the selected status filter
        $albumTypeFilter = request()->input('album_type'); // Get the selected album_type filter

        // Apply filtering based on status if provided
        if ($statusFilter) {
            $query->where('status', strtolower($statusFilter));
        }

        // Apply filtering based on album_type if provided
        if ($albumTypeFilter) {
            $query->where('album_type', strtolower($albumTypeFilter));
        }

        // Apply search filter if a general search value is provided
        if ($search) {
            $query->where(function ($query) use ($search) {
                // Search within the JSON fields for 'title_en' and 'title_ar'
                $query->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(title, '$.en')) LIKE ?", ["%$search%"])
                    ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(title, '$.ar')) LIKE ?", ["%$search%"]);
            })
                ->orWhere('status', 'LIKE', "%$search%")
                ->orWhere('album_type', 'LIKE', "%$search%");
        }

        return $query;
    }


    public function html(): HtmlBuilder{
        return $this->builder()
            ->setTableId('albums-table')
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
            Column::make('title_en')->title(__('dash.title_en')), // Explicitly display name in English
            Column::make('title_en')->title(__('dash.title_en')), // Explicitly display name in Arabic
            Column::make('album_type')->title(__('dash.album_type')),
            Column::make('upload_files')->title(__('dash.upload_files')),
            Column::make('status')->title(__('dash.status'))->addClass('status-cell'),
            Column::make('actions')->title(__('dash.actions'))->addClass('text-end'),
        ];
    }



    protected function filename(): string
    {
        return 'Albums_' . date('YmdHis');
    }

}
