<?php

namespace App\DataTables;

use App\Models\Property;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PropertiesDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        // add filter for publish_status
        // $property = Property::where('publish_status', 'Approved');
        // $property = Property::get();
        // get add properties
             
        // if (request()->has('publish_status')) {
        //     $property->where('publish_status', request('publish_status'));
        // }

        return (new EloquentDataTable($query))
            ->addColumn('created', function($property) {
                return date('d-m-Y', strtotime($property->created_at));
            })
            ->addColumn('user', function($property) {
                return ucwords($property->user?->name);
            })
            ->addColumn('type', function($property) {
                return $property->subtype?->name;
            })
            ->addColumn('area', function($property) {
                return $property->area_size . ' - ' . str_replace("_", " ", $property->area_unit->name);
            })
            ->addColumn('price', function($property) {
                return 'PKR ' . $property->price;
            })
            ->addColumn('city', function($property) {
                return $property->city?->name;
            })
            ->addColumn('location', function($property) {
                return $property->location?->name;
            })
            ->addColumn('purpose', function($property) {
                return ucwords($property->purpose);
            })
            ->addColumn('status', function($property) {
                //can make it use badge
                if ($property->publish_status == 'Approved') {
                    return '<span class="badge bg-success">Approved</span>';
                } else if ($property->publish_status == 'Pending') {
                    return '<span class="badge bg-secondary">Pending</span>';
                } else {
                    return '<span class="badge bg-danger">Cancelled</span>';
                }
            })
            ->addColumn('action', function($property) {
                return "<a href='/admin/requests/details/" . $property->id . "'><i class='far fa-edit'></i></a>";
            })
            ->rawColumns(['status', 'action'])
            ->setRowId('id')
            ->filterColumn('status', function($query, $keyword) {
                $query->where('publish_status', 'like', "%$keyword%");
            });
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Property $model): QueryBuilder
    {
        $query = $model->newQuery();
        $query->orderBy('created_at', 'desc');
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
                    ->setTableId('approved-properties-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax('', null, ['status' => 'function() { return $("#status-filter").val(); }'])
                    ->orderBy(0)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ])
                    ->parameters([
                        'drawCallback' => "function() {
                            $('.badge').each(function() {
                                $(this).parent().attr('data-search', $(this).text());
                            });
                        }",
                        'initComplete' => "function() {
                            this.api().columns(8).every(function() {
                                var column = this;
                                var select = $('<select id=\"status-filter\" class=\"form-control\"><option value=\"\">All</option></select>')
                                    .appendTo($(column.header()).empty())
                                    .on('change', function() {
                                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                        column.search(val ? '^'+val+'$' : '', true, false).draw();
                                    });
                                
                                select.append('<option value=\"Approved\">Approved</option>');
                                select.append('<option value=\"Pending\">Pending</option>');
                                select.append('<option value=\"Cancel\">Cancel</option>');
                            });
                        }",
                     
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
            Column::make('type')->title('Type'),
            Column::computed('area')->title('Area'),
            Column::computed('price')->title('Price'),
            Column::computed('city')->title('City'),
            Column::computed('location')->title('Location'),
            Column::computed('purpose')->title('Purpose'),
            Column::computed('status')->title('Status'),
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
        return 'ApprovedProperties_' . date('YmdHis');
    }
}
