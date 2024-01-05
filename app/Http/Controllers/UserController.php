<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::user()->id_role == 21) {
            $title = "Pengguna";
            $users = User::all();
            return view('user.index', ['title' => $title, 'users' => $users]);
        } else {
            return abort(404);
        }
    }

    public function store(Request $request)
    {
        if ($request->password == $request->confirm_password) {
            $request->validate([
                'name' => 'required|min:3|max:50|regex:/^[a-zA-Z ]+$/',
                'email' => 'required|email|unique:users|ends_with:@gmail.com|ends_with:@yahoo.com|ends_with:@hotmail.com|ends_with:@outlook.com|ends_with:@live.com',
                'password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/|confirmed',
                'phone' => 'required|numeric|digits_between:10,13|starts_with:0|unique:users'
            ]);

            $users = User::all();
            foreach ($users as $users) {
                if ($users->email == $request->email) {
                    session()->flash('error', 'Data gagal ditambah, email ' . $request->email . ' sudah digunakan');
                    return redirect(route('user.index'));
                }
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'id_role' => $request->id_role,
                'phone' => $request->phone
            ]);

            if (!$user) {
                session()->flash('error', 'Data gagal ditambah');
                return redirect(route('user.index'));
            } else {
                session()->flash('success', 'Data berhasil ditambah');
                return redirect(route('user.index'));
            }
        } else {
            session()->flash('error', 'Konfirmasi Password tidak valid');
            return redirect(route('user.index'));
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $id,
            'name' => 'required|min:3|max:50|regex:/^[a-zA-Z ]+$/',
            'phone' => 'required|numeric|digits_between:10,13|starts_with:0|unique:users,phone,' . $id,
        ]);

        $user = User::find($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'id_role' => $request->id_role,
            'phone' => $request->phone,
            'notactive' => $request->notactive,
        ]);

        if (!$user) {
            session()->flash('error', 'Data gagal diubah');
            return redirect(route('user.index'));
        } else {
            session()->flash('success', 'Data berhasil diubah');
            return redirect(route('user.index'));
        }
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if ($id == Auth::user()->id) {
            session()->flash('error', 'Data gagal dihapus');
            return redirect(route('user.index'));
        } else {
            $old_image = public_path() .  '/assets/images/' . $user->gambar;
            @unlink($old_image);
            $user->delete();
            if (!$user) {
                session()->flash('error', 'Data gagal dihapus');
                return redirect(route('user.index'));
            } else {
                session()->flash('success', 'Data berhasil dihapus');
                return redirect(route('user.index'));
            }
        }
    }

    public function reset_password($id)
    {
        if ($id == Auth::user()->id) {
            session()->flash('error', 'Password gagal diubah');
            return redirect(route('user.index'));
        } else {
            // $karakter = "ABCDEFGHIJKLMNOPQRSTUVWQYZ1234567890";
            // $password = substr(str_shuffle($karakter), 0, 8);
            $password = "12345678";
            $user = User::find($id);
            $user->update([
                'password' => Hash::make($password)
            ]);

            $user = User::find($id);
            session()->flash('success', 'Email: ' . $user->email . ' | Password Baru: ' . $password . '');
            return redirect(route('user.index'));
        }
    }
}
