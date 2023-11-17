<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Modules\Mon\Entities\ConfigDisplay;
use Modules\Mon\Repositories\Eloquent\UserRepository;

class UsersErrorExport implements FromView, WithEvents
{
    protected $list_error;
    protected $data_export = [];
    protected $columns_export;
    public function __construct($list_error)
    {
        $this->list_error = $list_error;
        $this->columns_export = [
            [
                'col_name' => 'name',
                'name' => trans('backend::user.label.name'),
            ],
            [
                'col_name' => 'email',
                'name' => trans('backend::user.label.email'),
            ],

            [
                'col_name' => 'phone',
                'name' => trans('backend::user.label.phone'),
            ],
            [
                'col_name' => 'department',
                'name' => trans('backend::user.label.department'),
            ],
            [
                'col_name' => 'sex',
                'name' => trans('backend::user.label.sex'),
            ],
            [
                'col_name' => 'birth_day',
                'name' => trans('backend::user.label.birth_day'),
            ],
            [
                'col_name' => 'identification',
                'name' => trans('backend::user.label.identification'),
            ],
            [
                'col_name' => 'active_at',
                'name' => trans('backend::user.label.active_at'),
            ],
            [
                'col_name' => 'expired_at',
                'name' => trans('backend::user.label.expired_at'),
            ],
            [
                'col_name' => 'username',
                'name' => trans('backend::user.label.username'),
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
        return view('exports.user_error', [
            'data' => $this->list_error,
            'columns' => $this->columns_export
        ]);
    }

    public function formatConfigPlay($config_play)
    {
        $columns_export = [];
        foreach ($config_play as $column) {

            $columns_export[] = [
                'col_name' => $column->col_name,
                'name' => trans('backend::user.label.' . $column->col_name)
            ];
        }
        return $columns_export;
    }

}
