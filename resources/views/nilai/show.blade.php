@extends('layouts.app')

@section('content')
    <style>
        /* Textarea styling */
        .nilai_peserta {
            text-align: center;
            width: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            position: absolute;
            resize: none;
            -webkit-box-sizing: border-box;
            /* <=iOS4, <= Android  2.3 */
            -moz-box-sizing: border-box;
            /* FF1+ */
            box-sizing: border-box;
            /* Chrome, IE8, Opera, Safari 5.1*/
        }

        /* Basic table styling */
        table {
            border-collapse: collapse;
        }

        table,
        th,
        td {
            position: relative;
            border: 1px solid black;
        }
    </style>
    <!-- Begin Page Content -->
    <div class="container-fluid">
        @include('partial.message')
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">{{ $title }} | {{ $user->name }}</h1>
        <hr>

        @if ($soal->status_nilai == 'draft' && Auth::user()->id != $soal->id_user)
            <div class="alert alert-secondary" role="alert">
                Nilai belum di-<b>Publish</b> oleh <b>{{ $soal->name }}</b>.
            </div>
        @elseif(
            $soal->status_nilai == 'publish' ||
                Auth::user()->id_role == '21' ||
                (Auth::user()->id == $soal->id_user && $soal->status_nilai == 'draft'))
            <div class="row">
                <div class="col-md-3 mb-3">
                    <div class="card">
                        @if ($user->gambar != null)
                            <img class="card-img-top" src="{{ asset('assets/images/' . $user->gambar) }}" alt="Card image cap">
                        @else
                            <img class="card-img-top" src="{{ asset('assets/images/profiledefault.PNG') }}"
                                alt="Card image cap">
                        @endif
                        <div class="card-body text-center">
                            <p class="card-text"><b>{{ $user->name }}</b></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card shadow  mb-4">
                        <div class="card-header">
                            <div class="float-left">
                                Informasi Nilai
                            </div>
                            <div class="float-right">
                                <a href="{{ route('profile.show', Crypt::encrypt($user->id)) }}" target="_blank"
                                    class="btn btn-sm btn-primary"><i class="fas fa-user"></i> Profile</a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td class="text-center"><i class="fa fa-user"></i></td>
                                            <td>Nama Peserta</td>
                                            <td>{{ $nilai->nama_peserta }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center"><i class="fa fa-star"></i></td>
                                            <td>Judul</td>
                                            <td><b>{{ $nilai->judul_soal }}</b></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center"><i class="fa fa-star"></i></td>
                                            <td>Kategori</td>
                                            <td><b>{{ $soal->nama_jenis_soal }}</b></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center"><i class="fa fa-question"></i></td>
                                            <td>Jumlah Pertanyaan</td>
                                            <td>{{ $jumlah_pertanyaan }}</td>
                                        </tr>
                                        <?php if($soal->jenis_soal != 'subjektif'){ ?>
                                        <tr>
                                            <td class="text-center"><i class="fa fa-check"></i></td>
                                            <td> Jawaban Benar</td>
                                            <td>{{ $nilai->terjawab }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center"><i class="fa fa-times"></i></td>
                                            <td>Jawaban Salah</td>
                                            <td>{{ $jumlah_pertanyaan - $nilai->terjawab }}</td>
                                        </tr>
                                        <?php } ?>
                                        <tr>
                                            <td class="text-center"><i class="fa fa-trophy"></i></td>
                                            <td>Total Nilai</td>
                                            <td>
                                                <b><?php echo number_format($nilai->total_nilai); ?></b>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($soal->jenis_soal == 'subjektif')
                    <div class="col-md-12">
                        <form action="{{ route('nilai_subjektif') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="id_soal" value="{{ $soal->id }}" />
                            <input type="hidden" name="id_user" value="{{ $user->id }}" />
                            <div class="card shadow col-md-12 mb-3">
                                <div class="card-header">
                                    <div class="float-left">
                                        Kunci Jawaban
                                    </div>
                                    <div class="float-right">
                                        @if ($soal->id_user == Auth::user()->id)
                                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i>
                                                Simpan Nilai</button>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th width="5%">#</th>
                                                    <th width="10%" class="text-center">Gambar</th>
                                                    <th>URL Video</th>
                                                    <th>Pertanyaan</th>
                                                    <th>Kunci Jawaban</th>
                                                    <th>Jawaban Peserta</th>
                                                    <th width="5%">Nilai</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                foreach ($jawabs as $jawab) { ?>
                                                <tr>
                                                    <td class="text-center">
                                                        <?php echo $i; ?>
                                                    </td>
                                                    <td class="text-center">
                                                        @if (!$jawab->gambar)
                                                            <img src="{{ asset('assets/images/imagedefault.png') }}"
                                                                class="img img-responsive img-thumbnail" width="50px">
                                                        @else
                                                            @include('nilai.modal_image')
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($jawab->url_video)
                                                            <?php $url_video = 'https://www.youtube.com/watch?v=' . substr($jawab->url_video, -11); ?>
                                                            <a href="{{ $url_video }}"
                                                                target="_blank">{{ $jawab->url_video }}</a>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td><?php echo $jawab->pertanyaan; ?>
                                                    </td>
                                                    <td>
                                                        {{ $jawab->jawaban_benar }}
                                                    </td>
                                                    <td>
                                                        {{ $jawab->jawaban_user }}
                                                    </td>
                                                    <td width="5%" class="text-center">
                                                        @if ($soal->id_user == Auth::user()->id)
                                                            <input type="hidden" name="id[]"
                                                                value="{{ $jawab->id }}" />
                                                            <input class="nilai_peserta" type="number" name="nilai[]"
                                                                placeholder="..." id="nilai"
                                                                value="{{ $jawab->status_jawab }}" required>
                                                        @else
                                                            {{ $jawab->status_jawab }}
                                                        @endif
                                                    </td>
                                                </tr>
                                                <?php $i++;}
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="col-md-12">
                        <div class="card shadow mb-3">
                            <div class="card-header">
                                <div class="float-left">
                                    Kunci Jawaban
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th width="5%">#</th>
                                                <th width="10%" class="text-center">Gambar</th>
                                                <th>URL Video</th>
                                                <th>Pertanyaan</th>
                                                <th>Kunci Jawaban</th>
                                                <th>Jawaban Peserta</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            foreach ($jawabs as $jawab) { ?>
                                            <tr>
                                                <td class="text-center">
                                                    <?php echo $i; ?>
                                                </td>
                                                <td class="text-center">
                                                    @if (!$jawab->gambar)
                                                        <img src="{{ asset('assets/images/imagedefault.png') }}"
                                                            class="img img-responsive img-thumbnail" width="50px">
                                                    @else
                                                        @include('nilai.modal_image')
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($jawab->url_video)
                                                        <?php $url_video = 'https://www.youtube.com/watch?v=' . substr($jawab->url_video, -11); ?>
                                                        <a href="{{ $url_video }}"
                                                            target="_blank">{{ $jawab->url_video }}</a>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td><?php echo $jawab->pertanyaan; ?></td>
                                                <td style="background-color: #ABEAC5; color:#333;">
                                                    {{ $jawab->jawaban_benar }}
                                                </td>
                                                @if ($jawab->jawaban_user == $jawab->jawaban_benar)
                                                    <td style="background-color: #ABEAC5; color:#333;">
                                                        {{ $jawab->jawaban_user }}
                                                    </td>
                                                @else
                                                    <td style="background-color: #E88880; color:#333;">
                                                        {{ $jawab->jawaban_user }}
                                                    </td>
                                                @endif
                                            </tr>
                                            <?php $i++;}
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>
    <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->

@endsection
