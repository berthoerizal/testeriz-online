<a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#editModal{{ $val->id }}">
    <i class="fa fa-pencil-alt"></i>
    Edit
</a>
<!-- Tambah Modal-->
<div class="modal fade" id="editModal{{ $val->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Jenis Soal</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ route('jenis_soal.update', $val->id) }}" method="POST">
                @method('PUT')
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_jenis_soal">Nama Jenis Soal</label>
                        <input type="text" class="form-control form-control-sm" name="nama_jenis_soal"
                            id="nama_jenis_soal" placeholder="Nama Jenis Soal" value="{{ $val->nama_jenis_soal }}"
                            required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success btn-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
