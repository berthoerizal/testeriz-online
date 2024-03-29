@extends('layouts.app')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        @include('partial.message')

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">{{ $title }} | {{ $soal->judul_soal }}</h1>
        <hr>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                Edit Informasi Soal
            </div>
            <div class="card-body">
                <form action="{{ route('soal.update', $soal->id) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label>Kategori Soal</label>
                                <select class="form-control" id="select2" name="id_jenis_soal">
                                    <?php foreach($jenis_soal as $val) { ?>
                                    <option value="{{ $val->id }}" @if ($val->id == $soal->id_jenis_soal) selected @endif>
                                        {{ $val->nama_jenis_soal }}</option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="judul_soal">Judul</label>
                                    <input type="text" class="form-control" name="judul_soal" id="judul_soal"
                                        placeholder="Judul" value="{{ $soal->judul_soal }}" required>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jenis_soal">Jenis Soal</label>
                                    <input type="text" class="form-control" name="jenis_soal" id="jenis_soal"
                                        placeholder="Judul" value="<?php echo ucwords($soal->jenis_soal); ?>" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="jenis_soal">Kode Ujian</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Kode Ujian"
                                        value="{{ $soal->pass_soal }}" id="pass_soal" aria-label="Kode Ujian"
                                        aria-describedby="basic-addon2" name="pass_soal" readonly required>
                                    <div class="input-group-append">
                                        <button onclick="func_pass_soal()" class="btn btn-outline-secondary" type="button"
                                            id="button-addon2"><i class="fas fa-sync"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="materi_file">Materi File</label><br />
                                    <input type="file" id="materi_file" name="materi_file" class="form-control">
                                    <p class="text-danger"><i>Boleh tidak diisi jika tidak/sudah memiliki materi file.</i>
                                    </p>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <label for="materi_video">Link Video</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"
                                            id="basic-addon3">https://www.youtube.com/watch?v=</span>
                                    </div>
                                    <input type="text" name="materi_video" id="materi_video"
                                        value="{{ $soal->materi_video }}" placeholder="Kode Video Youtube"
                                        class="form-control" id="basic-url" aria-describedby="basic-addon3">
                                    <p class="text-danger"><i>Boleh tidak diisi jika tidak memiliki materi video.</i>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status_soal">Status Ujian</label>
                                    <select class="form-control" id="status_soal" name="status_soal">
                                        <option value="draft" @if ($soal->status_soal == 'draft') selected @endif>
                                            Draft</option>
                                        <option value="publish" @if ($soal->status_soal == 'publish') selected @endif>
                                            Publish</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status_nilai">Status Nilai</label>
                                    <select class="form-control" id="status_nilai" name="status_nilai">
                                        <option value="draft" @if ($soal->status_nilai == 'draft') selected @endif>
                                            Draft</option>
                                        <option value="publish" @if ($soal->status_nilai == 'publish') selected @endif>
                                            Publish</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status_pelanggaran">Status Pelanggaran</label>
                                    <select class="form-control" id="status_pelanggaran" name="status_pelanggaran">
                                        <option value="0" @if ($soal->status_pelanggaran == 0) selected @endif>
                                            Tidak Aktif</option>
                                        <option value="1" @if ($soal->status_pelanggaran == 1) selected @endif>
                                            Aktif</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="tanggal_mulai">Tanggal Mulai</label>
                                            <input type="date" class="form-control form-control-sm"
                                                name="tanggal_mulai" value="{{ $soal->tanggal_mulai }}"
                                                id="tanggal_mulai">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="waktu_mulai">Waktu Mulai</label>
                                            <input type="time" class="form-control form-control-sm" name="waktu_mulai"
                                                value="{{ $soal->waktu_mulai }}" id="waktu_mulai">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="tanggal_selesai">Tanggal Selesai</label>
                                            <input type="date" class="form-control form-control-sm"
                                                name="tanggal_selesai" value="{{ $soal->tanggal_selesai }}"
                                                id="tanggal_selesai">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="waktu_selesai">Waktu Selesai</label>
                                            <input type="time" class="form-control form-control-sm"
                                                name="waktu_selesai" value="{{ $soal->waktu_selesai }}"
                                                id="waktu_selesai">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary btn-sm">Reset</button>
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->
    <script>
        function func_pass_soal() {
            var pass = Math.random().toString(36).slice(-8);
            document.getElementById("pass_soal").value = pass;
            console.log(pass);
        }
    </script>
@endsection
