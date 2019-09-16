<?php

namespace App\Exports;

use App\InOutRecord;
use App\StaffInOutRecordSheet;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class StaffInOutRecordExport implements WithMultipleSheets
{

    use Exportable;

    protected $month;

    /**
     * StaffInOutRecordExport constructor.
     * @param $month
     */
    public function __construct($month)
    {
        $this->month = $month;
    }

    /**
     * @return InOutRecord[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|Collection
     */
    private function getRecords()
    {
        return InOutRecord::with('staff:id,id_team,staff_name,id_office_hour_type',
            'staff.workHourType:id,office_in_time,office_out_time')
            ->whereMonth('in_time', '=', $this->month)->get();
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $recordsGroupByStaffName = $this->getRecords()->groupBy('staff.staff_name');
        $sheets = [];

        foreach ($recordsGroupByStaffName as $record) {
            $sheets[] = new StaffInOutRecordSheet($record);
        }

        return $sheets;
    }

}
