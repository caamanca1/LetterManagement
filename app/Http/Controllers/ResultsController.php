<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Result;
use App\Models\User;
use App\Models\Letter;

class ResultsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $user = User::Where('role', 'guru')->get();

        $letters = Letter::Where('id', $id)->first();

        return view('userGuru.result', compact('user', 'letters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $arrayDistinct = array_count_values($request->presence_recipients);
        $arrayAssoc = [];

        foreach ($arrayDistinct as $id => $count) {
            $user = User::Find($id);

            if($user) {
                $arrayItem = [
                    "id" => $id,
                    "name" => $user->name,
                ];

                array_push($arrayAssoc, $arrayItem);
            }
        }

        $request['presence_recipients'] = $arrayAssoc;

        Result::create($request->all());

        return redirect()->route('dataSurat.home')->with('success', 'Berhasil Menambah Data');
    }

    /**
     * Display the specified resource.
     */
    public function show(Result $results, $id)
    {
        $result = Result::where('letter_id', $id)->first();

        $user = User::where('role', 'guru')->get();

        $surat = Letter::find($id);

        return view('result.result', compact('surat', 'user', 'result'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
