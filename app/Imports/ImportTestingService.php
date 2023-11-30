<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Modules\Mon\Entities\Department;
use Modules\Mon\Entities\ServiceType;

class ImportTestingService implements ToModel, WithHeadingRow, WithStartRow
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
       if(!array_filter($row)) {
           return null;
       }
       $result_item = [
         "code" => $row[1] ?? null,
         "code_lis" => $row[2] ?? null,
         "name" => $row[3] ?? null,
         "type" => $row[4] ?? null,

         "ref_value" => $row[5] ?? null,
         "male_min_value" => $row[6] ?? null,
         "male_max_value" => $row[7] ?? null,
         "female_min_value" => $row[8] ?? null,
         "female_max_value" => $row[9] ?? null,
          "min_value" => $row[10] ?? null,
          "max_value" => $row[11] ?? null,
         "unit" => $row[12] ?? null,



      ];


       $result_item_index = [
           "code" => $row[14] ?? null,
           "code_lis" => $row[15] ?? null,
           "name" => $row[16] ?? null,

           "ref_value" => $row[17] ?? null,
           "male_min_value" => $row[18] ?? null,
           "male_max_value" => $row[19] ?? null,
           "female_min_value" => $row[20] ?? null,
           "female_max_value" => $row[21] ?? null,
           "min_value" => $row[22] ?? null,
           "max_value" => $row[23] ?? null,
           "unit" => $row[24] ?? null
       ];

       $result_item['ref_value'] = idic_convert_number_format($result_item['ref_value']);
       $result_item['male_min_value'] = idic_convert_number_format($result_item['male_min_value']);
       $result_item['male_max_value'] = idic_convert_number_format($result_item['male_max_value']);
       $result_item['female_min_value'] = idic_convert_number_format($result_item['female_min_value']);
       $result_item['female_max_value'] = idic_convert_number_format($result_item['female_max_value']);
       $result_item['min_value'] = idic_convert_number_format($result_item['min_value']);
       $result_item['max_value'] = idic_convert_number_format($result_item['max_value']);

       $result_item_index['ref_value'] = idic_convert_number_format($result_item_index['ref_value']);
       $result_item_index['male_min_value'] = idic_convert_number_format($result_item_index['male_min_value']);
       $result_item_index['male_max_value'] = idic_convert_number_format($result_item_index['male_max_value']);
       $result_item_index['female_min_value'] = idic_convert_number_format($result_item_index['female_min_value']);
       $result_item_index['female_max_value'] = idic_convert_number_format($result_item_index['female_max_value']);
       $result_item_index['min_value'] = idic_convert_number_format($result_item_index['min_value']);
       $result_item_index['max_value'] = idic_convert_number_format($result_item_index['max_value']);
       $result_item['index'] = $result_item_index;

       $this->result[] = $result_item;
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
