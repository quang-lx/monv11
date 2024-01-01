<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Modules\Admin\Repositories\Eloquent\EloquentTestingServiceRepository;
use Modules\Admin\Transformers\TestingServiceTransformer;
use Modules\Mon\Entities\TestingService;
use Illuminate\Support\Facades\Log;

class TestingServiceExport implements FromView, WithEvents
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
                'name' =>  trans('backend::service.label.code'),
            ],
            [
                'col_name' => 'code_lis',
                'name' =>  trans('backend::service.label.code_lis'),
            ],
            [
                'col_name' => 'name',
                'name' =>  trans('backend::service.label.name'),
            ],
            [
                'col_name' => 'min_value',
                'name' =>  trans('backend::service.label.min_value'),
            ],
            [
                'col_name' => 'max_value',
                'name' =>  trans('backend::service.label.max_value'),
            ],
            [
                'col_name' => 'ref_value',
                'name' =>  trans('backend::service.label.ref_value'),
            ],
            [
                'col_name' => 'unit',
                'name' =>  trans('backend::service.label.unit'),
            ],
            [
                'col_name' => 'male_min_value',
                'name' =>  trans('backend::service.label.male_min_value'),
            ],
            [
                'col_name' => 'male_max_value',
                'name' =>  trans('backend::service.label.male_max_value'),
            ],
            [
                'col_name' => 'female_min_value',
                'name' =>  trans('backend::service.label.female_min_value'),
            ],
            [
                'col_name' => 'female_max_value',
                'name' =>  trans('backend::service.label.female_max_value'),
            ],
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
        $repo = new EloquentTestingServiceRepository(new TestingService);
        $query = $repo->queryGetTestingService($this->request);
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
