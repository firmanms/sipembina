<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Pembinaankarir;
use Illuminate\Http\Request;

class ResumeController extends Controller
{

    public function resume(string $id)
    {
        $pegawai = Pegawai::with(['jabatans', 'bagians'])
        ->where('id', $id)
        ->first();
        $pegawaiid  = $pegawai->id;

        $pembinakarir   = Pembinaankarir::where('user_id',$pegawaiid)->first();

        return view('resume.resume',compact('pegawai', 'pembinakarir'));

    }
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
