<?php

namespace App\DataTables;

use App\Models\Ad;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Output\OutputInterface;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

use function Termwind\render;

class AdsDataTable extends DataTable
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
            ->addColumn('action', function ($ad) {
                return '
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-success btn-sm me-2"
                                onClick="handleApproveClick(' . $ad->id . ')">Approve</button>
                        <button class="btn btn-danger btn-sm"
                                onClick="handleCancelClick(' . $ad->id . ')">Cancel</button>
                    </div>';
            })
            ->addColumn('status', function ($ad) {
                $statusClass = 'badge ';
                $statusText = ucfirst($ad->status);

                if ($ad->status === 'approved') {
                    $statusClass .= 'bg-success';
                } elseif ($ad->status === 'canceled') {
                    $statusClass .= 'bg-danger';
                } else {
                    $statusClass .= 'bg-warning';
                }

                return '<span class="' . $statusClass . '">' . $statusText . '</span>';
            })
            ->addColumn('phone', function ($ad) {
                return $ad->user?->phone;
            })
            ->setRowId('id')
            ->rawColumns(['image', 'action', 'status']);
    }


    public function query(): QueryBuilder
    {
        $query = Ad::where('status', 'Pending')->orderBy('created_at', 'desc')->newQuery();

        if ($keyword = $this->request()->get('search')['value']) {
            $query->where(function ($query) use ($keyword) {
                $query->where('created_at', 'like', "%$keyword%")
                    ->orWhereHas('user', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%$keyword%")
                            ->orWhere('phone', 'like', "%$keyword%");
                    });
            });
        }
        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('ad-table')
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
            Column::computed('status')
                ->title('Status'),
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
        return 'AdsForApproval' . date('YmdHis');
    }
}
