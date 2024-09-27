
<body class="bg-gray-100 font-sans">
    <div class="flex h-screen">

        <!-- Sidebar -->
        <?php include 'app/views/partials/adminnav.php' ?>

        <!-- Main content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto">
            <!-- Top bar -->
            <?php include 'app/views/partials/adminheadder.php' ?>

            <!-- Articles content -->
            <div class="p-6">
                <!-- Article filters -->
                <div class="bg-white rounded-lg shadow p-4 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <input type="text" placeholder="Search articles..." class="border rounded px-3 py-2" id="search-articles">
                        <select class="border rounded px-3 py-2" id="category-filter">
                            <option>All Categories</option>
                            <!-- Categories will be populated here -->
                        </select>
                        <select class="border rounded px-3 py-2" id="author-filter">
                            <option>All Authors</option>
                            <!-- Authors will be populated here -->
                        </select>
                        <select class="border rounded px-3 py-2" id="status-filter">
                            <option>All Statuses</option>
                            <!-- Statuses will be populated here -->
                        </select>
                        <button class="bg-blue-500 text-white rounded px-4 py-2" id="filter-button">Filter</button>
                    </div>
                </div>

                <!-- Articles Table -->
                <div class="bg-white rounded-lg shadow overflow-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="articles-table-body">
                            <!-- Article rows will be populated here -->
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6 mt-4" id="pagination">
                    <!-- Pagination controls will be populated here -->
                </div>
            </div>
        </main>
    </div>
    <!-- Modal Structure -->
    <div id="article-modal" class="fixed inset-0 bg-gray-800 bg-opacity-75 hidden flex justify-center items-center z-50 overflow-auto p-4">
    <div class="bg-white rounded-lg shadow-xl w-3/4 max-w-4xl transform transition-all">
        <div class="p-6 max-h-[90vh] overflow-y-auto">
            <h2 id="modal-title" class="text-2xl font-bold mb-4 text-gray-800"></h2>
            <p id="modal-content" class="text-gray-700 mb-6 leading-relaxed"></p>
            <div class="space-y-2 mb-6">
                <p id="modal-author" class="text-sm text-gray-600 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <span></span>
                </p>
                <p id="modal-date" class="text-sm text-gray-600 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span></span>
                </p>
                <p id="modal-status" class="text-sm text-gray-600 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span></span>
                </p>
                <p id="modal-views" class="text-sm text-gray-600 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    <span></span>
                </p>
            </div>
            <div class="flex justify-end space-x-3">
                <button id="close-modal" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-4 py-2 rounded transition duration-300 ease-in-out">
                    Close
                </button>
                <button id="unpublish-article" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded transition duration-300 ease-in-out">
                    Unpublish
                </button>
            </div>
        </div>
    </div>
</div>

</body>

<script>
    const loadArticles = (page = 1) => {
        const search = document.getElementById('search-articles').value;
        const category = document.getElementById('category-filter').value;
        const author = document.getElementById('author-filter').value;
        const status = document.getElementById('status-filter').value;

        const formData = new FormData();
        formData.append('action', 'load_table_data_articles');
        formData.append('search', search);
        formData.append('category', category);
        formData.append('author', author);
        formData.append('status', status);
        formData.append('page', page);

        fetch('AdminProcess', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            const articlesTableBody = document.getElementById('articles-table-body');
            articlesTableBody.innerHTML = ''; // Clear previous rows

            // Populate articles table
            data.data.forEach((article, index) => {
                const date = new Date(article.created_at);
                const formattedDate = new Intl.DateTimeFormat('en-GB', {
                    weekday: 'long', 
                    day: 'numeric', 
                    month: 'long', 
                    year: 'numeric'
                }).format(date);

                const row = `
                    <tr onclick="openArticleModal(${JSON.stringify(article).replace(/"/g, '&quot;')})">
                        <td class="px-6 py-4 whitespace-nowrap">${(page - 1) * 10 + index + 1}</td>
                        <td class="px-6 py-4 whitespace-nowrap cursor-pointer hover:undeline">${article.title}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${article.author_name}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${article.category_name}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${formattedDate}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">${article.status}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="#" class="text-red-600 hover:text-red-900">Unpublish</a>
                        </td>
                    </tr>
                `;
                articlesTableBody.innerHTML += row;
            });

            // Populate category dropdown
            const categoryFilter = document.getElementById('category-filter');
            categoryFilter.innerHTML = ''; // Clear previous options
            data.filters.categories.forEach(category => {
                const option = document.createElement('option');
                option.value = category;
                option.text = category;
                categoryFilter.appendChild(option);
            });

            // Populate status dropdown
            const statusFilter = document.getElementById('status-filter');
            statusFilter.innerHTML = ''; // Clear previous options
            data.filters.statuses.forEach(status => {
                const option = document.createElement('option');
                option.value = status;
                option.text = status;
                statusFilter.appendChild(option);
            });

            // Populate author dropdown
            const authorFilter = document.getElementById('author-filter');
            authorFilter.innerHTML = ''; // Clear previous options
            data.filters.authors.forEach(author => {
                const option = document.createElement('option');
                option.value = author;
                option.text = author;
                authorFilter.appendChild(option);
            });

            // Update pagination
            const pagination = document.getElementById('pagination');
            pagination.innerHTML = `
                <div>
                    <p class="text-sm text-gray-700">
                        Showing <span class="font-medium">${(page - 1) * 10 + 1}</span> to <span class="font-medium">${Math.min(page * 10, data.pagination.total)}</span> of <span class="font-medium">${data.pagination.total}</span> results
                    </p>
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        ${page > 1 ? `<a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50" onclick="loadArticles(${page - 1})">Previous</a>` : ''}
                        ${Array.from({length: data.pagination.last_page}, (_, i) => {
                            return `<a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 ${i + 1 === page ? 'bg-indigo-500 text-white' : 'bg-white text-gray-500 hover:bg-gray-50'}" onclick="loadArticles(${i + 1})">${i + 1}</a>`;
                        }).join('')}
                        ${page < data.pagination.last_page ? `<a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50" onclick="loadArticles(${page + 1})">Next</a>` : ''}
                    </nav>
                </div>
            `;
        });
    };

    function openArticleModal(article) {
    document.getElementById('modal-title').textContent = article.title;
    document.getElementById('modal-content').innerHTML = article.content; // Use innerHTML to preserve HTML tags
    document.getElementById('modal-author').textContent = `Author: ${article.author_name}`;
    document.getElementById('modal-date').textContent = `Created At: ${new Intl.DateTimeFormat('en-GB', {
        weekday: 'long',
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    }).format(new Date(article.created_at))}`;
    document.getElementById('modal-status').textContent = `Status: ${article.status}`;
    document.getElementById('modal-views').textContent = `Views: ${article.views_count}`;

    const modal = document.getElementById('article-modal');
    modal.classList.remove('hidden');
}


    document.getElementById('close-modal').addEventListener('click', () => {
        const modal = document.getElementById('article-modal');
        modal.classList.add('hidden');
    });

    document.getElementById('unpublish-article').addEventListener('click', () => {
        // Implement unpublish functionality here
        alert('Article Unpublished');
        const modal = document.getElementById('article-modal');
        modal.classList.add('hidden');
    });

    document.getElementById('filter-button').addEventListener('click', () => {
        loadArticles();
    });

    // Load articles initially on page load
    window.onload = function() {
        loadArticles();
    }
    </script>

</html>