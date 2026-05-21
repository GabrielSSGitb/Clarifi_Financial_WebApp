<?php

namespace App\Http\Controllers;

use App\Exports\IncomesExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Exception;

class ExportExcelFileController extends Controller
{
    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export()
    {
        $id = auth()->id();
        $fileName = 'financial_report' . now()->format('Y_m_d') . '.xlsx';

        return Excel::download(new IncomesExport($id), $fileName);
    }
}
