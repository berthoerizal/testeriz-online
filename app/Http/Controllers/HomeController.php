<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function ranking($id_jenis_soal, $year)
    {
        $title = "Top 12 Ranking";

        if ($id_jenis_soal == 0) {
            $users = User::select('users.id', 'users.name', DB::raw('SUM(daftars.nilai) AS score'), 'users.facebook', 'users.twitter', 'users.instagram')
                ->leftJoin('daftars', 'daftars.id_user', '=', 'users.id')
                ->leftJoin('soals', 'soals.id', '=', 'daftars.id_soal')
                ->leftJoin('jenis_soal', 'jenis_soal.id', '=', 'soals.id_jenis_soal')
                ->where('daftars.status_daftar', 2)
                ->where('users.id_role', 0)
                ->where('users.notactive', 0)
                ->where('daftars.created_at', 'like', '%' . $year . '%')
                ->groupBy('users.name')
                ->orderByDesc('score')
                ->get(12);
        } else {
            $users = User::select('users.id', 'users.name', DB::raw('SUM(daftars.nilai) AS score'), 'users.facebook', 'users.twitter', 'users.instagram')
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
                ->get(12);
        }
        $jenis_soal = DB::table('jenis_soal')->get();

        return view('ranking', compact('title', 'users', 'jenis_soal', 'id_jenis_soal', 'year'));
    }
}
