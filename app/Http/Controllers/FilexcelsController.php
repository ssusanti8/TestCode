<?php

namespace App\Http\Controllers;

use App\Imports\ExcelImport;
use App\Exports\Exportexcel;
use App\Models\Filexcel;
use App\Models\Filexcel as ModelsFilexcel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class FilexcelsController extends Controller
{
    public function index()
    {
        // $filexcel = Filexcel::all();
        $filexcels = Filexcel::latest()->get();
        return view('filexcels.data_excel', compact('filexcels'));
    }


    public function import(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        $file = $request->file('file');

        // membuat nama file unik
        $nama_file = $file->hashName();

        //temporary file
        $path = $file->storeAs('public/excel/',$nama_file);

        // import data
        $import = Excel::import(new ExcelImport(), storage_path('app/public/excel/'.$nama_file));

        //remove from server
        Storage::delete($path);

        if($import) {
            //redirect
            return redirect()->route('filexcels.data_excel')->with(['success' => 'Data Berhasil Diimport!']);
        } else {
            //redirect
            return redirect()->route('filexcels.data_excel')->with(['error' => 'Data Gagal Diimport!']);
        }
    }

    public function export()
	{
		return Excel::download(new Exportexcel, 'ContohExportExcel.xlsx');
	}
}
