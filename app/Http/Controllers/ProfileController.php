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
        if (Auth::user()->id == $id) {
            $user = User::find($id);
            $title = $user->name;
            return view('profile.show', ['title' => $title, 'user' => $user]);
        } else {
            abort(404);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $id,
            'name' => 'required',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
