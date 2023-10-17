<?php

namespace App\DataTables;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProductDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($query) {
                $editBtn = "<a href='" . route('app.categories.edit', $query->id) . "'
                            class='btn btn-primary btn-sm mx-2'>
                            <i class='fas fa-pencil-alt'></i>
                            </a>";
                $delBtn = "<button onClick='Delete(this.id)' class='btn btn-danger btn-sm'
                            id=$query->id>
                            <i class='fas fa-trash'></i>
                            </button>";

                return $editBtn . $delBtn;
            })
            ->addColumn('tax_type', function ($query) {
                if ($query->tax_type == 'NON-PPN') {
                    return '<i class="badge badge-success">' . $query->tax_type . '</i>';
                } else {
                    return '<i class="badge badge-warning">' . $query->tax_type . '</i>';
                }
            })
            ->addColumn('category_id', function ($query) {
                return '<i class="badge badge-info">' . $query->category_name . '</i>';
            })
            ->addColumn('vendor_id', function ($query) {
                return '<i class="badge badge-info">' . $query->vendor_name . '</i>';
            })
            ->addColumn('periode', function ($query) {
                return '<i class="badge badge-info">' . $query->periode . '</i>';
            })
            ->rawColumns(['action', 'category_id', 'vendor_id', 'tax_type', 'periode']);
        // ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Product $model): QueryBuilder
    {
        return $model->newQuery()
            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
            ->leftJoin('vendors', 'vendors.id', '=', 'products.vendor_id')
            ->select('products.*', 'categories.name as category_name', 'vendors.name as vendor_name');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('product-table')
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

            // Column::make('id'),
            Column::make('row_number')
                ->title('#')
                ->render('meta.row + meta.settings._iDisplayStart + 1;')
                ->width(10),
            Column::make('serial_number')
                ->title('No. Barang'),
            Column::make('title')
                ->title('Nama Barang'),
            Column::make('sell_price_duz')
                ->title('Harga Duz'),
            Column::make('sell_price_pack')
                ->title('Harga Pack'),
            Column::make('sell_price_pcs')
                ->title('Harga Pcs'),
            Column::make('vendor_id')
                ->title('Pabrikan'),
            Column::make('tax_type')
                ->title('Pajak'),
            Column::make('category_id')
                ->title('Tipe'),
            Column::make('periode')
                ->title('Periode'),
            Column::computed('action')
                ->width(200)
                ->addClass('text-center'),

        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Product_' . date('YmdHis');
    }
}
