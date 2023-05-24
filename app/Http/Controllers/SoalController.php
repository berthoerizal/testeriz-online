<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Soal;
use App\Daftar;
use App\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SoalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $title = "Buat Soal";
        $soal = DB::table('soals')
            ->join('users', 'soals.id_user', '=', 'users.id')
            ->select('soals.*', 'users.name')
            ->orderBy('soals.id', 'desc')
            ->where('soals.id_user', Auth::user()->id)
            ->get();
        return view('soal.index', ['title' => $title, 'soal' => $soal]);
    }

    public function create()
    {
        $title = "Tambah Soal";
        return view('soal.create', ['title' => $title]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_soal' => 'required'
        ]);

        $soal = Soal::all();
        foreach ($soal as $soal) {
            if ($soal->judul_soal == $request->judul_soal) {
                session()->flash('error', 'Data gagal ditambah, Judul soal tidak boleh sama.');
                return redirect(route('soal.create'));
            }
        }

        if ($request->hasFile('materi_file')) {
            $resorce  = $request->file('materi_file');
            $materi_file   =  time() . "_" . $resorce->getClientOriginalName();
            // $resorce->move(\base_path() . "/../assets/images", $gambar);
            $resorce->move(public_path() . '/assets/materi', $materi_file);

            $soal = Soal::create([
                'id_user' => Auth::user()->id,
                'judul_soal' => $request->judul_soal,
                'slug_soal' => Str::slug($request->judul_soal),
                'pass_soal' => Str::random(8),
                'jenis_soal' => $request->jenis_soal,
                'status_soal' => $request->status_soal,
                'status_nilai' => $request->status_nilai,
                'materi_file' => $materi_file,
                'materi_video' => $request->materi_video,
                'tanggal_mulai' => $request->tanggal_mulai,
                'waktu_mulai' => $request->waktu_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'waktu_selesai' => $request->waktu_selesai,
                'status_nilai' => 'draft'
            ]);
        } else {
            $materi_file = NULL;
            $soal = Soal::create([
                'id_user' => Auth::user()->id,
                'judul_soal' => $request->judul_soal,
                'slug_soal' => Str::slug($request->judul_soal),
                'pass_soal' => Str::random(8),
                'jenis_soal' => $request->jenis_soal,
                'status_soal' => $request->status_soal,
                'status_nilai' => $request->status_nilai,
                'materi_file' => $materi_file,
                'materi_video' => $request->materi_video,
                'tanggal_mulai' => $request->tanggal_mulai,
                'waktu_mulai' => $request->waktu_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'waktu_selesai' => $request->waktu_selesai,
                'status_nilai' => 'draft'
            ]);
        }


        if (!$soal) {
            session()->flash('error', 'Data gagal ditambah');
            return redirect(route('soal.index'));
        } else {
            session()->flash('success', 'Data berhasil ditambah');
            return redirect(route('soal.show', $soal->slug_soal));
        }
    }

    public function show($slug_soal)
    {
        $user = User::find(Auth::user()->id);
        $title = "Info Soal";
        $soal = DB::table('soals')
            ->join('users', 'soals.id_user', '=', 'users.id')
            ->select('soals.*', 'users.name')
            ->where('soals.slug_soal', $slug_soal)
            ->first();

        $tanya = DB::table('tanyas')
            ->select('tanyas.*')
            ->where('id_soal', $soal->id)
            ->get();
        $count_tanya = DB::table('tanyas')
            ->select('tanyas.*')
            ->where('id_soal', $soal->id)
            ->count();

        $daftar = DB::table('daftars')
            ->where('id_user', Auth::user()->id)
            ->where('id_soal', $soal->id)
            ->first();

        if (!$daftar) {
            $cek_daftar = 0;
        } else {
            if ($daftar->status_daftar == 1) {
                $cek_daftar = 1;
            } else {
                $cek_daftar = 2;
            }
        }

        return view('soal.show', ['title' => $title, 'soal' => $soal, 'tanya' => $tanya, 'cek_daftar' => $cek_daftar, 'user' => $user, 'count_tanya' => $count_tanya]);
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $title = "Edit Soal";
        $soal = Soal::find($id);
        if ($soal->id_user == Auth::user()->id) {
            return view('soal.edit', ['title' => $title, 'soal' => $soal]);
        } else {
            return abort(404);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul_soal' => 'required|unique:soals,judul_soal,' . $id
        ]);

        if ($request->hasFile('materi_file')) {
            $resorce  = $request->file('materi_file');
            $materi_file   =  time() . "_" . $resorce->getClientOriginalName();
            // $resorce->move(\base_path() . "/../assets/images", $gambar);
            $resorce->move(public_path() . '/assets/materi', $materi_file);

            $soal = Soal::find($id);
            $old_image = public_path() . "/assets/materi/" . $soal->materi_file;
            @unlink($old_image);

            $soal->update([
                'id_user' => Auth::user()->id,
                'judul_soal' => $request->judul_soal,
                'slug_soal' => Str::slug($request->judul_soal),
                'status_soal' => $request->status_soal,
                'status_nilai' => $request->status_nilai,
                'materi_file' => $materi_file,
                'materi_video' => $request->materi_video,
                'tanggal_mulai' => $request->tanggal_mulai,
                'waktu_mulai' => $request->waktu_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'waktu_selesai' => $request->waktu_selesai
            ]);

            if (!$soal) {
                session()->flash('error', 'Data gagal diubah');
                return redirect(route('soal.edit', Crypt::encrypt($id)));
            } else {
                session()->flash('success', 'Data berhasil diubah');
                return redirect(route('soal.show', $soal->slug_soal));
            }
        } else {
            $soal = Soal::find($id);
            $soal->update([
                'id_user' => Auth::user()->id,
                'judul_soal' => $request->judul_soal,
                'slug_soal' => Str::slug($request->judul_soal),
                'status_soal' => $request->status_soal,
                'status_nilai' => $request->status_nilai,
                'materi_video' => $request->materi_video,
                'tanggal_mulai' => $request->tanggal_mulai,
                'waktu_mulai' => $request->waktu_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'waktu_selesai' => $request->waktu_selesai
            ]);

            if (!$soal) {
                session()->flash('error', 'Data gagal diubah');
                return redirect(route('soal.edit', Crypt::encrypt($id)));
            } else {
                session()->flash('success', 'Data berhasil diubah');
                return redirect(route('soal.show', $soal->slug_soal));
            }
        }
    }

    public function destroy($id)
    {
        $soal = Soal::find($id);
        $old_image = public_path() . "/assets/materi/" . $soal->materi_file;
        @unlink($old_image);
        $soal->delete();

        $tanya_images = DB::table('tanyas')->where('id_soal', $id)->get();
        foreach ($tanya_images as $image) {
            $old_image = public_path() . "/assets/materi/" . $image->gambar;
            @unlink($old_image);
        }

        DB::table('tanyas')->where('id_soal', $id)->delete();
        DB::table('daftars')->where('id_soal', $id)->delete();
        DB::table('jawabs')->where('id_soal', $id)->delete();

        if (!$soal) {
            session()->flash('error', 'Data gagal dihapus');
            return redirect(route('soal.index'));
        } else {
            session()->flash('success', 'Data berhasil dihapus');
            return redirect(route('soal.index'));
        }
    }

    public function download_materi($id)
    {
        $soal = Soal::find($id);
        return response()->download((public_path() . "/assets/materi/" . $soal->materi_file));
    }
}
