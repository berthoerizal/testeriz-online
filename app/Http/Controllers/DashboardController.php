<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Konfigurasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $title = "Dashboard";
        $user_count = User::all()->count();
        $soal_count = DB::table('soals')->where('id_user', Auth::user()->id)->count();
        $ujian_count = DB::table('daftars')->where('id_user', Auth::user()->id)->count();

        $ujians = DB::table('soals')
            ->join('users', 'soals.id_user', '=', 'users.id')
            ->select('soals.*', 'users.name')
            ->where('soals.id_user', '!=', Auth::user()->id)
            ->where('soals.status_soal', 'publish')
            ->orderBy('soals.id', 'desc')
            ->take(3)
            ->get();

        $user_name = Auth::user()->name;

        return view('dashboard', ['title' => $title, 'user_count' => $user_count, 'soal_count' => $soal_count, 'ujian_count' => $ujian_count, 'ujians' => $ujians, 'user_name' => $user_name]);
    }
}
