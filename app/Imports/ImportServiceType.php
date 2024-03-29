<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Modules\Mon\Entities\Department;

class ImportServiceType implements ToModel, WithHeadingRow, WithStartRow
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
         "code" => $row[1] ?? null,
         "name" => $row[2] ?? null,
         "description" => $row[3] ?? null,
         
      ];
   }

   public function getDataImport(): array
   {
      return $this->result;
   }

   public function startRow(): int
   {
      return 4; // Dòng bắt đầu từ 4
   }

}
