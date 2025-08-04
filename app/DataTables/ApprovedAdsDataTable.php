<?php

namespace App\DataTables;

use App\Models\Ad;
use App\Models\ApprovedAd;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ApprovedAdsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('created', function ($ad) {
                return date('d-m-Y', strtotime($ad->created_at));
            })
            ->addColumn('user', function ($ad) {
                return ucwords($ad->user?->name);
            })
            ->addColumn('image', function ($ad) {
                $url = env('FTP_BASE_URL') . '/' . $ad->file_name;
                return '<img src="' . $url . '" class="adApproveImg" />';
            })
            ->addColumn('phone', function ($ad) {
                return $ad->user?->phone;
            })
            ->addColumn('action', function ($ad) {
                $route = route('admin.requests.adDetails', $ad->id);
                return "<a href='$route' data-id='" . $ad->id . "'><i class='far fa-edit'></i></a>";
            })
            ->setRowId('id')
            ->rawColumns(['image', 'action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Ad $model): QueryBuilder
    {
        $query = $model->newQuery();
        $query->where('is_approved', 1)->orderBy('created_at', 'desc')->newQuery();
       
        if ($keyword = $this->request()->get('search')['value']) {
            $query->where(function ($query) use ($keyword) {
                $query->where('created_at', 'like', "%$keyword%") // Search in 'created'
                    ->orWhereHas('user', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%$keyword%") // Search in 'user'
                            ->orWhere('phone', 'like', "%$keyword%"); // Search in 'phone'
                    });
            });
        }
        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('approvedads-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('created')
                ->title('Added On'),
            Column::computed('user')
                ->title('Owner'),
            Column::computed('phone')
                ->title('Phone Number'),
            Column::computed('image')
                ->title('Ad')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
            Column::computed('action')
                ->title('Action')
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ApprovedAds_' . date('YmdHis');
    }
}
