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
                                                    <?php echo date('d-m-Y', strtotime($soal->tanggal_mulai)) .
                                                        '
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ' .
                                                        $soal->waktu_mulai; ?>
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
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="id_jenis_soal">Kategori</label>
                                        <select class="form-control" id="id_jenis_soal" name="id_jenis_soal">
                                            <option value="0">Semua</option>
                                            @foreach ($jenis_soal as $jenis)
                                                <option value="{{ $jenis->id }}">
                                                    {{ $jenis->nama_jenis_soal }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="jenis_soal">Periode</label>
                                    <div class="input-group mb-3">
                                        <input id="dateRangeInput" type="text" class="form-control"
                                            aria-label="Kode Ujian" aria-describedby="basic-addon2" name="peride" readonly>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="button-addon2"><i
                                                    class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="myChart" width="400" height="150"></canvas>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $('#dateRangeInput').daterangepicker({
            opens: 'left', // Position the calendar on the left side of the input field
            startDate: moment().startOf('day'), // Set the initial start date
            endDate: moment().endOf('day'), // Set the initial end date
            locale: {
                format: 'YYYY-MM-DD', // Format of the selected date range
            },
        });
        // Data for the chart
        var data = {
            labels: ['Yudi', 'Yola', 'Cika', 'Budi', 'Andi', 'Rani'],
            datasets: [{
                label: 'Score',
                data: [120, 180, 90, 200, 150, 300],
                backgroundColor: 'rgba(75, 192, 192, 0.6)' // Bar color
            }]
        };

        // Configuration options
        var options = {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        };

        // Create the chart
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: options
        });
    </script>
@endsection
