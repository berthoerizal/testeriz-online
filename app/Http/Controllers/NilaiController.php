<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Soal;
use App\Tanya;
use App\Daftar;
use App\jawab;
use App\Nilai;
use App\User;
use Illuminate\Support\Facades\Crypt;

class NilaiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function nilai_peserta($slug_soal)
    {
        $soal = DB::table('soals')->where('slug_soal', $slug_soal)->first();

        $title = "Nilai";

        $count_tanyas = DB::table('tanyas')
            ->where('id_soal', $soal->id)
            ->count();

        if ($soal->jenis_soal == "essay") {
            $nilais = DB::table('jawabs')
                ->leftJoin('users', 'jawabs.id_user', '=', 'users.id')
                ->leftJoin('soals', 'jawabs.id_soal', '=', 'soals.id')
                ->select('jawabs.*', 'users.name as nama_peserta', 'users.email', 'soals.judul_soal', DB::raw("(sum(status_jawab)) as total_nilai, sum(status_jawab) as terjawab"))
                ->where('jawabs.id_soal', $soal->id)
                ->groupBy('jawabs.id_user')
                ->get();
        } else {
            $nilais = DB::table('jawabs')
                ->leftJoin('users', 'jawabs.id_user', '=', 'users.id')
                ->leftJoin('soals', 'jawabs.id_soal', '=', 'soals.id')
                ->select('jawabs.*', 'users.name as nama_peserta', 'users.email', 'soals.judul_soal', DB::raw("(sum(status_jawab)/$count_tanyas)*100 as total_nilai, sum(status_jawab) as terjawab"))
                ->where('jawabs.id_soal', $soal->id)
                ->groupBy('jawabs.id_user')
                ->get();
        }

        if ($soal->id_user == Auth::user()->id) {
            return view('nilai.index', ['title' => $title, 'soal' => $soal, 'nilais' => $nilais, 'jumlah_pertanyaan' => $count_tanyas]);
        } else {
            return abort(404);
        }
    }

    public function detail_nilai($id_soal, $id_user)
    {
        $id_user = Crypt::decrypt($id_user);
        $title = "Info Nilai";
        $jawabs = DB::table('jawabs')
            ->join('tanyas', 'jawabs.id_tanya', '=', 'tanyas.id')
            ->select('jawabs.*', 'tanyas.pertanyaan', 'tanyas.gambar')
            ->where('jawabs.id_soal', $id_soal)
            ->where('jawabs.id_user', $id_user)
            ->get();

        $soal = DB::table('soals')
            ->join('users', 'soals.id_user', '=', 'users.id')
            ->select('soals.*', 'users.name')
            ->where('soals.id', $id_soal)
            ->first();

        $user = User::find($id_user);

        $count_tanyas = DB::table('tanyas')
            ->where('id_soal', $id_soal)
            ->count();

        if ($soal->jenis_soal == 'essay') {
            $nilai = DB::table('jawabs')
                ->leftJoin('users', 'jawabs.id_user', '=', 'users.id')
                ->leftJoin('soals', 'jawabs.id_soal', '=', 'soals.id')
                ->select('jawabs.*', 'users.name as nama_peserta', 'soals.judul_soal', DB::raw("(sum(status_jawab)) as total_nilai, sum(status_jawab) as terjawab"))
                ->where('jawabs.id_soal', $id_soal)
                ->where('jawabs.id_user', $id_user)
                ->groupBy('jawabs.id_user')
                ->first();
        } else {
            $nilai = DB::table('jawabs')
                ->leftJoin('users', 'jawabs.id_user', '=', 'users.id')
                ->leftJoin('soals', 'jawabs.id_soal', '=', 'soals.id')
                ->select('jawabs.*', 'users.name as nama_peserta', 'soals.judul_soal', DB::raw("(sum(status_jawab)/$count_tanyas)*100 as total_nilai, sum(status_jawab) as terjawab"))
                ->where('jawabs.id_soal', $id_soal)
                ->where('jawabs.id_user', $id_user)
                ->groupBy('jawabs.id_user')
                ->first();
        }

        return view('nilai.show', ['title' => $title, 'jawabs' => $jawabs, 'soal' => $soal, 'nilai' => $nilai, 'user' => $user, 'jumlah_pertanyaan' => $count_tanyas]);
    }

    public function nilai_essay(Request $request)
    {
        $ids = $request->input('id');
        $nilai_users = $request->input('nilai');
        foreach ($ids as $k => $id) {
            $values = array(
                'status_jawab' => $nilai_users[$k]
            );
            DB::table('jawabs')
                ->where('id', '=', $id)
                ->update($values);
        }

        return redirect()->back();
    }
}
