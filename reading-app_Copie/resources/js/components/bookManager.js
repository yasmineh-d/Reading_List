import { baseComponent } from './baseComponent';

export default (initialConfig = {}) => ({
    ...baseComponent,
    search: initialConfig.search || '',
    category: initialConfig.category || '',
    tableHtml: '',
    isSaving: false,
    modalTitle: 'Add New Book',

    init() {
        // search and category will be populated by x-model and default values in Blade
        const initialTable = document.getElementById('books-table-body');
        if (initialTable) {
            this.tableHtml = initialTable.innerHTML;
        }
    },

    updateTable() {
        const url = new URL(location.href);
        url.searchParams.set('search', this.search);
        url.searchParams.set('category', this.category);
        url.searchParams.set('page', 1);

        history.pushState({}, '', url);

        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(r => r.text())
            .then(html => {
                this.tableHtml = html;
                this.$nextTick(() => this.initLucide());
            });
    },

    openAddModal() {
        this.modalTitle = 'Add New Book';
        const form = document.getElementById('bookForm');
        form.reset();
        form.action = "/admin/books";

        const methodField = document.getElementById('method-field');
        if (methodField) methodField.remove();

        document.querySelectorAll('input[name="categories[]"]').forEach(cb => cb.checked = false);
        document.getElementById('current-image-preview')?.classList.add('hidden');

        const modal = document.getElementById('hs-add-book-modal');
        if (window.HSOverlay) {
            window.HSOverlay.open(modal);
        } else {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    },

    openEditModal(id) {
        this.modalTitle = 'Edit Book';
        const form = document.getElementById('bookForm');
        form.reset();
        document.querySelectorAll('input[name="categories[]"]').forEach(cb => cb.checked = false);
        document.getElementById('current-image-preview')?.classList.add('hidden');

        form.action = `/admin/books/${id}`;

        let methodField = document.getElementById('method-field');
        if (!methodField) {
            methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.id = 'method-field';
            methodField.value = 'PUT';
            form.appendChild(methodField);
        }

        fetch(`/admin/books/${id}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
            .then(r => r.json())
            .then(data => {
                if (data.success && data.book) {
                    const book = data.book;
                    document.getElementById('title').value = book.title;
                    document.getElementById('author').value = book.author;
                    document.getElementById('ISBN').value = book.ISBN || '';
                    document.getElementById('description').value = book.description || '';

                    const imgPreview = document.getElementById('edit-image-preview');
                    const imgContainer = document.getElementById('current-image-preview');
                    if (book.image && imgPreview && imgContainer) {
                        imgPreview.src = book.image;
                        imgContainer.classList.remove('hidden');
                    }

                    if (book.categories) {
                        book.categories.forEach(cat => {
                            const checkbox = document.querySelector(`input[name="categories[]"][value="${cat.id}"]`);
                            if (checkbox) checkbox.checked = true;
                        });
                    }

                    const modal = document.getElementById('hs-add-book-modal');
                    if (window.HSOverlay) {
                        window.HSOverlay.open(modal);
                    } else {
                        modal.classList.remove('hidden');
                        modal.classList.add('flex');
                    }
                }
            })
            .catch(err => console.error('Error loading book:', err));
    },

    saveBook() {
        const form = document.getElementById('bookForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        this.isSaving = true;
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            }
        })
            .then(async r => {
                const data = await r.json();
                if (!r.ok) throw new Error(data.message || `Error ${r.status}`);
                return data;
            })
            .then(data => {
                this.showAlert(data.message || 'Book saved!');
                if (window.HSOverlay) {
                    window.HSOverlay.close(document.getElementById('hs-add-book-modal'));
                } else {
                    document.getElementById('hs-add-book-modal').classList.add('hidden');
                }
                setTimeout(() => location.reload(), 1000);
            })
            .catch(err => {
                this.showAlert(err.message, 'error');
                this.isSaving = false;
            });
    }
});
