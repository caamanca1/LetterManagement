<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use App\Models\Letter_type;
use App\Models\User;
use App\Models\Result;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LetterExport;
use App\Exports\SuratExport;
use Illuminate\Http\Request;
use PDF;

class LetterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $letter = Letter::with('results', 'user', 'LetterType')->get();
        $user = User::where('role', 'guru')->get(['id', 'name']);
        // $letter_code = $item->LetterType->letter_code . '/' . '000' . $item->letter_type_id . '/' . 'SMK Wikrama' . '/' . $item['created_at']->format('Y');
        return view('dataSurat.index', compact('letter', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $letter = Letter_type::all();
        $user = User::where('role', 'guru')->get();
        return view('dataSurat.create', compact('letter', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $arrayDistinct = array_count_values($request->recipients);
        $arrayAssoc = [];
        
        foreach ($arrayDistinct as $id => $count) {
            $user = User::find($id);

            if ($user) {
                $arrayItem = [
                    "id" => $id,
                    "name" => $user->name,
                ];

                array_push($arrayAssoc, $arrayItem);
            }
        }

        $request['recipients'] = $arrayAssoc;
        $no = Letter_type::count()+1;
        Letter::create([
            'letter_perihal' => $request->letter_perihal,
            'letter_type_id' => $request->letter_type_id,
            'content' => $request->content,
            'recipients' => $request->recipients,
            'attachment' => $request->attachment,
            'notulis' => $request->notulis,
        ]);

        return redirect()->route('dataSurat.home')->with('success', 'Berhasil Menambah Data!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $surat = Letter::find($id);
        $user = User::all();

        return view('dataSurat.print', compact('surat', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Letter $letter, $id)
    {
        $letter = Letter_type::all();

        $surat = Letter::findOrFail($id);

        $user = User::where('role', 'guru')->get(['id', 'name']);

        return view('dataSurat.edit', compact('letter', 'surat', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Letter $Letter, $id)
    {
        $recipients = $request->recipients ?? [];

        $arrayDistinct = array_count_values($recipients);
        $arrayAssoc = [];
        
        foreach ($arrayDistinct as $UserId => $count) {
            $user = User::find($UserId);

            if ($user) {
                $arrayItem = [
                    "id" => $id,
                    "name" => $user->name,
                ];

                array_push($arrayAssoc, $arrayItem);
            }
        }

        $request['recipients'] = $arrayAssoc;

        $Letter->where('id', $id)->update([
            'letter_perihal' => $request->letter_perihal,
            'letter_type_id' => $request->letter_type_id,
            'content' => $request->content,
            'recipients' => $request->recipients,
            'attachment' => $request->attachment,
            'notulis' => $request->notulis,
        ]);

        return redirect()->route('dataSurat.home')->with('success', 'Berhasil Mengubah Data!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Letter $letter, $id)
    {
        Letter::where('id', $id)->delete();

        return redirect()->back()->with('deleted', 'Berhasil Menghapus Data!');
    }

    public function fileExport() 
    {
        return Excel::download(new SuratExport, 'Data-Surat.xlsx');
    } 

    public function downloadPDF($id) {
        $surat = Letter::find($id);

        if (!$surat) {
            return response()->json(['error' => 'Surat tidak ditemukan', 404]);
        }

        view()->share('surat', $surat);

        $pdf = PDF::loadView('dataSurat.download', compact('surat'));

        return $pdf->download('Data-Surat.pdf');
    }

}
