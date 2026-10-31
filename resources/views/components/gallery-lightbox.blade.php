@once
    <div class="modal fade" id="galleryLightbox" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content bg-transparent border-0">
                <button type="button" class="btn-close btn-close-white ms-auto me-2 mt-2" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body text-center pt-0">
                    <img id="galleryLightboxImage" src="" alt="" class="img-fluid rounded" style="max-height:80vh">
                    <p id="galleryLightboxCaption" class="text-white mt-3 mb-0"></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('show.bs.modal', function (event) {
            if (event.target.id !== 'galleryLightbox') return;
            const trigger = event.relatedTarget;
            if (!trigger) return;
            document.getElementById('galleryLightboxImage').src = trigger.dataset.fullSrc;
            document.getElementById('galleryLightboxCaption').textContent = trigger.dataset.caption || '';
        });
    </script>
@endonce
