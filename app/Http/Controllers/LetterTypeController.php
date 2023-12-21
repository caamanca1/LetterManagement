<?php

namespace App\Http\Controllers;

use App\Models\Letter_type;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LetterExport;
use Illuminate\Http\Request;
use PDF;

class LetterTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $letterType = Letter_type::all();
        return view('klasifikasi.index', compact('letterType'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('klasifikasi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'letter_code' => 'required|min:3',
            'name_type' => 'required',
        ]);
        $no = Letter_type::count()+1;
        $code = $request->letter_code . '-' . $no;
        Letter_type::create([
            'letter_code' => $code,
            'name_type' => $request->name_type,
        ]);

        return redirect()->route('KlasifikasiSurat.home')->with('success', 'Berhasil Menambah Data Klasifikasi Surat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Letter_type $letter_type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Letter_type $letter_type, $id)
    {
        $letterType = Letter_type::find($id);
        return view('klasifikasi.edit', compact('letterType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $letterType = Letter_type::find($id);
            if (!$letterType) {
                return redirect()->route('KlasifikasiSurat.home')->with('error', 'Surat tidak ditemukan.');
            }

        $request->validate([
            'letter_code',
            'name_type' => 'required',
        ]);

        if ($request->name_type) {
            // $password = substr($request->email, 0, 3).substr($request->name, 0, 3);
            $letterType->update([
                'letter_code',
                'name_type' => $request->name_type,
            ]);
        } else {
            $letterType->update([
                'letter_code',
                'name_type' => $request->name_type,
       
            ]);
        }

        return redirect()->route('KlasifikasiSurat.home')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Letter_type::where('id', $id)->delete();
        return redirect()->back()->with('deleted', 'Berhasil Menghapus Data!');
    }

    public function fileExport() 
    {
        return Excel::download(new LetterExport, 'Klasifikasi-Surat.xlsx');
    } 

   
}
