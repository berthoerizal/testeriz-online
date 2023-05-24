@extends('layouts.app')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        @include('partial.message')

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">{{ $title }}</h1>
        <hr>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="float-left">
                    Sudah Melakukan Pendaftaran
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th>Judul</th>
                                <th>Jadwal Mulai</th>
                                <th>Jadwal Selesai</th>
                                <th width="10%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($soal as $soal) { ?>
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
                                        <?php echo date('d-m-Y', strtotime($soal->tanggal_selesai)) . ' ' .
                                        $soal->waktu_selesai; ?>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-primary btn-sm" href="{{ route('soal.show', $soal->slug_soal) }}">
                                        <i class="fa fa-book"></i>
                                        Lihat
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
    <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->
@endsection
