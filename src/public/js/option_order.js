document.addEventListener('DOMContentLoaded', function () {
    const sortSelect = document.getElementById('sortSelect');
    if (!sortSelect) return;

    sortSelect.addEventListener('change', function () {
        const selectedSort = this.value;
        const baseUrl = this.dataset.url; // ← data属性から取得
        const keyword = document.querySelector('input[name="keyword"]').value;

        let url = baseUrl + '?sort=' + selectedSort;
        if (keyword) {
            url += '&keyword=' + encodeURIComponent(keyword);
        }

        window.location.href = url;
    });
});