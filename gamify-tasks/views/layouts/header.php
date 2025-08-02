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