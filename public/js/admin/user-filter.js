document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('user-filter');
    const rows = document.querySelectorAll('#user-table-body tr');

    if (!input) return;

    input.addEventListener('input', () => {
        const value = input.value.toLowerCase();

        rows.forEach(row => {
            const filterData = row.querySelector('[data-filter]');
            if (!filterData) return;

            const content = filterData.dataset.filter;
            row.style.display = content.includes(value) ? '' : 'none';
        });
    });
});
