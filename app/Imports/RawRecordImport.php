<?php

namespace App\Imports;

use App\InOutRecord;
use App\Staff;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class RawRecordImport implements ToCollection, WithStartRow
{

    use Importable;

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

    /**
     * @param Collection $collection
     * @throws \Exception
     */
    public function collection(Collection $rows)
    {
        // get current staffs info
        $newStaffs = Collection::make(new Staff);
        $newInOutRecords = Collection::make(new InOutRecord);
        $staffs = Staff::all();
        $staffIds = $staffs->map->only(['staff_id'])->sort();
        $currentStaffId = $staffIds->last();

        // get all existing inout record in range of import file months
        $dates = $rows->map->only(2)
            ->map(function ($date) {
                return Carbon::instance(Date::excelToDateTimeObject($date[2]));
            })->sort();

        $firstMonth = $dates->first()->month;
        $lastMonth = $dates->last()->month;
        $existingInOutRecords = InOutRecord::query()
            ->whereMonth('in_time', '>=', $firstMonth)
            ->whereMonth('out_time', '<=', $lastMonth)
            ->get('id_staff', 'in_time', 'out_time');

        foreach ($rows as $row) {
            $staffInTime = Date::excelToDateTimeObject($row[5]);
            $staffOutTime = Date::excelToDateTimeObject($row[6]);

            // add new staff to list then create later..
            if (!$staffs->contains('staff_name', $row[0]) &&
                !$newStaffs->contains('staff_name', $row[0])) {
                $staff = $this->createStaff($row);
                $newStaffs->add($staff);
                $staffId = ++$currentStaffId;
            } else {
                $staff = $staffs->where('staff_name', $row[0]);
                $staffId = $staff->first()->id;
            }

            // add new in out record to list and then create later..
            $isExist = $existingInOutRecords->contains(function ($val, $key) use ($staffId, $staffInTime, $staffOutTime) {
                return $val->id_staff == $staffId &&
                    $val->in_time == $staffInTime &&
                    $val->out_time == $staffOutTime;
            });

            if (!$isExist) {
                $inOutRecord = $this->createInOutRecord($staffId, $staffInTime, $staffOutTime);
                $newInOutRecords->add($inOutRecord);
            }
        }

        Staff::insert($newStaffs->toArray());
        InOutRecord::insert($newInOutRecords->toArray());
    }

    /**
     * @param $staffId
     * @param \DateTime $staffInTime
     * @param \DateTime $staffOutTime
     * @return InOutRecord
     */
    public function createInOutRecord($staffId, \DateTime $staffInTime, \DateTime $staffOutTime): InOutRecord
    {
        $inOutRecord = new InOutRecord;
        $inOutRecord->id_staff = $staffId;
        $inOutRecord->in_time = $staffInTime;
        $inOutRecord->out_time = $staffOutTime;
        return $inOutRecord;
    }

    /**
     * @param $row
     * @return Staff
     */
    public function createStaff($row): Staff
    {
        $staff = new Staff;
        $staff->staff_name = $row[0];
        $staff->email = '';
        return $staff;
    }

}
