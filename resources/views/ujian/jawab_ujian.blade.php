@extends('layouts_ujian.ujian')

@section('content')
    <div class="container">
        <div class="row mb-3">
            <div class="col-md-12">
                <h4><b>{{ $soal->judul_soal }}</b></h4>
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


                            <a class="btn btn-primary btn-sm" href="#" data-toggle="modal"
                                data-target="#selesaiUjian">
                                Selesai Ujian <i class="fa fa-arrow-right"></i>
                            </a>
                            <!-- Tambah Modal-->
                            <div class="modal fade" id="selesaiUjian" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Selesai Ujian</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Yakin ingin menyelesaikan ujian ini?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary btn-sm"
                                                data-dismiss="modal">Batal</button>
                                            @if ($soal->jenis_soal == 'obyektif')
                                                <button type="button" onclick="selesaiUjian('finish')"
                                                    class="btn btn-primary btn-sm">Yakin</button>
                                            @else
                                                <button type="submit" class="btn btn-primary btn-sm">Yakin</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="table-responsive">
                                    <p><b style="color: #333;">Pertanyaan</b></p>
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <tbody>
                                            <tr>
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
                                <p><b style="color: #333;">Pilihan Jawaban </b></p>
                                @php
                                    $options = [$row->pilihan1, $row->pilihan2, $row->pilihan3, $row->pilihan4];
                                    shuffle($options);
                                @endphp

                                @foreach ($options as $option)
                                    <form
                                        onsubmit="submitForm(event, '{{ route('user_jawab_ujian', ['id_soal' => $soal->id, 'id_tanya' => $row->id]) }}')"
                                        class="pilihan_jawaban">
                                        @method('PUT')
                                        @csrf
                                        <input type="hidden" name="jawaban_user" value="{{ $option }}" />
                                        <button type="submit"
                                            class="btn-option btn btn{{ $jawab->jawaban_user == $option ? ' btn-primary' : ' btn-outline-primary' }} btn-sm btn-block text-justify"
                                            onclick="changeButtonClass(this)">
                                            {{ $option }}
                                        </button>
                                    </form>
                                @endforeach
                            </div>
                        </div>
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
                                        <form action="{{ route('jawab_ujian_post', ['slug_soal' => $soal->slug_soal]) }}"
                                            method="POST">
                                            @method('PUT')
                                            @csrf
                                            <input type="hidden" name="id_tanya" value="{{ $row->id }}">
                                            <button type="submit"
                                                class="btn 
                                        <?php if ($row->id == $tanya_id) {
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
                                            </button>
                                        </form>
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
                selesaiUjian('Waktu ujian telah habis!');
                // document.getElementById('btnSignIn').click(); //kondisi tombol ditekan otomatis
            }
        }, 1000);

        function changeButtonClass(button) {
            var buttons = document.getElementsByClassName('btn-option');
            for (var i = 0; i < buttons.length; i++) {
                buttons[i].classList.remove('btn-primary');
                buttons[i].classList.add('btn-outline-primary');
            }
            button.classList.remove('btn-outline-primary');
            button.classList.add('btn-primary');
        }

        function submitForm(event, url) {
            event.preventDefault(); // Prevent form submission

            // Get the form data
            var formData = new FormData(event.target);

            // Send an AJAX request
            var xhr = new XMLHttpRequest();
            xhr.open('POST', url, true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Handle the response here (if needed)
                    console.log(xhr.responseText);
                }
            };

            xhr.send(formData);
        }

        var status = 'not finish';

        function selesaiUjian(message) {

            if (message == 'finish') {
                status = 'finish';
                message = 'Peserta telah menyelesaikan ujian.';
            }

            alert(message);

            // Konfigurasi fetch request
            var data = new FormData();
            data.append("ket", message);

            // Konfigurasi fetch request
            var url = "{{ route('selesai_ujian', ['id_soal' => $soal->id]) }}";
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

        pelanggaranUjian();

        function pelanggaranUjian() {
            // Menambahkan event listener untuk menangkap saat pengguna mencoba beralih tab
            document.addEventListener('visibilitychange', function(event) {
                if (document.visibilityState === 'hidden') {
                    // Menampilkan dialog peringatan

                    if (status != 'finish') {
                        alert('Anda terdeteksi mencoba beralih tab!');
                        console.log(status);
                    }
                    //selesaiUjian('Anda terdeteksi mencoba beralih tab!');
                }
            });

            // window.addEventListener("blur", function() {
            //     // Pengguna beralih dari tab saat ini
            //     alert('Anda terdeteksi mencoba beralih tab!');
            // });


            window.addEventListener('resize', function(event) {
                // Tampilkan pesan peringatan kepada pengguna
                if (status != 'finish') {
                    alert('Anda terdeteksi mencoba mengubah ukuran jendela!');
                }
                //selesaiUjian('Anda terdeteksi mencoba mengubah ukuran jendela!');
            });

        }

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
