@extends('layouts_ujian.app')

@section('content')
    <?php
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }
    ?>
    <div class="container">
        <div class="row mb-3">
            <div class="col-md-12">
                <h4>{{ $soal->judul_soal }}</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card text-justify">
                    <div class="card-header">
                        <div class="float-right">
                            <button class="btn btn-dark btn-sm">
                                <b id="demo"></b>
                            </button>


                            @include('ujian.modal_selesai_ujian')
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            <?php foreach ($data as $row) { ?>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="table-responsive">
                                    <p><b style="color: #333;">Pertanyaan</b></p>
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td width="5%"><b><?php echo $data->currentPage(); ?>.</b>
                                                </td>
                                                <td width="55%"><?php echo $row->pertanyaan; ?></td>
                                                @if ($row->gambar != null)
                                                    <td>
                                                        @include('ujian.modal_image')
                                                    </td>
                                                @endif
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <p><b style="color: #333;">Pilihan Jawaban</b></p>
                                @foreach ($jawab as $jawab)
                                    <form
                                        action="{{ route('user_jawab_ujian', ['id_soal' => $soal->id, 'id_tanya' => $row->id]) }}"
                                        method="POST" class="pilihan_jawaban">
                                        @method('PUT')
                                        @csrf
                                        <input name="page" type="hidden" value={{ $page }}>
                                        <input type="hidden" name="jawaban_user" value="{{ $row->pilihan1 }}" />
                                        @if ($jawab->jawaban_user == $row->pilihan1)
                                            <button type="submit"
                                                class="btn btn-primary btn-sm btn-block text-justify">{{ $row->pilihan1 }}</button>
                                        @else
                                            <button type="submit"
                                                class="btn btn-outline-primary btn-sm btn-block text-justify">{{ $row->pilihan1 }}</button>
                                        @endif
                                    </form>

                                    <form
                                        action="{{ route('user_jawab_ujian', ['id_soal' => $soal->id, 'id_tanya' => $row->id]) }}"
                                        method="POST" class="pilihan_jawaban">
                                        @method('PUT')
                                        @csrf
                                        <input name="page" type="hidden" value={{ $page }}>
                                        <input type="hidden" name="jawaban_user" value="{{ $row->pilihan2 }}" />
                                        @if ($jawab->jawaban_user == $row->pilihan2)
                                            <button type="submit"
                                                class="btn btn-primary btn-sm btn-block text-justify">{{ $row->pilihan2 }}</button>
                                        @else
                                            <button type="submit"
                                                class="btn btn-outline-primary btn-sm btn-block text-justify">{{ $row->pilihan2 }}</button>
                                        @endif
                                    </form>

                                    <form
                                        action="{{ route('user_jawab_ujian', ['id_soal' => $soal->id, 'id_tanya' => $row->id]) }}"
                                        method="POST" class="pilihan_jawaban">
                                        @method('PUT')
                                        @csrf
                                        <input name="page" type="hidden" value={{ $page }}>
                                        <input type="hidden" name="jawaban_user" value="{{ $row->pilihan3 }}" />
                                        @if ($jawab->jawaban_user == $row->pilihan3)
                                            <button type="submit"
                                                class="btn btn-primary btn-sm btn-block text-justify">{{ $row->pilihan3 }}</button>
                                        @else
                                            <button type="submit"
                                                class="btn btn-outline-primary btn-sm btn-block text-justify">{{ $row->pilihan3 }}</button>
                                        @endif
                                    </form>

                                    <form
                                        action="{{ route('user_jawab_ujian', ['id_soal' => $soal->id, 'id_tanya' => $row->id]) }}"
                                        method="POST" class="pilihan_jawaban">
                                        @method('PUT')
                                        @csrf
                                        <input name="page" type="hidden" value={{ $page }}>
                                        <input type="hidden" name="jawaban_user" value="{{ $row->pilihan4 }}" />
                                        @if ($jawab->jawaban_user == $row->pilihan4)
                                            <button type="submit"
                                                class="btn btn-primary btn-sm btn-block text-justify">{{ $row->pilihan4 }}</button>
                                        @else
                                            <button type="submit"
                                                class="btn btn-outline-primary btn-sm btn-block text-justify">{{ $row->pilihan4 }}</button>
                                        @endif
                                    </form>
                                @endforeach

                            </div>
                        </div>
                        <?php } ?>
                        </p>
                    </div>
                    {{-- <div class="card-footer text-muted">
                        <div class="float-right">
                            {!! $data->links() !!}
                        </div>
                    </div> --}}
                </div>
            </div>
            <div class="col-md-12 mt-2">
                <div class="card text-justify">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex flex-wrap justify-content-center">
                                    @foreach ($tanya as $index => $row)
                                        <a href="{{ route('halaman_soal', ['id_soal' => $soal->id, 'page' => $index + 1]) }}"
                                            class="btn 
                                        <?php if ($index + 1 == $page) {
                                            echo 'btn-primary';
                                        } else {
                                            if ($row->jawaban_user != null) {
                                                echo 'btn-outline-primary';
                                            } else {
                                                echo 'btn-secondary';
                                            }
                                        } ?>
                                         btn-sm text-center m-1">
                                            {{ $index + 1 }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $id_soal = $soal->id;
        $tanggal_selesai = $soal->tanggal_selesai;
        $waktu_selesai = $soal->waktu_selesai;
        ?>
    </div>
    <script>
        // Set the date we're counting down to
        var tanggal_waktu = new Date("<?php
        echo $tanggal_selesai;
        echo ' ';
        echo $waktu_selesai;
        ?>
                ").getTime();

                // Update the count down every 1 second
                var x = setInterval(function() {

                    // Get todays date and time
                    var now = new Date().getTime();

                    // Find the distance between now and the count down date
                    var distance = tanggal_waktu - now;

                    // Time calculations for days, hours, minutes and seconds
                    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    // Output the result in an element with id="demo"
                    document.getElementById("demo").innerHTML = days + "d " + hours + "h " +
                        minutes + "m " + seconds + "s ";

                    // If the count down is over, write some text 
                    if (distance < 0) {
                        clearInterval(x);
                        window.location.href = "{{ route('selesai_ujian', ['id_soal' => $id_soal]) }}";
                        // document.getElementById('btnSignIn').click(); //kondisi tombol ditekan otomatis
                    }
                }, 1000);
    </script>
@endsection
