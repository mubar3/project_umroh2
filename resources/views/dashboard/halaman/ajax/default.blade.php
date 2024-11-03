

<div class="modal fade" id="modallogout" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalHapusLabel">Anda yakin untuk logout?</h5>
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btn-cancel-logout">Batal</button>
                <button type="button" class="btn btn-danger" id="btn-confirm-logout">Logout</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Menampilkan modal ketika tombol logout diklik
    $('#kliklogout').on('click', function() {
        $('#modallogout').modal('show');
    });

    // Menutup modal ketika tombol batal diklik
    $('#btn-cancel-logout').on('click', function() {
        $('#modallogout').modal('hide');
    });

    // Redirect ke URL logout saat tombol logout di dalam modal diklik
    $('#btn-confirm-logout').on('click', function() {
        window.location.href = "{{ url('/logout') }}";
    });
</script>
