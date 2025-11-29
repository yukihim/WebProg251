document.addEventListener('DOMContentLoaded', function() {
    const searchBox = document.getElementById('searchBox');
    const suggestions = document.getElementById('searchSuggestions');

    searchBox.addEventListener('input', function() {
        const query = this.value.trim();
        if (query.length == 0) {
            suggestions.innerHTML = '';
            return;
        }
        fetch('/quanswebsite/public/helper/ajax_search.php?query=' + encodeURIComponent(query))
            .then(res => res.json())
            .then(data => {
                if (data.length === 0) {
                    suggestions.innerHTML = '';
                    return;
                }
                suggestions.innerHTML = data.map(item =>
                    `<a href="../app/Views/car/show.php?cid=${item.cid}" class="list-group-item list-group-item-action">${item.model_name}</a>`
                ).join('');
            });
    });

    document.addEventListener('click', function(e) {
        if (!searchBox.contains(e.target) && !suggestions.contains(e.target)) {
            suggestions.innerHTML = '';
        }
    });
});