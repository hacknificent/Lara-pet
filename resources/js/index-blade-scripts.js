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

    function computeNextOrder(el) {
        const prev = el.previousElementSibling;
        const next = el.nextElementSibling;

        const prevOrder = prev?.dataset?.order ? parseFloat(prev.dataset.order) : null;
        const nextOrder = next?.dataset?.order ? parseFloat(next.dataset.order) : null;

        if (prevOrder !== null && nextOrder !== null) {
            // Between two elements: use an adaptive small step so digits don't explode.
            let step = 0.1;
            let newOrder = prevOrder + step;

            while (newOrder >= nextOrder && step > 0.00000001) {
                step /= 10;
                newOrder = prevOrder + step;
            }

            return newOrder;
        }

        if (prevOrder !== null) {
            // After previous element
            return prevOrder + 1.0;
        }

        if (nextOrder !== null) {
            // Before next element: subtract an adaptive step from the former first element.
            let step = 0.1;
            while (nextOrder <= step && step > 0.00000001) {
                step /= 10;
            }
            return nextOrder - step;
        }

        return 1.0;
    }

    async function onDrop(e) {
        e.preventDefault();
        const dropzone = e.currentTarget;
        dropzone.classList.remove('drag-over');
        const id = e.dataTransfer.getData('text/plain');
        if (!id) return;

        const el = document.querySelector('[data-id="' + id + '"]');
        if (!el) return;

        // Find insertion point based on mouse Y coordinate
        const articles = Array.from(dropzone.querySelectorAll('.draggable-idea'));
        let insertBefore = null;

        for (const article of articles) {
            if (article === el) continue; // Skip the element itself
            const rect = article.getBoundingClientRect();
            if (e.clientY < rect.top + rect.height / 2) {
                insertBefore = article;
                break;
            }
        }

        if (insertBefore) {
            dropzone.insertBefore(el, insertBefore);
        } else {
            dropzone.appendChild(el);
        }

        const newStatus = parseInt(dropzone.dataset.status, 10);
        const newOrder = computeNextOrder(el);

        try {
            const res = await fetch(`/project-ideas/${id}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ status: newStatus, order: newOrder }),
            });

            if (!res.ok) {
                const json = await res.json().catch(() => null);
                const msg = json && (json.message || json.errors)
                    ? (json.message || JSON.stringify(json.errors))
                    : 'Update failed';
                throw new Error(msg);
            }

            const json = await res.json();
            el.dataset.order = newOrder;

            // If rescale was triggered, reload page
            if (json.rescaled) {
                setTimeout(() => window.location.reload(), 500);
            }
        } catch (err) {
            console.error(err);
            alert('Could not update position: ' + err.message);
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
