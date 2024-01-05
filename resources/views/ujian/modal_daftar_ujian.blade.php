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
    <div class="modal-dialog bd-example-modal-lg" role="document">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <h5 class="modal-title text-primary"><i class="fas fa-info"></i> <b>Daftar Ujian</b>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-inline" action="{{ route('daftar_ujian') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body text-justify" style="padding: 20px 30px;">
                    <?php if($soal->status_pelanggaran==1) { ?>
                    <p>Saat melaksanakan ujian, harap diperhatikan hal berikut:</p>
                    <p><b class="text-danger">Tidak diperbolehkan berpindah halaman atau membuka tab baru</b> selama
                        ujian
                        berlangsung. Jika
                        terjadi maka halaman ujian akan tertutup dan tidak dapat diakses kembali.</p>
                    <p><b class="text-danger">Tidak diperbolehkan melakukan copy-paste</b> selama ujian berlangsung.</p>
                    <p><b class="text-danger">Tidak diperbolehkan melakukan minimize pada halaman</b> ujian. Jika
                        terjadi
                        maka halaman ujian
                        akan
                        tertutup dan tidak dapat diakses kembali</p>
                    <p><b class="text-danger">Segala bentuk kecurangan</b> akan dianggap pelanggaran serius.</p>


                    <?php } ?>


                    <input type="hidden" name="id_soal" value="{{ $soal->id }}" />


                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Kode Ujian" aria-label="Kode Ujian"
                            aria-describedby="basic-addon2" name="kode_ujian">
                        <div class="input-group-append">
                            <button type="submit" class="input-group-text btn btn-primary">Masuk</button>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>
