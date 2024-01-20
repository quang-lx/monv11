<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Modules\Mon\Entities\Department;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportPatient implements ToModel, WithHeadingRow, WithStartRow
{
   protected $rows = 0;
   /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
   protected $result = [];

   public function model(array $row)
   {
      $this->result[] = [
         "name" => $row[1] ?? null,
         "sex" => $row[2] == 'Nữ' ? 0 : 1 ?? null,
         "birthday" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[3] ?? null)->format('Y-m-d'),
         "phone" => $row[4] ?? null,
         "email" => $row[5] ?? null,
         "papers" => $row[6] ?? null,
         "job" => $row[7] ?? null,
         "address" => $row[8] ?? null,
         "dependant" => $row[9] ?? null,
         "phone_dependant" => $row[10] ?? null
      ];
   }

   public function getDataImport(): array
   {
      return $this->result;
   }

   public function startRow(): int
   {
      return 5; // Dòng bắt đầu từ 5
   }

}
