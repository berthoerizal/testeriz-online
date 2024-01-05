<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($id)
    {

        $id = Crypt::decrypt($id);
        $soal_count = DB::table('soals')->where('id_user', $id)->count();
        $ujian_count = DB::table('daftars')->where('id_user', $id)->where('status_daftar', 2)->count();

        $user = User::find($id);

        $result = DB::table('daftars')
            ->leftJoin('soals', 'soals.id', '=', 'daftars.id_soal')
            ->leftJoin('jenis_soal', 'jenis_soal.id', '=', 'soals.id_jenis_soal')
            ->select('jenis_soal.nama_jenis_soal', DB::raw('count(daftars.id) as total_count'), DB::raw('sum(daftars.nilai) as total_sum'))
            ->where('daftars.id_user', $id)
            ->where('daftars.status_daftar', 2)
            ->where('soals.status_nilai', 'publish')
            ->groupBy('jenis_soal.nama_jenis_soal')
            ->orderByDesc(DB::raw('sum(daftars.nilai)'))
            ->get();

        $nilai = 0;
        foreach ($result as $r) {
            $nilai += $r->total_sum;
        }


        if ($user->id_role == 0) {

            $ujian = DB::table('daftars')
                ->select('daftars.*', 'soals.judul_soal', 'jenis_soal.nama_jenis_soal')
                ->leftJoin('soals', 'daftars.id_soal', '=', 'soals.id')
                ->leftJoin('jenis_soal', 'soals.id_jenis_soal', '=', 'jenis_soal.id')
                ->where('daftars.status_daftar', 2)
                ->where('daftars.id_user', $id)->get();
        } else {
            $ujian = DB::table('soals')
                ->leftJoin('jenis_soal', 'soals.id_jenis_soal', '=', 'jenis_soal.id')
                ->where('soals.id_user', $id)->get();
        }
        $title = $user->name;
        return view('profile.show', ['title' => $title, 'user' => $user, 'soal_count' => $soal_count, 'ujian_count' => $ujian_count, 'ujian' => $ujian, 'result' => $result, 'nilai' => $nilai]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $id,
            'name' => 'required',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'phone' => 'required|numeric|digits_between:10,13|unique:users,phone,' . $id,
            'facebook' => 'url|unique:users,facebook,' . $id,
            'twitter' => 'url|unique:users,twitter,' . $id,
            'instagram' => 'url|unique:users,instagram,' . $id,
        ]);

        if ($request->hasFile('gambar')) {
            $resorce  = $request->file('gambar');
            $gambar   = $resorce->getClientOriginalName();

            $resorce->move(public_path() . '/assets/images', $gambar);

            $user = User::find($id);
            $old_image = public_path() .  '/assets/images/' . $user->gambar;
            @unlink($old_image);

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'gambar' => $gambar,
                'phone' => $request->phone,
                'facebook' => $request->facebook,
                'twitter' => $request->twitter,
                'instagram' => $request->instagram,
            ]);

            $id = Crypt::encrypt(Auth::user()->id);
            if (!$user) {
                session()->flash('error', 'Data gagal diubah');
                return redirect(route('profile.show', $id));
            } else {
                session()->flash('success', 'Data berhasil diubah');
                return redirect(route('profile.show', $id));
            }
        } else {
            $user = User::find($id);
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'facebook' => $request->facebook,
                'twitter' => $request->twitter,
                'instagram' => $request->instagram,
            ]);

            $id = Crypt::encrypt(Auth::user()->id);
            if (!$user) {
                session()->flash('error', 'Data gagal diubah');
                return redirect(route('profile.show', $id));
            } else {
                session()->flash('success', 'Data berhasil diubah');
                return redirect(route('profile.show', $id));
            }
        }
    }

    public function update_password(Request $request, $id)
    {
        if ($request->password == $request->confirm_password) {
            $request->validate([
                'password' => 'required|min:8'
            ]);
            $user = User::find($id);
            $user->update([
                'password' => Hash::make($request->password)
            ]);

            $id = Crypt::encrypt(Auth::user()->id);
            session()->flash('success', 'Password Berhasil diperbarui');
            return redirect(route('profile.show', $id));
        } else {
            $id = Crypt::encrypt(Auth::user()->id);
            session()->flash('error', 'Konfirmasi Password tidak valid');
            return redirect(route('profile.show', $id));
        }
    }
}
