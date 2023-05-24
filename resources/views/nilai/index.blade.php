@extends('layouts.app')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        @include('partial.message')

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">{{ $title }} - {{ $soal->judul_soal }}</h1>
        <hr>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="float-left">
                    Nilai Peserta Ujian
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th>Nama Peserta</th>
                                <th>Email</th>
                                <th>Nilai</th>
                                <th width="20%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($nilais as $nilai) { ?>
                            <tr>
                                <td class="text-center">
                                    <?php echo $i; ?>
                                </td>
                                <td><?php echo $nilai->nama_peserta; ?></td>
                                <td><?php echo $nilai->email; ?></td>
                                </td>
                                </td>
                                <td class="text-right"><?php echo number_format($nilai->total_nilai); ?></td>
                                <td class="text-center">
                                    <a class="btn btn-primary btn-sm"
                                        href="{{ route('detail_nilai', ['id_soal' => $nilai->id_soal, 'id_user' => Crypt::encrypt($nilai->id_user)]) }}">
                                        <i class="fa fa-book"></i>
                                        Info
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
