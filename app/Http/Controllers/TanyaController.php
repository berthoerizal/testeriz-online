<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Soal;
use App\Tanya;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class TanyaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pertanyaan' => 'required',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($request->jawaban == "pilihan1") {
            $jawaban_benar = $request->pilihan1;
        } elseif ($request->jawaban == "pilihan2") {
            $jawaban_benar = $request->pilihan2;
        } elseif ($request->jawaban == "pilihan3") {
            $jawaban_benar = $request->pilihan3;
        } elseif ($request->jawaban == "pilihan4") {
            $jawaban_benar = $request->pilihan4;
        } else {
            $jawaban_benar = NULL;
        }

        $soal = DB::table('soals')->where('slug_soal', $request->slug_soal)->first();

        DB::table('daftars')->where('id_soal', $soal->id)->delete();
        DB::table('jawabs')->where('id_soal', $soal->id)->delete();

        if ($request->hasFile('gambar')) {
            $resorce  = $request->file('gambar');
            $gambar   =  time() . "_" . $resorce->getClientOriginalName();
            // $resorce->move(\base_path() . "/../assets/images", $gambar);
            $resorce->move(public_path() . '/assets/images', $gambar);

            if ($soal->jenis_soal == 'obyektif') {
                $tanya = Tanya::create([
                    'id_soal' => $soal->id,
                    'pertanyaan' => $request->pertanyaan,
                    'jawaban' => $jawaban_benar,
                    'pilihan1' => $request->pilihan1,
                    'pilihan2' => $request->pilihan2,
                    'pilihan3' => $request->pilihan3,
                    'pilihan4' => $request->pilihan4,
                    'pilihan_benar' => $request->jawaban,
                    'gambar' => $gambar
                ]);
            } else {
                $tanya = Tanya::create([
                    'id_soal' => $soal->id,
                    'pertanyaan' => $request->pertanyaan,
                    'jawaban' => $request->jawaban,
                    'gambar' => $gambar
                ]);
            }
        } else {
            $gambar = NULL;
            if ($soal->jenis_soal == 'obyektif') {
                $tanya = Tanya::create([
                    'id_soal' => $soal->id,
                    'pertanyaan' => $request->pertanyaan,
                    'jawaban' => $jawaban_benar,
                    'pilihan1' => $request->pilihan1,
                    'pilihan2' => $request->pilihan2,
                    'pilihan3' => $request->pilihan3,
                    'pilihan4' => $request->pilihan4,
                    'pilihan_benar' => $request->jawaban,
                    'gambar' => $gambar
                ]);
            } else {
                $tanya = Tanya::create([
                    'id_soal' => $soal->id,
                    'pertanyaan' => $request->pertanyaan,
                    'jawaban' => $request->jawaban,
                    'gambar' => $gambar
                ]);
            }
        }

        if (!$tanya) {
            session()->flash('error', 'Data gagal ditambah');
            return redirect(route('soal.show', $request->slug_soal));
        } else {
            session()->flash('success', 'Data berhasil ditambah');
            return redirect(route('soal.show', $request->slug_soal));
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pertanyaan' => 'required',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($request->jawaban == "pilihan1") {
            $jawaban_benar = $request->pilihan1;
        } elseif ($request->jawaban == "pilihan2") {
            $jawaban_benar = $request->pilihan2;
        } elseif ($request->jawaban == "pilihan3") {
            $jawaban_benar = $request->pilihan3;
        } elseif ($request->jawaban == "pilihan4") {
            $jawaban_benar = $request->pilihan4;
        } else {
            $jawaban_benar = NULL;
        }

        $soal = DB::table('soals')->where('slug_soal', $request->slug_soal)->first();

        DB::table('daftars')->where('id_soal', $soal->id)->delete();
        DB::table('jawabs')->where('id_soal', $soal->id)->delete();

        if ($request->hasFile('gambar')) {
            $resorce  = $request->file('gambar');
            $gambar   =  time() . "_" . $resorce->getClientOriginalName();
            // $resorce->move(\base_path() . "/../assets/images", $gambar);
            $resorce->move(public_path() . '/assets/images', $gambar);

            $tanya = Tanya::find($id);
            $old_image = public_path() . "/assets/images/" . $tanya->gambar;
            @unlink($old_image);

            if ($soal->jenis_soal == 'obyektif') {
                $tanya->update([
                    'id_soal' => $soal->id,
                    'pertanyaan' => $request->pertanyaan,
                    'jawaban' => $jawaban_benar,
                    'pilihan1' => $request->pilihan1,
                    'pilihan2' => $request->pilihan2,
                    'pilihan3' => $request->pilihan3,
                    'pilihan4' => $request->pilihan4,
                    'pilihan_benar' => $request->jawaban,
                    'gambar' => $gambar
                ]);
            } else {
                $tanya->update([
                    'id_soal' => $soal->id,
                    'pertanyaan' => $request->pertanyaan,
                    'jawaban' => $request->jawaban,
                    'gambar' => $gambar
                ]);
            }

            if (!$tanya) {
                session()->flash('error', 'Data gagal diubah');
                return redirect(route('soal.show', $request->slug_soal));
            } else {
                session()->flash('success', 'Data berhasil diubah');
                return redirect(route('soal.show', $request->slug_soal));
            }
        } else {
            $tanya = Tanya::find($id);
            if ($soal->jenis_soal == 'obyektif') {
                $tanya->update([
                    'id_soal' => $soal->id,
                    'pertanyaan' => $request->pertanyaan,
                    'jawaban' => $jawaban_benar,
                    'pilihan1' => $request->pilihan1,
                    'pilihan2' => $request->pilihan2,
                    'pilihan3' => $request->pilihan3,
                    'pilihan4' => $request->pilihan4,
                    'pilihan_benar' => $request->jawaban
                ]);
            } else {
                $tanya->update([
                    'id_soal' => $soal->id,
                    'pertanyaan' => $request->pertanyaan,
                    'jawaban' => $request->jawaban
                ]);
            }

            if (!$tanya) {
                session()->flash('error', 'Data gagal diubah');
                return redirect(route('soal.show', $request->slug_soal));
            } else {
                session()->flash('success', 'Data berhasil diubah');
                return redirect(route('soal.show', $request->slug_soal));
            }
        }
    }

    public function destroy(Request $request, $id)
    {
        $soal = DB::table('soals')->where('slug_soal', $request->slug_soal)->first();
        DB::table('daftars')->where('id_soal', $soal->id)->delete();
        DB::table('jawabs')->where('id_soal', $soal->id)->delete();

        $tanya = Tanya::find($id);
        if ($tanya->gambar != 'imagedefault.png') {
            $old_image = public_path() . "/assets/images/" . $tanya->gambar;
            @unlink($old_image);
        }
        $tanya->delete();

        if (!$tanya) {
            session()->flash('error', 'Data gagal dihapus');
            return redirect(route('soal.show', $request->slug_soal));
        } else {
            session()->flash('success', 'Data berhasil dihapus');
            return redirect(route('soal.show', $request->slug_soal));
        }
    }
}
