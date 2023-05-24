<!-- Button trigger modal -->
<button type="button" class="btn btn-link" data-toggle="modal" data-target="#exampleModalCenter{{ $row->id }}">
    <img src="{{ asset('assets/images/' . $row->gambar) }}" class="img img-responsive" style="display:block;"
        width="100%" height="100%">
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter{{ $row->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mb-0 p-0">
                <img src="{{ asset('assets/images/' . $row->gambar) }}" alt="" style="width:100%">
            </div>
        </div>
    </div>
</div>
