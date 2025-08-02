<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap\Breadcrumbs;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html as Html;
dmstr\web\AdminLteAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <!-- Theme style -->
    <?php $this->head() ?>
    <style>
        :root {
            --primary: #3b82f6;
            --primary-dark: #1e40af;
            --secondary: #64748b;
            --accent: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --success: #22c55e;
        }

        .dark {
            --bg-primary: #0f172a;
            --bg-secondary: #1e293b;
            --bg-tertiary: #334155;
            --text-primary: #f8fafc;
            --text-secondary: #cbd5e1;
            --border: #334155;
        }

        .light {
            --bg-primary: #ffffff;
            --bg-secondary: #f8fafc;
            --bg-tertiary: #e2e8f0;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --border: #e2e8f0;
        }

        * {
            font-family: 'Inter', sans-serif;
        }

        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .stat-card {
            background: linear-gradient(135deg, var(--bg-secondary) 0%, var(--bg-tertiary) 100%);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .progress-bar {
            background: linear-gradient(90deg, var(--primary) 0%, var(--accent) 100%);
            border-radius: 10px;
            height: 8px;
        }

        .xp-bar {
            background: linear-gradient(90deg, #fbbf24 0%, #f59e0b 50%, #d97706 100%);
        }

        .sidebar {
            background: var(--bg-secondary);
            border-right: 1px solid var(--border);
        }

        .nav-item {
            transition: all 0.2s ease;
            border-radius: 8px;
            margin: 2px 0;
        }

        .nav-item:hover,
        .nav-item.active {
            background: var(--primary);
            color: white;
        }

        .achievement-badge {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.8;
            }
        }

        .quest-card {
            border-left: 4px solid var(--primary);
            background: var(--bg-secondary);
        }

        .theme-btn {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid white;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .theme-btn:hover {
            transform: scale(1.1);
        }

        /* Enhanced light mode styling */
        .light .stat-card,
        .light .bg-white {
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }

        .light .stat-card:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        /* Fix bright backgrounds in dark mode */
        .dark .bg-yellow-50 {
            background: rgba(251, 191, 36, 0.1) !important;
        }

        .dark .bg-yellow-100 {
            background: rgba(251, 191, 36, 0.2) !important;
        }

        .dark .bg-blue-50 {
            background: rgba(59, 130, 246, 0.1) !important;
        }

        .dark .bg-blue-100 {
            background: rgba(59, 130, 246, 0.2) !important;
        }

        .dark .bg-green-50 {
            background: rgba(16, 185, 129, 0.1) !important;
        }

        .dark .bg-green-100 {
            background: rgba(16, 185, 129, 0.2) !important;
        }

        .dark .bg-purple-50 {
            background: rgba(139, 92, 246, 0.1) !important;
        }

        .dark .bg-purple-100 {
            background: rgba(139, 92, 246, 0.2) !important;
        }

        .dark .bg-red-50 {
            background: rgba(239, 68, 68, 0.1) !important;
        }

        .dark .bg-red-100 {
            background: rgba(239, 68, 68, 0.2) !important;
        }

        /* Ensure text readability in dark mode */
        .dark .text-yellow-600,
        .dark .text-blue-600,
        .dark .text-green-600,
        .dark .text-purple-600,
        .dark .text-red-600 {
            color: var(--text-primary) !important;
        }

        /* Dark mode form fixes */
        .dark input,
        .dark textarea,
        .dark select {
            background: var(--bg-secondary) !important;
            border-color: var(--border) !important;
            color: var(--text-primary) !important;
        }

        .dark input::placeholder,
        .dark textarea::placeholder {
            color: var(--text-secondary) !important;
        }

        .dark input:focus,
        .dark textarea:focus,
        .dark select:focus {
            background: var(--bg-tertiary) !important;
            border-color: var(--primary) !important;
        }

        /* Enhanced light mode styling */
        .light .stat-card,
        .light .bg-white {
            border: 2px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.15), 0 2px 4px -1px rgba(0, 0, 0, 0.1);
        }

        .light .stat-card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2), 0 4px 6px -2px rgba(0, 0, 0, 0.1);
            border-color: #cbd5e1;
        }

        /* Enhanced shadows for all cards */
        .light .rounded-xl {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.15), 0 2px 4px -1px rgba(0, 0, 0, 0.1);
            border: 1px solid #e2e8f0;
        }

        /* Dark mode enhanced borders */
        .dark .stat-card,
        .dark .bg-white,
        .dark .rounded-xl {
            border: 1px solid var(--border);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3), 0 2px 4px -1px rgba(0, 0, 0, 0.2);
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 10px;
            position: relative;
            max-width: 90%;
            max-height: 90%;
        }

        .modal-sm {
            max-width: 300px;
        }

        .modal-md {
            max-width: 500px;
        }

        .modal-lg {
            max-width: 800px;
        }

        .modal-xl {
            max-width: 1200px;
        }

        .close {
            position: absolute;
            right: 15px;
            top: 15px;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        /* Sidebar Collapsed State */
        .sidebar.collapsed {
            width: 4rem;
            /* 64px */
        }

        .sidebar.collapsed .sidebar-text {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }

        .sidebar.collapsed .nav-item {
            justify-content: center;
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .sidebar.collapsed .nav-icon {
            margin-right: 0;
        }

        .sidebar.collapsed #sidebarCollapseBtn i {
            transform: rotate(180deg);
        }

        /* Tooltip for collapsed sidebar */
        .sidebar.collapsed .nav-item {
            position: relative;
        }

        .sidebar.collapsed .nav-item:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            background: #1f2937;
            color: white;
            padding: 0.5rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            white-space: nowrap;
            z-index: 1000;
            margin-left: 0.5rem;
            opacity: 1;
        }

        .sidebar.collapsed .nav-item:hover::before {
            content: '';
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            border: 5px solid transparent;
            border-right-color: #1f2937;
            margin-left: -5px;
        }

        /* Mobile Responsive */
        @media (max-width: 1023px) {
            .sidebar {
                width: 16rem;
                /* 256px on mobile */
            }

            .sidebar.collapsed {
                width: 16rem;
                /* Don't collapse on mobile, just hide */
                transform: translateX(-100%);
            }
        }

        /* Smooth transitions */
        .sidebar {
            transition: width 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        .sidebar-text {
            transition: opacity 0.3s ease-in-out, width 0.3s ease-in-out;
        }

        .nav-icon {
            transition: margin 0.3s ease-in-out;
        }

        /* Content area adjustment */
        .main-content {
            transition: margin-left 0.3s ease-in-out;
        }

        .sidebar.collapsed~.main-content {
            margin-left: 4rem;
        }

        @media (max-width: 1023px) {
            .sidebar.collapsed~.main-content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body class="light bg-gray-50 text-gray-900" style="background: var(--bg-primary); color: var(--text-primary);">

<?php $this->beginBody() ?>
    <!-- Header -->
     <?php
    // NavBar::begin([
    //     'brandLabel' => Yii::$app->name,
    //     'brandUrl' => Yii::$app->homeUrl,
    //     'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
    // ]);
    // Nav::widget([
    //     'options' => ['class' => 'navbar-nav'],
    //     'items' => [
    //         ['label' => 'Home', 'url' => ['/site/index']],
    //         ['label' => 'About', 'url' => ['/site/about']],
    //         ['label' => 'Contact', 'url' => ['/site/contact']],
    //         Yii::$app->user->isGuest
    //             ? ['label' => 'Login', 'url' => ['/site/login']]
    //             : '<li class="nav-item">'
    //                 . Html::beginForm(['/site/logout'])
    //                 . Html::submitButton(
    //                     'Logout (' . Yii::$app->user->identity->username . ')',
    //                     ['class' => 'nav-link btn btn-link logout']
    //                 )
    //                 . Html::endForm()
    //                 . '</li>'
    //     ]
    // ]);
    // NavBar::end();
    ?>
    <?= Yii::$app->controller->renderPartial('/layouts/header'); ?>

    <div class="flex">
        <!-- Sidebar -->
         <?= $this->render('_sidebar') ?>
        <?php Yii::$app->controller->renderPartial('/layouts/sidebar'); ?>

        <!-- Sidebar Overlay for Mobile -->
        <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-10 lg:hidden hidden"></div>

        <!-- Main Content -->
        <main class="main-content flex-1 lg:m-4 transition-all duration-300">
            <?= Alert::widget() ?>
            <?= $content ?>
        </main>
    </div>

    <!-- Overlay for mobile sidebar -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-10 lg:hidden hidden"></div>
    <script>
        // Ensure Chart.js is loaded before DOM ready
        window.addEventListener('load', function () {
            if (typeof Chart === 'undefined') {
                console.error('Chart.js failed to load');
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Sidebar Toggle
            // const sidebarToggle = document.getElementById('sidebarToggle');
            // const sidebar = document.getElementById('sidebar');

            // sidebarToggle.addEventListener('click', function () {
            //     sidebar.classList.toggle('-translate-x-full');
            // });

            // Dark Mode Toggle
            const darkModeToggle = document.getElementById('darkModeToggle');

            darkModeToggle.addEventListener('click', function () {
                document.body.classList.toggle('dark');
            });

            // User Dropdown Menu
            const userDropdown = document.getElementById('userDropdown');
            const userDropdownMenu = document.getElementById('userDropdownMenu');

            userDropdown.addEventListener('click', function () {
                userDropdownMenu.classList.toggle('hidden');
            });

            const notificationDropdown = document.getElementById('notificationDropdown');
            const notificationDropdownMenu = document.getElementById('notificationMenu');

            notificationDropdown.addEventListener('click', function () {
                notificationDropdownMenu.classList.toggle('hidden');
            });

            // Theme Controls
            const themeButtons = document.querySelectorAll('.theme-btn');

            themeButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    const theme = this.dataset.theme;
                    document.body.classList.remove('light', 'dark');
                    document.body.classList.add(theme);
                });
            });

            // Map Initialization
            // const mapContainer = document.getElementById('map');

            // if (mapContainer) {
            //     const map = new google.maps.Map(mapContainer, {
            //         center: { lat: -34.397, lng: 150.644 },
            //         zoom: 8,
            //     });
            // }
        });
    </script>
    <script>
        // Global state
        let currentTheme = 'light';
        let currentColorScheme = 'blue';
        let statsChart = null;
        let map = null;

        // Initialize app
        $(document).ready(function () {
            initializeDashboard();
            initializeNavigation();
            initializeThemeControls();
            initializeCharts();
            initializeMap();
            initializeForms();
            $('#userDropdown').click(function (e) {
                e.stopPropagation();
                $('#userDropdownMenu').toggleClass('hidden');
            });

            // Close dropdown when clicking outside
            $(document).click(function () {
                $('#userDropdownMenu').addClass('hidden');
            });

            $('#userDropdownMenu').click(function (e) {
                e.stopPropagation();
            });

            // Initialize radar chart
            initializeRadarChart();
        });

        function destroyExistingCharts() {
            if (statsChart) {
                statsChart.destroy();
                statsChart = null;
            }
            if (window.radarChart) {
                window.radarChart.destroy();
                window.radarChart = null;
            }
        }

        function initializeRadarChart() {
            const ctx = document.getElementById('playerStatsRadar');
            if (!ctx) return;

            if (window.radarChart) {
                window.radarChart.destroy();
            }

            window.radarChart = new Chart(ctx, {
                type: 'radar',
                data: {
                    labels: ['Health', 'Creativity', 'Knowledge', 'Happiness', 'Money'],
                    datasets: [{
                        label: 'Stats',
                        data: [85, 72, 91, 78, 64],
                        backgroundColor: 'rgba(59, 130, 246, 0.2)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: 'rgba(59, 130, 246, 1)'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        r: {
                            angleLines: { display: false },
                            suggestedMin: 0,
                            suggestedMax: 100
                        }
                    },
                    animation: {
                        duration: 0
                    }
                }
            });
        }

        // Dashboard initialization
        function initializeDashboard() {
            showView('dashboard');

            // Initialize charts with delay to ensure DOM is ready
            setTimeout(() => {
                if (typeof Chart !== 'undefined') {
                    initializeCharts();
                    initializeRadarChart();
                }
            }, 500);

            $('.stat-card').hover(
                function () { $(this).addClass('shadow-lg'); },
                function () { $(this).removeClass('shadow-lg'); }
            );

            // User dropdown
            $('#userDropdown').click(function (e) {
                e.stopPropagation();
                $('#userDropdownMenu').toggleClass('hidden');
            });

            $(document).click(function () {
                $('#userDropdownMenu').addClass('hidden');
            });

            $('#userDropdownMenu').click(function (e) {
                e.stopPropagation();
            });
        }

        // Navigation functionality
        function initializeNavigation() {
            // Sidebar toggle for mobile
            $('#sidebarToggle').click(function () {
                $('#sidebar').toggleClass('-translate-x-full');
                $('#sidebarOverlay').toggleClass('hidden');
            });

            // Hide sidebar on overlay click
            $('#sidebarOverlay').click(function () {
                $('#sidebar').addClass('-translate-x-full');
                $('#sidebarOverlay').addClass('hidden');
            });

            // Navigation items
            $('.nav-item').click(function (e) {
                e.preventDefault();
                const target = $(this).attr('href').substring(1);

                // Update active state
                $('.nav-item').removeClass('active');
                $(this).addClass('active');

                // Show corresponding view
                showView(target);

                // Hide mobile sidebar
                if ($(window).width() < 1024) {
                    $('#sidebar').addClass('-translate-x-full');
                    $('#sidebarOverlay').addClass('hidden');
                }
            });
        }

        // Show/hide views
        function showView(viewName) {
            $('.view').addClass('hidden');
            $(`#${viewName}`).removeClass('hidden');

            // Initialize view-specific functionality
            if (viewName === 'dashboard' && !statsChart) {
                setTimeout(initializeCharts, 100);
            }
            if (viewName === 'dashboard' && !map) {
                setTimeout(initializeMap, 100);
            }
        }

        // Theme controls
        function initializeThemeControls() {
            // Dark mode toggle
            $('#darkModeToggle').click(function () {
                toggleDarkMode();
            });

            // Color theme buttons
            $('.theme-btn').click(function () {
                const theme = $(this).data('theme');
                setColorTheme(theme);
            });
        }

        // Toggle dark/light mode
        function toggleDarkMode() {
            currentTheme = currentTheme === 'light' ? 'dark' : 'light';
            $('body').removeClass('light dark').addClass(currentTheme);

            // Update icon
            const icon = currentTheme === 'dark' ? 'fa-sun' : 'fa-moon';
            $('#darkModeToggle i').removeClass('fa-moon fa-sun').addClass(icon);

            // Update charts if they exist
            if (statsChart) {
                updateChartTheme();
            }
        }

        // Set color theme
        function setColorTheme(theme) {
            currentColorScheme = theme;
            const root = document.documentElement;

            const themes = {
                blue: { primary: '#3b82f6', primaryDark: '#1e40af', accent: '#10b981' },
                green: { primary: '#10b981', primaryDark: '#059669', accent: '#3b82f6' },
                purple: { primary: '#8b5cf6', primaryDark: '#7c3aed', accent: '#ec4899' },
                red: { primary: '#ef4444', primaryDark: '#dc2626', accent: '#f59e0b' }
            };

            const colors = themes[theme];
            root.style.setProperty('--primary', colors.primary);
            root.style.setProperty('--primary-dark', colors.primaryDark);
            root.style.setProperty('--accent', colors.accent);

            // Update nav-item active states
            $('.nav-item.active').css('background-color', colors.primary);

            // Update theme button indicator
            $('.theme-btn').removeClass('ring-2 ring-white');
            $(`.theme-btn[data-theme="${theme}"]`).addClass('ring-2 ring-white');
        }

        // Initialize charts
        function initializeCharts() {
            const ctx = document.getElementById('statsChart');
            if (!ctx) return;

            // Destroy existing chart if it exists
            if (statsChart) {
                statsChart.destroy();
            }
            // destroyExistingCharts();

            const chartData = {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [
                    {
                        label: 'Health',
                        data: [78, 80, 82, 81, 85, 83, 85],
                        borderColor: '#ef4444',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        tension: 0.4
                    },
                    {
                        label: 'Knowledge',
                        data: [85, 87, 89, 90, 91, 90, 91],
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4
                    },
                    {
                        label: 'Happiness',
                        data: [72, 75, 78, 76, 78, 77, 78],
                        borderColor: '#fbbf24',
                        backgroundColor: 'rgba(251, 191, 36, 0.1)',
                        tension: 0.4
                    }
                ]
            };

            statsChart = new Chart(ctx, {
                type: 'line',
                data: chartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            min: 60,
                            max: 100
                        }
                    },
                    animation: {
                        duration: 0 // Disable animations to prevent glitching
                    }
                }
            });
        }

        // Initialize map
        function initializeMap() {
            const mapContainer = document.getElementById('map');

            if (mapContainer && !map) {
                map = L.map('map').setView([51.505, -0.09], 13);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                // Add sample markers
                const activities = [
                    { lat: 51.505, lng: -0.09, name: 'Morning Run', type: 'fitness' },
                    { lat: 51.515, lng: -0.1, name: 'Library Visit', type: 'education' },
                    { lat: 51.495, lng: -0.08, name: 'Coffee Shop', type: 'social' }
                ];

                activities.forEach(activity => {
                    const icon = activity.type === 'fitness' ? '🏃' :
                        activity.type === 'education' ? '📚' : '☕';

                    L.marker([activity.lat, activity.lng])
                        .addTo(map)
                        .bindPopup(`${icon} ${activity.name}`);
                });
            }
        }


        // Update chart theme
        function updateChartTheme() {
            if (!statsChart) return;

            const textColor = currentTheme === 'dark' ? '#f8fafc' : '#0f172a';
            const gridColor = currentTheme === 'dark' ? '#334155' : '#e2e8f0';

            statsChart.options.plugins.legend.labels.color = textColor;
            statsChart.options.scales.x.ticks.color = textColor;
            statsChart.options.scales.y.ticks.color = textColor;
            statsChart.options.scales.x.grid.color = gridColor;
            statsChart.options.scales.y.grid.color = gridColor;

            statsChart.update();
        }

        // Form handling
        function initializeForms() {
            // Task creation form
            $('form').on('submit', function (e) {
                e.preventDefault();

                // Show success message
                showNotification('Success!', 'Item created successfully', 'success');

                // Reset form
                this.reset();
            });

            // Checkbox interactions
            $('input[type="checkbox"]').change(function () {
                const $parent = $(this).closest('.flex');
                if (this.checked) {
                    $parent.find('span').first().addClass('line-through opacity-60');
                    showNotification('Task Completed!', '+XP earned', 'success');
                } else {
                    $parent.find('span').first().removeClass('line-through opacity-60');
                }
            });

            // Button interactions
            $('.bg-green-500, .bg-blue-500, .bg-purple-500').click(function (e) {
                if ($(this).text().includes('Complete') || $(this).text().includes('Accept')) {
                    e.preventDefault();
                    showNotification('Action Completed!', 'Progress updated', 'success');
                }
            });
        }

        // Notification system
        function showNotification(title, message, type = 'info') {
            const colors = {
                success: 'bg-green-500',
                error: 'bg-red-500',
                info: 'bg-blue-500',
                warning: 'bg-yellow-500'
            };

            const notification = $(`
                <div class="fixed top-4 right-4 ${colors[type]} text-white px-6 py-4 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-check-circle"></i>
                        <div>
                            <div class="font-semibold">${title}</div>
                            <div class="text-sm opacity-90">${message}</div>
                        </div>
                    </div>
                </div>
            `);

            $('body').append(notification);

            // Animate in
            setTimeout(() => {
                notification.removeClass('translate-x-full');
            }, 100);

            // Animate out and remove
            setTimeout(() => {
                notification.addClass('translate-x-full');
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Simulate real-time updates
        function simulateUpdates() {
            setInterval(() => {
                // Update XP bar occasionally
                if (Math.random() > 0.8) {
                    const currentWidth = parseFloat($('.xp-bar').css('width')) || 62.5;
                    const newWidth = Math.min(currentWidth + Math.random() * 2, 100);
                    $('.xp-bar').css('width', newWidth + '%');
                }
            }, 10000);
        }

        // Start simulated updates
        simulateUpdates();

        // Responsive handling
        $(window).resize(function () {
            if ($(window).width() >= 1024) {
                $('#sidebar').removeClass('-translate-x-full');
                $('#sidebarOverlay').addClass('hidden');
            }
        });

        // Toastr Configuration
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        // Modal Controls
        function initializeModals() {
            // Sign In Modal
            $('#openSigninModal').click(() => $('#signinModal').removeClass('hidden'));
            $('#closeSigninModal, #signinModal').click(e => {
                if (e.target.id === 'signinModal' || e.target.id === 'closeSigninModal') {
                    $('#signinModal').addClass('hidden');
                }
            });

            // Sign Up Modal
            $('#showSignupModal').click(() => {
                $('#signinModal').addClass('hidden');
                $('#signupModal').removeClass('hidden');
            });
            $('#showSigninModal').click(() => {
                $('#signupModal').addClass('hidden');
                $('#signinModal').removeClass('hidden');
            });
            $('#closeSignupModal, #signupModal').click(e => {
                if (e.target.id === 'signupModal' || e.target.id === 'closeSignupModal') {
                    $('#signupModal').addClass('hidden');
                }
            });
        }

        // Notification Dropdown
        function initializeNotifications() {
            $('#notificationDropdown').click(e => {
                e.stopPropagation();
                $('#notificationMenu').toggleClass('hidden');
            });

            $(document).click(() => $('#notificationMenu').addClass('hidden'));
            $('#notificationMenu').click(e => e.stopPropagation());

            $('#markAllRead').click(() => {
                $('.notification-item .bg-blue-500').removeClass('bg-blue-500').addClass('bg-gray-300');
                $('#notificationBadge').text('0').addClass('hidden');
                toastr.success('All notifications marked as read');
            });
        }

        // Settings Page
        function initializeSettings() {
            $('.settings-tab').click(function () {
                const tab = $(this).data('tab');
                $('.settings-tab').removeClass('active');
                $(this).addClass('active');
                $('.settings-content').addClass('hidden');
                $(`#${tab}-settings`).removeClass('hidden');
            });
        }

        // Toastr Triggers
        function initializeToastrTriggers() {
            // Add buttons to trigger different toastr types
            $('.trigger-success').click(() => toastr.success('Task completed successfully!', 'Great job!'));
            $('.trigger-info').click(() => toastr.info('New quest available!', 'Info'));
            $('.trigger-warning').click(() => toastr.warning('Your streak is at risk!', 'Warning'));
            $('.trigger-error').click(() => toastr.error('Failed to save changes', 'Error'));
        }

        function showSigninModal() {
            $('#signupModal').addClass('hidden');
            $('#signinModal').removeClass('hidden');
        }

        function showSignupModal() {
            $('#signinModal').addClass('hidden');
            $('#signupModal').removeClass('hidden');
        }

        // Initialize all new components
        $(document).ready(function () {
            initializeModals();
            initializeNotifications();
            initializeSettings();
            initializeToastrTriggers();
        });

        // Tab switching functionality
        document.querySelectorAll('.settings-tab').forEach(tab => {
            tab.addEventListener('click', function () {
                // Remove active class from all tabs and contents
                document.querySelectorAll('.settings-tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.settings-content').forEach(c => c.classList.add('hidden'));

                // Add active class to clicked tab
                this.classList.add('active');

                // Show corresponding content
                const tabName = this.getAttribute('data-tab');
                const content = document.getElementById(tabName + '-settings');
                if (content) {
                    content.classList.remove('hidden');
                }
            });
        });

        // Toast notification functions
        function showToast(type) {
            const position = document.getElementById('toastPosition').value;

            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-" + position,
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            const messages = {
                'success': 'This is a success message!',
                'error': 'This is an error message!',
                'warning': 'This is a warning message!',
                'info': 'This is an info message!'
            };

            toastr[type](messages[type]);
        }

        // Modal functions
        function showModal(size) {
            const modal = document.getElementById('demoModal');
            const content = document.getElementById('modalContent');
            const body = document.getElementById('modalBody');

            // Set modal size
            content.className = `modal-content modal-${size === 'xlarge' ? 'xl' : size === 'large' ? 'lg' : size === 'medium' ? 'md' : 'sm'}`;

            // Set modal content based on size
            const contents = {
                'small': '<h3 class="text-lg font-semibold mb-4">Small Modal</h3><p>This is a small modal example.</p>',
                'medium': '<h3 class="text-xl font-semibold mb-4">Medium Modal</h3><p>This is a medium-sized modal with more content space.</p><div class="mt-4"><button class="bg-blue-500 text-white px-4 py-2 rounded">Action Button</button></div>',
                'large': '<h3 class="text-2xl font-semibold mb-4">Large Modal</h3><p>This is a large modal that can contain more detailed content, forms, or complex layouts.</p><div class="grid grid-cols-2 gap-4 mt-4"><div class="p-4 bg-gray-100 rounded">Column 1</div><div class="p-4 bg-gray-100 rounded">Column 2</div></div>',
                'xlarge': '<h3 class="text-3xl font-semibold mb-4">Extra Large Modal</h3><p>This is an extra large modal suitable for complex forms, data tables, or detailed content.</p><div class="grid grid-cols-3 gap-4 mt-4"><div class="p-4 bg-gray-100 rounded">Section 1</div><div class="p-4 bg-gray-100 rounded">Section 2</div><div class="p-4 bg-gray-100 rounded">Section 3</div></div>'
            };

            body.innerHTML = contents[size];
            modal.classList.add('show');
        }

        function showConfirmDialog() {
            const modal = document.getElementById('demoModal');
            const content = document.getElementById('modalContent');
            const body = document.getElementById('modalBody');

            content.className = 'modal-content modal-md';
            body.innerHTML = `
        <h3 class="text-xl font-semibold mb-4">Confirm Action</h3>
        <p class="mb-6">Are you sure you want to perform this action? This cannot be undone.</p>
        <div class="flex justify-end space-x-3">
            <button onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</button>
            <button onclick="confirmAction()" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Confirm</button>
        </div>
    `;

            modal.classList.add('show');
        }

        function showFormModal() {
            const modal = document.getElementById('demoModal');
            const content = document.getElementById('modalContent');
            const body = document.getElementById('modalBody');

            content.className = 'modal-content modal-md';
            body.innerHTML = `
        <h3 class="text-xl font-semibold mb-4">Sample Form</h3>
        <form class="space-y-4">
            <div>
                <label class="block text-sm font-medium mb-2">Name</label>
                <input type="text" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Email</label>
                <input type="email" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Message</label>
                <textarea rows="3" class="w-full px-4 py-2 border rounded-lg"></textarea>
            </div>
        </form>
        <div class="flex justify-end space-x-3 mt-6">
            <button onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</button>
            <button onclick="submitForm()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Submit</button>
        </div>
    `;

            modal.classList.add('show');
        }

        function showImageModal() {
            const modal = document.getElementById('demoModal');
            const content = document.getElementById('modalContent');
            const body = document.getElementById('modalBody');

            content.className = 'modal-content modal-lg';
            body.innerHTML = `
        <h3 class="text-xl font-semibold mb-4">Image Gallery</h3>
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-gray-200 h-48 rounded-lg flex items-center justify-center">
                <i class="fas fa-image text-6xl text-gray-400"></i>
            </div>
            <div class="bg-gray-200 h-48 rounded-lg flex items-center justify-center">
                <i class="fas fa-image text-6xl text-gray-400"></i>
            </div>
        </div>
        <p class="mt-4 text-gray-600">Sample image gallery modal with placeholder images.</p>
    `;

            modal.classList.add('show');
        }

        function closeModal() {
            document.getElementById('demoModal').classList.remove('show');
        }

        function confirmAction() {
            showToast('success');
            closeModal();
        }

        function submitForm() {
            showToast('success');
            closeModal();
        }

        // Close modal when clicking outside
        window.onclick = function (event) {
            const modal = document.getElementById('demoModal');
            if (event.target === modal) {
                closeModal();
            }
        }

        // Sidebar functionality
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const sidebarCollapseBtn = document.getElementById('sidebarCollapseBtn');
            const mobileMenuBtn = document.getElementById('mobileMenuBtn'); // Assuming you have this in your header

            // Add tooltips to nav items for collapsed state
            const navItems = document.querySelectorAll('.nav-item');
            navItems.forEach(item => {
                const text = item.querySelector('.sidebar-text').textContent;
                item.setAttribute('data-tooltip', text);
            });

            // Toggle sidebar collapse on desktop
            if (sidebarCollapseBtn) {
                sidebarCollapseBtn.addEventListener('click', function () {
                    sidebar.classList.toggle('collapsed');

                    // Save state to localStorage
                    if (sidebar.classList.contains('collapsed')) {
                        localStorage.setItem('sidebarCollapsed', 'true');
                    } else {
                        localStorage.setItem('sidebarCollapsed', 'false');
                    }
                });
            }

            // Mobile menu toggle (you'll need to add this button to your header)
            if (mobileMenuBtn) {
                mobileMenuBtn.addEventListener('click', function () {
                    sidebar.classList.toggle('-translate-x-full');
                    sidebarOverlay.classList.toggle('hidden');
                });
            }

            // Close sidebar when clicking overlay on mobile
            sidebarOverlay.addEventListener('click', function () {
                sidebar.classList.add('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
            });

            // Restore sidebar state from localStorage
            const sidebarState = localStorage.getItem('sidebarCollapsed');
            if (sidebarState === 'true' && window.innerWidth >= 1024) {
                sidebar.classList.add('collapsed');
            }

            // Handle window resize
            window.addEventListener('resize', function () {
                if (window.innerWidth >= 1024) {
                    // Desktop: show sidebar, hide overlay
                    sidebarOverlay.classList.add('hidden');
                    sidebar.classList.remove('-translate-x-full');

                    // Restore collapsed state if it was saved
                    const sidebarState = localStorage.getItem('sidebarCollapsed');
                    if (sidebarState === 'true') {
                        sidebar.classList.add('collapsed');
                    }
                } else {
                    // Mobile: remove collapsed state, hide sidebar by default
                    sidebar.classList.remove('collapsed');
                    sidebar.classList.add('-translate-x-full');
                }
            });

            // Close mobile sidebar when clicking on nav items
            navItems.forEach(item => {
                item.addEventListener('click', function () {
                    if (window.innerWidth < 1024) {
                        sidebar.classList.add('-translate-x-full');
                        sidebarOverlay.classList.add('hidden');
                    }
                });
            });
        });
    </script>
    <div id="demoModal" class="modal">
        <div class="modal-content" id="modalContent">
            <span class="close" onclick="closeModal()">&times;</span>
            <div id="modalBody">
                <!-- Dynamic content will be inserted here -->
            </div>
        </div>
    </div>
    <!-- Sign In Modal -->
    <div id="signinModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl p-8 max-w-md w-full shadow-2xl" style="background: var(--bg-secondary);">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-blue-600 mb-2">Welcome Back!</h2>
                    <p class="text-gray-600">Sign in to continue your quest</p>
                </div>

                <form id="signinForm" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium mb-2">Email</label>
                        <input type="email" required
                            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Password</label>
                        <div class="relative">
                            <input type="password" required
                                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <button type="button" class="absolute right-3 top-3 text-gray-400 hover:text-gray-600">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded text-blue-500">
                            <span class="ml-2 text-sm">Remember me</span>
                        </label>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-500">Forgot password?</a>
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-500 text-white py-3 rounded-lg hover:bg-blue-600 font-medium">
                        Sign In
                    </button>

                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500" style="background: var(--bg-secondary);">Or
                                continue with</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <button type="button"
                            class="flex items-center justify-center px-4 py-2 border rounded-lg hover:bg-gray-50">
                            <i class="fab fa-google text-red-500 mr-2"></i>
                            Google
                        </button>
                        <button type="button"
                            class="flex items-center justify-center px-4 py-2 border rounded-lg hover:bg-gray-50">
                            <i class="fab fa-github mr-2"></i>
                            GitHub
                        </button>
                    </div>

                    <p class="text-center text-sm">
                        Don't have an account?
                        <button type="button" id="showSignupModal"
                            class="text-blue-600 hover:text-blue-500 font-medium">Sign up</button>
                    </p>
                </form>

                <button id="closeSigninModal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Sign Up Modal -->
    <div id="signupModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl p-8 max-w-md w-full shadow-2xl" style="background: var(--bg-secondary);">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-blue-600 mb-2">Start Your Quest!</h2>
                    <p class="text-gray-600">Create your account and begin your journey</p>
                </div>

                <form id="signupForm" class="space-y-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">First Name</label>
                            <input type="text" required
                                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">Last Name</label>
                            <input type="text" required
                                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Email</label>
                        <input type="email" required
                            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Password</label>
                        <input type="password" required
                            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Confirm Password</label>
                        <input type="password" required
                            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" required class="rounded text-blue-500">
                        <span class="ml-2 text-sm">I agree to the <a href="#"
                                class="text-blue-600 hover:text-blue-500">Terms of Service</a> and <a href="#"
                                class="text-blue-600 hover:text-blue-500">Privacy Policy</a></span>
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-500 text-white py-3 rounded-lg hover:bg-blue-600 font-medium">
                        Create Account
                    </button>

                    <p class="text-center text-sm">
                        Already have an account?
                        <button type="button" id="showSigninModal"
                            class="text-blue-600 hover:text-blue-500 font-medium">Sign in</button>
                    </p>
                </form>

                <button id="closeSignupModal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
    </div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>