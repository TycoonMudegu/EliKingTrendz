
<body class="bg-gray-100 font-sans">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <?php include 'app/views/partials/adminnav.php' ?>

        <!-- Main content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto">
            <!-- Top bar -->
            <?php include 'app/views/partials/adminheadder.php' ?>

            <!-- Analytics content -->
            <div class="p-6">
                <h2 class="text-2xl font-semibold mb-6">Analytics</h2>

                <!-- Date range selector -->
                <div class="bg-white rounded-lg shadow p-4 mb-6">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700">Select Date Range:</span>
                        <div class="flex space-x-4">
                            <input type="date" class="border rounded px-3 py-2">
                            <input type="date" class="border rounded px-3 py-2">
                            <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Apply</button>
                        </div>
                    </div>
                </div>

                <!-- Quick stats -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-full p-3">
                                <i class="fas fa-eye text-white"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-600">Total Views</p>
                                <p class="text-lg font-semibold">1,234,567</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-full p-3">
                                <i class="fas fa-user-plus text-white"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-600">New Subscribers</p>
                                <p class="text-lg font-semibold">5,678</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-full p-3">
                                <i class="fas fa-clock text-white"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-600">Avg. Time on Site</p>
                                <p class="text-lg font-semibold">3m 45s</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-red-500 rounded-full p-3">
                                <i class="fas fa-share-alt text-white"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-600">Social Shares</p>
                                <p class="text-lg font-semibold">12,345</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-white rounded-lg shadow p-4">
                        <h3 class="text-lg font-semibold mb-4">Daily Views</h3>
                        <canvas id="dailyViewsChart"></canvas>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <h3 class="text-lg font-semibold mb-4">Top Categories</h3>
                        <canvas id="topCategoriesChart"></canvas>
                    </div>
                </div>

                <!-- Top Articles Table -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b">
                        <h3 class="text-lg font-semibold">Top Performing Articles</h3>
                    </div>
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Views</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Shares</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Avg. Time</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <!-- Add table rows here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Sample chart