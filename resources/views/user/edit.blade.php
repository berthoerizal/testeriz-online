@if ($user->id == Auth::user()->id)
    <a class="btn btn-primary btn-sm" href="{{ route('profile.show', Crypt::encrypt(Auth::user()->id)) }}">
        <i class="fa fa-pencil-alt"></i>
        Edit
    </a>
@else
    <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#editModal{{ $user->id }}">
        <i class="fa fa-pencil-alt"></i>
        Edit
    </a>
@endif
<!-- Tambah Modal-->
<div class="modal fade" id="editModal{{ $user->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ route('user.update', $user->id) }}" method="POST">
                @method('PUT')
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="id_role">Akses Level</label>
                        <select class="form-control form-control-sm" id="id_role" name="id_role">
                            <option value="0" @if ($user->id_role == null || $user->id_rol == 0) selected @endif>Jawab Ujian
                            </option>
                            <option value="1" @if ($user->id_role == 1) selected @endif>Buat Soal
                            </option>
                            <option value="21" @if ($user->id_role == '21') selected @endif>Administrator
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" class="form-control form-control-sm" name="name" id="name"
                            placeholder="Nama Lengkap" value="{{ $user->name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control form-control-sm" name="email" id="email"
                            placeholder="Email" value="{{ $user->email }}" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control form-control-sm" name="phone" id="phone"
                            placeholder="Nomor Hp" value="{{ $user->phone }}" required>
                    </div>
                    <div class="form-group">
                        <label for="notactive">Status</label>
                        <select class="form-control form-control-sm" id="notactive" name="notactive">
                            <option value="0" @if ($user->notactive == 0) selected @endif>Aktif</option>
                            <option value="1" @if ($user->notactive == 1) selected @endif>Tidak Aktif
                            </option>
                        </select>
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
