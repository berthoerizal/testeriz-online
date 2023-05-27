@extends('layouts_ujian.ujian')

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
                <h4><b>{{ $soal->judul_soal }}</b></h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('selesai_ujian_essay') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="id_soal" value="{{ $soal->id }}" />
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
                                                        <textarea class="form-control form-control-sm" name="jawaban[]" id="jawaban" placeholder="...">{{ old('jawaban') }}</textarea>
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
        function selesaiUjian(message) {
            var jawaban = [];
            var ids = [];

            // Mengambil semua elemen input dengan nama "jawaban[]"
            var inputs_jawaban = document.getElementsByName("jawaban[]");
            var inputs_id = document.getElementsByName("id[]");
            // Iterasi melalui elemen-elemen input dan menyimpan nilai ke dalam variabel jawaban dan ids
            for (var i = 0; i < inputs_jawaban.length; i++) {
                jawaban.push(inputs_jawaban[i].value);
                ids.push(inputs_id[i].value);
            }

            alert(message);

            // Data yang akan dikirimkan
            var data = new FormData();
            data.append("id_soal", "{{ $soal->id }}"); // Contoh nilai id_soal, sesuaikan dengan nilai yang sesuai
            data.append("jawaban", jawaban);
            data.append("id", ids);
            data.append("ket", message);

            // Konfigurasi fetch request
            var url = "{{ route('selesai_ujian_essay') }}";
            var options = {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the request headers
                },
                body: data,
            };

            // Kirim request menggunakan fetch
            fetch(url, options)
                .then(response => {
                    if (response.ok) {

                        window.location.href =
                            "{{ route('detail_nilai', ['id_soal' => $soal->id, 'id_user' => Crypt::encrypt(Auth::user()->id)]) }}";
                    } else {
                        throw new Error('Request failed.');
                    }
                })
                .catch(error => {
                    // Tangani error jika terjadi
                    console.error('Terjadi kesalahan:', error);
                });

        }

        // Set the date we're counting down to
        var tanggal_waktu = new Date("{{ $tanggal_selesai . ' ' . $waktu_selesai }}").getTime();

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
                selesaiUjian("Waktu ujian telah habis!");
                // document.getElementById('btnSignIn').click(); //kondisi tombol ditekan otomatis
            }
        }, 1000);

        // Menambahkan event listener untuk menangkap saat pengguna mencoba beralih tab
        document.addEventListener('visibilitychange', function(event) {
            if (document.visibilityState === 'hidden') {
                // Menampilkan dialog peringatan
                selesaiUjian('Anda terdeteksi mencoba beralih tab!');
            }
        });

        window.addEventListener('resize', function(event) {
            // Tampilkan pesan peringatan kepada pengguna
            selesaiUjian('Anda terdeteksi mencoba mengubah ukuran jendela!');
        });

        // Batasi fungsi pencarian
        document.addEventListener('keydown', function(event) {
            if (event.ctrlKey || event.metaKey) {
                var forbiddenKeys = ['F', 'R',
                    'U'
                ]; // Daftar tombol keyboard yang ingin Anda larang (misalnya F untuk find, R untuk refresh, U untuk view source)
                if (forbiddenKeys.indexOf(event.key.toUpperCase()) !== -1) {
                    event.preventDefault();
                    alert('Fitur ini dinonaktifkan selama ujian berlangsung.');
                }
            }
        });

        // Batasi salin dan tempel
        var inputElements = document.querySelectorAll('input, textarea');
        for (var i = 0; i < inputElements.length; i++) {
            inputElements[i].setAttribute('onpaste', 'return false');
        }
    </script>
@endsection
