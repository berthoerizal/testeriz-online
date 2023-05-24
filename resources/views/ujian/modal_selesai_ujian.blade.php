<a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#selesaiUjian">
    Selesai Ujian <i class="fa fa-arrow-right"></i>
</a>
<!-- Tambah Modal-->
<div class="modal fade" id="selesaiUjian" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
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
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                @if ($soal->jenis_soal == 'obyektif')
                    <a href="{{ route('selesai_ujian', ['id_soal' => $soal->id]) }}"
                        class="btn btn-primary btn-sm">Yakin</a>
                @else
                    <button type="submit" class="btn btn-primary btn-sm">Yakin</button>
                @endif
            </div>
        </div>
    </div>
</div>
