@extends('layouts.app')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        @include('partial.message')

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Profile</h1>
        <hr>

        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="card">
                    <div class="card-body">
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
                    @if ($user->id_role == 0)
                        <div class="card-footer">

                            <p style="font-size: 14px;">Total Ujian Diikuti : {{ $ujian_count }}</p>
                            <canvas id="myChart" width="400" height="400"></canvas>

                        </div>
                        <div class="card-footer">

                            <button class="btn btn-primary btn-sm btn-block"> <i class="fas fa-trophy text-warning"></i>
                                <b>Score :
                                    100</b></button>
                        </div>
                    @endif
                </div>
            </div>
            @if (Auth::user()->id == $user->id)
                <div class="col-md-9">
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <div class="float-right">
                                @include('profile.update_password')
                            </div>
                        </div>

                        <form action="{{ route('profile.update', $user->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @method('PUT')
                            {{ csrf_field() }}
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" width="100%" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td class="text-center"><i class="fas fa-user"></i></td>
                                                <td>Nama</td>
                                                <td><input type="text" class="form-control form-control-sm"
                                                        name="name" value="{{ $user->name }}" required></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><i class="fa fa-envelope"></i></td>
                                                <td>Email</td>
                                                <td><input type="email" class="form-control form-control-sm"
                                                        name="email" value="{{ $user->email }}" required></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><i class="fas fa-phone"></i></td>
                                                <td>Phone</td>
                                                <td><input type="text" class="form-control form-control-sm"
                                                        name="phone" value="{{ $user->phone }}" required></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><i class="fas fa-image"></i></td>
                                                <td>Upload Gambar</td>
                                                <td>
                                                    <input type="file" name="gambar" id="gambar"
                                                        onchange="previewImg()">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><i class="fas fa-book"></i></td>
                                                <td>Akses Level</td>
                                                <td>
                                                    @if ($user->id_role == 0 || $user->id_role == null)
                                                        <span class="badge badge-primary">Jawab Ujian</span>
                                                    @elseif ($user->id_role == 1)
                                                        <span class="badge badge-success">Buat Soal</span>
                                                    @elseif ($user->id_role == 21)
                                                        <span class="badge badge-warning">Administrator</span>
                                                    @else
                                                        <span class="badge badge-danger">Belum Terdaftar</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @if (Auth::user()->id_role == 1)
                                                <tr>
                                                    <td class="text-center"><i class="fa fa-question"></i></td>
                                                    <td>Soal Dibuat</td>
                                                    <td>{{ $soal_count }}</td>
                                                </tr>
                                            @endif

                                            @if (Auth::user()->id_role == 0 || Auth::user()->id_role == null)
                                                <tr>
                                                    <td class="text-center"><i class="fa fa-check"></i></td>
                                                    <td>Ujian Diikuti</td>
                                                    <td>{{ $ujian_count }}</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <span class="float-right">
                                    <button type="reset" class="btn btn-secondary btn-sm">Reset</button>
                                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i>
                                        Simpan</button>
                                </span>
                                <br><br>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="col-md-9">
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <div class="float-right">
                                @if ($user->notactive == 1)
                                    <span class="badge badge-danger">Tidak Aktif</span>
                                @else
                                    <span class="badge badge-success">Aktif</span>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td class="text-center"><i class="fas fa-user"></i></td>
                                            <td>Nama</td>
                                            <td>{{ $user->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center"><i class="fa fa-envelope"></i></td>
                                            <td>Email</td>
                                            <td>{{ $user->email }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center"><i class="fas fa-phone"></i></td>
                                            <td>Phone</td>
                                            <td>{{ $user->phone }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center"><i class="fas fa-book"></i></td>
                                            <td>Akses Level</td>
                                            <td>
                                                @if ($user->id_role == 0 || $user->id_role == null)
                                                    <span class="badge badge-primary">Jawab Ujian</span>
                                                @elseif ($user->id_role == 1)
                                                    <span class="badge badge-success">Buat Soal</span>
                                                @elseif ($user->id_role == 21)
                                                    <span class="badge badge-warning">Administrator</span>
                                                @else
                                                    <span class="badge badge-danger">Belum Terdaftar</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @if ($user->id_role == 1)
                                            <tr>
                                                <td class="text-center"><i class="fa fa-question"></i></td>
                                                <td>Soal Dibuat</td>
                                                <td>{{ $soal_count }}</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Judul</th>
                                            <th>Kategori</th>
                                            <th>Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ujian as $s)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $s->judul_soal }}</td>
                                                <td>{{ $s->nama_jenis_soal }}</td>
                                                <td class="text-center">
                                                    {{ date('d/m/Y H:i:s', strtotime($s->created_at)) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function previewImg() {
            const gambar = document.querySelector('#gambar');
            const imgPreview = document.querySelector('.img-preview');
            const fileGambar = new FileReader();
            fileGambar.readAsDataURL(gambar.files[0]);

            fileGambar.onload = function(e) {
                imgPreview.src = e.target.result;
            }
        }

        var data = {
            labels: ['Matematika', 'Bahasa Indonesia', 'IPA', 'IPS'],
            datasets: [{
                data: [12, 19, 3, 5],
                backgroundColor: ['red', 'blue', 'yellow', 'green']
            }]
        };

        // Create the pie chart
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: data
        });
    </script>
@endsection
