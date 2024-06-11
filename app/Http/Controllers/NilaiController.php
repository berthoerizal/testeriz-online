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
use Exception;

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

        if ($soal->jenis_soal == "subjektif") {
            $nilais = DB::table('jawabs')
                ->select('jawabs.id_soal', 'jawabs.id_user', 'users.name AS nama_peserta', 'users.email', 'jenis_soal.nama_jenis_soal', 'soals.judul_soal', 'daftars.status_daftar', DB::raw('SUM(jawabs.status_jawab) AS total_nilai'), DB::raw('SUM(jawabs.status_jawab) AS terjawab'), 'daftars.ket')
                ->leftJoin('users', 'jawabs.id_user', '=', 'users.id')
                ->leftJoin('soals', 'jawabs.id_soal', '=', 'soals.id')
                ->leftJoin('daftars', function ($join) {
                    $join->on('jawabs.id_user', '=', 'daftars.id_user')
                        ->on('soals.id', '=', 'daftars.id_soal');
                })
                ->leftJoin('jenis_soal', 'soals.id_jenis_soal', '=', 'jenis_soal.id')
                ->where('jawabs.id_soal', $soal->id)
                ->groupBy('jawabs.id_user')
                ->get();
        } else {
            $nilais = DB::table('jawabs')
                ->select('jawabs.id_soal', 'jawabs.id_user', 'users.name as nama_peserta', 'users.email', 'jenis_soal.nama_jenis_soal', 'soals.judul_soal', 'daftars.status_daftar', DB::raw("(SUM(jawabs.status_jawab) / $count_tanyas) * 100 as total_nilai"), DB::raw('SUM(jawabs.status_jawab) as terjawab'), 'daftars.ket')
                ->leftJoin('users', 'jawabs.id_user', '=', 'users.id')
                ->leftJoin('soals', 'jawabs.id_soal', '=', 'soals.id')
                ->leftJoin('daftars', function ($join) {
                    $join->on('jawabs.id_user', '=', 'daftars.id_user')
                        ->on('soals.id', '=', 'daftars.id_soal');
                })
                ->leftJoin('jenis_soal', 'soals.id_jenis_soal', '=', 'jenis_soal.id')
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
            ->select('jawabs.*', 'tanyas.pertanyaan', 'tanyas.gambar', 'tanyas.url_video')
            ->where('jawabs.id_soal', $id_soal)
            ->where('jawabs.id_user', $id_user)
            ->get();

        $soal = DB::table('soals')
            ->join('users', 'soals.id_user', '=', 'users.id')
            ->join('jenis_soal', 'soals.id_jenis_soal', '=', 'jenis_soal.id')
            ->select('soals.*', 'users.name', 'jenis_soal.nama_jenis_soal')
            ->where('soals.id', $id_soal)
            ->first();

        $user = User::find($id_user);

        $count_tanyas = DB::table('tanyas')
            ->where('id_soal', $id_soal)
            ->count();

        if ($soal->jenis_soal == 'subjektif') {
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

    public function nilai_subjektif(Request $request)
    {
        $ids = $request->input('id');
        $id_soal = $request->input('id_soal');
        $id_user = $request->input('id_user');
        $nilai_users = $request->input('nilai');

        $max_nilai = 100;
        $nilai = 0;
        foreach ($ids as $k => $id) {
            $nilai += $nilai_users[$k];
        }

        if ($nilai > $max_nilai) {
            return redirect()->back()->with('error', 'Nilai melebihi batas maksimal 100');
        } else {
            foreach ($ids as $k => $id) {
                $values = array(
                    'status_jawab' => $nilai_users[$k]
                );
                DB::table('jawabs')
                    ->where('id', '=', $id)
                    ->update($values);
            }
            DB::table('daftars')->where('id_soal', $id_soal)->where('id_user', $id_user)->update(['nilai' => $nilai]);

            return redirect()->back()->with('success', 'Nilai berhasil disimpan');
        }
    }

    public function reset_nilai($id_soal, $flag, $id_user = null)
    {
        try {
            $slug_soal = Soal::find($id_soal)->slug_soal;
            if ($flag == "all") {
                //update daftars
                DB::table('daftars')
                    ->where('id_soal', $id_soal)
                    ->update(['status_daftar' => 1]);

                //update jawabs
                DB::table('jawabs')
                    ->where('id_soal', $id_soal)
                    ->update(['status_jawab' => 0, 'jawaban_user' => null]);
            } else {
                //update daftars
                DB::table('daftars')
                    ->where('id_soal', $id_soal)
                    ->where('id_user', $id_user)
                    ->update(['status_daftar' => 1]);

                //update jawabs
                DB::table('jawabs')
                    ->where('id_soal', $id_soal)
                    ->where('id_user', $id_user)
                    ->update(['status_jawab' => 0, 'jawaban_user' => null]);
            }

            session()->flash('success', 'Data berhasil di-reset');
            return redirect(route('nilai_peserta', ['id' => $slug_soal]));
        } catch (Exception $e) {
            session()->flash('error', 'Data gagal di-reset');
            // redirect to nilai_peserta
            return redirect(route('nilai_peserta', ['id' => $slug_soal]));
        }
    }
}
