@extends('layouts.app')

@section('content')

    <!-- Tampilan HTML -->

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <?php
        date_default_timezone_set('Asia/Jakarta');
        $jadwal_sekarang = date('Y-m-d H:i:s');
        $jadwal_selesai_merge = $soal->tanggal_selesai . ' ' . $soal->waktu_selesai;
        $jadwal_selesai = date('Y-m-d H:i:s', strtotime($jadwal_selesai_merge));
        
        $jadwal_mulai_merge = $soal->tanggal_mulai . ' ' . $soal->waktu_mulai;
        $jadwal_mulai = date('Y-m-d H:i:s', strtotime($jadwal_mulai_merge));
        ?>

        @include('partial.message')

        <!-- Page Heading -->
        @if ($soal->id_user == $user->id)
            <h1 class="h3 mb-2 text-gray-800">Soal | {{ $soal->judul_soal }}</h1>
        @else
            <h1 class="h3 mb-2 text-gray-800">Ujian | {{ $soal->judul_soal }}</h1>
        @endif
        <hr>
        <div class="row">

            @if ($soal->id_user == $user->id)
                <div class="col-md-12">
                    <div class="card shadow  mb-4">
                        <div class="card-header">
                            <div class="float-left">
                                Pertanyaan
                            </div>
                            <div class="float-right">
                                <?php if ($jadwal_sekarang > $jadwal_mulai) { ?>
                                <a class="btn btn-primary btn-sm disabled" href="#">
                                    <i class="fa fa-plus"></i>
                                    Tambah
                                </a>
                                <?php } else { ?>
                                @include('soal.modal_create_tanya')
                                <?php } ?>
                                <a href="{{ route('nilai_peserta', $soal->slug_soal) }}" class="btn btn-primary btn-sm"><i
                                        class="fa fa-trophy"></i>
                                    Nilai</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="10%" class="text-center">Gambar</th>
                                            <th width="10%">Video</th>
                                            <th>Pertanyaan</th>
                                            <th>Jawaban Benar</th>
                                            <th width="20%" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($tanya as $tanya) { ?>
                                        <tr>
                                            <td class="text-center">
                                                <?php echo $i; ?>
                                            </td>
                                            <td class="text-center">
                                                @if (!$tanya->gambar)
                                                    <img src="{{ asset('assets/images/imagedefault.png') }}"
                                                        class="img img-responsive img-thumbnail" width="50px">
                                                @else
                                                    @include('soal.modal_image')
                                                @endif
                                            </td>
                                            <td>
                                                @if ($tanya->url_video)
                                                    <?php $url_video = 'https://www.youtube.com/watch?v=' . substr($tanya->url_video, -11); ?>
                                                    <a href="{{ $url_video }}"
                                                        target="_blank">{{ $tanya->url_video }}</a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td><?php echo $tanya->pertanyaan; ?></td>
                                            <td>{{ $tanya->jawaban }}</td>
                                            <td>
                                                <?php if ($jadwal_sekarang > $jadwal_mulai) { ?> <a class="btn btn-primary btn-sm disabled"
                                                    href="#">
                                                    <i class="fa fa-pencil-alt"></i>
                                                    Edit
                                                </a>
                                                <a class="btn btn-danger btn-sm disabled" href="#">
                                                    <i class="fa fa-trash-alt"></i>
                                                    Hapus
                                                </a>
                                                <?php } else { ?>
                                                @include('soal.modal_edit_tanya')
                                                @include('soal.modal_delete_tanya')
                                                <?php } ?>
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
            @endif

            <div class="col-md-3 mb-3">
                <div class="card">
                    @if ($soal->materi_video != null)
                        <div class="embed-responsive embed-responsive-1by1 card-img-top">
                            <iframe width="420" height="315"
                                src="https://www.youtube.com/embed/{{ $soal->materi_video }}" frameborder="0"
                                allowfullscreen></iframe>
                        </div>
                    @else
                        <img class="card-img-top" src="{{ asset('assets/images/novideodefault.PNG') }}"
                            alt="Card image cap">
                    @endif
                    <div class="card-body text-center">
                        <p class="card-text"><b>Materi Video</b></p>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card shadow  mb-3">
                    <div class="card-header">
                        <div class="float-left">
                            Detail Informasi
                            @if ($soal->id_user == $user->id)
                                Soal
                            @else
                                Ujian
                            @endif
                        </div>

                        <div class="float-right">
                            @if ($soal->id_user == $user->id)
                                @include('soal.delete')
                                <a class="btn btn-primary btn-sm"
                                    href="{{ route('soal.edit', Crypt::encrypt($soal->id)) }}">
                                    <i class="fa fa-pencil-alt"></i>
                                    Edit
                                </a>

                                <button onclick="shareToWhatsApp()" class="btn btn-success btn-sm"><i
                                        class="fas fa-share"></i> Bagikan</button>
                            @else
                                @if ($cek_daftar == 0)
                                    <?php if ($jadwal_sekarang <= $jadwal_selesai) { ?>
                                    @include('ujian.modal_daftar_ujian')
                                    <a href="#" class="btn btn-primary btn-sm disabled"><i class="fa fa-trophy"></i>
                                        Nilai</a><?php } else { ?> <a href="#"
                                        class="btn btn-primary btn-sm disabled"><i class="fa fa-edit"></i>
                                        Daftar</a>
                                    <a href="#" class="btn btn-primary btn-sm disabled"><i class="fa fa-trophy"></i>
                                        Nilai</a>
                                    <?php } ?>
                                @elseif ($cek_daftar == 1)
                                    <?php if ($jadwal_sekarang <= $jadwal_selesai) { ?>
                                    <button type="button" class="btn btn-primary btn-sm masukUjianBtn"><i
                                            class="fa fa-edit"></i> Masuk Ujian
                                    </button>

                                    <a href="#" class="btn btn-primary btn-sm disabled"><i class="fa fa-trophy"></i>
                                        Nilai</a> <?php } else { ?>
                                    <a href="#" class="btn btn-primary btn-sm disabled"><i class="fa fa-edit"></i>
                                        Masuk Ujian</a>
                                    <a class="btn btn-primary btn-sm"
                                        href="{{ route('selesai_ujian', ['id_soal' => $soal->id]) }}">
                                        <i class="fa fa-trophy"></i>
                                        Nilai
                                    </a>
                                    <?php } ?>
                                @elseif($cek_daftar == 2 || $jadwal_sekarang <= $jadwal_selesai)
                                    <a href="#" class="btn btn-primary btn-sm disabled"><i class="fa fa-edit"></i>
                                        Masuk Ujian</a>
                                    <a class="btn btn-primary btn-sm"
                                        href="{{ route('detail_nilai', ['id_soal' => $soal->id, 'id_user' => Crypt::encrypt($user->id)]) }}">
                                        <i class="fa fa-trophy"></i>
                                        Nilai
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td width="5%"><i class="fa fa-user"></i></td>
                                        <td>Dibuat Oleh</td>
                                        <td>{{ $soal->name }}</td>
                                    </tr>
                                    <tr>
                                        <td width="5%"><i class="fa fa-book"></i></td>
                                        <td>Materi File</td>
                                        <td>
                                            @if ($soal->materi_file == null)
                                                <i>Tidak ada file.</i>
                                            @else
                                                <a href="{{ route('download_materi', $soal->id) }}"><i
                                                        class="fa fa-download"></i>
                                                    {{ $soal->materi_file }}</a>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="5%"><i class="fa fa-star"></i></td>
                                        <td>Judul</td>
                                        <td><b>{{ $soal->judul_soal }}</b></td>
                                    </tr>
                                    <tr>
                                        <td width="5%"><i class="fa fa-star"></i></td>
                                        <td>Kategori</td>
                                        <td><b>{{ $soal->nama_jenis_soal }}</b></td>
                                    </tr>
                                    <tr>
                                        <td width="5%"><i class="fa fa-file-alt"></i></td>
                                        <td>Jenis Soal</td>
                                        <td><i><?php echo ucwords($soal->jenis_soal); ?></i>
                                        </td>
                                    </tr>
                                    @if ($soal->id_user == $user->id)
                                        <tr>
                                            <td width="5%"><i class="fa fa-lightbulb"></i></td>
                                            <td>Status Ujian</td>
                                            <td>
                                                @if ($soal->status_soal == 'publish')
                                                    <span class="badge badge-success"><?php echo ucwords($soal->status_soal); ?></b>
                                                    @else
                                                        <span class="badge badge-danger"><?php echo ucwords($soal->status_soal); ?></b>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="5%"><i class="fa fa-trophy"></i></td>
                                            <td>Status Nilai</td>
                                            <td>
                                                @if ($soal->status_nilai == 'publish')
                                                    <span class="badge badge-success"><?php echo ucwords($soal->status_nilai); ?></b>
                                                    @else
                                                        <span class="badge badge-danger"><?php echo ucwords($soal->status_nilai); ?></b>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="5%"><i class="fa fa-trophy"></i></td>
                                            <td>Status Pelanggaran</td>
                                            <td>
                                                @if ($soal->status_pelanggaran == 0)
                                                    <span class="badge badge-danger"><?php echo 'Tidak Aktif'; ?></b>
                                                    @else
                                                        <span class="badge badge-success"><?php echo 'Aktif'; ?></b>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td width="5%"><i class="fa fa-question"></i></td>
                                        <td>Jumlah Pertanyaan</td>
                                        <td>{{ $count_tanya }}</td>
                                    </tr>
                                    <tr>
                                        <td width="5%"><i class="fa fa-calendar"></i></td>
                                        <td>Jadwal Mulai</td>
                                        <td>
                                            @if ($soal->tanggal_mulai == null || $soal->waktu_mulai == null)
                                                -
                                            @else
                                                <?php echo date('d-m-Y', strtotime($soal->tanggal_mulai)) . ' ' . $soal->waktu_mulai; ?>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="5%"><i class="fa fa-calendar"></i></td>
                                        <td>Jadwal Selesai</td>
                                        <td>
                                            @if ($soal->tanggal_selesai == null || $soal->waktu_selesai == null)
                                                -
                                            @else
                                                <?php echo date('d-m-Y', strtotime($soal->tanggal_selesai)) . ' ' . $soal->waktu_selesai; ?>
                                            @endif
                                        </td>
                                    </tr>
                                    @if ($soal->id_user == $user->id)
                                        <tr>
                                            <td width="5%"><i class="fa fa-key"></i></td>
                                            <td>Kode Ujian
                                            </td>
                                            <td><b>{{ $soal->pass_soal }}</b></td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->


    <!-- Tampilan HTML -->

    <div id="myModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog bd-example-modal-lg" role="document">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <h5 class="modal-title text-primary"><i class="fas fa-info"></i> <b>Masuk Ujian</b>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-justify" style="padding: 20px 30px;">
                    <?php if($soal->status_pelanggaran==1) { ?>
                    <p>Saat melaksanakan ujian, harap diperhatikan hal berikut:</p>
                    <p><b class="text-danger">Tidak diperbolehkan berpindah halaman atau membuka tab baru</b> selama ujian
                        berlangsung. Jika
                        terjadi maka halaman ujian akan tertutup dan tidak dapat diakses kembali.</p>
                    <p><b class="text-danger">Tidak diperbolehkan melakukan copy-paste</b> selama ujian berlangsung.</p>
                    <p><b class="text-danger">Tidak diperbolehkan melakukan minimize pada halaman</b> ujian. Jika terjadi
                        maka halaman ujian
                        akan
                        tertutup dan tidak dapat diakses kembali</p>
                    <p><b class="text-danger">Segala bentuk kecurangan</b> akan dianggap pelanggaran serius.</p>
                    <?php } ?>


                    @if ($cek_daftar == 0)
                    @else
                        <a href="{{ route('tunggu_ujian', ['slug_soal' => $soal->slug_soal]) }}"
                            class="btn btn-primary btn-block">Masuk Ujian</a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function shareToWhatsApp() {
            var url = '{{ route('soal.show', $soal->slug_soal) }}';
            var password = '{{ $soal->pass_soal }}';
            var message = url + ' | Kode Ujian: ' + password;
            var encodedMessage = encodeURIComponent(message);
            var whatsappLink = 'whatsapp://send?text=' + encodedMessage;
            window.location.href = whatsappLink;
        }


        function masukUjian() {
            // Menampilkan modal
            $('#myModal').modal('show');
        }

        $(document).ready(function() {
            // Menambahkan event listener pada tombol "Masuk Ujian"
            $('.masukUjianBtn').click(function() {
                masukUjian();
            });
        });
    </script>
@endsection
