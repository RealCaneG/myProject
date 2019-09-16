<?php

namespace App\Http\Controllers;

use App\Exports\StaffInOutRecordExport;
use App\Imports\RawRecordImport;
use App\InOutRecord;
use App\Staff;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Writer\Exception;

class ImportExcelController extends Controller
{
    public function index()
    {
        $data = DB::table('raw_record')->orderBy('id', 'DESC')->get();
        return view('import_excel', compact('data'));
    }


    public function import(Request $request)
    {
        $this->validate($request, ['select_file' => 'required|mimes:xls,xlsx']);
        Excel::import(new RawRecordImport, request()->file('select_file'));
              return back()->with('success', 'Excel Data Imported Successfully.');
    }

    public function export() {
        try {
            return Excel::download(new StaffInOutRecordExport(1), 'test.xlsx');
        } catch (Exception $e) {
            echo $e;
        } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
            echo $e;
        }
    }
}
