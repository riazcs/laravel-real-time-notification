<?php

namespace App\Http\Controllers;

use App\Exports\CompaniesEmailExport;
use App\Imports\UsersImport;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportImportController extends Controller
{
    public function index()
    {
        $data = User::paginate(5);
        return view('csv.export', compact('data'));
    }

    public function csv_export(Type $var = null)
    {
        return Excel::download(new CompaniesEmailExport, 'comapanies_mail.xlsx');
    }

    public function csv_import(Type $var = null)
    {
        Excel::import(new UsersImport, request()->file('file'));
        return back();
    }
}
