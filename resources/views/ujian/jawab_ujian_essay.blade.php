@extends('layouts_ujian.app')

@section('content')
    <style>
        /* Textarea styling */
        textarea {
            width: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            position: absolute;
            resize: none;
            -webkit-box-sizing: border-box;
            /* <=iOS4, <= Android  2.3 */
            -moz-box-sizing: border-box;
            /* FF1+ */
            box-sizing: border-box;
            /* Chrome, IE8, Opera, Safari 5.1*/
        }

        /* Basic table styling */
        table {
            border-collapse: collapse;
        }

        table,
        th,
        td {
            position: relative;
            border: 1px solid black;
        }

    </style>
    <div class="container">
        <div class="row mb-3">
            <div class="col-md-12">
                <h4>{{ $soal->judul_soal }}</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('selesai_ujian_essay') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="id_soal" value="{{ $soal->id }}" />
                    <div class="card text-justify">
                        <div class="card-header">
                            <p
                                style="padding: 8px; border-style: solid; font-size: 12px; border-color: #3B3838; color: #ffff; border-radius: 8px; background-color: #3B3838">
                                <b id="demo"></b>
                            </p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <th width="5%">#</th>
                                                <th width="40%">Pertanyaan</th>
                                                <th width="15%">Gambar</th>
                                                <th width="40%">Jawaban Peserta</th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                foreach ($data as $row) {
                                                $id_tanya = $row->id; ?>
                                                <tr>
                                                    <td><b><?php echo $i; ?>.</b>
                                                    </td>
                                                    <td><?php echo $row->pertanyaan; ?></td>
                                                    @if ($row->gambar != null)
                                                        <td>
                                                            @include('ujian.modal_image')
                                                        </td>
                                                    @else
                                                        <td><i>Tidak ada gambar.</i></td>
                                                    @endif
                                                    <td>
                                                        <input type="hidden" name="id[]" value="{{ $row->id_jawab }}" />
                                                        <textarea class="form-control form-control-sm" name="jawaban[]"
                                                            id="jawaban" placeholder="...">{{ old('jawaban') }}</textarea>
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
                        <div class="card-footer text-muted">
                            <div class="float-right">
                                @include('ujian.modal_selesai_ujian')
                            </div>
                        </div>
                    </div>
                </form>
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
                echo $tanggal_selesai; echo ' '; echo $waktu_selesai;
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
