@extends('layouts.app')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        @include('partial.message')

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">{{ $title }}</h1>
        <hr>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                Tambah Informasi Soal
            </div>
            <div class="card-body">
                <form action="{{ route('soal.store') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="judul_soal">Judul</label>
                                    <input type="text" class="form-control" name="judul_soal" id="judul_soal"
                                        placeholder="Judul" value="{{ old('judul_soal') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="jenis_soal">Jenis Soal</label>
                                    <select class="form-control" id="jenis_soal" name="jenis_soal">
                                        <option value="obyektif">Obyektif</option>
                                        <option value="essay">Essay</option>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status_soal">Status Ujian</label>
                                            <select class="form-control" id="status_soal" name="status_soal">
                                                <option value="draft">Draft</option>
                                                <option value="publish">Publish</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status_nilai">Status Nilai</label>
                                            <select class="form-control" id="status_nilai" name="status_nilai">
                                                <option value="draft">Draft</option>
                                                <option value="publish">Publish</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="materi_file">Materi File</label><br />
                                    <input type="file" id="materi_file" name="materi_file">
                                    <p><i>Kosongkan jika tidak memiliki materi file.</i></p>
                                </div>
                                <div>
                                    <label for="materi_video">Link Video</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"
                                                id="basic-addon3">https://www.youtube.com/watch?v=</span>
                                        </div>
                                        <input type="text" name="materi_video" id="materi_video"
                                            value="{{ old('materi_video') }}" placeholder="Kode Video Youtube"
                                            class="form-control" id="basic-url" aria-describedby="basic-addon3">
                                        <p><i>Kosongkan jika tidak memiliki materi video.</i></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="tanggal_mulai">Tanggal Mulai</label>
                                            <input type="date" class="form-control form-control-sm" name="tanggal_mulai"
                                                id="tanggal_mulai">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="waktu_mulai">Waktu Mulai</label>
                                            <input type="time" class="form-control form-control-sm" name="waktu_mulai"
                                                id="waktu_mulai">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="tanggal_selesai">Tanggal Selesai</label>
                                            <input type="date" class="form-control form-control-sm" name="tanggal_selesai"
                                                id="tanggal_selesai">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="waktu_selesai">Waktu Selesai</label>
                                            <input type="time" class="form-control form-control-sm" name="waktu_selesai"
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

@endsection
