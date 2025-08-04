// Script added by Hamza Amjad to handle Profile dropdown menu inside header
document.querySelector('.toggle-sidebar-btn').addEventListener('click', function () {
    let sidebar = document.getElementById('sidebar');
    
    if (sidebar.classList.contains('sidebar-collapsed-profile')) {
        sidebar.classList.remove('sidebar-collapsed-profile');
    }
    
    sidebar.classList.toggle('sidebar-collapsed');
});

// Handle profile click (collapse sidebar on small screens)
document.querySelector('.nav-profile').addEventListener('click', function () {
    if (window.innerWidth < 576) {
        let sidebar = document.getElementById('sidebar');
        
        // Collapse sidebar when profile is clicked
        sidebar.classList.add('sidebar-collapsed-profile');
    }
});