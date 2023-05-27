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
                    @include('user.create')
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Phone</th>
                                <th class="text-center">Hak Akses</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" width="30%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($users as $user) { ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td class="text-center">{{ $user->phone }}</td>
                                <td class="text-center">
                                    @if ($user->id_role == 0)
                                        <span class="badge badge-primary">Jawab Ujian</span>
                                    @elseif ($user->id_role == 1)
                                        <span class="badge badge-success">Buat Soal</span>
                                    @elseif ($user->id_role == 21)
                                        <span class="badge badge-warning">Administrator</span>
                                    @else
                                        <span class="badge badge-danger">Belum Terdaftar</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($user->notactive == 1)
                                        <span class="badge badge-danger">Tidak Aktif</span>
                                    @else
                                        <span class="badge badge-success">Aktif</span>
                                    @endif
                                </td>
                                <td><a href="{{ route('profile.show', Crypt::encrypt($user->id)) }}" target="_blank"
                                        class="btn btn-sm btn-primary"><i class="fas fa-user"></i> Profile</a>
                                    @include('user.edit')
                                    @include('user.reset_password')
                                    {{-- @include('user.delete') --}}
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
