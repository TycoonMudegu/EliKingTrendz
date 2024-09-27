<?php
include_once 'app/config/dbconfig.php';
include_once 'app/Controllers/AdminController.php';

// Determine the current page (defaults to 1)
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$adminController = new AdminController($pdo);
$metrics = $adminController->getDashboardMetrics();
// Fetch the posts and pagination data
$data = $adminController->getRecentArticlesWithPagination($currentPage);
$posts = $data['posts'];
$totalPages = $data['total_pages'];
$currentPage = $data['current_page'];
?>
<body class="bg-gray-100 font-sans">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <?php include 'app/views/partials/adminnav.php' ?>

        <!-- Main content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto">
            <!-- Top bar -->
            <?php include 'app/views/partials/adminheadder.php' ?>

            <!-- Dashboard content -->
            <div class="p-6">
                <!-- Quick stats -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-full p-3">
                                <i class="fas fa-newspaper text-white"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-600">Today's Posts</p>
                                <p class="text-lg font-semibold"><?php echo $metrics['total_posts']; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-full p-3">
                                <i class="fas fa-eye text-white"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-600">Total Views</p>
                                <p class="text-lg font-semibold"><?php echo $metrics['total_views']; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-full p-3">
                                <i class="fas fa-users text-white"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-600">New Subscribers</p>
                                <p class="text-lg font-semibold"><?php echo $metrics['new_subscribers']; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-red-500 rounded-full p-3">
                                <i class="fas fa-comment-alt text-white"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-600">New Comments</p>
                                <p class="text-lg font-semibold"><?php echo $metrics['new_comments']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-white rounded-lg shadow p-4">
                        <h3 class="text-lg font-semibold mb-4">Readership by Category</h3>
                        <div class="h-64">
                            <canvas id="categoryChart"></canvas>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <h3 class="text-lg font-semibold mb-4">Views Over Time</h3>
                        <div class="h-64">
                            <canvas id="viewsChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Recent Articles Table -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="flex items-center justify-between px-6 py-4 border-b">
                        <h3 class="text-lg font-semibold">Recent Articles</h3>
                        <a href="#" class="text-blue-600 hover:underline">Show All</a>
                    </div>
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Views</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody id="table-body" class="bg-white divide-y divide-gray-200">
                            <!-- AJAX will load content here -->
                        </tbody>
                    </table>

                    <!-- Pagination controls -->
                    <div class="px-6 py-4">
                        <nav class="flex justify-end">
                            <ul id="pagination-controls" class="inline-flex items-center -space-x-px">
                                <!-- AJAX will load pagination controls here -->
                            </ul>
                        </nav>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function loadTable(page = 1) {
        $.ajax({
            url: 'AdminProcess',  // The intermediary page handling the request
            type: 'POST',                  // Use POST instead of GET
            data: {
                action: 'load_table',
                page: page
            },
            dataType: 'json',
            success: function(response) {
                // Update the table body with the new data
                let tableBody = '';
                response.data.forEach(function(post) {
                    tableBody += `<tr>
                                    <td class="px-6 py-4 whitespace-nowrap">${post.title}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">${post.author}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">${post.category}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">${post.views_count}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        ${post.status === 'published' ? 
                                            '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Published</span>' : 
                                            '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Draft</span>'
                                        }
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    </td>
                                </tr>`;
                });
                $('#table-body').html(tableBody);

                // Update pagination controls
                let pagination = '';
                if (response.currentPage > 1) {
                    pagination += `<li>
                                    <a href="#" onclick="loadTable(${response.currentPage - 1})" class="px-3 py-2 border border-gray-300 text-gray-500 hover:bg-gray-100">Previous</a>
                                   </li>`;
                }
                for (let page = 1; page <= response.totalPages; page++) {
                    pagination += `<li>
                                    <a href="#" onclick="loadTable(${page})" class="px-3 py-2 border ${page === response.currentPage ? 'bg-blue-600 text-white' : 'border-gray-300 text-gray-500 hover:bg-gray-100'}">${page}</a>
                                   </li>`;
                }
                if (response.currentPage < response.totalPages) {
                    pagination += `<li>
                                    <a href="#" onclick="loadTable(${response.currentPage + 1})" class="px-3 py-2 border border-gray-300 text-gray-500 hover:bg-gray-100">Next</a>
                                   </li>`;
                }
                $('#pagination-controls').html(pagination);
            }
        });
    }

    // Load the first page on document ready
    $(document).ready(function() {
        loadTable();
    });

    $(document).ready(function() {
        // Fetch the chart data from the server
        $.ajax({
            url: 'AdminProcess',  // The PHP endpoint we just created
            method: 'POST',
            data: { action: 'load_chart_data' },
            dataType: 'json',
            success: function(response) {
                // Prepare data for readership by category chart
                let categories = [];
                let readershipCounts = [];
                response.readershipByCategory.forEach(function(categoryData) {
                    categories.push(categoryData.category_name); // Adjusted to use category_name
                    readershipCounts.push(categoryData.readership_count);
                });

                // Create the readership by category chart
                var categoryChartCtx = document.getElementById('categoryChart').getContext('2d');
                new Chart(categoryChartCtx, {
                    type: 'pie',  // Pie chart for categories
                    data: {
                        labels: categories,
                        datasets: [{
                            data: readershipCounts,
                            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'],
                            hoverBackgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40']
                        }]
                    },
                    options: {
                        responsive: true,
                        title: {
                            display: true,
                            text: 'Readership by Category'
                        }
                    }
                });

                // Prepare data for views over time chart
                let dates = [];
                let views = [];
                response.viewsOverTime.forEach(function(viewData) {
                    dates.push(viewData.date);
                    views.push(viewData.total_views);
                });

                // Create the views over time chart
                var viewsChartCtx = document.getElementById('viewsChart').getContext('2d');
                new Chart(viewsChartCtx, {
                    type: 'line',  // Line chart for views over time
                    data: {
                        labels: dates,
                        datasets: [{
                            label: 'Views',
                            data: views,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 2,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        title: {
                            display: true,
                            text: 'Views Over Time'
                        },
                        scales: {
                            x: {
                                type: 'time',
                                time: {
                                    unit: 'day'
                                }
                            }
                        }
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error('Failed to fetch data:', error);
            }
        });
    });
    </script>
</body>
</html>
