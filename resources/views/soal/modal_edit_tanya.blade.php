<a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#editModal{{ $tanya->id }}">
    <i class="fa fa-pencil-alt"></i>
    Edit
</a>
<!-- Tambah Modal-->
<div class="modal fade" id="editModal{{ $tanya->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Pertanyaan</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            @if ($soal->jenis_soal == 'essay')
                <form action="{{ route('tanya.update', $tanya->id) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    {{ csrf_field() }}
                    <input type="hidden" name="slug_soal" value="{{ $soal->slug_soal }}" />
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pertanyaan">Pertanyaan</label>
                                    <textarea name="pertanyaan" id="pertanyaan" class="form-control textarea-tinymce"
                                        height="100px">{{ $tanya->pertanyaan }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gambar">Gambar</label><br />
                                    <input type="file" id="gambar" name="gambar">
                                </div>
                                <div class="form-group">
                                    <label for="jawaban">Jawaban</label>
                                    <textarea class="form-control form-control-sm" name="jawaban" id="jawaban" rows="11"
                                        required>{{ $tanya->jawaban }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    </div>
                </form>
            @else
                <form action="{{ route('tanya.update', $tanya->id) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    {{ csrf_field() }}
                    <input type="hidden" name="slug_soal" value="{{ $soal->slug_soal }}" />
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pertanyaan">Pertanyaan</label>
                                    <textarea name="pertanyaan" id="pertanyaan" class="form-control textarea-tinymce"
                                        height="100px">{{ $tanya->pertanyaan }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="gambar">Gambar</label><br />
                                    <input type="file" id="gambar" name="gambar">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pilihan1">Opsi 1</label>
                                    <input type="text" class="form-control form-control-sm" name="pilihan1"
                                        id="pilihan1" placeholder="Opsi 1" value="{{ $tanya->pilihan1 }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="pilihan2">Opsi 2</label>
                                    <input type="text" class="form-control form-control-sm" name="pilihan2"
                                        id="pilihan2" placeholder="Opsi 2" value="{{ $tanya->pilihan2 }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="pilihan3">Opsi 3</label>
                                    <input type="text" class="form-control form-control-sm" name="pilihan3"
                                        id="pilihan3" placeholder="Opsi 3" value="{{ $tanya->pilihan3 }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="pilihan3">Opsi 4</label>
                                    <input type="text" class="form-control form-control-sm" name="pilihan4"
                                        id="pilihan4" placeholder="Opsi 4" value="{{ $tanya->pilihan4 }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="jawaban_benar">Pilih Jawaban Benar</label>
                                    <select name="jawaban" class="form-control form-control-sm">
                                        <option value="pilihan1" @if ($tanya->pilihan_benar == 'pilihan1') selected @endif>Opsi 1</option>
                                        <option value="pilihan2" @if ($tanya->pilihan_benar == 'pilihan2') selected @endif>Opsi 2</option>
                                        <option value="pilihan3" @if ($tanya->pilihan_benar == 'pilihan3') selected @endif>Opsi 3</option>
                                        <option value="pilihan4" @if ($tanya->pilihan_benar == 'pilihan4') selected @endif>Opsi 4</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
