<!-- Modal -->
<div class="modal fade" id="confirmationDelete-{{ $item->id }}" tabindex="-1" aria-labelledby="confirmationDeleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="/rw-unit/{{ $item->id }}" method="POST">
        @csrf
        @method('DELETE')
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title fs-5" id="confirmationDeleteLabel">Confirmation Delete</h3>
          </div>
          <div class="modal-body">
            <p>Are you sure you want to delete this ADUAN?</p>
            <p class="text-danger">This action cannot be undone.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-outline-danger">Yes, Delete</button>
          </div>
        </div>
    </form>
  </div>
</div>
