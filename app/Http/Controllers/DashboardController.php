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
        $id_jenis_soal = 0;
        // get this year 
        $year = date('Y');

        if (isset($_GET['id_jenis_soal'])) {
            $id_jenis_soal = $_GET['id_jenis_soal'];
        }

        if (isset($_GET['year'])) {
            $year = $_GET['year'];
        }

        $title = "Dashboard";
        $user_count = User::all()->where('notactive', 0)->count();
        $soal_count = DB::table('soals')->where('id_user', Auth::user()->id)->count();
        if (Auth::user()->id_role == 21) {
            $soal_count = DB::table('soals')->count();
        }
        $ujian_count = DB::table('daftars')->where('id_user', Auth::user()->id)->count();

        $ujians = DB::table('soals')
            ->join('users', 'soals.id_user', '=', 'users.id')
            ->join('jenis_soal', 'soals.id_jenis_soal', '=', 'jenis_soal.id')
            ->select('soals.*', 'users.name', 'jenis_soal.nama_jenis_soal')
            ->where('soals.id_user', '!=', Auth::user()->id)
            ->where('soals.status_soal', 'publish')
            ->orderBy('soals.id', 'desc')
            ->take(5)
            ->get();

        if ($id_jenis_soal == 0) {
            $users = User::select('users.id', 'users.name', DB::raw('SUM(daftars.nilai) AS score'))
                ->leftJoin('daftars', 'daftars.id_user', '=', 'users.id')
                ->leftJoin('soals', 'soals.id', '=', 'daftars.id_soal')
                ->leftJoin('jenis_soal', 'jenis_soal.id', '=', 'soals.id_jenis_soal')
                ->where('daftars.status_daftar', 2)
                ->where('users.id_role', 0)
                ->where('users.notactive', 0)
                ->where('daftars.created_at', 'like', '%' . $year . '%')
                ->groupBy('users.name')
                ->orderByDesc('score')
                ->get();
        } else {
            $users = User::select('users.id', 'users.name', DB::raw('SUM(daftars.nilai) AS score'))
                ->leftJoin('daftars', 'daftars.id_user', '=', 'users.id')
                ->leftJoin('soals', 'soals.id', '=', 'daftars.id_soal')
                ->leftJoin('jenis_soal', 'jenis_soal.id', '=', 'soals.id_jenis_soal')
                ->where('daftars.status_daftar', 2)
                ->where('users.id_role', 0)
                ->where('users.notactive', 0)
                ->where('jenis_soal.id', $id_jenis_soal)
                ->where('daftars.created_at', 'like', '%' . $year . '%')
                ->groupBy('users.name')
                ->orderByDesc('score')
                ->get();
        }

        $jenis_soal = DB::table('jenis_soal')->get();

        $user_name = Auth::user()->name;

        return view('dashboard', ['title' => $title, 'user_count' => $user_count, 'soal_count' => $soal_count, 'ujian_count' => $ujian_count, 'ujians' => $ujians, 'user_name' => $user_name, 'jenis_soal' => $jenis_soal, 'users' => $users, 'id_jenis_soal' => $id_jenis_soal, 'year' => $year]);
    }
}
