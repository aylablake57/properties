<?php

namespace App\DataTables;

use App\Models\UserFeedback;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class GeneralFeedbackDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('created', function ($userfeedback) {
            return date('d-m-Y', strtotime($userfeedback->created_at));
        })
        ->addColumn('user', function ($userfeedback) {
            return ucwords($userfeedback->user?->name);
        })
        ->addColumn('comment', function ($userfeedback) {
            return $userfeedback->comments;
        })
        ->addColumn('suggestions', function ($userfeedback) {
            return $userfeedback->suggestions;
        })
        ->addColumn('rating', function ($userfeedback) {
            return $userfeedback->rating;
        })
        ->addColumn('status', function ($userfeedback) {
            $isApproved = $userfeedback->status === 'Published';
            $badgeClass = $isApproved ? 'text-bg-success' : 'text-bg-warning';
            $isChecked = $isApproved ? 'checked' : '';

            return '
                <div class="form-check form-switch">
                    <input class="form-check-input isApproved" type="checkbox" role="switch" id="isApproved__' . $userfeedback->id . '"
                           data-id="' . $userfeedback->id . '" ' . $isChecked . ' onclick="toggleGeneralFeedbackStatus(this)">
                    <span class="badge ' . $badgeClass . '">' . ($isApproved ? 'Approved' : 'Draft') . '</span>
                </div>';
        })
        ->rawColumns(['status'])
        ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(UserFeedback $model): QueryBuilder
    {
        return $model->newQuery()
            ->with('user')
            ->where('status', 'Draft')
            ->orWhere('status', 'Published')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('generalfeedback-table')
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
            Column::computed('created')->title('Added On'),
            Column::computed('user')->title('Owner'),
            Column::computed('comment')->title('Comments'),
            Column::computed('suggestions')->title('Suggestions'),
            Column::computed('rating')->title('Ratings'),
            Column::computed('status')->title('Status'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'GeneralFeedback_' . date('YmdHis');
    }
}
