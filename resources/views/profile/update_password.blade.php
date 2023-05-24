<a class="btn btn-dark btn-sm" href="#" data-toggle="modal" data-target="#passwordModal{{ Auth::user()->id }}">
    <i class="fa fa-key"></i>
    Update Password
</a>
<!-- Update Password Modal-->
<div class="modal fade" id="passwordModal{{ Auth::user()->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Password</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ route('update_password', [Auth::user()->id]) }}" method="POST">
                @method('PUT')
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="password">Password Baru</label>
                        <input type="password" class="form-control form-control-sm" name="password" id="password"
                            value="" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Konfirmasi Password</label>
                        <input type="password" class="form-control form-control-sm" name="confirm_password"
                            id="confirm_password" value="" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
