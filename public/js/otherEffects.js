document.addEventListener('DOMContentLoaded', function() {
    var backToTop = document.getElementById('backToTop');
    if (backToTop) {
        backToTop.addEventListener('click', function(e) {
            e.preventDefault();

            // Smooth scroll to top
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }
});