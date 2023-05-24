<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Konfigurasi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KonfigurasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::user()->id_role == 21) {
            $konfig = DB::table('konfigurasis')->first();
            $title = "Konfigurasi";

            return view('konfigurasi.index', [
                'title' => $title,
                'konfig' => $konfig
            ]);
        } else {
            return abort(404);
        }
    }

    public function update(Request $request, $id)
    {
        $konfig = Konfigurasi::find($id);
        $konfig->update([
            'author' => $request->author,
            'namaweb' => $request->namaweb,
            'desc1' => $request->desc1,
            'desc2' => $request->desc2,
            'email' => $request->email,
            'keywords' => $request->keywords
        ]);

        if (!$konfig) {
            session()->flash('error', 'Data gagal diubah');
            return redirect(route('konfigurasi.index'));
        } else {
            session()->flash('success', 'Data berasil diubah');
            return redirect(route('konfigurasi.index'));
        }
    }
}
