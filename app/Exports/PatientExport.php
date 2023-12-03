<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Modules\Admin\Repositories\Eloquent\EloquentPatientRepository;
use Modules\Admin\Transformers\PatientTransformer;
use Modules\Mon\Entities\ConfigDisplay;
use Modules\Mon\Entities\Patient;

class PatientExport implements FromView, WithEvents
{
    protected $request;
    protected $data_export = [];
    protected $columns_export;
    public function __construct($request)
    {
        $this->request = $request;
        $this->columns_export = [
            [
                'col_name' => 'id',
                'name' => trans('backend::patient.label.id'),
            ],
            [
                'col_name' => 'name',
                'name' => trans('backend::patient.label.name'),
            ],
            [
                'col_name' => 'sex',
                'name' => trans('backend::patient.label.sex'),
            ],
            [
                'col_name' => 'birthday',
                'name' => trans('backend::patient.label.birthday'),
            ],
            [
                'col_name' => 'phone',
                'name' => trans('backend::patient.label.phone'),
            ],
            [
                'col_name' => 'email',
                'name' => trans('backend::patient.label.email'),
            ],
            [
                'col_name' => 'papers',
                'name' => trans('backend::patient.label.papers'),
            ],
            [
                'col_name' => 'job',
                'name' => trans('backend::patient.label.job'),
            ],
            [
                'col_name' => 'address',
                'name' => trans('backend::patient.label.address'),
            ],
            [
                'col_name' => 'created_at',
                'name' => trans('backend::patient.label.created_at'),
            ],
            [
                'col_name' => 'status',
                'name' => trans('backend::patient.label.status'),
            ],
            [
                'col_name' => 'data_sources',
                'name' => trans('backend::patient.label.data_sources'),
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
        $patient_repo = new EloquentPatientRepository(new Patient);
        $query = $patient_repo->queryGetPatients($this->request);
        $patients = PatientTransformer::collection($query->get());
        Log::info([$patients]);
        foreach ($patients as $patient) {
            $this->data_export[] = $patient;
        }
        $config_play = ConfigDisplay::where('table_name', 'patient')->orderBy('position', 'asc')->get();
        if (count($config_play) > 0) {
            $this->columns_export = $this->formatConfigPlay($config_play);
        }

        return view('exports.template', [
            'data_export' => $this->data_export,
            'columns' => $this->columns_export
        ]);
    }

    public function formatConfigPlay($config_play)
    {
        $columns_export = [];
        foreach ($config_play as $column) {

            $columns_export[] = [
                'col_name' => $column->col_name,
                'name' => trans('backend::patient.label.' . $column->col_name)
            ];
        }
        return $columns_export;
    }

}
