<?php
// By Asfia

namespace App\DataTables;

use App\Enums\FeedbackStatus;
use App\Models\Feedback;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class FeedbacksDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('created', function ($feedback) {
                return date('d-m-Y', strtotime($feedback->created_at));
            })
            ->addColumn('user', function ($feedback) {
                return ucwords($feedback->user?->name);
            })
            ->addColumn('comment', function ($feedback) {
                return $feedback->comment;
            })
            ->addColumn('rating', function ($feedback) {
                return $feedback->rating;
            })
            ->addColumn('status', function ($feedback) {
                $isApproved = $feedback->status?->value === 'Approved';
                $badgeClass = $isApproved ? 'text-bg-success' : 'text-bg-warning';
                $isChecked = $isApproved ? 'checked' : '';

                return '
                    <div class="form-check form-switch">
                        <input class="form-check-input isApproved" type="checkbox" role="switch" id="isApproved_' . $feedback->id . '"
                               data-id="' . $feedback->id . '" ' . $isChecked . ' onclick="toggleStatus(this)">
                        <span class="badge ' . $badgeClass . '">' . ($isApproved ? 'Approved' : 'Pending') . '</span>
                    </div>';
            })
            ->rawColumns(['status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Feedback $model): QueryBuilder
    {
        $query = $model->newQuery();
        $query->where(function ($query) {
            $query->where('status', FeedbackStatus::Pending->value)
                ->orWhere('status', FeedbackStatus::Approved->value);
        })
            ->orderBy('created_at', 'desc');

        if ($keyword = $this->request()->get('search')['value']) {
            $query->where(function ($query) use ($keyword) {
                $query->where('created_at', 'like', "%$keyword%")
                    ->orWhere('comment', 'like', "%$keyword%")
                    ->orWhere('rating', '=', $keyword)
                    ->orWhere('status', 'like', "%$keyword%");
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
            ->setTableId('feedbacks-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload'),

            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('created')->title('Added On'),
            Column::computed('user')->title('Owner'),
            Column::computed('comment')->title('Comments'),
            Column::computed('rating')->title('Ratings'),
            Column::computed('status')->title('Status'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Feedbacks_' . date('YmdHis');
    }
}
