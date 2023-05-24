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
            <div class="float-right">
                <a href="{{ route('soal.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>
                    Tambah</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="font-size: 12px;">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>Materi Soal</th>
                            <th>Judul Soal</th>
                            <th>Jenis & Status</th>
                            <th>Waktu Soal</th>
                            <th>Password Soal</th>
                            <th width="20%" class="text-center">Aksi</th>
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
                                <td>
                                    @if ($soal->materi_file == null)
                                    Tidak ada file.
                                    @else
                                    <a href="{{ route('download_materi', $soal->id) }}"><i class="fa fa-download"></i>
                                        {{ $soal->materi_file }}</a>
                                    @endif
                                    <hr>
                                    @if ($soal->materi_video == null)
                                    Tidak ada video.
                                    @else
                                    @include('soal.modal_youtube')
                                    @endif
                                </td>
                                <td><?php echo $soal->judul_soal; ?><br /><span>Oleh:
                                        {{ $soal->id_user }}</span></td>
                                <td>Jenis Soal: <b><?php echo $soal->jenis_soal; ?></b>
                                    <hr />
                                    Status Soal: <b><?php echo $soal->status_soal; ?></b>
                                </td>
                                <td><?php echo $soal->tanggal_mulai .
                                        ' ' .
                                        $soal->waktu_mulai .
                                        ' s/d <br />
                                    ' .
                                        $soal->tanggal_selesai .
                                        ' ' .
                                        $soal->waktu_selesai; ?></td>
                                <td><b>{{ $soal->pass_soal }}</b></td>
                                <td>
                                </td>
                            </tr>
                        <?php $i++;
                        }
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