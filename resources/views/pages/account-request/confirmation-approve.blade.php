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
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-outline-success">Yes, Approve</button>
          </div>
        </div>
    </form>
  </div>
</div>
