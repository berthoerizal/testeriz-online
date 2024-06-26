<a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#tambahModal">
    <i class="fa fa-plus"></i>
    Tambah
</a>

<!-- Tambah Modal-->
<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Pertanyaan</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            @if ($soal->jenis_soal == 'subjektif')
                <form action="{{ route('tanya.store') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="slug_soal" value="{{ $soal->slug_soal }}" />
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pertanyaan">Pertanyaan</label>
                                    <textarea name="pertanyaan" id="pertanyaan" class="form-control textarea-tinymce">{{ old('pertanyaan') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gambar">Gambar</label><br />
                                    <input type="file" id="gambar" name="gambar">
                                </div>
                                <div class="form-group">
                                    <label for="jawaban">Jawaban</label>
                                    <textarea class="form-control form-control-sm" name="jawaban" id="jawaban" rows="11" required>{{ old('jawaban') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="url_video">URL Video</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"
                                                id="basic-addon3">https://www.youtube.com/watch?v=</span>
                                        </div>
                                        <input type="text" name="url_video" id="url_video"
                                            value="{{ old('url_video') }}" placeholder="Kode Video Youtube"
                                            class="form-control" id="basic-url" aria-describedby="basic-addon3">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    </div>
                </form>
            @elseif($soal->jenis_soal == 'objektif')
                <form action="{{ route('tanya.store') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="slug_soal" value="{{ $soal->slug_soal }}" />
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pertanyaan">Pertanyaan</label>
                                    <textarea name="pertanyaan" id="pertanyaan" class="form-control textarea-tinymce" height="100px">{{ old('pertanyaan') }}</textarea>
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
                                        id="pilihan1" value="{{ old('pilihan1') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="pilihan2">Opsi 2</label>
                                    <input type="text" class="form-control form-control-sm" name="pilihan2"
                                        id="pilihan2" value="{{ old('pilihan2') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="pilihan3">Opsi 3</label>
                                    <input type="text" class="form-control form-control-sm" name="pilihan3"
                                        id="pilihan3" value="{{ old('pilihan3') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="pilihan3">Opsi 4</label>
                                    <input type="text" class="form-control form-control-sm" name="pilihan4"
                                        id="pilihan4" value="{{ old('pilihan4') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="jawaban_benar">Pilih Jawaban Benar</label>
                                    <select name="jawaban" class="form-control form-control-sm">
                                        <option value="pilihan1">Opsi 1</option>
                                        <option value="pilihan2">Opsi 2</option>
                                        <option value="pilihan3">Opsi 3</option>
                                        <option value="pilihan4">Opsi 4</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="url_video">URL Video</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"
                                                id="basic-addon3">https://www.youtube.com/watch?v=</span>
                                        </div>
                                        <input type="text" name="url_video" id="url_video"
                                            value="{{ old('url_video') }}" placeholder="Kode Video Youtube"
                                            class="form-control" id="basic-url" aria-describedby="basic-addon3">
                                    </div>
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
