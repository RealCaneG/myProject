<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\RichText\RichText;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

/*
 * @mixin Eloquent
 */

class StaffInOutRecordSheet Implements WithTitle, WithHeadings, WithMapping, FromCollection, ShouldAutoSize, WithEvents
{
    protected $records;

    /**
     * StaffInOutRecordSheet constructor.
     */
    public function __construct(Collection $records)
    {
        $this->records = $records;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return ['Staff Name', 'Group', 'Date', 'Day', 'Tin', 'Tsch', '*Tin - Tsch', "Occurrence:\r Not In Office", "Occurrence:\r Tin - Tsch > 15 mins"];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->records->first()->staff->staff_name;
    }

    /**
     * @return array
     * @var Collection $record
     */
    public function map($record): array
    {
        $formattedDayOfWeek = [
            1 => 'MON',
            2 => 'TUE',
            3 => 'WED',
            4 => 'THU',
            5 => 'FRI',
            6 => 'SAT',
            7 => 'SUN'
        ];

        $late = '';
        $absence = '1';
        $inTimeDiff = 'No Time-in';
        $dayOfWeek = new Carbon($record->in_time);
        $officialInTime = new Carbon(explode(' ', $record->staff->workHourType->office_in_time)[1]);

        if ($record->in_time != null) {
            $staffInTime = new Carbon(explode(' ', $record->in_time)[1]);
            $inTimeDiff = $officialInTime->diff($staffInTime)->format('%r%H:%I:%S');
            $late = Str::contains($inTimeDiff, '-') ? '' : '1';
            $absence = '';
        }

        return [
            $record->staff->staff_name,
            $record->staff->id_team,
            Carbon::parse($record->in_time)->format('Y-m-d'),
            $formattedDayOfWeek[$dayOfWeek->dayOfWeek],
            Carbon::parse($record->in_time)->format('H:i'),
            Carbon::parse($record->staff->workHourType->office_in_time)->format('H:i'),
            $inTimeDiff,
            $absence,
            $late,
        ];
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        return $this->records;
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {

        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->styleCells(
                    'A1:D1',
                    [
                        //Set background style
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => [
                                'rgb' => '000000',
                            ]
                        ],

                        //Set font style
                        'font' => [
                            'name' => 'Calibri',
                            'size' => 12,
                            'bold' => true,
                            'color' => ['argb' => 'FFFFFFFF'],
                        ],

                        'alignment' => [
                            'wrap' => true,
                            'horizontal' => Alignment::HORIZONTAL_CENTER,
                        ]
                    ]
                );
//305496
                $event->sheet->styleCells(
                    'H1:I1',
                    [
                        //Set background style
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => [
                                'rgb' => '305496',
                            ]
                        ],

                        //Set font style
                        'font' => [
                            'name' => 'Calibri',
                            'size' => 12,
                            'bold' => true,
                            'color' => ['argb' => 'FFFFFFFF'],
                        ],

                        'alignment' => [
                            'wrap' => true,
                            'horizontal' => Alignment::HORIZONTAL_CENTER,
                        ]
                    ]
                );

                $event->sheet->styleFonts(
                    'G1',
                    '*',
                    [
                        'color' => ['argb' => 'FFFF0000'],
                        'size' => 15,
                    ]
                );
            },
        ];
    }
}
