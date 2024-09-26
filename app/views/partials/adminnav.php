<?php require_once 'app/views/head.php'?>

<aside class="w-64 bg-white shadow-md">
            <div class="p-4 border-b">
                <h1 class="text-xl font-bold text-blue-600"># NEWSMIN</h1>
            </div>
            <div class="p-4">
                <div class="flex items-center mb-4">
                    <img src="/api/placeholder/40/40" alt="Admin" class="rounded-full mr-2">
                    <div>
                        <p class="font-semibold">John Doe</p>
                        <p class="text-sm text-gray-600">Admin</p>
                    </div>
                </div>
                <nav>
                    <a href="AdminDash" class="block py-2 px-4 text-blue-600"><i class="fas fa-tachometer-alt mr-2"></i> Dashboard</a>
                    <a href="Articles" class="block py-2 px-4 text-gray-600 hover:bg-gray-100"><i class="fas fa-newspaper mr-2"></i> Articles</a>
                    <a href="Analitics" class="block py-2 px-4 text-gray-600 hover:bg-gray-100"><i class="fas fa-chart-bar mr-2"></i> Analytics</a>
                    <a href="Authors" class="block py-2 px-4 text-gray-600 hover:bg-gray-100"><i class="fas fa-users mr-2"></i> Authors</a>
                    <a href="Categories" class="block py-2 px-4 text-gray-600 hover:bg-gray-100"><i class="fas fa-table mr-2"></i> Categories</a>
                </nav>
            </div>
        </aside>