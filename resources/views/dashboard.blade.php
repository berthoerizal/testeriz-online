@extends('layouts.app')

@section('content')
    <!-- Content Wrapper -->

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">{{ $title }}</h1>
        <hr />
        <div class="row">
            <div class="col-md-3 mb-4">
                @if (Auth::user()->id_role == 21)
                    <div class="card border-left-dark mb-3 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Pengguna
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $user_count }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="card border-left-dark mb-3 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Soal Dibuat
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $soal_count }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-question fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-left-dark mb-3 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Ujian Diikuti
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $ujian_count }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-check fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="alert alert-primary" role="alert">
                    <p>Hello <b><?php echo $user_name; ?></b></p>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            Ujian Terbaru
                        </div>
                        <div class="float-right">
                            <a href="{{ route('ujian.index') }}" class="btn btn-primary btn-sm">Lihat Semua <i
                                    class="fa fa-arrow-alt-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0"
                                style="font-size: 12px;">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th>Judul</th>
                                        <th>Jadwal Mulai</th>
                                        <th>Jadwal Selesai</th>
                                        <th width="15%" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($ujians as $soal) { ?>
                                    <tr>
                                        <td class="text-center">
                                            <?php echo $i; ?>
                                        </td>
                                        <td><?php echo $soal->judul_soal; ?><br /><span>Oleh:
                                                {{ $soal->name }}</span></td>
                                        <td>
                                            @if ($soal->tanggal_mulai == null || $soal->waktu_mulai == null)
                                                -
                                            @else
                                                <?php echo date('d-m-Y', strtotime($soal->tanggal_mulai)) .
                                                    '
                                                                                                                                                ' .
                                                    $soal->waktu_mulai; ?>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($soal->tanggal_selesai == null || $soal->waktu_selesai == null)
                                                -
                                            @else
                                                <?php echo date('d-m-Y', strtotime($soal->tanggal_selesai)) . ' ' . $soal->waktu_selesai; ?>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a class="btn btn-primary btn-sm"
                                                href="{{ route('soal.show', $soal->slug_soal) }}">
                                                <i class="fa fa-book"></i> Lihat
                                            </a>
                                        </td>
                                    </tr>
                                    <?php $i++;}
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
