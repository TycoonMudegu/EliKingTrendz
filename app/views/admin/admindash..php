<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Dark Theme News Blog Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary-green': '#52ff3f',
                        'primary-dark-green': '#006400',
                        'primary-blue': '#0033cc',
                        'primary-dark-blue': '#001a66',
                        'primary-blue2': '#bddbe8',
                        'primary-dark-blue2': '#5a7c85',
                        'primary-green2': '#99cc66',
                        'primary-dark-green2': '#4d6633',
                        'primary-white': '#FFFFFF',
                        'primary-dark-white': '#bfbfbf',
                        'primary-gray': '#E6F0DC',
                        'primary-dark-gray': '#99a386',
                        primary: '#3B82F6',
                        secondary: '#10B981',
                        accent: '#8B5CF6',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-primary-dark-blue text-primary-white">
    <div class="flex h-screen">
        <!-- Sticky Sidebar -->
        <aside class="w-64 bg-primary-dark-blue2 text-primary-white overflow-y-auto sticky top-0 h-screen">
            <div class="p-4">
                <h2 class="text-2xl font-bold mb-6">News Blog Admin</h2>
                <nav>
                    <ul class="space-y-2">
                        <li><a href="#" class="block py-2 px-4 rounded hover:bg-primary-blue2 hover:text-primary-dark-blue transition duration-200">Dashboard</a></li>
                        <li><a href="#" class="block py-2 px-4 rounded hover:bg-primary-blue2 hover:text-primary-dark-blue transition duration-200">Authors</a></li>
                        <li><a href="#" class="block py-2 px-4 rounded hover:bg-primary-blue2 hover:text-primary-dark-blue transition duration-200">News</a></li>
                        <li><a href="#" class="block py-2 px-4 rounded hover:bg-primary-blue2 hover:text-primary-dark-blue transition duration-200">Users</a></li>
                        <li><a href="#" class="block py-2 px-4 rounded hover:bg-primary-blue2 hover:text-primary-dark-blue transition duration-200">Settings</a></li>
                    </ul>
                </nav>
            </div>
            <div class="absolute bottom-0 w-full p-4">
                <div class="flex items-center mb-4">
                    <img src="/api/placeholder/32/32" alt="Admin Avatar" class="w-8 h-8 rounded-full mr-2">
                    <span>Signed in as Admin</span>
                </div>
                <button class="w-full bg-primary-dark-blue text-primary-white py-2 px-4 rounded hover:bg-primary-blue hover:text-primary-white transition duration-200">Log out</button>
            </div>
        </aside>

        <!-- Main content -->
        <div class="flex-1 overflow-auto">
            <header class="bg-primary-dark-blue2 shadow-sm p-4 sticky top-0 z-10">
                <h1 class="text-2xl font-bold text-primary-white">Dashboard</h1>
            </header>

            <main class="p-6">
                <!-- Metrics Overview -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-primary-dark-blue2 rounded-xl shadow-sm p-6 border-l-4 border-primary-green hover:shadow-lg transition duration-200 cursor-pointer">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 mr-4">
                                <i class="fas fa-chart-line text-3xl text-primary-green"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-primary-dark-white">Trending News</p>
                                <p class="text-2xl font-semibold text-primary-white">12</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-primary-dark-blue2 rounded-xl shadow-sm p-6 border-l-4 border-primary-green2 hover:shadow-lg transition duration-200 cursor-pointer">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 mr-4">
                                <i class="fas fa-users text-3xl text-primary-green2"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-primary-dark-white">Total Authors</p>
                                <p class="text-2xl font-semibold text-primary-white">87</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-primary-dark-blue2 rounded-xl shadow-sm p-6 border-l-4 border-primary-blue hover:shadow-lg transition duration-200 cursor-pointer">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 mr-4">
                                <i class="fas fa-user-friends text-3xl text-primary-blue"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-primary-dark-white">Total Users</p>
                                <p class="text-2xl font-semibold text-primary-white">2,453</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-primary-dark-blue2 rounded-xl shadow-sm p-6 border-l-4 border-primary-green hover:shadow-lg transition duration-200 cursor-pointer">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 mr-4">
                                <i class="fas fa-bolt text-3xl text-primary-green"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-primary-dark-white">Breaking News</p>
                                <p class="text-2xl font-semibold text-primary-white">3</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts and Tables -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                    <!-- Top Countries by Users -->
                    <div class="bg-primary-dark-blue2 rounded-xl shadow-sm p-6 hover:shadow-lg transition duration-200">
                        <h2 class="text-xl font-semibold mb-4 text-primary-white">Top Countries by Users</h2>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <span class="w-20 text-sm text-primary-dark-white">USA</span>
                                <div class="flex-1 bg-primary-dark-blue rounded-full h-3">
                                    <div class="bg-primary-green rounded-full h-3" style="width: 75%;"></div>
                                </div>
                                <span class="ml-4 text-sm font-medium text-primary-white">75%</span>
                            </div>
                            <div class="flex items-center">
                                <span class="w-20 text-sm text-primary-dark-white">UK</span>
                                <div class="flex-1 bg-primary-dark-blue rounded-full h-3">
                                    <div class="bg-primary-green2 rounded-full h-3" style="width: 60%;"></div>
                                </div>
                                <span class="ml-4 text-sm font-medium text-primary-white">60%</span>
                            </div>
                            <div class="flex items-center">
                                <span class="w-20 text-sm text-primary-dark-white">Canada</span>
                                <div class="flex-1 bg-primary-dark-blue rounded-full h-3">
                                    <div class="bg-primary-blue rounded-full h-3" style="width: 45%;"></div>
                                </div>
                                <span class="ml-4 text-sm font-medium text-primary-white">45%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Top Authors -->
                    <div class="bg-primary-dark-blue2 rounded-xl shadow-sm p-6 hover:shadow-lg transition duration-200">
                        <h2 class="text-xl font-semibold mb-4 text-primary-white">Top Authors</h2>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="text-left text-xs font-semibold text-primary-dark-white uppercase">
                                        <th class="pb-3 pr-2">Author</th>
                                        <th class="pb-3 pr-2">Posts</th>
                                        <th class="pb-3">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm">
                                    <tr class="border-b border-primary-dark-blue">
                                        <td class="py-3 pr-2">John Doe</td>
                                        <td class="py-3 pr-2">42</td>
                                        <td class="py-3"><span class="bg-primary-green text-primary-dark-blue py-1 px-2 rounded-full text-xs">Approved</span></td>
                                    </tr>
                                    <tr class="border-b border-primary-dark-blue">
                                        <td class="py-3 pr-2">Jane Smith</td>
                                        <td class="py-3 pr-2">38</td>
                                        <td class="py-3"><span class="bg-primary-green text-primary-dark-blue py-1 px-2 rounded-full text-xs">Approved</span></td>
                                    </tr>
                                    <tr>
                                        <td class="py-3 pr-2">Bob Johnson</td>
                                        <td class="py-3 pr-2">27</td>
                                        <td class="py-3"><span class="bg-primary-green2 text-primary-dark-blue py-1 px-2 rounded-full text-xs">Pending</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity and Messages -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Recent Activity -->
                    <div class="bg-primary-dark-blue2 rounded-xl shadow-sm p-6 hover:shadow-lg transition duration-200">
                        <h2 class="text-xl font-semibold mb-4 text-primary-white">Recent Activity</h2>
                        <ul class="space-y-4">
                            <li class="flex items-center bg-primary-dark-blue p-3 rounded-lg hover:bg-primary-blue2 hover:text-primary-dark-blue transition duration-200">
                                <div class="bg-primary-blue p-2 rounded-full mr-3">
                                    <i class="fas fa-user-plus text-primary-white"></i>
                                </div>
                                <span class="text-sm">New author registered: Alice Brown</span>
                            </li>
                            <li class="flex items-center bg-primary-dark-blue p-3 rounded-lg hover:bg-primary-blue2 hover:text-primary-dark-blue transition duration-200">
                                <div class="bg-primary-green2 p-2 rounded-full mr-3">
                                    <i class="fas fa-newspaper text-primary-white"></i>
                                </div>
                                <span class="text-sm">New article published: "The Future of AI"</span>
                            </li>
                            <li class="flex items-center bg-primary-dark-blue p-3 rounded-lg hover:bg-primary-blue2 hover:text-primary-dark-blue transition duration-200">
                                <div class="bg-primary-green p-2 rounded-full mr-3">
                                    <i class="fas fa-exclamation-triangle text-primary-white"></i>
                                </div>
                                <span class="text-sm">Breaking news: "Major Economic Shift"</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Messages -->
                    <div class="bg-primary-dark-blue2 rounded-xl shadow-sm p-6 hover:shadow-lg transition duration-200">
                        <h2 class="text-xl font-semibold mb-4 text-primary-white">Messages</h2>
                        <ul class="space-y-4">
                            <li class="flex items-start bg-primary-dark-blue p-3 rounded-lg hover:bg-primary-blue2 hover:text-primary-dark-blue transition duration-200">
                                <img src="/api/placeholder/40/40" alt="User Avatar" class="w-10 h-10 rounded-full mr-3">
                                <div>
                                    <p class="font-semibold">Support Team</p>
                                    <p class="text-sm text-primary-dark-white">New feature request: dark mode for the dashboard</p>
                                </div>
                            </li>
                            <li class="flex items-start bg-primary-dark-blue p-3 rounded-lg hover:bg-primary-blue2 hover:text-primary-dark-blue transition duration-200">
                                <img src="/api/placeholder/40/40" alt="User Avatar" class="w-10 h-10 rounded-full mr-3">
                                <div>
                                    <p class="font-semibold">John Doe</p>
                                    <p class="text-sm text-primary-dark-white">Question about article submission process</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>