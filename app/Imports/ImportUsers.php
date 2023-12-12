<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Modules\Mon\Entities\Department;
use Modules\Mon\Entities\User;

class ImportUsers implements ToModel, WithHeadingRow, WithStartRow
{
   protected $rows = 0;
   /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
   protected $result = [];

   public function __construct()
   {
      // $this->idExcelImport = $idExcelImport;
   }

   public function model(array $row)
   {
      $this->result[] = [
         "name" => $row[1] ?? null,
         "email" => $row[2] ?? null,
         "phone" => $row[3] ?? null,
         "department_id" => $this->getDepartmentId($row[4]) ?? null,
         "department" => $row[4] ?? null,
         "sex" => $row[5] == 'x' ? User::FEMALE : User::MALE,
         "birth_day" => $row[6] ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[6])->format('Y-m-d H:i:s') : null,
         "identification" => $row[7] ?? null,
         "active_at" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[8] ?? null)->format('Y-m-d H:i:s'),
         "expired_at" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[9] ?? null)->format('Y-m-d H:i:s'),
         "username" => $row['thong_tin_tai_khoan'] ?? null,
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

   public function getDepartmentId($name): int
   {

      $department_model = Department::where('name', $name)->first();
      if (!$department_model) {
         $department_model = new Department();
         $department_model->name = $name;
         $department_model->not_assign =1;
         $department_model->save();
      }
      return $department_model->id;
   }

}
