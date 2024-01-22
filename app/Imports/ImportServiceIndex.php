<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Modules\Mon\Entities\Department;

class ImportServiceIndex implements ToModel, WithHeadingRow, WithStartRow
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
      if (empty(array_filter($row))) {
         return null;
     }

      $this->result[] = [
         "code" => $row[1] ?? null,
         "code_lis" => $row[2] ?? null,
         "name" => $row[3] ?? null,
         "ref_value" => $row[4] ?? null,
         "male_min_value" => $row[5] ?? null,
         "male_max_value" => $row[6] ?? null,
         "female_min_value" => $row[7] ?? null,
         "female_max_value" => $row[8] ?? null,
         "min_value" => $row[9] ?? null,
         "max_value" => $row[10] ?? null,
         "unit" => $row[11] ?? null,
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
