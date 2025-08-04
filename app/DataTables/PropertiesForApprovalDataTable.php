<?php

namespace App\DataTables;

use App\Models\PropertiesForApproval;
use App\Models\Property;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PropertiesForApprovalDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        
        return (new EloquentDataTable($query))
            ->addColumn('created' , function($property) {
                return date('d-m-Y' , strtotime($property->created_at));
            })
            ->addColumn('user' , function($property) {
                return ucwords($property->user?->name);
            })
            ->addColumn('type' , function($property) {
                return $property->subtype?->name;
            })
            ->addColumn('area' , function($property) {
                return $property->area_size . ' - ' . str_replace("_", " ", $property->area_unit->name);
            })
            ->addColumn('price' , function($property) {
                return 'PKR ' . $property->price;
            })
            ->addColumn('city' , function($property) {
                return $property->city?->name;
            })
            ->addColumn('location', function($property) {
                return $property->location?->name;
            })
            ->addColumn('purpose' , function($property) {
                return ucwords($property->purpose);
            })
            ->addColumn('action' , function($property) {
                return "<a href='/admin/requests/details/" . $property->id . "'><i class='far fa-edit'></i></a>"; /* <i class='bi bi-trash text-danger'></i>") */
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Property $model): QueryBuilder
    {
        $query = $model->newQuery();
        $query->where('publish_status' , 'Pending')->orderBy('created_at', 'desc');
            if (request()->filled('status')) {
                $status = request('status');
                $query->where('publish_status', $status);
            }
            if ($keyword = $this->request()->get('search')['value']) {
                $query->where(function ($query) use ($keyword) {
                    $query->where('created_at', 'like', "%$keyword%")
                        ->orWhereHas('user', function ($q) use ($keyword) {
                            $q->where('name', 'like', "%$keyword%");
                        })
                        ->orWhereHas('subtype', function ($q) use ($keyword) {
                            $q->where('name', 'like', "%$keyword%");
                        }) 
                        ->orWhere(function ($q) use ($keyword) {
                            $parts = explode(' ', $keyword);
                            if (count($parts) > 1) {
                                $size = $parts[0];
                                $unit = implode(' ', array_slice($parts, 1));
                                $q->where(function ($subQ) use ($size, $unit) {
                                    $subQ->where('area_size', 'like', "%$size%")
                                         ->where('area_unit', 'like', "%$unit%");
                                });
                            } else {
                                $q->where('area_size', 'like', "%$keyword%")
                                  ->orWhere('area_unit', 'like', "%$keyword%");
                            }
                        })
                        ->orWhere('price', 'like', "%$keyword%")
                        ->orWhereHas('city', function ($q) use ($keyword) {
                            $q->where('name', 'like', "%$keyword%");
                        })
                        ->orWhereHas('location', function ($q) use ($keyword) {
                            $q->where('name', 'like', "%$keyword%");
                        })
                        ->orWhere('purpose', 'like', "%$keyword%")
                        ->orWhere('publish_status', 'like', "%$keyword%");
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
                    ->setTableId('propertiesforapproval-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(0)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]) ->parameters([
                        'initComplete' => "function() {
                            this.api().columns().every(function () {
                                var column = this;
                                var input = document.createElement('input');
                                $(input).appendTo($(column.footer()).empty())
                                .on('change', function () {
                                    column.search($(this).val(), false, false, true).draw();
                                });
                            });
                        }",
                    ]);;
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('created')->title('Added On'),
            Column::computed('user')->title('Owner'),
            Column::make('type')->title('Type'),
            Column::computed('area')->title('Area'),
            Column::computed('price')->title('Price'),
            Column::computed('city')->title('City'),
            Column::computed('location')->title('Location'),
            Column::computed('purpose')->title('Purpose'),
            Column::computed('action')->title('Action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'PropertiesForApproval_' . date('YmdHis');
    }
}
