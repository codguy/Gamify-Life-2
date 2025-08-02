<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Life Quest Dashboard</title>
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

    <!-- Header -->
    <header class="bg-white shadow-sm border-b" style="background: var(--bg-secondary); border-color: var(--border);">
        <div class="flex items-center justify-between px-6 py-4">
            <div class="flex items-center space-x-4">
                <!-- <button id="sidebarToggle" class="lg:hidden">
                    <i class="fas fa-bars text-xl"></i>
                </button> -->
                <button id="mobileMenuBtn" class="lg:hidden p-2 rounded-lg hover:bg-gray-100">
                    <i class="fas fa-bars text-gray-600"></i>
                </button>
                <h1 class="text-2xl font-bold text-blue-600">Life Quest</h1>
            </div>

            <!-- User Stats -->
            <!-- Replace the current user stats div with: -->
            <div class="flex items-center space-x-6">
                <!-- Search Bar -->
                <div class="relative">
                    <input type="text" placeholder="Search..."
                        class="pl-10 pr-4 py-2 rounded-lg border bg-white text-sm w-64">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>

                <!-- Notifications -->
                <!-- Enhanced Notifications -->
                <div class="relative">
                    <button id="notificationDropdown" class="relative p-2 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-bell text-xl"></i>
                        <span id="notificationBadge"
                            class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">3</span>
                    </button>

                    <!-- Notification Dropdown Menu -->
                    <div id="notificationMenu"
                        class="hidden absolute right-0 mt-2 w-96 bg-white rounded-xl shadow-lg border z-50"
                        style="background: var(--bg-secondary); border-color: var(--border);">
                        <div class="p-4 border-b" style="border-color: var(--border);">
                            <div class="flex items-center justify-between">
                                <h3 class="font-semibold text-lg">Notifications</h3>
                                <button id="markAllRead" class="text-sm text-blue-500 hover:text-blue-600">Mark all
                                    read</button>
                            </div>
                        </div>

                        <div class="max-h-96 overflow-y-auto">
                            <div class="notification-item p-4 border-b hover:bg-gray-50 cursor-pointer"
                                style="border-color: var(--border);">
                                <div class="flex items-start space-x-3">
                                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-trophy text-green-500"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-medium">New Achievement Unlocked!</p>
                                        <p class="text-sm text-gray-600">You've earned the "Streak Master" badge</p>
                                        <p class="text-xs text-gray-400 mt-1">2 minutes ago</p>
                                    </div>
                                    <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                </div>
                            </div>

                            <div class="notification-item p-4 border-b hover:bg-gray-50 cursor-pointer"
                                style="border-color: var(--border);">
                                <div class="flex items-start space-x-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-users text-blue-500"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-medium">Friend Request</p>
                                        <p class="text-sm text-gray-600">John Doe wants to connect with you</p>
                                        <p class="text-xs text-gray-400 mt-1">1 hour ago</p>
                                    </div>
                                    <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                </div>
                            </div>

                            <div class="notification-item p-4 border-b hover:bg-gray-50 cursor-pointer"
                                style="border-color: var(--border);">
                                <div class="flex items-start space-x-3">
                                    <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-fire text-yellow-500"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-medium">Streak Reminder</p>
                                        <p class="text-sm text-gray-600">Don't forget to complete your daily tasks!</p>
                                        <p class="text-xs text-gray-400 mt-1">3 hours ago</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 border-t" style="border-color: var(--border);">
                            <button class="w-full text-center text-blue-500 hover:text-blue-600 text-sm">View All
                                Notifications</button>
                        </div>
                    </div>
                </div>

                <!-- Theme Controls -->
                <div class="flex items-center space-x-2">
                    <button id="darkModeToggle" class="p-2 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-moon"></i>
                    </button>
                    <div class="flex space-x-1">
                        <div class="theme-btn bg-blue-500" data-theme="blue"></div>
                        <div class="theme-btn bg-green-500" data-theme="green"></div>
                        <div class="theme-btn bg-purple-500" data-theme="purple"></div>
                        <div class="theme-btn bg-red-500" data-theme="red"></div>
                    </div>
                </div>

                <!-- User Dropdown -->
                <div class="relative">
                    <button id="userDropdown" class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-white text-sm"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="userDropdownMenu"
                        class="hidden absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border p-4 z-50"
                        style="background: var(--bg-secondary); border-color: var(--border);">
                        <!-- Player Info -->
                        <div class="text-center mb-4">
                            <div
                                class="w-16 h-16 bg-blue-500 rounded-full mx-auto mb-2 flex items-center justify-center">
                                <i class="fas fa-user text-white text-2xl"></i>
                            </div>
                            <h3 class="font-bold">Player Name</h3>
                            <div class="flex items-center justify-center space-x-2 mt-2">
                                <i class="fas fa-star text-yellow-500"></i>
                                <span class="font-semibold">Level 12</span>
                            </div>
                        </div>

                        <!-- XP Progress -->
                        <div class="mb-4">
                            <div class="flex items-center justify-between text-sm mb-1">
                                <span>Experience</span>
                                <span>1,250 / 2,000 XP</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="xp-bar h-3 rounded-full" style="width: 62.5%"></div>
                            </div>
                        </div>

                        <!-- Currency -->
                        <div class="flex justify-between mb-4">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-coins text-yellow-600"></i>
                                <span class="font-semibold">2,450</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-gem text-purple-500"></i>
                                <span class="font-semibold">15 Gems</span>
                            </div>
                        </div>

                        <!-- Player Stats Radar Chart -->
                        <div class="mb-4">
                            <canvas id="playerStatsRadar" width="200" height="200"></canvas>
                        </div>

                        <hr class="my-4" style="border-color: var(--border);">

                        <!-- Menu Items -->
                        <div class="space-y-2">
                            <a href="#" class="block px-3 py-2 rounded hover:bg-gray-100 text-sm">Profile Settings</a>
                            <a href="#" class="block px-3 py-2 rounded hover:bg-gray-100 text-sm">Privacy</a>
                            <a href="#" class="block px-3 py-2 rounded hover:bg-gray-100 text-sm">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="flex">
        <!-- Sidebar -->
        <aside id="sidebar"
            class="sidebar w-64 min-h-screen p-4 transform -translate-x-full lg:translate-x-0 transition-all duration-300 ease-in-out fixed lg:relative z-20">
            <!-- Sidebar Header with Toggle Button -->
            <div class="flex items-center justify-between mb-6">
                <div class="sidebar-logo flex items-center space-x-2">
                    <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-gamepad text-white text-sm"></i>
                    </div>
                    <span class="sidebar-text font-bold text-lg">GameHub</span>
                </div>
                <button id="sidebarCollapseBtn"
                    class="hidden lg:block p-1 rounded-lg hover:bg-gray-200 transition-colors">
                    <i class="fas fa-chevron-left text-gray-600"></i>
                </button>
            </div>

            <nav class="space-y-2">
                <a href="#dashboard"
                    class="nav-item active flex items-center space px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200">
                    <i class="fas fa-tachometer-alt w-5 nav-icon"></i>
                    <span class="sidebar-text">Dashboard</span>
                </a>
                <a href="#tasks"
                    class="nav-item flex items-center space px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200">
                    <i class="fas fa-tasks w-5 nav-icon"></i>
                    <span class="sidebar-text">Tasks</span>
                </a>
                <a href="#quests"
                    class="nav-item flex items-center space px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200">
                    <i class="fas fa-scroll w-5 nav-icon"></i>
                    <span class="sidebar-text">Quests</span>
                </a>
                <a href="#habits"
                    class="nav-item flex items-center space px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200">
                    <i class="fas fa-repeat w-5 nav-icon"></i>
                    <span class="sidebar-text">Habits</span>
                </a>
                <a href="#achievements"
                    class="nav-item flex items-center space px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200">
                    <i class="fas fa-trophy w-5 nav-icon"></i>
                    <span class="sidebar-text">Achievements</span>
                </a>
                <a href="#leaderboard"
                    class="nav-item flex items-center space px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200">
                    <i class="fas fa-ranking-star w-5 nav-icon"></i>
                    <span class="sidebar-text">Leaderboard</span>
                </a>
                <a href="#journal"
                    class="nav-item flex items-center space px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200">
                    <i class="fas fa-book w-5 nav-icon"></i>
                    <span class="sidebar-text">Journal</span>
                </a>
                <a href="#goals"
                    class="nav-item flex items-center space px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200">
                    <i class="fa-solid fa-bullseye w-5 nav-icon"></i>
                    <span class="sidebar-text">Goals</span>
                </a>
                <a href="#shop"
                    class="nav-item flex items-center space px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200">
                    <i class="fas fa-shopping-cart w-5 nav-icon"></i>
                    <span class="sidebar-text">Shop</span>
                </a>
                <a href="#social"
                    class="nav-item flex items-center space px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200">
                    <i class="fas fa-users w-5 nav-icon"></i>
                    <span class="sidebar-text">Social</span>
                </a>
                <a href="#settings"
                    class="nav-item flex items-center space px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200">
                    <i class="fas fa-cog w-5 nav-icon"></i>
                    <span class="sidebar-text">Settings</span>
                </a>
                <a href="#error-page"
                    class="nav-item flex items-center space px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200">
                    <i class="fas fa-exclamation-triangle w-5 nav-icon"></i>
                    <span class="sidebar-text">Error Page</span>
                </a>
            </nav>

            <!-- Sidebar Footer (Optional) -->
            <div class="absolute bottom-4 left-4 right-4">
                <div class="sidebar-text text-xs text-gray-500 text-center">
                    <p>Version 1.0.0</p>
                </div>
            </div>
        </aside>

        <!-- Sidebar Overlay for Mobile -->
        <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-10 lg:hidden hidden"></div>

        <!-- Main Content -->
        <main class="main-content flex-1 lg:m-4 transition-all duration-300">

            <!-- Dashboard View -->
            <div id="dashboard" class="view">
                <!-- Player Stats -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold mb-6">Player Stats</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6">

                        <!-- Physical Health -->
                        <div class="stat-card rounded-xl p-6 text-center">
                            <div
                                class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-heart text-2xl text-red-500"></i>
                            </div>
                            <h3 class="font-semibold text-gray-600 mb-2">Physical Health</h3>
                            <div class="text-3xl font-bold text-red-500 mb-2">85</div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-red-500 h-2 rounded-full" style="width: 85%"></div>
                            </div>
                        </div>

                        <!-- Creativity -->
                        <div class="stat-card rounded-xl p-6 text-center">
                            <div
                                class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-palette text-2xl text-purple-500"></i>
                            </div>
                            <h3 class="font-semibold text-gray-600 mb-2">Creativity</h3>
                            <div class="text-3xl font-bold text-purple-500 mb-2">72</div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-purple-500 h-2 rounded-full" style="width: 72%"></div>
                            </div>
                        </div>

                        <!-- Knowledge -->
                        <div class="stat-card rounded-xl p-6 text-center">
                            <div
                                class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-brain text-2xl text-blue-500"></i>
                            </div>
                            <h3 class="font-semibold text-gray-600 mb-2">Knowledge</h3>
                            <div class="text-3xl font-bold text-blue-500 mb-2">91</div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-500 h-2 rounded-full" style="width: 91%"></div>
                            </div>
                        </div>

                        <!-- Happiness -->
                        <div class="stat-card rounded-xl p-6 text-center">
                            <div
                                class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-smile text-2xl text-yellow-500"></i>
                            </div>
                            <h3 class="font-semibold text-gray-600 mb-2">Happiness</h3>
                            <div class="text-3xl font-bold text-yellow-500 mb-2">78</div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-yellow-500 h-2 rounded-full" style="width: 78%"></div>
                            </div>
                        </div>

                        <!-- Money -->
                        <div class="stat-card rounded-xl p-6 text-center">
                            <div
                                class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-dollar-sign text-2xl text-green-500"></i>
                            </div>
                            <h3 class="font-semibold text-gray-600 mb-2">Money</h3>
                            <div class="text-3xl font-bold text-green-500 mb-2">64</div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: 64%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

                    <!-- Today's Tasks -->
                    <div class="bg-white rounded-xl p-6 shadow-sm" style="background: var(--bg-secondary);">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold">Today's Tasks</h3>
                            <button class="text-blue-500 hover:text-blue-600">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg"
                                style="background: var(--bg-tertiary);">
                                <input type="checkbox" class="rounded text-blue-500">
                                <span class="flex-1">Morning workout</span>
                                <span class="text-sm bg-red-100 text-red-600 px-2 py-1 rounded">+5 Health</span>
                            </div>
                            <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg"
                                style="background: var(--bg-tertiary);">
                                <input type="checkbox" class="rounded text-blue-500" checked>
                                <span class="flex-1 line-through opacity-60">Read 30 minutes</span>
                                <span class="text-sm bg-blue-100 text-blue-600 px-2 py-1 rounded">+3 Knowledge</span>
                            </div>
                            <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg"
                                style="background: var(--bg-tertiary);">
                                <input type="checkbox" class="rounded text-blue-500">
                                <span class="flex-1">Write in journal</span>
                                <span class="text-sm bg-yellow-100 text-yellow-600 px-2 py-1 rounded">+2
                                    Happiness</span>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Achievements -->
                    <div class="bg-white rounded-xl p-6 shadow-sm" style="background: var(--bg-secondary);">
                        <h3 class="text-lg font-semibold mb-4">Recent Achievements</h3>
                        <div class="space-y-3">
                            <div
                                class="flex items-center space-x-3 p-3 bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-lg">
                                <div class="achievement-badge w-10 h-10 rounded-full flex items-center justify-center">
                                    <i class="fas fa-fire text-white text-sm"></i>
                                </div>
                                <div>
                                    <div class="font-medium">7-Day Streak!</div>
                                    <div class="text-sm text-gray-600">Completed tasks for 7 days</div>
                                </div>
                            </div>
                            <div
                                class="flex items-center space-x-3 p-3 bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg">
                                <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-book text-white text-sm"></i>
                                </div>
                                <div>
                                    <div class="font-medium">Bookworm</div>
                                    <div class="text-sm text-gray-600">Read 100 hours this month</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Daily Streak -->
                    <div class="bg-white rounded-xl p-6 shadow-sm" style="background: var(--bg-secondary);">
                        <h3 class="text-lg font-semibold mb-4">Daily Streak</h3>
                        <div class="text-center">
                            <div class="text-4xl font-bold text-orange-500 mb-2">🔥 12</div>
                            <div class="text-sm text-gray-600 mb-4">Days in a row</div>
                            <div class="grid grid-cols-7 gap-1">
                                <div
                                    class="w-8 h-8 bg-green-500 rounded flex items-center justify-center text-white text-xs">
                                    M</div>
                                <div
                                    class="w-8 h-8 bg-green-500 rounded flex items-center justify-center text-white text-xs">
                                    T</div>
                                <div
                                    class="w-8 h-8 bg-green-500 rounded flex items-center justify-center text-white text-xs">
                                    W</div>
                                <div
                                    class="w-8 h-8 bg-green-500 rounded flex items-center justify-center text-white text-xs">
                                    T</div>
                                <div
                                    class="w-8 h-8 bg-green-500 rounded flex items-center justify-center text-white text-xs">
                                    F</div>
                                <div
                                    class="w-8 h-8 bg-blue-500 rounded flex items-center justify-center text-white text-xs">
                                    S</div>
                                <div
                                    class="w-8 h-8 bg-gray-300 rounded flex items-center justify-center text-gray-600 text-xs">
                                    S</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <div class="bg-white rounded-xl p-6 shadow-sm" style="background: var(--bg-secondary);">
                        <h3 class="text-lg font-semibold mb-4">Stats Progress</h3>
                        <canvas id="statsChart" width="400" height="200"></canvas>
                    </div>
                    <div class="bg-white rounded-xl p-6 shadow-sm" style="background: var(--bg-secondary);">
                        <h3 class="text-lg font-semibold mb-4">Activity Locations</h3>
                        <div id="map" style="height: 300px; border-radius: 8px;"></div>
                    </div>
                </div>
            </div>

            <!-- Tasks View -->
            <div id="tasks" class="view hidden">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Tasks Management</h2>
                    <button
                        class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 flex items-center space-x-2">
                        <i class="fas fa-plus"></i>
                        <span>New Task</span>
                    </button>
                </div>

                <!-- Task Form -->
                <div class="bg-white rounded-xl p-6 shadow-sm mb-6" style="background: var(--bg-secondary);">
                    <h3 class="text-lg font-semibold mb-4">Create New Task</h3>
                    <form class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" placeholder="Task title"
                            class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        <select class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option>Select Category</option>
                            <option>Health & Fitness</option>
                            <option>Learning</option>
                            <option>Creative</option>
                            <option>Social</option>
                            <option>Work</option>
                        </select>
                        <input type="date" class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        <select class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option>Priority Level</option>
                            <option>High</option>
                            <option>Medium</option>
                            <option>Low</option>
                        </select>
                        <div class="md:col-span-2">
                            <textarea placeholder="Task description" rows="3"
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>
                        <div class="md:col-span-2">
                            <h4 class="font-medium mb-2">Stat Rewards</h4>
                            <div class="grid grid-cols-5 gap-4">
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Health</label>
                                    <input type="number" min="0" max="10" class="w-full px-3 py-2 border rounded">
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Creativity</label>
                                    <input type="number" min="0" max="10" class="w-full px-3 py-2 border rounded">
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Knowledge</label>
                                    <input type="number" min="0" max="10" class="w-full px-3 py-2 border rounded">
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Happiness</label>
                                    <input type="number" min="0" max="10" class="w-full px-3 py-2 border rounded">
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Money</label>
                                    <input type="number" min="0" max="10" class="w-full px-3 py-2 border rounded">
                                </div>
                            </div>
                        </div>
                        <div class="md:col-span-2">
                            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">
                                Create Task
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Task Lists -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="bg-white rounded-xl p-6 shadow-sm" style="background: var(--bg-secondary);">
                        <h3 class="text-lg font-semibold mb-4 text-yellow-600">⏳ Pending</h3>
                        <div class="space-y-3">
                            <div class="p-4 border-l-4 border-yellow-500 bg-yellow-50 rounded-r-lg">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="font-medium">Morning Meditation</h4>
                                    <span class="text-xs bg-yellow-200 text-yellow-800 px-2 py-1 rounded">High</span>
                                </div>
                                <p class="text-sm text-gray-600 mb-2">15 minutes mindfulness practice</p>
                                <div class="flex justify-between items-center">
                                    <div class="flex space-x-1">
                                        <span class="text-xs bg-red-100 text-red-600 px-2 py-1 rounded">+3 Health</span>
                                        <span class="text-xs bg-yellow-100 text-yellow-600 px-2 py-1 rounded">+5
                                            Happiness</span>
                                    </div>
                                    <button class="text-green-500 hover:text-green-600">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-6 shadow-sm" style="background: var(--bg-secondary);">
                        <h3 class="text-lg font-semibold mb-4 text-blue-600">🔄 In Progress</h3>
                        <div class="space-y-3">
                            <div class="p-4 border-l-4 border-blue-500 bg-blue-50 rounded-r-lg">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="font-medium">Learn Spanish</h4>
                                    <span class="text-xs bg-blue-200 text-blue-800 px-2 py-1 rounded">Medium</span>
                                </div>
                                <p class="text-sm text-gray-600 mb-2">Complete Duolingo lesson</p>
                                <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                                    <div class="bg-blue-500 h-2 rounded-full" style="width: 60%"></div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <div class="flex space-x-1">
                                        <span class="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded">+4
                                            Knowledge</span>
                                    </div>
                                    <button class="text-green-500 hover:text-green-600">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-6 shadow-sm" style="background: var(--bg-secondary);">
                        <h3 class="text-lg font-semibold mb-4 text-green-600">✅ Completed</h3>
                        <div class="space-y-3">
                            <div class="p-4 border-l-4 border-green-500 bg-green-50 rounded-r-lg opacity-75">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="font-medium line-through">Read 30 minutes</h4>
                                    <span class="text-xs bg-green-200 text-green-800 px-2 py-1 rounded">Done</span>
                                </div>
                                <p class="text-sm text-gray-600 mb-2">Finished chapter 5</p>
                                <div class="flex space-x-1">
                                    <span class="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded">+3
                                        Knowledge</span>
                                    <span class="text-xs bg-yellow-100 text-yellow-600 px-2 py-1 rounded">+2
                                        Happiness</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quests View -->
            <div id="quests" class="view hidden">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Epic Quests</h2>
                    <button
                        class="bg-purple-500 text-white px-4 py-2 rounded-lg hover:bg-purple-600 flex items-center space-x-2">
                        <i class="fas fa-scroll"></i>
                        <span>Create Quest</span>
                    </button>
                </div>

                <!-- Active Quests -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <div class="quest-card bg-white rounded-xl p-6 shadow-sm" style="background: var(--bg-secondary);">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-bold text-purple-600">🏃‍♂️ Fitness Warrior</h3>
                            <span
                                class="bg-purple-100 text-purple-600 px-3 py-1 rounded-full text-sm font-medium">Active</span>
                        </div>
                        <p class="text-gray-600 mb-4">Complete 30 days of consistent exercise to unlock the Fitness
                            Warrior badge and gain massive health stats!</p>

                        <div class="mb-4">
                            <div class="flex justify-between text-sm mb-2">
                                <span>Progress</span>
                                <span>18/30 days</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-purple-500 h-3 rounded-full" style="width: 60%"></div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-red-500">+25</div>
                                <div class="text-sm text-gray-600">Health Reward</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-yellow-500">500</div>
                                <div class="text-sm text-gray-600">XP Reward</div>
                            </div>
                        </div>

                        <div class="border-t pt-4">
                            <h4 class="font-medium mb-2">Recent Activities</h4>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between text-sm">
                                    <span>✅ Morning run - 5km</span>
                                    <span class="text-green-600">Today</span>
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <span>✅ Gym session - 1hr</span>
                                    <span class="text-green-600">Yesterday</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="quest-card bg-white rounded-xl p-6 shadow-sm" style="background: var(--bg-secondary);">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-bold text-blue-600">📚 Knowledge Seeker</h3>
                            <span
                                class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-sm font-medium">Active</span>
                        </div>
                        <p class="text-gray-600 mb-4">Read 10 books this quarter to become a true Knowledge Seeker and
                            unlock exclusive learning resources!</p>

                        <div class="mb-4">
                            <div class="flex justify-between text-sm mb-2">
                                <span>Progress</span>
                                <span>7/10 books</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-blue-500 h-3 rounded-full" style="width: 70%"></div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-blue-500">+30</div>
                                <div class="text-sm text-gray-600">Knowledge Reward</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-yellow-500">750</div>
                                <div class="text-sm text-gray-600">XP Reward</div>
                            </div>
                        </div>

                        <div class="border-t pt-4">
                            <h4 class="font-medium mb-2">Recently Read</h4>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between text-sm">
                                    <span>✅ "Atomic Habits"</span>
                                    <span class="text-green-600">Completed</span>
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <span>📖 "Deep Work"</span>
                                    <span class="text-blue-600">Reading</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Available Quests -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold mb-4">Available Quests</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div class="bg-white rounded-lg p-4 shadow-sm border-2 border-dashed border-gray-300 hover:border-green-400 cursor-pointer transition-colors"
                            style="background: var(--bg-secondary);">
                            <div class="text-center">
                                <div class="text-3xl mb-2">🎨</div>
                                <h4 class="font-semibold mb-2">Creative Master</h4>
                                <p class="text-sm text-gray-600 mb-3">Complete 15 creative projects in 30 days</p>
                                <div class="flex justify-center space-x-2 mb-3">
                                    <span class="text-xs bg-purple-100 text-purple-600 px-2 py-1 rounded">+20
                                        Creativity</span>
                                    <span class="text-xs bg-yellow-100 text-yellow-600 px-2 py-1 rounded">400 XP</span>
                                </div>
                                <button class="bg-green-500 text-white px-4 py-2 rounded text-sm hover:bg-green-600">
                                    Accept Quest
                                </button>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg p-4 shadow-sm border-2 border-dashed border-gray-300 hover:border-green-400 cursor-pointer transition-colors"
                            style="background: var(--bg-secondary);">
                            <div class="text-center">
                                <div class="text-3xl mb-2">💰</div>
                                <h4 class="font-semibold mb-2">Wealth Builder</h4>
                                <p class="text-sm text-gray-600 mb-3">Save $1000 and track expenses for 60 days</p>
                                <div class="flex justify-center space-x-2 mb-3">
                                    <span class="text-xs bg-green-100 text-green-600 px-2 py-1 rounded">+25 Money</span>
                                    <span class="text-xs bg-yellow-100 text-yellow-600 px-2 py-1 rounded">600 XP</span>
                                </div>
                                <button class="bg-green-500 text-white px-4 py-2 rounded text-sm hover:bg-green-600">
                                    Accept Quest
                                </button>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg p-4 shadow-sm border-2 border-dashed border-gray-300 hover:border-green-400 cursor-pointer transition-colors"
                            style="background: var(--bg-secondary);">
                            <div class="text-center">
                                <div class="text-3xl mb-2">🧘</div>
                                <h4 class="font-semibold mb-2">Zen Master</h4>
                                <p class="text-sm text-gray-600 mb-3">Meditate daily for 21 days straight</p>
                                <div class="flex justify-center space-x-2 mb-3">
                                    <span class="text-xs bg-yellow-100 text-yellow-600 px-2 py-1 rounded">+15
                                        Happiness</span>
                                    <span class="text-xs bg-yellow-100 text-yellow-600 px-2 py-1 rounded">350 XP</span>
                                </div>
                                <button class="bg-green-500 text-white px-4 py-2 rounded text-sm hover:bg-green-600">
                                    Accept Quest
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Habits View -->
            <div id="habits" class="view hidden">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Habit Tracker</h2>
                    <button
                        class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 flex items-center space-x-2">
                        <i class="fas fa-plus"></i>
                        <span>Add Habit</span>
                    </button>
                </div>

                <!-- Habit Creation Form -->
                <div class="bg-white rounded-xl p-6 shadow-sm mb-6" style="background: var(--bg-secondary);">
                    <h3 class="text-lg font-semibold mb-4">Create New Habit</h3>
                    <form class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <input type="text" placeholder="Habit name" class="px-4 py-2 border rounded-lg">
                        <select class="px-4 py-2 border rounded-lg">
                            <option>Frequency</option>
                            <option>Daily</option>
                            <option>Weekly</option>
                            <option>Custom</option>
                        </select>
                        <input type="time" class="px-4 py-2 border rounded-lg">
                        <div class="md:col-span-3">
                            <button type="submit"
                                class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600">
                                Create Habit
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Habit Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="bg-white rounded-xl p-6 shadow-sm" style="background: var(--bg-secondary);">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-semibold">💧 Drink 8 glasses of water</h3>
                                <p class="text-sm text-gray-600">Daily • 7:00 AM reminder</p>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-blue-500">12</div>
                                <div class="text-sm text-gray-600">day streak</div>
                            </div>
                        </div>

                        <div class="grid grid-cols-7 gap-2 mb-4">
                            <div class="text-center">
                                <div class="text-xs text-gray-600 mb-1">Mon</div>
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check text-white text-xs"></i>
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="text-xs text-gray-600 mb-1">Tue</div>
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check text-white text-xs"></i>
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="text-xs text-gray-600 mb-1">Wed</div>
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check text-white text-xs"></i>
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="text-xs text-gray-600 mb-1">Thu</div>
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check text-white text-xs"></i>
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="text-xs text-gray-600 mb-1">Fri</div>
                                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-droplet text-white text-xs"></i>
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="text-xs text-gray-600 mb-1">Sat</div>
                                <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
                            </div>
                            <div class="text-center">
                                <div class="text-xs text-gray-600 mb-1">Sun</div>
                                <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <div class="flex space-x-1">
                                <span class="text-xs bg-red-100 text-red-600 px-2 py-1 rounded">+2 Health</span>
                            </div>
                            <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                                Mark Complete
                            </button>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-6 shadow-sm" style="background: var(--bg-secondary);">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-semibold">📚 Read for 30 minutes</h3>
                                <p class="text-sm text-gray-600">Daily • 8:00 PM reminder</p>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-green-500">25</div>
                                <div class="text-sm text-gray-600">day streak</div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="text-sm text-gray-600 mb-2">This week's progress: 5/7 days</div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: 71%"></div>
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <div class="flex space-x-1">
                                <span class="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded">+3 Knowledge</span>
                                <span class="text-xs bg-yellow-100 text-yellow-600 px-2 py-1 rounded">+1
                                    Happiness</span>
                            </div>
                            <button class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                                Mark Complete
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Achievements View -->
            <div id="achievements" class="view hidden">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold mb-2">Achievements & Badges</h2>
                    <p class="text-gray-600">Unlock badges by completing tasks and maintaining streaks!</p>
                </div>

                <!-- Achievement Stats -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-xl p-6 text-center shadow-sm" style="background: var(--bg-secondary);">
                        <div class="text-3xl font-bold text-yellow-500 mb-2">24</div>
                        <div class="text-sm text-gray-600">Total Badges</div>
                    </div>
                    <div class="bg-white rounded-xl p-6 text-center shadow-sm" style="background: var(--bg-secondary);">
                        <div class="text-3xl font-bold text-blue-500 mb-2">12</div>
                        <div class="text-sm text-gray-600">This Month</div>
                    </div>
                    <div class="bg-white rounded-xl p-6 text-center shadow-sm" style="background: var(--bg-secondary);">
                        <div class="text-3xl font-bold text-green-500 mb-2">85%</div>
                        <div class="text-sm text-gray-600">Completion Rate</div>
                    </div>
                    <div class="bg-white rounded-xl p-6 text-center shadow-sm" style="background: var(--bg-secondary);">
                        <div class="text-3xl font-bold text-purple-500 mb-2">3</div>
                        <div class="text-sm text-gray-600">Legendary</div>
                    </div>
                </div>

                <!-- Achievement Categories -->
                <div class="mb-6">
                    <div class="flex flex-wrap gap-2">
                        <button class="bg-blue-500 text-white px-4 py-2 rounded-full text-sm">All</button>
                        <button
                            class="bg-gray-200 text-gray-700 px-4 py-2 rounded-full text-sm hover:bg-gray-300">Health</button>
                        <button
                            class="bg-gray-200 text-gray-700 px-4 py-2 rounded-full text-sm hover:bg-gray-300">Knowledge</button>
                        <button
                            class="bg-gray-200 text-gray-700 px-4 py-2 rounded-full text-sm hover:bg-gray-300">Creativity</button>
                        <button
                            class="bg-gray-200 text-gray-700 px-4 py-2 rounded-full text-sm hover:bg-gray-300">Social</button>
                    </div>
                </div>

                <!-- Achievement Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div
                        class="bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl p-6 text-white relative overflow-hidden">
                        <div
                            class="absolute top-2 right-2 bg-yellow-300 text-yellow-800 px-2 py-1 rounded-full text-xs font-bold">
                            LEGENDARY
                        </div>
                        <div class="text-4xl mb-3">🏆</div>
                        <h3 class="text-xl font-bold mb-2">Task Master</h3>
                        <p class="text-yellow-100 text-sm mb-4">Complete 1000 tasks</p>
                        <div class="flex justify-between items-center">
                            <span class="text-sm">Unlocked 2 days ago</span>
                            <div class="text-right">
                                <div class="text-lg font-bold">+500 XP</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-red-400 to-red-600 rounded-xl p-6 text-white">
                        <div class="text-4xl mb-3">🔥</div>
                        <h3 class="text-xl font-bold mb-2">Streak Warrior</h3>
                        <p class="text-red-100 text-sm mb-4">Maintain a 30-day streak</p>
                        <div class="flex justify-between items-center">
                            <span class="text-sm">Unlocked 5 days ago</span>
                            <div class="text-right">
                                <div class="text-lg font-bold">+200 XP</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl p-6 text-white">
                        <div class="text-4xl mb-3">📚</div>
                        <h3 class="text-xl font-bold mb-2">Bookworm</h3>
                        <p class="text-blue-100 text-sm mb-4">Read 50 hours this month</p>
                        <div class="flex justify-between items-center">
                            <span class="text-sm">Unlocked 1 week ago</span>
                            <div class="text-right">
                                <div class="text-lg font-bold">+150 XP</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-300 rounded-xl p-6 text-gray-600 border-2 border-dashed border-gray-400">
                        <div class="text-4xl mb-3 opacity-50">🎨</div>
                        <h3 class="text-xl font-bold mb-2">Creative Genius</h3>
                        <p class="text-sm mb-4">Complete 25 creative projects</p>
                        <div class="w-full bg-gray-400 rounded-full h-2 mb-2">
                            <div class="bg-purple-500 h-2 rounded-full" style="width: 60%"></div>
                        </div>
                        <div class="text-sm">15/25 projects completed</div>
                    </div>

                    <div class="bg-gray-300 rounded-xl p-6 text-gray-600 border-2 border-dashed border-gray-400">
                        <div class="text-4xl mb-3 opacity-50">💪</div>
                        <h3 class="text-xl font-bold mb-2">Fitness Beast</h3>
                        <p class="text-sm mb-4">Work out 100 times</p>
                        <div class="w-full bg-gray-400 rounded-full h-2 mb-2">
                            <div class="bg-red-500 h-2 rounded-full" style="width: 83%"></div>
                        </div>
                        <div class="text-sm">83/100 workouts completed</div>
                    </div>

                    <div class="bg-gray-300 rounded-xl p-6 text-gray-600 border-2 border-dashed border-gray-400">
                        <div class="text-4xl mb-3 opacity-50">🧘</div>
                        <h3 class="text-xl font-bold mb-2">Zen Master</h3>
                        <p class="text-sm mb-4">Meditate 100 hours total</p>
                        <div class="w-full bg-gray-400 rounded-full h-2 mb-2">
                            <div class="bg-yellow-500 h-2 rounded-full" style="width: 34%"></div>
                        </div>
                        <div class="text-sm">34/100 hours completed</div>
                    </div>
                </div>
            </div>

            <!-- Leaderboard View -->
            <div id="leaderboard" class="view hidden">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold mb-2">Leaderboard</h2>
                    <p class="text-gray-600">See how you rank against other players!</p>
                </div>

                <!-- Leaderboard Tabs -->
                <div class="flex space-x-4 mb-6">
                    <button class="bg-blue-500 text-white px-4 py-2 rounded-lg">Weekly</button>
                    <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300">Monthly</button>
                    <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300">All Time</button>
                </div>

                <!-- Top 3 Podium -->
                <div class="bg-white rounded-xl p-6 shadow-sm mb-6" style="background: var(--bg-secondary);">
                    <div class="flex justify-center items-end space-x-8">
                        <!-- 2nd Place -->
                        <div class="text-center">
                            <div
                                class="w-16 h-16 bg-gray-400 rounded-full flex items-center justify-center mx-auto mb-2">
                                <span class="text-white font-bold">JD</span>
                            </div>
                            <div class="text-lg font-bold">Jane Doe</div>
                            <div class="text-2xl">🥈</div>
                            <div class="text-xl font-bold text-gray-500">8,450 XP</div>
                            <div class="bg-gray-400 h-20 w-24 mt-2 rounded-t-lg flex items-end justify-center pb-2">
                                <span class="text-white font-bold text-2xl">2</span>
                            </div>
                        </div>

                        <!-- 1st Place -->
                        <div class="text-center">
                            <div
                                class="w-20 h-20 bg-yellow-500 rounded-full flex items-center justify-center mx-auto mb-2">
                                <span class="text-white font-bold text-lg">AS</span>
                            </div>
                            <div class="text-xl font-bold">Alex Smith</div>
                            <div class="text-3xl">👑</div>
                            <div class="text-2xl font-bold text-yellow-500">12,340 XP</div>
                            <div class="bg-yellow-500 h-32 w-28 mt-2 rounded-t-lg flex items-end justify-center pb-2">
                                <span class="text-white font-bold text-3xl">1</span>
                            </div>
                        </div>

                        <!-- 3rd Place -->
                        <div class="text-center">
                            <div
                                class="w-16 h-16 bg-orange-600 rounded-full flex items-center justify-center mx-auto mb-2">
                                <span class="text-white font-bold">MB</span>
                            </div>
                            <div class="text-lg font-bold">Mike Brown</div>
                            <div class="text-2xl">🥉</div>
                            <div class="text-xl font-bold text-orange-600">7,890 XP</div>
                            <div class="bg-orange-600 h-16 w-24 mt-2 rounded-t-lg flex items-end justify-center pb-2">
                                <span class="text-white font-bold text-xl">3</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Full Leaderboard -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden" style="background: var(--bg-secondary);">
                    <div class="px-6 py-4 border-b" style="border-color: var(--border);">
                        <h3 class="text-lg font-semibold">Weekly Rankings</h3>
                    </div>
                    <div class="divide-y" style="divide-color: var(--border);">
                        <div class="px-6 py-4 flex items-center justify-between bg-blue-50">
                            <div class="flex items-center space-x-4">
                                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold text-sm">4</span>
                                </div>
                                <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold">YOU</span>
                                </div>
                                <div>
                                    <div class="font-semibold">You</div>
                                    <div class="text-sm text-gray-600">Level 12</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-bold text-blue-500">6,780 XP</div>
                                <div class="text-sm text-gray-600">↑ 2 positions</div>
                            </div>
                        </div>

                        <div class="px-6 py-4 flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-8 h-8 bg-gray-500 rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold text-sm">5</span>
                                </div>
                                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold">SJ</span>
                                </div>
                                <div>
                                    <div class="font-semibold">Sarah Johnson</div>
                                    <div class="text-sm text-gray-600">Level 11</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-bold">5,920 XP</div>
                                <div class="text-sm text-gray-600">↓ 1 position</div>
                            </div>
                        </div>

                        <div class="px-6 py-4 flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-8 h-8 bg-gray-500 rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold text-sm">6</span>
                                </div>
                                <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold">RW</span>
                                </div>
                                <div>
                                    <div class="font-semibold">Robert Wilson</div>
                                    <div class="text-sm text-gray-600">Level 10</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-bold">5,340 XP</div>
                                <div class="text-sm text-gray-600">- No change</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Journal View -->
            <div id="journal" class="view hidden">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Daily Journal</h2>
                    <button
                        class="bg-purple-500 text-white px-4 py-2 rounded-lg hover:bg-purple-600 flex items-center space-x-2">
                        <i class="fas fa-pen"></i>
                        <span>New Entry</span>
                    </button>
                </div>

                <!-- Journal Entry Form -->
                <div class="bg-white rounded-xl p-6 shadow-sm mb-6" style="background: var(--bg-secondary);">
                    <h3 class="text-lg font-semibold mb-4">Today's Reflection</h3>
                    <form class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">How are you feeling today?</label>
                            <div class="flex space-x-2">
                                <button type="button" class="text-2xl hover:scale-110 transition-transform">😊</button>
                                <button type="button" class="text-2xl hover:scale-110 transition-transform">😐</button>
                                <button type="button" class="text-2xl hover:scale-110 transition-transform">😔</button>
                                <button type="button" class="text-2xl hover:scale-110 transition-transform">😤</button>
                                <button type="button" class="text-2xl hover:scale-110 transition-transform">🤗</button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">What went well today?</label>
                            <textarea rows="3" placeholder="Share your wins and positive moments..."
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">What could be improved?</label>
                            <textarea rows="3" placeholder="Reflect on challenges and areas for growth..."
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Tomorrow's focus</label>
                            <input type="text" placeholder="What's your main priority for tomorrow?"
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500">
                        </div>

                        <button type="submit"
                            class="bg-purple-500 text-white px-6 py-2 rounded-lg hover:bg-purple-600 flex items-center space-x-2">
                            <i class="fas fa-save"></i>
                            <span>Save Entry</span>
                        </button>
                    </form>
                </div>

                <!-- Recent Entries -->
                <div class="space-y-4">
                    <h3 class="text-xl font-semibold">Recent Entries</h3>

                    <div class="bg-white rounded-xl p-6 shadow-sm" style="background: var(--bg-secondary);">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex items-center space-x-3">
                                <span class="text-2xl">😊</span>
                                <div class="text-sm text-gray-600">Yesterday • July 22, 2025</div>
                            </div>
                            <button class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                        </div>

                        <div class="space-y-3">
                            <div>
                                <h4 class="font-medium text-green-600 mb-1">What went well:</h4>
                                <p class="text-gray-700">Completed my morning workout and felt energized all day. Had a
                                    great productive session working on my creative project.</p>
                            </div>
                            <div>
                                <h4 class="font-medium text-orange-600 mb-1">Areas for improvement:</h4>
                                <p class="text-gray-700">Spent too much time on social media during work breaks. Need to
                                    be more mindful of my phone usage.</p>
                            </div>
                            <div>
                                <h4 class="font-medium text-blue-600 mb-1">Tomorrow's focus:</h4>
                                <p class="text-gray-700">Start reading the new book I bought and practice Spanish for 30
                                    minutes.</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-6 shadow-sm" style="background: var(--bg-secondary);">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex items-center space-x-3">
                                <span class="text-2xl">😐</span>
                                <div class="text-sm text-gray-600">July 21, 2025</div>
                            </div>
                            <button class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                        </div>

                        <div class="space-y-3">
                            <div>
                                <h4 class="font-medium text-green-600 mb-1">What went well:</h4>
                                <p class="text-gray-700">Met my step goal and had a good conversation with a friend I
                                    hadn't talked to in a while.</p>
                            </div>
                            <div>
                                <h4 class="font-medium text-orange-600 mb-1">Areas for improvement:</h4>
                                <p class="text-gray-700">Felt a bit overwhelmed with work tasks. Need to break them down
                                    into smaller, manageable chunks.</p>
                            </div>
                            <div>
                                <h4 class="font-medium text-blue-600 mb-1">Tomorrow's focus:</h4>
                                <p class="text-gray-700">Organize my task list and prioritize the most important items.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Goals View -->
            <div id="goals" class="view hidden">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Goal Setting</h2>
                    <button
                        class="bg-indigo-500 text-white px-4 py-2 rounded-lg hover:bg-indigo-600 flex items-center space-x-2">
                        <i class="fas fa-target"></i>
                        <span>New Goal</span>
                    </button>
                </div>

                <!-- Goal Creation Form -->
                <div class="bg-white rounded-xl p-6 shadow-sm mb-6" style="background: var(--bg-secondary);">
                    <h3 class="text-lg font-semibold mb-4">Set a New Goal</h3>
                    <form class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" placeholder="Goal title"
                            class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                        <select class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                            <option>Goal Type</option>
                            <option>Health & Fitness</option>
                            <option>Learning & Growth</option>
                            <option>Career</option>
                            <option>Personal</option>
                            <option>Financial</option>
                        </select>
                        <input type="date" class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                        <select class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                            <option>Priority</option>
                            <option>High</option>
                            <option>Medium</option>
                            <option>Low</option>
                        </select>
                        <div class="md:col-span-2">
                            <textarea placeholder="Describe your goal and why it's important to you..." rows="3"
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500"></textarea>
                        </div>
                        <div class="md:col-span-2">
                            <button type="submit"
                                class="bg-indigo-500 text-white px-6 py-2 rounded-lg hover:bg-indigo-600">
                                Create Goal
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Active Goals -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <div class="bg-white rounded-xl p-6 shadow-sm border-l-4 border-green-500"
                        style="background: var(--bg-secondary);">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-green-600">🏃‍♂️ Run a Half Marathon</h3>
                                <p class="text-sm text-gray-600">Target: December 15, 2025</p>
                            </div>
                            <span
                                class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-sm font-medium">Active</span>
                        </div>

                        <p class="text-gray-700 mb-4">Train consistently to complete my first half marathon in under 2
                            hours. This will significantly boost my physical health and personal confidence.</p>

                        <div class="mb-4">
                            <div class="flex justify-between text-sm mb-2">
                                <span>Progress</span>
                                <span>65% Complete</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-green-500 h-3 rounded-full" style="width: 65%"></div>
                            </div>
                        </div>

                        <div class="space-y-2 mb-4">
                            <div class="flex items-center text-sm">
                                <i class="fas fa-check text-green-500 w-4"></i>
                                <span class="ml-2">✅ Complete 5K run</span>
                            </div>
                            <div class="flex items-center text-sm">
                                <i class="fas fa-check text-green-500 w-4"></i>
                                <span class="ml-2">✅ Complete 10K run</span>
                            </div>
                            <div class="flex items-center text-sm">
                                <i class="fas fa-circle text-blue-500 w-4"></i>
                                <span class="ml-2">🔄 Complete 15K run</span>
                            </div>
                            <div class="flex items-center text-sm">
                                <i class="fas fa-circle text-gray-400 w-4"></i>
                                <span class="ml-2">⏳ Race day preparation</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <div class="text-sm text-gray-600">144 days remaining</div>
                            <button class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 text-sm">
                                Update Progress
                            </button>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-6 shadow-sm border-l-4 border-blue-500"
                        style="background: var(--bg-secondary);">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-blue-600">📚 Read 24 Books This Year</h3>
                                <p class="text-sm text-gray-600">Target: December 31, 2025</p>
                            </div>
                            <span
                                class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-sm font-medium">Active</span>
                        </div>

                        <p class="text-gray-700 mb-4">Expand my knowledge and improve my reading habit by completing 2
                            books per month. Focus on personal development, fiction, and technical books.</p>

                        <div class="mb-4">
                            <div class="flex justify-between text-sm mb-2">
                                <span>Progress</span>
                                <span>12/24 books (50%)</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-blue-500 h-3 rounded-full" style="width: 50%"></div>
                            </div>
                        </div>

                        <div class="space-y-2 mb-4">
                            <div class="flex items-center text-sm">
                                <i class="fas fa-book text-blue-500 w-4"></i>
                                <span class="ml-2">Currently reading: "Deep Work"</span>
                            </div>
                            <div class="flex items-center text-sm">
                                <i class="fas fa-check text-green-500 w-4"></i>
                                <span class="ml-2">Last completed: "Atomic Habits"</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <div class="text-sm text-gray-600">161 days remaining</div>
                            <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 text-sm">
                                Log Book
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Completed Goals -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold mb-4">Recently Completed</h3>
                    <div class="bg-white rounded-xl p-6 shadow-sm border-l-4 border-gray-400 opacity-75"
                        style="background: var(--bg-secondary);">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-gray-600 line-through">🎨 Learn Digital Art</h3>
                                <p class="text-sm text-gray-600">Completed: July 15, 2025</p>
                            </div>
                            <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-sm font-medium">✅
                                Completed</span>
                        </div>
                        <p class="text-gray-600 mb-4">Master basic digital art techniques and create 10 original pieces.
                        </p>
                        <div class="text-sm text-green-600 font-medium">🎉 Goal completed! +15 Creativity, +200 XP</div>
                    </div>
                </div>
            </div>

            <!-- Shop View -->
            <div id="shop" class="view hidden">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold mb-2">Life Quest Shop</h2>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-coins text-yellow-500"></i>
                            <span class="font-semibold">2,450 Coins</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-gem text-purple-500"></i>
                            <span class="font-semibold">15 Gems</span>
                        </div>
                    </div>
                </div>

                <!-- Shop Categories -->
                <div class="flex flex-wrap gap-2 mb-6">
                    <button class="bg-blue-500 text-white px-4 py-2 rounded-full text-sm">All Items</button>
                    <button
                        class="bg-gray-200 text-gray-700 px-4 py-2 rounded-full text-sm hover:bg-gray-300">Power-ups</button>
                    <button
                        class="bg-gray-200 text-gray-700 px-4 py-2 rounded-full text-sm hover:bg-gray-300">Themes</button>
                    <button
                        class="bg-gray-200 text-gray-700 px-4 py-2 rounded-full text-sm hover:bg-gray-300">Rewards</button>
                    <button
                        class="bg-gray-200 text-gray-700 px-4 py-2 rounded-full text-sm hover:bg-gray-300">Premium</button>
                </div>

                <!-- Shop Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Power-ups -->
                    <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow"
                        style="background: var(--bg-secondary);">
                        <div class="text-center">
                            <div class="text-4xl mb-3">⚡</div>
                            <h3 class="text-lg font-bold mb-2">XP Booster</h3>
                            <p class="text-sm text-gray-600 mb-4">Double XP for the next 24 hours</p>
                            <div class="flex items-center justify-center space-x-2 mb-4">
                                <i class="fas fa-coins text-yellow-500"></i>
                                <span class="font-bold text-lg">150</span>
                            </div>
                            <button class="bg-yellow-500 text-white px-6 py-2 rounded-lg hover:bg-yellow-600 w-full">
                                Purchase
                            </button>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow"
                        style="background: var(--bg-secondary);">
                        <div class="text-center">
                            <div class="text-4xl mb-3">🔥</div>
                            <h3 class="text-lg font-bold mb-2">Streak Freeze</h3>
                            <p class="text-sm text-gray-600 mb-4">Protect your streak for one missed day</p>
                            <div class="flex items-center justify-center space-x-2 mb-4">
                                <i class="fas fa-coins text-yellow-500"></i>
                                <span class="font-bold text-lg">100</span>
                            </div>
                            <button class="bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600 w-full">
                                Purchase
                            </button>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow"
                        style="background: var(--bg-secondary);">
                        <div class="text-center">
                            <div class="text-4xl mb-3">💎</div>
                            <h3 class="text-lg font-bold mb-2">Stat Multiplier</h3>
                            <p class="text-sm text-gray-600 mb-4">1.5x stat gains for 3 days</p>
                            <div class="flex items-center justify-center space-x-2 mb-4">
                                <i class="fas fa-gem text-purple-500"></i>
                                <span class="font-bold text-lg">5</span>
                            </div>
                            <button class="bg-purple-500 text-white px-6 py-2 rounded-lg hover:bg-purple-600 w-full">
                                Purchase
                            </button>
                        </div>
                    </div>

                    <!-- Themes -->
                    <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow"
                        style="background: var(--bg-secondary);">
                        <div class="text-center">
                            <div class="text-4xl mb-3">🌙</div>
                            <h3 class="text-lg font-bold mb-2">Dark Knight Theme</h3>
                            <p class="text-sm text-gray-600 mb-4">Sleek dark theme with blue accents</p>
                            <div class="flex items-center justify-center space-x-2 mb-4">
                                <i class="fas fa-coins text-yellow-500"></i>
                                <span class="font-bold text-lg">300</span>
                            </div>
                            <button class="bg-gray-800 text-white px-6 py-2 rounded-lg hover:bg-gray-700 w-full">
                                Purchase
                            </button>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow"
                        style="background: var(--bg-secondary);">
                        <div class="text-center">
                            <div class="text-4xl mb-3">🌸</div>
                            <h3 class="text-lg font-bold mb-2">Cherry Blossom Theme</h3>
                            <p class="text-sm text-gray-600 mb-4">Beautiful pink and white theme</p>
                            <div class="flex items-center justify-center space-x-2 mb-4">
                                <i class="fas fa-coins text-yellow-500"></i>
                                <span class="font-bold text-lg">250</span>
                            </div>
                            <button class="bg-pink-500 text-white px-6 py-2 rounded-lg hover:bg-pink-600 w-full">
                                Purchase
                            </button>
                        </div>
                    </div>

                    <!-- Real Rewards -->
                    <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow"
                        style="background: var(--bg-secondary);">
                        <div class="text-center">
                            <div class="text-4xl mb-3">☕</div>
                            <h3 class="text-lg font-bold mb-2">Coffee Treat</h3>
                            <p class="text-sm text-gray-600 mb-4">Reward yourself with your favorite coffee</p>
                            <div class="flex items-center justify-center space-x-2 mb-4">
                                <i class="fas fa-coins text-yellow-500"></i>
                                <span class="font-bold text-lg">200</span>
                            </div>
                            <button class="bg-brown-500 text-white px-6 py-2 rounded-lg hover:bg-brown-600 w-full"
                                style="background-color: #8B4513;">
                                Claim Reward
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social View -->
            <div id="social" class="view hidden">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold mb-2">Social Hub</h2>
                    <p class="text-gray-600">Connect with friends and share your progress!</p>
                </div>

                <!-- Social Stats -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-xl p-6 text-center shadow-sm" style="background: var(--bg-secondary);">
                        <div class="text-3xl font-bold text-blue-500 mb-2">23</div>
                        <div class="text-sm text-gray-600">Friends</div>
                    </div>
                    <div class="bg-white rounded-xl p-6 text-center shadow-sm" style="background: var(--bg-secondary);">
                        <div class="text-3xl font-bold text-green-500 mb-2">156</div>
                        <div class="text-sm text-gray-600">Challenges Won</div>
                    </div>
                    <div class="bg-white rounded-xl p-6 text-center shadow-sm" style="background: var(--bg-secondary);">
                        <div class="text-3xl font-bold text-purple-500 mb-2">47</div>
                        <div class="text-sm text-gray-600">Posts Shared</div>
                    </div>
                    <div class="bg-white rounded-xl p-6 text-center shadow-sm" style="background: var(--bg-secondary);">
                        <div class="text-3xl font-bold text-orange-500 mb-2">892</div>
                        <div class="text-sm text-gray-600">Likes Received</div>
                    </div>
                </div>

                <!-- Recent Activity Feed -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2">
                        <h3 class="text-xl font-semibold mb-4">Activity Feed</h3>
                        <div class="space-y-4">
                            <div class="bg-white rounded-xl p-6 shadow-sm" style="background: var(--bg-secondary);">
                                <div class="flex items-start space-x-4">
                                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                                        <span class="text-white font-bold text-sm">AS</span>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2 mb-2">
                                            <span class="font-semibold">Alex Smith</span>
                                            <span class="text-sm text-gray-600">completed a quest</span>
                                            <span class="text-sm text-gray-400">2h ago</span>
                                        </div>
                                        <div class="bg-gradient-to-r from-purple-50 to-purple-100 p-4 rounded-lg">
                                            <div class="flex items-center space-x-2">
                                                <span class="text-2xl">🏃‍♂️</span>
                                                <div>
                                                    <div class="font-medium text-gray-500">Fitness Warrior Quest Completed!</div>
                                                    <div class="text-sm text-gray-600">+25 Health, +500 XP</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-4 mt-3 text-sm">
                                            <button
                                                class="flex items-center space-x-1 text-gray-600 hover:text-red-500">
                                                <i class="fas fa-heart"></i>
                                                <span>12</span>
                                            </button>
                                            <button
                                                class="flex items-center space-x-1 text-gray-600 hover:text-blue-500">
                                                <i class="fas fa-comment"></i>
                                                <span>3</span>
                                            </button>
                                            <button class="text-gray-600 hover:text-green-500">
                                                <i class="fas fa-share"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-xl p-6 shadow-sm" style="background: var(--bg-secondary);">
                                <div class="flex items-start space-x-4">
                                    <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                                        <span class="text-white font-bold text-sm">SJ</span>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2 mb-2">
                                            <span class="font-semibold">Sarah Johnson</span>
                                            <span class="text-sm text-gray-600">achieved a new badge</span>
                                            <span class="text-sm text-gray-400">4h ago</span>
                                        </div>
                                        <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 p-4 rounded-lg">
                                            <div class="flex items-center space-x-2">
                                                <span class="text-2xl">🏆</span>
                                                <div>
                                                    <div class="font-medium text-gray-500">Streak Master Badge Unlocked!</div>
                                                    <div class="text-sm text-gray-600">Completed 50 daily streaks</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-4 mt-3 text-sm">
                                            <button
                                                class="flex items-center space-x-1 text-gray-600 hover:text-red-500">
                                                <i class="fas fa-heart"></i>
                                                <span>8</span>
                                            </button>
                                            <button
                                                class="flex items-center space-x-1 text-gray-600 hover:text-blue-500">
                                                <i class="fas fa-comment"></i>
                                                <span>2</span>
                                            </button>
                                            <button class="text-gray-600 hover:text-green-500">
                                                <i class="fas fa-share"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-xl p-6 shadow-sm" style="background: var(--bg-secondary);">
                                <div class="flex items-start space-x-4">
                                    <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center">
                                        <span class="text-white font-bold text-sm">MB</span>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2 mb-2">
                                            <span class="font-semibold">Mike Brown</span>
                                            <span class="text-sm text-gray-600">started a challenge</span>
                                            <span class="text-sm text-gray-400">6h ago</span>
                                        </div>
                                        <div class="bg-gradient-to-r from-blue-50 to-blue-100 p-4 rounded-lg">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <div class="font-medium text-gray-500">30-Day Reading Challenge</div>
                                                    <div class="text-sm text-gray-600">Read for 30 minutes daily</div>
                                                </div>
                                                <button
                                                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 text-sm">
                                                    Join Challenge
                                                </button>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-4 mt-3 text-sm">
                                            <button
                                                class="flex items-center space-x-1 text-gray-600 hover:text-red-500">
                                                <i class="fas fa-heart"></i>
                                                <span>15</span>
                                            </button>
                                            <button
                                                class="flex items-center space-x-1 text-gray-600 hover:text-blue-500">
                                                <i class="fas fa-comment"></i>
                                                <span>7</span>
                                            </button>
                                            <button class="text-gray-600 hover:text-green-500">
                                                <i class="fas fa-share"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Friends & Challenges Sidebar -->
                    <div class="space-y-6">
                        <!-- Friends List -->
                        <div class="bg-white rounded-xl p-6 shadow-sm" style="background: var(--bg-secondary);">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold">Friends</h3>
                                <button class="text-blue-500 hover:text-blue-600">
                                    <i class="fas fa-user-plus"></i>
                                </button>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                            <span class="text-white text-sm font-bold">AS</span>
                                        </div>
                                        <div>
                                            <div class="font-medium text-sm">Alex Smith</div>
                                            <div class="text-xs text-green-500">Online</div>
                                        </div>
                                    </div>
                                    <div class="text-xs text-gray-500">Level 15</div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                            <span class="text-white text-sm font-bold">SJ</span>
                                        </div>
                                        <div>
                                            <div class="font-medium text-sm">Sarah Johnson</div>
                                            <div class="text-xs text-gray-400">2h ago</div>
                                        </div>
                                    </div>
                                    <div class="text-xs text-gray-500">Level 13</div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div
                                            class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center">
                                            <span class="text-white text-sm font-bold">MB</span>
                                        </div>
                                        <div>
                                            <div class="font-medium text-sm">Mike Brown</div>
                                            <div class="text-xs text-gray-400">1d ago</div>
                                        </div>
                                    </div>
                                    <div class="text-xs text-gray-500">Level 10</div>
                                </div>
                            </div>
                        </div>

                        <!-- Active Challenges -->
                        <div class="bg-white rounded-xl p-6 shadow-sm" style="background: var(--bg-secondary);">
                            <h3 class="text-lg font-semibold mb-4">Active Challenges</h3>
                            <div class="space-y-4">
                                <div class="border rounded-lg p-3" style="border-color: var(--border);">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="font-medium text-sm">Morning Workout</div>
                                        <div class="text-xs bg-green-100 text-green-600 px-2 py-1 rounded">3/5 days
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <div class="flex -space-x-2">
                                            <div class="w-6 h-6 bg-blue-500 rounded-full border-2 border-white"></div>
                                            <div class="w-6 h-6 bg-green-500 rounded-full border-2 border-white"></div>
                                            <div class="w-6 h-6 bg-purple-500 rounded-full border-2 border-white"></div>
                                        </div>
                                        <div class="text-xs text-gray-600">+2 others</div>
                                    </div>
                                </div>
                                <div class="border rounded-lg p-3" style="border-color: var(--border);">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="font-medium text-sm">Reading Sprint</div>
                                        <div class="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded">7/10 books
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <div class="flex -space-x-2">
                                            <div class="w-6 h-6 bg-red-500 rounded-full border-2 border-white"></div>
                                            <div class="w-6 h-6 bg-yellow-500 rounded-full border-2 border-white"></div>
                                        </div>
                                        <div class="text-xs text-gray-600">+4 others</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settings View -->
            <div id="settings" class="view hidden">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold mb-2">Settings</h2>
                    <p class="text-gray-600">Customize your Life Quest experience</p>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                    <!-- Settings Sidebar -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-xl p-4 shadow-sm" style="background: var(--bg-secondary);">
                            <nav class="space-y-2">
                                <button
                                    class="settings-tab active w-full text-left px-4 py-3 rounded-lg hover:bg-gray-100"
                                    data-tab="profile">
                                    <i class="fas fa-user w-5 mr-3"></i>Profile
                                </button>
                                <button class="settings-tab w-full text-left px-4 py-3 rounded-lg hover:bg-gray-100"
                                    data-tab="preferences">
                                    <i class="fas fa-cog w-5 mr-3"></i>Preferences
                                </button>
                                <button class="settings-tab w-full text-left px-4 py-3 rounded-lg hover:bg-gray-100"
                                    data-tab="notifications">
                                    <i class="fas fa-bell w-5 mr-3"></i>Notifications
                                </button>
                                <button class="settings-tab w-full text-left px-4 py-3 rounded-lg hover:bg-gray-100"
                                    data-tab="privacy">
                                    <i class="fas fa-shield-alt w-5 mr-3"></i>Privacy
                                </button>
                                <button class="settings-tab w-full text-left px-4 py-3 rounded-lg hover:bg-gray-100"
                                    data-tab="account">
                                    <i class="fas fa-key w-5 mr-3"></i>Account
                                </button>
                                <button class="settings-tab w-full text-left px-4 py-3 rounded-lg hover:bg-gray-100"
                                    data-tab="modals">
                                    <i class="fas fa-window-restore w-5 mr-3"></i>Modals and Toastr
                                </button>
                            </nav>
                        </div>
                    </div>

                    <!-- Settings Content -->
                    <div class="lg:col-span-3">
                        <!-- Profile Settings -->
                        <div id="profile-settings" class="settings-content">
                            <div class="bg-white rounded-xl p-6 shadow-sm" style="background: var(--bg-secondary);">
                                <h3 class="text-xl font-semibold mb-6">Profile Settings</h3>

                                <div class="flex items-center space-x-6 mb-8">
                                    <div class="relative">
                                        <div
                                            class="w-24 h-24 bg-blue-500 rounded-full flex items-center justify-center">
                                            <i class="fas fa-user text-white text-3xl"></i>
                                        </div>
                                        <button
                                            class="absolute bottom-0 right-0 bg-gray-800 text-white rounded-full w-8 h-8 flex items-center justify-center">
                                            <i class="fas fa-camera text-xs"></i>
                                        </button>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-lg">Player Avatar</h4>
                                        <p class="text-gray-600 text-sm">Click to upload a new profile picture</p>
                                    </div>
                                </div>

                                <form class="space-y-6">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-sm font-medium mb-2">Display Name</label>
                                            <input type="text" value="Player Name"
                                                class="w-full px-4 py-2 border rounded-lg">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-2">Username</label>
                                            <input type="text" value="@playername"
                                                class="w-full px-4 py-2 border rounded-lg">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium mb-2">Bio</label>
                                        <textarea rows="3" placeholder="Tell others about yourself..."
                                            class="w-full px-4 py-2 border rounded-lg"></textarea>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-sm font-medium mb-2">Location</label>
                                            <input type="text" placeholder="City, Country"
                                                class="w-full px-4 py-2 border rounded-lg">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-2">Time Zone</label>
                                            <select class="w-full px-4 py-2 border rounded-lg">
                                                <option>UTC-8 (Pacific Time)</option>
                                                <option>UTC-5 (Eastern Time)</option>
                                                <option>UTC+0 (GMT)</option>
                                            </select>
                                        </div>
                                    </div>

                                    <button type="submit"
                                        class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">
                                        Save Changes
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Preferences Settings -->
                        <div id="preferences-settings" class="settings-content hidden">
                            <div class="bg-white rounded-xl p-6 shadow-sm" style="background: var(--bg-secondary);">
                                <h3 class="text-xl font-semibold mb-6">Preferences</h3>

                                <div class="space-y-8">
                                    <div>
                                        <h4 class="font-medium mb-4">Appearance</h4>
                                        <div class="space-y-4">
                                            <div class="flex items-center justify-between">
                                                <label class="flex items-center space-x-3">
                                                    <span>Dark Mode</span>
                                                </label>
                                                <label class="relative inline-flex items-center cursor-pointer">
                                                    <input type="checkbox" class="sr-only peer">
                                                    <div
                                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                                    </div>
                                                </label>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium mb-2">Theme Color</label>
                                                <div class="flex space-x-2">
                                                    <div class="theme-btn bg-blue-500" data-theme="blue"></div>
                                                    <div class="theme-btn bg-green-500" data-theme="green"></div>
                                                    <div class="theme-btn bg-purple-500" data-theme="purple"></div>
                                                    <div class="theme-btn bg-red-500" data-theme="red"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <h4 class="font-medium mb-4">Dashboard</h4>
                                        <div class="space-y-4">
                                            <div class="flex items-center justify-between">
                                                <label>Show daily streak on dashboard</label>
                                                <input type="checkbox" checked class="rounded text-blue-500">
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <label>Display XP animations</label>
                                                <input type="checkbox" checked class="rounded text-blue-500">
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <label>Auto-refresh stats</label>
                                                <input type="checkbox" class="rounded text-blue-500">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notifications Settings -->
                        <div id="notifications-settings" class="settings-content hidden">
                            <div class="bg-white rounded-xl p-6 shadow-sm" style="background: var(--bg-secondary);">
                                <h3 class="text-xl font-semibold mb-6">Notification Settings</h3>

                                <div class="space-y-6">
                                    <div>
                                        <h4 class="font-medium mb-4">Push Notifications</h4>
                                        <div class="space-y-3">
                                            <div class="flex items-center justify-between">
                                                <label>Game achievements</label>
                                                <input type="checkbox" checked class="rounded text-blue-500">
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <label>Daily challenges</label>
                                                <input type="checkbox" checked class="rounded text-blue-500">
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <label>Friend activities</label>
                                                <input type="checkbox" class="rounded text-blue-500">
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <label>System updates</label>
                                                <input type="checkbox" checked class="rounded text-blue-500">
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <h4 class="font-medium mb-4">Email Notifications</h4>
                                        <div class="space-y-3">
                                            <div class="flex items-center justify-between">
                                                <label>Weekly summary</label>
                                                <input type="checkbox" checked class="rounded text-blue-500">
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <label>Security alerts</label>
                                                <input type="checkbox" checked class="rounded text-blue-500">
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <label>Marketing emails</label>
                                                <input type="checkbox" class="rounded text-blue-500">
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium mb-2">Notification Sound</label>
                                        <select class="w-full px-4 py-2 border rounded-lg">
                                            <option>Default</option>
                                            <option>Chime</option>
                                            <option>Bell</option>
                                            <option>None</option>
                                        </select>
                                    </div>

                                    <button class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">
                                        Save Notification Settings
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Privacy Settings -->
                        <div id="privacy-settings" class="settings-content hidden">
                            <div class="bg-white rounded-xl p-6 shadow-sm" style="background: var(--bg-secondary);">
                                <h3 class="text-xl font-semibold mb-6">Privacy Settings</h3>

                                <div class="space-y-6">
                                    <div>
                                        <h4 class="font-medium mb-4">Profile Visibility</h4>
                                        <div class="space-y-3">
                                            <div class="flex items-center justify-between">
                                                <label>Show profile to everyone</label>
                                                <input type="radio" name="profile-visibility" value="public" checked>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <label>Show profile to friends only</label>
                                                <input type="radio" name="profile-visibility" value="friends">
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <label>Hide profile</label>
                                                <input type="radio" name="profile-visibility" value="private">
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <h4 class="font-medium mb-4">Data Sharing</h4>
                                        <div class="space-y-3">
                                            <div class="flex items-center justify-between">
                                                <label>Share game statistics</label>
                                                <input type="checkbox" checked class="rounded text-blue-500">
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <label>Allow friend suggestions</label>
                                                <input type="checkbox" class="rounded text-blue-500">
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <label>Analytics and usage data</label>
                                                <input type="checkbox" checked class="rounded text-blue-500">
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <h4 class="font-medium mb-4">Data Management</h4>
                                        <div class="space-y-3">
                                            <button
                                                class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                                                Download My Data
                                            </button>
                                            <button
                                                class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 ml-3">
                                                Delete My Account
                                            </button>
                                        </div>
                                    </div>

                                    <button class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">
                                        Save Privacy Settings
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Account Settings -->
                        <div id="account-settings" class="settings-content hidden">
                            <div class="bg-white rounded-xl p-6 shadow-sm" style="background: var(--bg-secondary);">
                                <h3 class="text-xl font-semibold mb-6">Account Settings</h3>

                                <div class="space-y-6">
                                    <div>
                                        <h4 class="font-medium mb-4">Login Information</h4>
                                        <div class="space-y-4">
                                            <div>
                                                <label class="block text-sm font-medium mb-2">Email Address</label>
                                                <input type="email" value="player@example.com"
                                                    class="w-full px-4 py-2 border rounded-lg">
                                            </div>
                                            <button
                                                class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                                                Change Email
                                            </button>
                                        </div>
                                    </div>

                                    <div>
                                        <h4 class="font-medium mb-4">Password</h4>
                                        <div class="space-y-4">
                                            <div>
                                                <label class="block text-sm font-medium mb-2">Current Password</label>
                                                <input type="password" class="w-full px-4 py-2 border rounded-lg">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-2">New Password</label>
                                                <input type="password" class="w-full px-4 py-2 border rounded-lg">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-2">Confirm New
                                                    Password</label>
                                                <input type="password" class="w-full px-4 py-2 border rounded-lg">
                                            </div>
                                            <button
                                                class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                                                Change Password
                                            </button>
                                        </div>
                                    </div>

                                    <div>
                                        <h4 class="font-medium mb-4">Two-Factor Authentication</h4>
                                        <div class="flex items-center justify-between mb-4">
                                            <span>Enable 2FA</span>
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" class="sr-only peer">
                                                <div
                                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                                </div>
                                            </label>
                                        </div>
                                    </div>

                                    <div>
                                        <h4 class="font-medium mb-4">Connected Accounts</h4>
                                        <div class="space-y-3">
                                            <div class="flex items-center justify-between p-3 border rounded-lg">
                                                <div class="flex items-center">
                                                    <i class="fab fa-google text-red-500 mr-3"></i>
                                                    <span>Google Account</span>
                                                </div>
                                                <button class="text-blue-500 hover:text-blue-600">Connect</button>
                                            </div>
                                            <div class="flex items-center justify-between p-3 border rounded-lg">
                                                <div class="flex items-center">
                                                    <i class="fab fa-facebook text-blue-500 mr-3"></i>
                                                    <span>Facebook Account</span>
                                                </div>
                                                <button class="text-red-500 hover:text-red-600">Disconnect</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modals and Toastr Settings -->
                        <div id="modals-settings" class="settings-content hidden">
                            <div class="bg-white rounded-xl p-6 shadow-sm" style="background: var(--bg-secondary);">
                                <h3 class="text-xl font-semibold mb-6">Modals and Toast Notifications Demo</h3>

                                <div class="space-y-8">
                                    <!-- Toast Notifications -->
                                    <div>
                                        <h4 class="font-medium mb-4">Toast Notifications</h4>
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
                                            <button onclick="showToast('success')"
                                                class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                                                Success Toast
                                            </button>
                                            <button onclick="showToast('error')"
                                                class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                                                Error Toast
                                            </button>
                                            <button onclick="showToast('warning')"
                                                class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">
                                                Warning Toast
                                            </button>
                                            <button onclick="showToast('info')"
                                                class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                                                Info Toast
                                            </button>
                                        </div>

                                        <div class="mb-4">
                                            <label class="block text-sm font-medium mb-2">Toast Position</label>
                                            <select id="toastPosition" class="w-full px-4 py-2 border rounded-lg">
                                                <option value="top-right">Top Right</option>
                                                <option value="top-left">Top Left</option>
                                                <option value="bottom-right">Bottom Right</option>
                                                <option value="bottom-left">Bottom Left</option>
                                                <option value="top-center">Top Center</option>
                                                <option value="bottom-center">Bottom Center</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Modal Demonstrations -->
                                    <div>
                                        <h4 class="font-medium mb-4">Modal Demonstrations</h4>
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                            <button onclick="showModal('small')"
                                                class="bg-purple-500 text-white px-4 py-2 rounded-lg hover:bg-purple-600">
                                                Small Modal
                                            </button>
                                            <button onclick="showModal('medium')"
                                                class="bg-indigo-500 text-white px-4 py-2 rounded-lg hover:bg-indigo-600">
                                                Medium Modal
                                            </button>
                                            <button onclick="showModal('large')"
                                                class="bg-pink-500 text-white px-4 py-2 rounded-lg hover:bg-pink-600">
                                                Large Modal
                                            </button>
                                            <button onclick="showModal('xlarge')"
                                                class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                                                X-Large Modal
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Custom Alerts -->
                                    <div>
                                        <h4 class="font-medium mb-4">Custom Alerts</h4>
                                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                            <button onclick="showConfirmDialog()"
                                                class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600">
                                                Confirm Dialog
                                            </button>
                                            <button onclick="showFormModal()"
                                                class="bg-teal-500 text-white px-4 py-2 rounded-lg hover:bg-teal-600">
                                                Form Modal
                                            </button>
                                            <button onclick="showImageModal()"
                                                class="bg-cyan-500 text-white px-4 py-2 rounded-lg hover:bg-cyan-600">
                                                Image Modal
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Error Page View -->
            <div id="error-page" class="view hidden">
                <div class="min-h-screen flex items-center justify-center">
                    <div class="text-center">
                        <div class="mb-8">
                            <div class="text-9xl font-bold text-gray-300">404</div>
                            <div class="text-2xl font-semibold text-gray-600 mb-4">Oops! Quest not found</div>
                            <p class="text-gray-500 mb-8">The page you're looking for has vanished into the digital
                                realm.</p>
                        </div>

                        <div class="space-x-4">
                            <button onclick="showView('dashboard')"
                                class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600">
                                <i class="fas fa-home mr-2"></i>Return to Dashboard
                            </button>
                            <button class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300">
                                <i class="fas fa-envelope mr-2"></i>Report Issue
                            </button>
                        </div>
                    </div>
                </div>
            </div>
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
</body>

</html>