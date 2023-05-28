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

                    {{-- @if (Auth::user()->id == $user->id)
                        <div class="card-header">
                            @include('profile.update_password')
                        </div>
                    @endif --}}


                    <div class="card-body">
                        @if ($user->gambar != null)
                            <img class="card-img-top" src="{{ asset('assets/images/' . $user->gambar) }}" alt="Card image cap">
                        @else
                            <img class="card-img-top" src="{{ asset('assets/images/profiledefault.PNG') }}"
                                alt="Card image cap">
                        @endif
                        <div class="card-body text-center">
                            <b>{{ $user->name }}</b>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ $user->facebook }}">
                            <i class="fab fa-facebook-f" style="color: #1877F2;"></i>
                        </a>
                        <a href="{{ $user->twitter }}">
                            <i class="fab fa-twitter" style="color: #1DA1F2;"></i>
                        </a>
                        <a href="{{ $user->instagram }}">
                            <i class="fab fa-instagram" style="color: #E4405F;"></i>
                        </a>
                    </div>
                    @if ($user->id_role == 0)
                        <div class="card-footer">

                            <button class="btn btn-primary btn-sm btn-block"> <i class="fas fa-trophy text-warning"></i>
                                <b>Total Score :
                                    {{ $nilai }}</b></button>
                        </div>
                    @endif
                    @if ($user->id_role == 0)
                        <div class="card-footer">

                            <p style="font-size: 14px;">Total Ujian Diikuti : <span
                                    class="badge badge-primary">{{ $ujian_count }}</span></p>
                            <canvas id="myChartPie" width="400" height="400"></canvas>

                        </div>
                    @endif
                </div>
            </div>
            @if (Auth::user()->id == $user->id)
                <div class="col-md-9">
                    <div class="card shadow mb-4">

                        @if ($user->id_role == 0)
                            <div class="card-header">
                                <canvas id="myChartBar" width="400" height="150"></canvas>
                            </div>
                        @endif

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
                                                <td class="text-center"><i class="fab fa-facebook-f"></i></td>
                                                <td>URL Facebook</td>
                                                <td><input type="text" class="form-control form-control-sm"
                                                        name="facebook" value="{{ $user->facebook }}"></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><i class="fab fa-twitter"></i></td>
                                                <td>URL Twitter</td>
                                                <td><input type="text" class="form-control form-control-sm"
                                                        name="twitter" value="{{ $user->twitter }}"></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><i class="fab fa-instagram"></i></td>
                                                <td>URL Instagram</td>
                                                <td><input type="text" class="form-control form-control-sm"
                                                        name="instagram" value="{{ $user->instagram }}"></td>
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
                        @if ($user->id_role == 0)
                            <div class="card-header">

                                <canvas id="myChartBar" width="400" height="150"></canvas>
                            </div>
                        @endif
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td class="text-center"><i class="fas fa-user"></i></td>
                                            <td>Nama</td>
                                            <td>{{ $user->name }}
                                                @if ($user->notactive == 1)
                                                    <span class="badge badge-danger">Tidak Aktif</span>
                                                @else
                                                    <span class="badge badge-success">Aktif</span>
                                                @endif
                                            </td>
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

        var result = <?php echo json_encode($result); ?>;

        var labels = [];
        var dataValues = [];
        var backgroundColors = [];

        result.forEach(function(row) {
            labels.push(row.nama_jenis_soal);
            dataValues.push(row.total_count);
            backgroundColors.push(getRandomColor());
        });

        var data = {
            labels: labels,
            datasets: [{
                data: dataValues,
                backgroundColor: backgroundColors,
            }]
        };

        var ctxPie = document.getElementById('myChartPie').getContext('2d');
        new Chart(ctxPie, {
            type: 'pie',
            data: data
        });

        // Bar Chart
        var labelsBar = [];
        var dataValuesBar = [];
        var backgroundColorsBar = []; // Added array for bar chart colors

        result.forEach(function(row) {
            labelsBar.push(row.nama_jenis_soal);
            dataValuesBar.push(row.total_sum);
            backgroundColorsBar.push(getColorForLabel(row
                .nama_jenis_soal)); // Use function to get color based on label
        });

        var dataBar = {
            labels: labelsBar,
            datasets: [{
                label: 'Score Tertinggi',
                data: dataValuesBar,
                backgroundColor: backgroundColorsBar
            }]
        };

        var ctxBar = document.getElementById('myChartBar').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: dataBar,
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        function getRandomColor() {
            var r = Math.floor(Math.random() * 156) + 100; // Generate random values between 100 and 255
            var g = Math.floor(Math.random() * 156) + 100;
            var b = Math.floor(Math.random() * 156) + 100;
            return 'rgb(' + r + ',' + g + ',' + b + ')';
        }

        function getColorForLabel(label) {
            var index = labels.indexOf(label); // Get the index of the label in the labels array
            if (index !== -1) {
                return backgroundColors[index]; // Return the corresponding color from the pie chart colors
            }
            return 'rgba(75, 192, 192, 0.6)'; // Default color for unmatched labels
        }
    </script>
@endsection
