<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Maatwebsite\Excel\Sheet;
use PHPExcel_RichText;
use PhpOffice\PhpSpreadsheet\RichText\ITextElement;
use PhpOffice\PhpSpreadsheet\RichText\RichText;
use PhpOffice\PhpSpreadsheet\RichText\Run;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PHPExcel;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
            $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
        });

        Sheet::macro('styleFonts', function (Sheet $sheet, string $cell, string $appendText, array $style) {
            $richTextObj = new RichText();

            //$run1 = $richTextObj->createTextRun($appendText);
            //$run1->getFont()->applyFromArray($style);
            $oriText = $sheet->getDelegate()->getCell($cell)->getValue();
            $run2 = $richTextObj->createTextRun("TESSTTST");
            $phpColor = new Color();
            $phpColor->setRGB(Color::COLOR_RED);
            $run2->getFont()->setBold(true)->setSize(30)->setColor($phpColor);
            $sheet->getDelegate()->getCell($cell)->setValue($richTextObj);
            $sheet->getDelegate()->getStyle($cell)->getFont()->setBold(true)->getColor()->setARGB(Color::COLOR_RED);
        });
    }
}
