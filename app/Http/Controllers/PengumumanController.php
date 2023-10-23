<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pengumuman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\PDF;

class PengumumanController extends Controller
{
    public function pengumuman()
    {
        $user_id = Auth::user()->id;
        $pengumumans = Pengumuman::all();
        return view('pengumuman.pengumuman', compact('pengumumans'), [
            'pengumumans' => $pengumumans,
            'users' => User::with('pengumumans')->whereId(auth()->user()->id)->first(),
            'title' => 'Pengumuman'
        ]);
    }

    public function index()
    {
        $user_id = Auth::user()->id;
        $pengumumans = Pengumuman::where('user_id', $user_id)->paginate(10);
        return view('pengumuman.index', compact('pengumumans'), [
            'title' => 'Pengumuman'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_id = Auth::user()->id;
        $users = DB::table('users')->where('id', $user_id)->paginate(1);
        return view('pengumuman.create', compact('users'), [
            'title' => 'Tambah Pengumuman'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'judul'   => 'required',
            'dokumen' => [
                'required',
                'file',
                'mimes:pdf',
                function ($attribute, $value, $fail) {
                    $size = $value->getSize(); // Get file size in bytes
        
                    if ($size < 100000 || $size > 500000) {
                        $fail('The '.$attribute.' must be a PDF file between 100KB and 500KB.');
                    }
                },
            ],
        ]);

        //upload dokumen
        $dokumen = $request->file('dokumen');
        $dokumen->storeAs('public/pengumumans', $dokumen->hashName());

        $pengumuman = Pengumuman::create([
            'user_id' => Auth::user()->id,
            'judul'   => $request->judul,
            'dokumen'   => $dokumen->hashName(),
        ]);

        if($pengumuman){
            //redirect dengan pesan sukses
            return redirect()->route('pengumuman.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('pengumuman.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Pengumuman $pengumuman)
    {
        $user_id = Auth::user()->id;
        $users = DB::table('users')->where('id', $user_id)->paginate(1);
        return view('pengumuman.edit', compact('users','pengumuman'), [
            'title' => 'Edit Pengumuman'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pengumuman $pengumuman)
    {
        $this->validate($request, [
            'judul'   => 'required',
            'dokumen' => [
                'required',
                'file',
                'mimes:pdf',
                function ($attribute, $value, $fail) {
                    $size = $value->getSize(); // Get file size in bytes
        
                    if ($size < 100000 || $size > 500000) {
                        $fail('The '.$attribute.' must be a PDF file between 100KB and 500KB.');
                    }
                },
            ],
        ]);

        //get data Pengumuman by ID
        $pengumuman = Pengumuman::findOrFail($pengumuman->id);

        if($request->file('dokumen') == "") {

            $pengumuman->update([
                'judul'   => $request->judul,
            ]);

        } else {

            //hapus old image
            Storage::disk('local')->delete('public/pengumumans/'.$pengumuman->dokumen);

            //upload new image
            $dokumen = $request->file('dokumen');
            $dokumen->storeAs('public/pengumumans', $dokumen->hashName());

            $pengumuman->update([
                'judul'   => $request->judul,
                'dokumen'   => $dokumen->hashName(),
            ]);

        }

        if($pengumuman){
            //redirect dengan pesan sukses
            return redirect()->route('pengumuman.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('pengumuman.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        Storage::disk('local')->delete('public/pengumumans/'.$pengumuman->dokumen);
        $pengumuman->delete();

        if($pengumuman){
            //redirect dengan pesan sukses
            return redirect()->route('pengumuman.index')->with(['success' => 'Data Berhasil Dihapus!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('pengumuman.index')->with(['error' => 'Data Gagal Dihapus!']);
        }
    }

    public function cetakdokumen_pdf()
    {
        $user_id = Auth::user()->id;
        $pengumumans = Pengumuman::all();
        $view = view('pengumuman.katalog_pdf', compact('pengumumans'));
        $pdf = app()->make('dompdf.wrapper');
        $pdf->loadView('pengumuman.katalog_pdf', compact('pengumumans'));
        return $pdf->download('laporan-pengumuman-pdf.pdf', [
            'users' => User::with('pengumumans')->whereId(auth()->user()->id)->first(),
        ]);
    }
}
