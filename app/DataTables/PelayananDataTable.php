<?php

namespace App\DataTables;

use App\Models\Pelayanan;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PelayananDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function($query) {
                    return <<< HTML
                    <div class="btn-group" aria-label="Basic example" role="group">
                        <a href="javascript:void(0);" class="btn btn-icon btn-primary" onclick="viewPelayanan($query->id)" title="View"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a> &nbsp;
                        <a href="javascript:void(0);" class="btn btn-icon btn-danger" onclick="deletePelayanan($query->id)" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a> &nbsp;
                    </div>
HTML;
             });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\core $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Pelayanan $model)
    {
        return $model->newQuery()->with('jenis_pelayanan');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('Pelayanan-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(0,'desc')
                    ->buttons(
                        Button::make('create'),
                        Button::make('excel'),
                        Button::make('csv'),
                        // Button::make('print'),
                        // Button::make('reset'),
                        // Button::make('reload')
                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
            Column::make('id'),
            Column::make('nomor'),
            Column::make('jenis_pelayanan.name')->title('Jenis Pelayanan'),
            Column::make('nik'),
            Column::make('name'),
            Column::make('address'),
            // Column::make('created_at'),
            // Column::make('updated_at'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Pelayanan_' . date('YmdHis');
    }
}
