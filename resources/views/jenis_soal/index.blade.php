@extends('layouts.app')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        {{-- @include('partial.message') --}}

        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @else
            @include('partial.message')
        @endif

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">{{ $title }}</h1>
        <hr>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="float-right">

                    @include('jenis_soal.create')
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Nama Jenis Soal</th>
                                <th class="text-center" width="30%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($jenis_soal as $key=> $val) { ?>
                            <tr>
                                <td class="text-center"><?php echo $key + 1; ?>.</td>
                                <td>{{ $val->nama_jenis_soal }}</td>
                                <td>
                                    @include('jenis_soal.edit')
                                    @include('jenis_soal.delete')
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
