<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Modules\Admin\Repositories\Eloquent\EloquentDeviceRepository;
use Modules\Mon\Entities\Device;

class DevicesExport implements FromView, WithEvents
{
    protected $request;
    protected $data_export = [];
    protected $columns_export;
    public function __construct($request)
    {
        $this->request = $request;
        $this->columns_export = [
            [
                'col_name' => 'code',
                'name' =>  trans('backend::device.label.code'),
            ],
            [
                'col_name' => 'name',
                'name' =>  trans('backend::device.label.name'),
            ],
            [
                'col_name' => 'serial_number',
                'name' =>  trans('backend::device.label.serial number'),
            ],
            [
                'col_name' => 'box',
                'name' =>  trans('backend::device.label.box'),
            ],
            [
                'col_name' => 'status',
                'name' =>  trans('backend::device.label.status'),
            ]
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $to = $event->sheet->getDelegate()->getHighestRowAndColumn();
                $cellRange = 'A1:' . $to['column'] . $to['row']; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(10);

                for ($row = 0; $row <= $to['row']; $row++) {
                    $event->sheet->getDelegate()->getRowDimension($row)->setRowHeight(20);
                }
                $columns = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T"];

                for ($column = 0; $column < count($columns); $column++) {
                    $event->sheet->getDelegate()->getColumnDimension($columns[$column])->setAutoSize(true);
                }
                $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setVertical('center');

                $event->sheet->getStyle($cellRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                    ],
                ]);
            },
        ];
    }
    public function view(): View
    {
        $repo = new EloquentDeviceRepository(new Device);
        $query = $repo->queryGetDevice($this->request);

        $query->chunk(100, function ($list) {
            foreach ($list as $data) {
                $this->data_export[] = $data->toArray();
            }
        });
        return view('exports.template', [
            'data_export' => $this->data_export,
            'columns' => $this->columns_export
        ]);
    }

    
}
