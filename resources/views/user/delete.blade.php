@if ($user->id_role == 21)
    <a class="btn btn-danger btn-sm disabled" href="#">
        <i class="fa fa-trash-alt"></i>
        Hapus
    </a>
@else
    <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#deleteModal{{ $user->id }}">
        <i class="fa fa-trash-alt"></i>
        Hapus
    </a>
@endif
<!-- Tambah Modal-->
<div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Yakin ingin menghapus <b>{{ $user->name }}</b> ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                <form action="{{ route('user.destroy', $user->id) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <input class="btn btn-danger btn-sm" type="submit" value="Hapus" />
                </form>
                {{-- <a href="{{ route('user.destroy', $user->id) }}"
                    class="btn btn-danger">Hapus</a> --}}
            </div>
        </div>
    </div>
</div>
