@extends('layouts_ujian.app')

@section('content')
    <style>
        .content {
            display: flex;
            justify-content: space-around;
            align-items: center;
        }

        .value {
            font-size: 100px;
            display: block;
            font-weight: bold;
            color: #6780FC;
        }

        #user {
            font-size: 20px;
            display: block;
            font-weight: bold;
            color: #6780FC;
        }
    </style>
    <div class="container">
        <div class="card">
            <div class="card-body" style="padding: 30px;">
                <!-- desktop -->
                <div class="d-md-block d-none">
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="d-flex h-100">
                                <div class="justify-content-center align-self-center pl-5">
                                    <h2>
                                        <strong class="text-primary">{{ $konfigurasi->namaweb }}</strong><br />
                                        Ujian Online
                                    </h2>
                                    <p>{{ $konfigurasi->desc1 }}</p>
                                    <a href="{{ route('soal.index') }}" class="btn btn-outline-info">
                                        Buat Soal
                                    </a>
                                    <a href="{{ route('ujian.index') }}" class="btn btn-outline-info">
                                        Ikuti Ujian
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <img src="{{ asset('assets/images/home.png') }}" width="80%" />
                        </div>
                    </div>
                </div>

                <!-- handphone -->
                <div class="d-sm-block d-md-none">
                    <div class="row mt-4">
                        <div class="col-md-6 mb-3">
                            <img src="{{ asset('assets/images/home.png') }}" width="100%" />
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex h-100">
                                <div class="justify-content-center align-self-center">
                                    <h2>
                                        <strong class="text-primary">{{ $konfigurasi->namaweb }}</strong><br />
                                        Ujian Online
                                    </h2>
                                    <p>{{ $konfigurasi->desc1 }}</p>
                                    <a href="{{ route('soal.index') }}" class="btn btn-outline-info">
                                        Buat Soal
                                    </a>
                                    <a href="{{ route('ujian.index') }}" class="btn btn-outline-info">
                                        Ikuti Ujian
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body" style="padding: 30px;">
                <div class="row">
                    <div class="col-md-8">
                        <p id="desc2">{!! $konfigurasi->desc2 !!}</p>
                    </div>
                    <dvi class="col-md-4">
                        <div class="content">
                            <div class="value" akhi="<?php echo $user_count; ?>">0</div>
                        </div>
                        <p class="text-center"><b id="user">Pengguna
                                Aktif</b></p>
                    </dvi>
                </div>
            </div>
        </div>
    </div>
    <script>
        const counters = document.querySelectorAll('.value');
        const speed = 200;

        counters.forEach(counter => {
            const animate = () => {
                const value = +counter.getAttribute('akhi');
                const data = +counter.innerText;

                const time = value / speed;
                if (data < value) {
                    counter.innerText = Math.ceil(data + time);
                    setTimeout(animate, 1);
                } else {
                    counter.innerText = value;
                }

            }

            animate();
        });
    </script>
@endsection
