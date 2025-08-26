<!-- Modal -->
<div class="modal fade" id="detailAccount-{{ $item->id }}" tabindex="-1" aria-labelledby="detailAccountLabel" aria-hidden="true">
  <div class="modal-dialog">
<div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title fs-5" id="detailAccountLabel">Detail Account</h3>
          </div>
          <div class="modal-body">
            <div action="form-group mb-3">
                <label for="name">NAME</label>
                <input type="text" name="name" class="form-control" value="{{ $item->user->name }}" readonly>
            </div>
            <div action="form-group mb-3">
                <label for="email">E-MAIL</label>
                <input type="email" name="email" class="form-control" value="{{ $item->user->email }}" readonly>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
  </div>
</div>
