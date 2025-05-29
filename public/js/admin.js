// Admin Panel JavaScript

// Enable Bootstrap tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

// Confirm delete actions
document.addEventListener('click', function(e) {
    if (e.target && e.target.classList.contains('confirm-delete')) {
        if (!confirm('Are you sure you want to delete this item? This action cannot be undone.')) {
            e.preventDefault();
        }
    }
});

// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    var alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            alert.style.transition = 'opacity 0.5s ease-in-out';
            alert.style.opacity = '0';
            setTimeout(function() {
                alert.remove();
            }, 500);
        }, 5000);
    });
});

// Toggle sidebar on mobile
document.addEventListener('DOMContentLoaded', function() {
    var toggler = document.querySelector('.navbar-toggler');
    if (toggler) {
        toggler.addEventListener('click', function() {
            document.body.classList.toggle('sidebar-open');
        });
    }
}); 