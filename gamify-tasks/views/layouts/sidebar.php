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
        <button id="sidebarCollapseBtn" class="hidden lg:block p-1 rounded-lg hover:bg-gray-200 transition-colors">
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