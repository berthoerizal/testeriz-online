<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Soal;
use App\Tanya;
use App\Daftar;
use App\jawab;
use App\User;
use Illuminate\Support\Facades\Crypt;

class UjianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ujian_sudah_selesai()
    {
        $title = "Ikuti Ujian | Sudah Selesai";

        //sudah ujian
        $soal = DB::table('daftars')
            ->join('soals', 'daftars.id_soal', '=', 'soals.id')
            ->join('users', 'soals.id_user', '=', 'users.id')
            ->join('jenis_soal', 'soals.id_jenis_soal', '=', 'jenis_soal.id')
            ->select('soals.*', 'daftars.status_daftar', 'users.name', 'jenis_soal.nama_jenis_soal')
            ->where('daftars.id_user', '=', Auth::user()->id)
            ->where('soals.status_soal', 'publish')
            ->where('daftars.status_daftar', '!=', 1)
            ->orderBy('soals.id', 'desc')
            ->get();

        return view('ujian.ujian_sudah_daftar', ['title' => $title, 'soal' => $soal]);
    }


    public function ujian_sudah_daftar()
    {
        $title = "Ikuti Ujian | Sudah Daftar";

        //sudah daftar
        $soal = DB::table('daftars')
            ->join('soals', 'daftars.id_soal', '=', 'soals.id')
            ->join('users', 'soals.id_user', '=', 'users.id')
            ->join('jenis_soal', 'soals.id_jenis_soal', '=', 'jenis_soal.id')
            ->select('soals.*', 'daftars.status_daftar', 'users.name', 'jenis_soal.nama_jenis_soal')
            ->where('daftars.id_user', '=', Auth::user()->id)
            ->where('soals.status_soal', 'publish')
            ->where('daftars.status_daftar', '!=', 2)
            ->orderBy('soals.id', 'desc')
            ->get();

        return view('ujian.ujian_sudah_daftar', ['title' => $title, 'soal' => $soal]);
    }

    public function index()
    {
        $title = "Ikuti Ujian | Semua Ujian";

        $soal = DB::table('soals')
            ->join('users', 'soals.id_user', '=', 'users.id')
            ->join('jenis_soal', 'soals.id_jenis_soal', '=', 'jenis_soal.id')
            ->select('soals.*', 'users.name', 'jenis_soal.nama_jenis_soal')
            ->where('soals.id_user', '!=', Auth::user()->id)
            ->where('soals.status_soal', 'publish')
            ->orderBy('soals.id', 'desc')
            ->get();

        return view('ujian.semua_ujian', ['title' => $title, 'soal' => $soal]);
    }

    public function daftar_ujian(Request $request)
    {
        $request->validate([
            'kode_ujian' => 'required',
        ]);

        $soal = Soal::find($request->id_soal);

        $daftar = DB::table('daftars')
            ->where('id_user', Auth::user()->id)
            ->where('id_soal', $request->id_soal)
            ->first();

        if (isset($daftar->status_daftar) == 2) {
            session()->flash('error', 'Gagal melakukan pendaftaran. Anda sudah pernah mengerjakan ujian ini.');
            return redirect(route('soal.show', $soal->slug_soal));
        } else {

            if ('berthoerizal' == $request->kode_ujian || $soal->pass_soal == $request->kode_ujian) {

                $tanya = DB::table('tanyas')->where('id_soal', $request->id_soal)->get();
                foreach ($tanya as $tanya) {
                    $create_jawab = Jawab::create([
                        'id_user' => Auth::user()->id,
                        'id_soal' => $request->id_soal,
                        'id_tanya' => $tanya->id,
                        'jawaban_benar' => $tanya->jawaban,
                        'jawaban_user' => NULL,
                        'status_jawab' => 0
                    ]);
                }

                $daftar = Daftar::create([
                    'id_user' => Auth::user()->id,
                    'id_soal' => $request->id_soal,
                    'status_daftar' => 1
                ]);

                if (!$daftar) {
                    session()->flash('error', 'Gagal melakukan pendaftaran.');
                    return redirect(route('soal.show', $soal->slug_soal));
                } else {
                    session()->flash('success', 'Berhasil melakukan pendaftaran.');
                    return redirect(route('tunggu_ujian', $soal->slug_soal));
                }
            } else {

                session()->flash('error', 'Gagal melakukan pendaftaran, kode ujian Salah');
                return redirect(route('soal.show', $soal->slug_soal));
            }
        }
    }

    public function tunggu_ujian($slug_soal)
    {
        $title = "Tunggu Ujian";
        $soal = DB::table('soals')->where('slug_soal', $slug_soal)->first();
        $cek_daftar = DB::table('daftars')
            ->where('id_soal', $soal->id)
            ->where('id_user', Auth::user()->id)
            ->first();
        if ($cek_daftar->status_daftar == 1) {
            return view('ujian.tunggu_ujian', ['title' => $title, 'soal' => $soal]);
        } else {
            return abort(404);
        }
    }


    public function jawab_ujian_post(Request $request, $slug_soal)
    {

        $title = "Ujian";
        $soal = DB::table('soals')->where('slug_soal', $slug_soal)->first();
        if ($soal->jenis_soal == 'obyektif') {
            $data = DB::table('tanyas')
                ->where('id_soal', $soal->id)
                ->where('id', $request->id_tanya)
                ->first();

            $tanya = DB::table('tanyas')
                ->select('tanyas.id', 'jawabs.jawaban_user')
                ->leftJoin('jawabs', 'tanyas.id', '=', 'jawabs.id_tanya')
                ->where('tanyas.id_soal', $soal->id)
                ->where('jawabs.id_user', Auth::user()->id)
                ->get();

            $jawab = DB::table('jawabs')
                ->where('id_soal', $soal->id)
                ->where('id_tanya', $request->id_tanya)
                ->where('id_user', Auth::user()->id)
                ->first();

            $cek_daftar = DB::table('daftars')
                ->where('id_soal', $soal->id)
                ->where('id_user', Auth::user()->id)
                ->first();

            if ($cek_daftar->status_daftar == 1) {
                return view('ujian.jawab_ujian', ['row' => $data, 'soal' => $soal, 'title' => $title, 'jawab' => $jawab, 'tanya' => $tanya, 'tanya_id' => $request->id_tanya]);
            } else {
                return abort(404);
            }
        }
    }

    public function jawab_ujian_get($slug_soal)
    {
        $title = "Ujian";
        $soal = DB::table('soals')->where('slug_soal', $slug_soal)->first();
        if ($soal->jenis_soal == 'obyektif') {
            $data = DB::table('tanyas')->where('id_soal', $soal->id)->first();



            $tanya = DB::table('tanyas')
                ->select('tanyas.id', 'jawabs.jawaban_user')
                ->leftJoin('jawabs', 'tanyas.id', '=', 'jawabs.id_tanya')
                ->where('tanyas.id_soal', $soal->id)
                ->where('jawabs.id_user', Auth::user()->id)
                ->get();


            $jawab = DB::table('jawabs')
                ->where('id_soal', $soal->id)
                ->where('id_user', Auth::user()->id)
                ->first();

            $cek_daftar = DB::table('daftars')
                ->where('id_soal', $soal->id)
                ->where('id_user', Auth::user()->id)
                ->first();

            if ($cek_daftar->status_daftar == 1) {
                return view('ujian.jawab_ujian', ['row' => $data, 'soal' => $soal, 'title' => $title, 'jawab' => $jawab, 'tanya' => $tanya, 'tanya_id' => $data->id]);
            } else {
                return abort(404);
            }
        } else {
            $data = DB::table('tanyas')
                ->join('jawabs', 'tanyas.id', '=', 'jawabs.id_tanya')
                ->select('tanyas.*', 'jawabs.id as id_jawab')
                ->where('jawabs.id_soal', $soal->id)
                ->where('jawabs.id_user', Auth::user()->id)
                ->get();

            $cek_daftar = DB::table('daftars')
                ->where('id_soal', $soal->id)
                ->where('id_user', Auth::user()->id)
                ->first();

            if ($cek_daftar->status_daftar == 1) {
                return view('ujian.jawab_ujian_essay', ['data' => $data, 'soal' => $soal, 'title' => $title]);
            } else {
                return abort(404);
            }
        }
    }

    public function user_jawab_ujian(Request $request, $id_soal, $id_tanya)
    {
        $tanya = DB::table('tanyas')
            ->where('id', $id_tanya)
            ->where('id_soal', $id_soal)
            ->first();

        if ($request->jawaban_user == $tanya->jawaban) {
            $status_jawab = 1;
            // 1 bernilai benar
        } else {
            $status_jawab = 0;
            // 0 bernilai salah
        }
        $update_jawab = DB::table('jawabs')
            ->where('id_user', Auth::user()->id)
            ->where('id_soal', $id_soal)
            ->where('id_tanya', $id_tanya)
            ->update(array('jawaban_user' => $request->jawaban_user, 'status_jawab' => $status_jawab));
        return response()->json(['success' => true]);
    }

    public function selesai_ujian_essay(Request $request)
    {


        $ids = explode(",", $request->input('id'));
        $jawabans = explode(",", $request->input('jawaban'));
        foreach ($ids as $k => $id) {
            $values = array(
                'jawaban_user' => $jawabans[$k]
            );
            DB::table('jawabs')
                ->where('id', '=', $id)
                ->update($values);
        }

        $update_daftars = DB::table('daftars')
            ->where('id_user', Auth::user()->id)
            ->where('id_soal',  $request->input('id_soal'))
            ->update(array('status_daftar' => 2, 'ket' => $request->input('ket')));

        $user = User::find(Auth::user()->id);


        return redirect(route('detail_nilai', ['id_soal' =>  $request->input('id_soal'), 'id_user' => Crypt::encrypt($user->id)]));
    }

    public function selesai_ujian(Request $request, $id_soal)
    {
        $jumlah_terjawab = DB::table('jawabs')
            ->where('id_soal', $id_soal)
            ->where('id_user', Auth::user()->id)
            ->where('status_jawab', 1)
            ->count();
        $jumlah_tanya = DB::table('tanyas')
            ->where('id_soal', $id_soal)
            ->count();
        $nilai = $jumlah_terjawab / $jumlah_tanya * 100;
        DB::table('daftars')
            ->where('id_user', Auth::user()->id)
            ->where('id_soal', $id_soal)
            ->update(array('status_daftar' => 2, 'ket' => $request->input('ket'), 'nilai' => $nilai));
        $user = User::find(Auth::user()->id);

        return redirect(route('detail_nilai', ['id_soal' => $id_soal, 'id_user' => Crypt::encrypt($user->id)]));
    }
}
