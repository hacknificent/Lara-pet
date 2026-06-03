(function () {
    const csrfTokenElement = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfTokenElement ? csrfTokenElement.content : null;

    let dragged = null;

    function onDragStart(e) {
        dragged = e.currentTarget;
        e.dataTransfer.setData('text/plain', e.currentTarget.dataset.id);
        e.dataTransfer.effectAllowed = 'move';
        e.currentTarget.style.opacity = '0.6';
    }

    function onDragEnd() {
        if (dragged) dragged.style.opacity = '';
        dragged = null;
    }

    function onDragOver(e) {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';
    }

    function onDragEnter(e) {
        e.currentTarget.classList.add('drag-over');
    }

    function onDragLeave(e) {
        e.currentTarget.classList.remove('drag-over');
    }

    async function onDrop(e) {
        e.preventDefault();
        const dropzone = e.currentTarget;
        dropzone.classList.remove('drag-over');
        const id = e.dataTransfer.getData('text/plain');
        if (!id) return;

        const el = document.querySelector('[data-id="' + id + '"]');
        if (el) {
            dropzone.appendChild(el);
        }

        const newStatus = dropzone.dataset.status;

        try {
            const res = await fetch(`/project-ideas/${id}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ status: parseInt(newStatus, 10) }),
            });

            if (!res.ok) {
                const json = await res.json().catch(() => null);
                const msg = json && (json.message || json.errors)
                    ? (json.message || JSON.stringify(json.errors))
                    : 'Update failed';
                throw new Error(msg);
            }
        } catch (err) {
            console.error(err);
            alert('Could not update status: ' + err.message);
        }
    }

    function init() {
        document.querySelectorAll('.draggable-idea').forEach((el) => {
            el.addEventListener('dragstart', onDragStart);
            el.addEventListener('dragend', onDragEnd);
        });

        document.querySelectorAll('.dropzone').forEach((zone) => {
            zone.addEventListener('dragover', onDragOver);
            zone.addEventListener('dragenter', onDragEnter);
            zone.addEventListener('dragleave', onDragLeave);
            zone.addEventListener('drop', onDrop);
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
