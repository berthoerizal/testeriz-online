@extends('layouts.app')

@section('content')
    <!-- Content Wrapper -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">{{ $title }}</h1>
        <hr />

        <div class="row">
            <div class="col-md-12">
                <a href="https://chat.openai.com/" class="btn btn-dark btn-md" target="_blank"><b><i
                            class="fa fa-comments"></i> Chat GPT</b></a>
            </div>
        </div>

        <br>

        <div class="row">

            @if (Auth::user()->id_role == 0)
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="float-left">
                                5 Ujian Terbaru
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
                                            <th>Kategori</th>
                                            <th>Dibuat Oleh</th>
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
                                            <td><?php echo $soal->judul_soal; ?></td>
                                            <td><?php echo $soal->nama_jenis_soal; ?></td>
                                            <td>{{ $soal->name }}</td>
                                            <td class="text-center">
                                                @if ($soal->tanggal_mulai == null || $soal->waktu_mulai == null)
                                                    -
                                                @else
                                                    <?php echo date('d-m-Y', strtotime($soal->tanggal_mulai)) . ' ' . $soal->waktu_mulai; ?>
                                                @endif
                                            </td>
                                            <td class="text-center">
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
            @else
                <div class="col-md-12 mb-2">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('dashboard') }}">
                                @method('GET')
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="id_jenis_soal">Kategori</label>
                                            <select class="form-control" id="id_jenis_soal" name="id_jenis_soal">
                                                <option value="0">Semua</option>
                                                @foreach ($jenis_soal as $jenis)
                                                    <option value="{{ $jenis->id }}"
                                                        @if ($id_jenis_soal == $jenis->id) selected @endif>
                                                        {{ $jenis->nama_jenis_soal }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="jenis_soal">Periode</label>
                                        <div class="input-group mb-3">
                                            <input id="dateRangeInput" type="number" class="form-control" aria-label="year"
                                                aria-describedby="basic-addon2" name="year" value="{{ $year }}"
                                                required>
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="submit"
                                                    id="button-addon2"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home"
                                        role="tab" aria-controls="pills-home" aria-selected="true">Grafik</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile"
                                        role="tab" aria-controls="pills-profile" aria-selected="false">Tabel</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                    aria-labelledby="pills-home-tab">
                                    <canvas id="barChart" width="400" height="120"></canvas>
                                </div>
                                <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                    aria-labelledby="pills-profile-tab">

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped" id="dataTable" width="100%"
                                            cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th width="10%">#</th>
                                                    <th width="80%">Nama</th>
                                                    <th width="10%">Score</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($users as $user)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td><a
                                                                href="{{ route('profile.show', Crypt::encrypt($user->id)) }}"><b>{{ $user->name }}</b></a>
                                                        </td>
                                                        <td class="text-right">{{ $user->score }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
    </div>

    <?php
    //for chart js bar
    $labels = [];
    $scores = [];
    
    foreach ($users as $user) {
        $labels[] = $user->name;
        $scores[] = $user->score;
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        ;
        var ctx = document.getElementById('barChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Scores',
                    data: <?php echo json_encode($scores); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
