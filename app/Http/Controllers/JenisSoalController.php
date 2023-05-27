<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JenisSoal;

class JenisSoalController extends Controller
{
    //crud master jenis soal
    public function index()
    {
        $title = 'Jenis Soal';
        $jenis_soal = JenisSoal::all();
        return view('jenis_soal.index', ['jenis_soal' => $jenis_soal, 'title' => $title]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis_soal' => 'required|unique:jenis_soal,nama_jenis_soal|max:255|min:3|regex:/^[a-zA-Z\s]*$/'
        ]);

        $jenis_soal = JenisSoal::create([
            'nama_jenis_soal' => $request->nama_jenis_soal
        ]);

        if ($jenis_soal) {
            return redirect(route('jenis_soal.index'))->with('success', 'Data berhasil ditambah.');
        } else {
            return redirect(route('jenis_soal.index'))->with('error', 'Data gagal ditambah.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_jenis_soal' => 'required|max:255|min:3|regex:/^[a-zA-Z\s]*$/|unique:jenis_soal,nama_jenis_soal,' . $id
        ]);

        $jenis_soal = JenisSoal::find($id);
        $jenis_soal->nama_jenis_soal = $request->nama_jenis_soal;
        $jenis_soal->save();

        if ($jenis_soal) {
            return redirect(route('jenis_soal.index'))->with('success', 'Data berhasil diubah.');
        } else {
            return redirect(route('jenis_soal.index'))->with('error', 'Data gagal diubah.');
        }
    }

    public function destroy($id)
    {
        $jenis_soal = JenisSoal::find($id);
        $jenis_soal->delete();

        if ($jenis_soal) {
            return redirect(route('jenis_soal.index'))->with('success', 'Data berhasil dihapus.');
        } else {
            return redirect(route('jenis_soal.index'))->with('error', 'Data gagal dihapus.');
        }
    }
}
