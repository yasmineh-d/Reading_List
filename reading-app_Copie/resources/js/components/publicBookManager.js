import { baseComponent } from './baseComponent';

export default (initialConfig = {}) => ({
    ...baseComponent,
    search: initialConfig.search || '',
    category: initialConfig.category || '',
    booksHtml: '',

    init() {
        const container = document.getElementById('books-container');
        if (container) {
            this.booksHtml = container.innerHTML;
        }

        // Handle pagination clicks within the component container
        document.addEventListener('click', (e) => {
            const link = e.target.closest('#pagination-container a') || e.target.closest('.pagination a');
            if (link && document.getElementById('books-container').contains(link)) {
                e.preventDefault();
                this.fetchPage(link.href);
            }
        });
    },

    fetchBooks() {
        const url = new URL(window.location.href);
        url.searchParams.set('search', this.search);
        url.searchParams.set('category', this.category);
        url.searchParams.delete('page');

        history.pushState(null, '', url.toString());

        this.loadContent(url.toString());
    },

    fetchPage(url) {
        history.pushState(null, '', url);
        this.loadContent(url);
        window.scrollTo({ top: 0, behavior: 'smooth' });
    },

    loadContent(url) {
        fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
            .then(response => response.text())
            .then(html => {
                this.booksHtml = html;
                this.$nextTick(() => this.initLucide());
            })
            .catch(error => console.error('Error fetching books:', error));
    }
});
