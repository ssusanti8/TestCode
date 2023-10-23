<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Katalog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\PDF;
// use Dompdf\Dompdf;
// use Dompdf\Options;

class KatalogController extends Controller
{
    public function katalog()
    {
        $user_id = Auth::user()->id;
        $katalogs = Katalog::all();
        return view('katalog.katalog', compact('katalogs'), [
            'katalogs' => $katalogs,
            'users' => User::with('katalogs')->whereId(auth()->user()->id)->first(),
            'title' => 'Katalog'
        ]);
    }

    public function index()
    {
        $user_id = Auth::user()->id;
        $katalogs = Katalog::where('user_id', $user_id)->paginate(10);
        return view('katalog.index', compact('katalogs'), [
            'title' => 'Katalog'
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
        return view('katalog.create', compact('users'), [
            'title' => 'Tambah Katalog'
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
            'tanggal'     => 'required',
            'gambar'    => 'required|image|mimes:png,jpg,jpeg',
            'deskripsi' => 'required',
            'harga'     => 'required',
            'stok'     => 'required',
        ]);

        //upload gambar
        $gambar = $request->file('gambar');
        $gambar->storeAs('public/katalogs', $gambar->hashName());

        $katalog = Katalog::create([
            'user_id' => Auth::user()->id,
            'tanggal'   => $request->tanggal,
            'gambar'   => $gambar->hashName(),
            'deskripsi'  => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
        ]);

        if($katalog){
            //redirect dengan pesan sukses
            return redirect()->route('katalog.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('katalog.index')->with(['error' => 'Data Gagal Disimpan!']);
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
    public function edit(Katalog $katalog)
    {
        $user_id = Auth::user()->id;
        $users = DB::table('users')->where('id', $user_id)->paginate(1);
        return view('katalog.edit', compact('users','katalog'), [
            'title' => 'Edit Katalog'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Katalog $katalog)
    {
        $this->validate($request, [
            'tanggal'     => 'required',
            'gambar'      => 'required|image|mimes:png,jpg,jpeg',
            'deskripsi'   => 'required',
            'harga'     => 'required',
            'stok'     => 'required',
        ]);

        //get data Katalog by ID
        $katalog = Katalog::findOrFail($katalog->id);

        if($request->file('gambar') == "") {

            $katalog->update([
                'tanggal'   => $request->tanggal,
                'deskripsi'     => $request->deskripsi,
                'harga'   => $request->harga,
                'stok'   => $request->stok,
            ]);

        } else {

            //hapus old image
            Storage::disk('local')->delete('public/katalogs/'.$katalog->gambar);

            //upload new image
            $gambar = $request->file('gambar');
            $gambar->storeAs('public/katalogs', $gambar->hashName());

            $katalog->update([
                'tanggal'   => $request->tanggal,
                'gambar'   => $gambar->hashName(),
                'deskripsi'     => $request->deskripsi,
                'harga'   => $request->harga,
                'stok'   => $request->stok,
            ]);

        }

        if($katalog){
            //redirect dengan pesan sukses
            return redirect()->route('katalog.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('katalog.index')->with(['error' => 'Data Gagal Disimpan!']);
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
        $katalog = Katalog::findOrFail($id);
        Storage::disk('local')->delete('public/katalogs/'.$katalog->gambar);
        $katalog->delete();

        if($katalog){
            //redirect dengan pesan sukses
            return redirect()->route('katalog.index')->with(['success' => 'Data Berhasil Dihapus!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('katalog.index')->with(['error' => 'Data Gagal Dihapus!']);
        }
    }

    public function cetak_pdf()
    {
        $user_id = Auth::user()->id;
        $katalogs = Katalog::all();
        $view = view('katalog.katalog_pdf', compact('katalogs'));
        $pdf = app()->make('dompdf.wrapper');
        $pdf->loadView('katalog.katalog_pdf', compact('katalogs'));
        return $pdf->download('laporan-katalog-pdf.pdf', [
            'users' => User::with('katalogs')->whereId(auth()->user()->id)->first(),
        ]);
    }
}