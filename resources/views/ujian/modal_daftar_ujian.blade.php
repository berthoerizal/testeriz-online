@if ($count_tanya > 0)
    <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#daftarUjian">
        <i class="fa fa-edit"></i>
        Daftar
    </a>
@else
    <a class="btn btn-primary btn-sm disabled" href="#">
        <i class="fa fa-edit"></i>
        Daftar
    </a>
@endif
<!-- Tambah Modal-->
<div class="modal fade" id="daftarUjian" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Daftar Ujian</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ route('daftar_ujian') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="id_soal" value="{{ $soal->id }}" />
                <div class="modal-body">
                    <div class="form-group">
                        <label for="kode_ujian">Kode Ujian</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon3"><i class="fa fa-key"></i></span>
                            </div>
                            <input type="password" name="kode_ujian" id="kode_ujian" value=""
                                class="form-control" id="basic-url" aria-describedby="basic-addon3">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm">Masuk</button>
                </div>
            </form>
        </div>
    </div>
</div>
