<div class="modal fade" id="confirmationApprove-{{ $item->id }}" tabindex="-1" aria-labelledby="confirmationApproveLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="/account-requests/approval/{{ $item->id }}" method="POST">
        @csrf
        @method('POST')
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title fs-5" id="confirmationApproveLabel">Confirmation Approve</h3>
          </div>

          <div class="modal-body">
              <input type="hidden" name="for" value="approve">
            <p>Are you sure you want to Approve this Account ?
                <div class="form-group mt-3">
                    <label for="resident_id">Pilih Penduduk</label>
                        <select name="resident_id" id="resident_id" class="form-control">
                            <option value="">No data</option>
                            @foreach ($residents as $item )
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-outline-success">Yes, Approve</button>
          </div>
        </div>
    </form>
  </div>
</div>
