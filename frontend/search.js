document.addEventListener('DOMContentLoaded', () => {
    const searchForm = document.getElementById('search-form');
    const searchInput = document.getElementById('search-input');

    searchForm.addEventListener('submit', (e) => {
        e.preventDefault(); // Prevent default form submission

        const query = searchInput.value.trim(); // Get search input value

        if (query) {
            // Redirect to shop page with search query
            window.location.href = `view.php?search=${encodeURIComponent(query)}`;
        } else {
            alert('Please enter a search term.');
        }
    });
});
