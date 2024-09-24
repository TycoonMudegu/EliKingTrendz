<?php require_once 'app/views/partials/navbar.php'; ?>
<?php
// Assuming you have a way to initialize the database connection
require_once 'app/controllers/PostsController.php';

// Initialize the PostController
$postController = new PostController($pdo);

// Fetch drafts and published posts for the logged-in user
$draftPosts = $postController->listPosts('draft');
$publishedPosts = $postController->listPosts('published');
?>

<style>
    #modalContent {
        max-height: 60vh;
        overflow-y: auto;
        font-size: 1.1rem;
        line-height: 1.8;
        color: #333;
    }
    #modalContent p {
        margin-bottom: 1rem;
    }
</style>

<body class="bg-gray-100 font-PTserif" x-data="{ activeTab: 'about', editing: false, bio: '', storiesTab: 'drafts', writing: false, storyTitle: '', storyBody: '' }">


<div class="max-w-4xl mx-auto py-10" x-data="{ writing: false, storiesTab: 'drafts', storyTitle: '', storyBody: '', activeTab: 'home' }">
    <!-- Profile Header -->
    <div class="flex justify-between items-center border-b pb-4">
        <h1 class="text-4xl font-bold"><?php echo htmlspecialchars($_SESSION['full_name'] ?? ''); ?></h1>
        <div class="flex items-center">
            <img src="<?php echo htmlspecialchars($_SESSION['user_picture'] ?? ''); ?>" alt="Profile Picture" class="w-16 h-16 rounded-full mr-4">
            <div>
                <p class="font-semibold"><?php echo htmlspecialchars($_SESSION['full_name'] ?? ''); ?></p>
                <p class="text-gray-500">1 Follower</p>
                <a href="#" class="text-green-600 hover:underline">Edit profile</a>
            </div>
        </div>
    </div>

    <!-- Your Stories Section -->
    <div class="flex justify-between items-center py-4 border-b">
        <h2 class="text-2xl font-bold">Your Stories</h2>
        <!-- Updated: Change button to a link -->
        <a href="Write" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Write a Story
        </a>
    </div>


    <!-- Stories Tabs -->
    <div class="flex space-x-6 py-4 border-t">
        <button @click="storiesTab = 'drafts'" :class="{ 'text-black font-medium underline': storiesTab === 'drafts', 'text-gray-500': storiesTab !== 'drafts' }" class="hover:text-green-600">Drafts</button>
        <button @click="storiesTab = 'published'" :class="{ 'text-black font-medium underline': storiesTab === 'published', 'text-gray-500': storiesTab !== 'published' }" class="hover:text-green-600">Published</button>
    </div>

    <!-- Content Section -->
    <div class="mt-8">


        <!-- Write a Story Section -->
        <div x-show="writing" class="bg-white p-6 rounded shadow mb-6">
            <h3 class="text-xl font-semibold mb-4">Write a New Story</h3>
            <form @submit.prevent="submitStory()">
                <div class="mb-4">
                    <input type="text" x-model="storyTitle" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300" placeholder="Story Title" required>
                </div>
                <div class="mb-4">
                    <textarea x-model="storyBody" class="w-full p-3 border rounded-lg resize-none focus:outline-none focus:ring-2 focus:ring-blue-300" placeholder="Write your story here..." rows="10" required></textarea>
                </div>
                <div class="flex space-x-2">
                    <button type="button" @click="writing = false" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">Cancel</button>
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Save Story</button>
                </div>
            </form>
        </div>

        <!-- Drafts Section -->
        <div x-data="draftStories()" 
         x-show="storiesTab === 'drafts'" 
         class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-2xl font-bold mb-6 text-gray-800">Draft Stories</h3>

    
    <?php if (is_array($draftPosts) && count($draftPosts) > 0): ?>
        <div class="space-y-6">
            <?php foreach ($draftPosts as $post): ?>
                <div class="bg-gray-50 p-4 rounded-md transition duration-300 hover:shadow-lg">
                    <h4 class="text-xl font-semibold mb-2 text-gray-700"><?php echo htmlspecialchars($post['title']); ?></h4>
                    <p class="text-gray-600 mb-4"><?php echo htmlspecialchars(substr($post['content'], 0, 100)); ?>...</p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Last edited: <?php echo date('M d, Y h:i A', strtotime($post['updated_at'])); ?></span>
                        <div class="space-x-2">
                            <button @click="showModal = true; currentPost = <?php echo htmlspecialchars(json_encode([
                                'posts_id' => $post['posts_id'],
                                'title' => htmlspecialchars($post['title']),
                                'content' => htmlspecialchars_decode($post['content'])
                            ]), ENT_QUOTES); ?>" 
                                    class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                View Story
                            </button>
                            
                            <a href="Write?id=<?php echo urlencode(base64_encode($post['posts_id'])); ?>">
                                <button 
                                class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none  transition duration-150 ease-in-out"
                                aria-label="Edit Post">
                                    Edit
                                </button>
                            </a>

                            <button 
                                @click="showPublishModal = true; postToPublish = <?php echo htmlspecialchars(json_encode([
                                    'posts_id' => $post['posts_id'],
                                    'title' => htmlspecialchars($post['title'])
                                ]), ENT_QUOTES); ?>"
                                    class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-stone-600 hover:bg-stone-700 transition duration-150 ease-in-out"
                                    aria-label="Publish Post"
                            >
                                Publish
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-gray-700 italic">No drafts available.</p>
    <?php endif; ?>

            <!-- Modal -->
            <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                    <h3 class="text-3xl leading-tight font-bold text-gray-900 mb-6" id="modal-title" x-text="currentPost?.title"></h3>
                                    <div class="mt-2">
                                        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed" x-html="currentPost?.content"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <a :href="'Write?id=' + btoa(currentPost?.posts_id)" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm transition duration-150 ease-in-out">
                                Edit Story
                            </a>
                            <button type="button" @click="showModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition duration-150 ease-in-out">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>

                <!-- Modern Publish Modal -->

                    <div x-show="showPublishModal" 
                            class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" 
                            x-transition:enter="transition ease-out duration-300" 
                            x-transition:enter-start="opacity-0" 
                            x-transition:enter-end="opacity-100" 
                            x-transition:leave="transition ease-in duration-200" 
                            x-transition:leave-start="opacity-100" 
                            x-transition:leave-end="opacity-0">
                            <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white">
                                <div class="mt-3">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900 text-center" x-text="'Publish: ' + postToPublish?.title"></h3>
                                    <div class="mt-2 px-7 py-3">
                                        <div
                                            @dragover.prevent="dragOver = true"
                                            @dragleave.prevent="dragOver = false"
                                            @drop.prevent="handleFileDrop($event)"
                                            :class="{'border-dashed border-2 border-blue-500': dragOver}"
                                            class="mt-1 flex flex-col items-center justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md transition duration-300 ease-in-out"
                                        >
                                            <div class="space-y-1 text-center">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                                <div class="flex text-sm text-gray-600">
                                                    <p class="pl-1">Drag and drop your image here, or</p>
                                                </div>
                                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                            </div>
                                            <label for="file-upload" class="mt-4 cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                <span class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition duration-300">Select Image</span>
                                                <input id="file-upload" name="file-upload" type="file" class="sr-only" accept="image/*" @change="handleFileSelect($event.target.files[0])">
                                            </label>
                                        </div>
                                        <div x-show="previewImage" class="mt-3">
                                            <img :src="previewImage" alt="Preview" class="max-w-full h-auto rounded-lg shadow-md">
                                        </div>
                                    </div>
                                    <div class="items-center px-4 py-3">
                                        <button id="publishButton" 
                                                @click="publishPost()"
                                                :disabled="isPublishing"
                                                class="w-full px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 transition duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                                            <span x-show="!isPublishing">Publish</span>
                                            <span x-show="isPublishing" class="flex items-center justify-center">
                                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                                Publishing...
                                            </span>
                                        </button>
                                    </div>
                                    <div class="items-center px-4 py-3">
                                        <button @click="showPublishModal = false; resetPublishState();" 
                                                :disabled="isPublishing"
                                                class="w-full px-4 py-2 bg-gray-300 text-gray-700 text-base font-medium rounded-md shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300 transition duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                
        </div>



        <!-- Published Section -->
        <div x-data="{ showModal: false, currentPost: null }" x-show="storiesTab === 'published'" class="bg-white p-8 rounded-lg shadow-md">
            <h3 class="text-2xl font-bold mb-6 text-gray-800">Published Stories</h3>
            <?php if (is_array($publishedPosts) && count($publishedPosts) > 0): ?>
                <div class="space-y-6">
                    <?php foreach ($publishedPosts as $post): ?>
                        <div class="bg-gray-50 p-6 rounded-lg shadow-sm transition duration-300 ease-in-out hover:shadow-md">
                            <h4 class="font-semibold text-xl text-gray-800 mb-2"><?php echo htmlspecialchars($post['title']); ?></h4>
                            <div class="text-gray-600 mb-4">
                                <?php 
                                $stripped_content = strip_tags($post['content']);
                                echo htmlspecialchars(substr($stripped_content, 0, 100)) . (strlen($stripped_content) > 100 ? '...' : '');
                                ?>
                            </div>
                            <div class="flex flex-wrap justify-between gap-3">
                                <span class="text-sm text-gray-500">Published: <?php echo date('M d, Y h:i A', strtotime($post['published_at'])); ?></span>

                                <div class="flex flex-wrap gap-3">
                                    <button @click="showModal = true; currentPost = <?php echo htmlspecialchars(json_encode([
                                        'posts_id' => $post['posts_id'],
                                        'title' => $post['title'],
                                        'content' => htmlspecialchars_decode($post['content'])
                                    ]), ENT_QUOTES); ?>"
                                            class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                        View Story
                                    </button>
                                    <a href="Write?id=<?php echo urlencode(base64_encode($post['posts_id'])); ?>"
                                    class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-400 transition duration-150 ease-in-out">
                                        Edit Story
                                    </a>
                                    <button
                                        type="button"
                                        onclick="unpublishPost(<?php echo $post['posts_id']; ?>)"
                                        class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out">
                                        Unpublish Story
                                    </button>

                                </div>
                            </div>

                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-gray-700 text-center py-8">No published stories yet.</p>
            <?php endif; ?>

            <!-- Modal -->
            <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                    <h3 class="text-3xl leading-tight font-bold text-gray-900 mb-6" id="modal-title" x-text="currentPost?.title"></h3>
                                    <div class="mt-2">
                                        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed" x-html="currentPost?.content"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <a :href="'Write?id=' + btoa(currentPost?.posts_id)" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm transition duration-150 ease-in-out">
                                Edit Story
                            </a>
                            <button type="button" @click="showModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition duration-150 ease-in-out">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
        function draftStories() {
            return {
                showModal: false,
                showPublishModal: false,
                currentPost: null,
                postToPublish: null,
                previewImage: null,
                selectedFile: null,
                dragOver: false,
                isPublishing: false,
                
                handleFileDrop(e) {
                    e.preventDefault();
                    this.dragOver = false;
                    const file = e.dataTransfer.files[0];
                    this.handleFileSelect(file);
                },
                
                handleFileSelect(file) {
                    if (file && file.type.startsWith('image/')) {
                        this.selectedFile = file;
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.previewImage = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                },
                
                async publishPost() {
                    if (!this.selectedFile || !this.postToPublish) {
                        alert('Please select an image and a post to publish.');
                        return;
                    }
                    
                    this.isPublishing = true;
                    
                    const formData = new FormData();
                    formData.append('image', this.selectedFile);
                    formData.append('action', 'publish'); // Ensure this matches the backend
                    formData.append('post_id', this.postToPublish.posts_id);
                    
                    // // Debugging: Log FormData entries
                    // for (let [key, value] of formData.entries()) {
                    //     console.log(`${key}: ${value}`);
                    // }body: formData 
                    
                    try {
                        const response = await fetch('PostProcess', {
                            method: 'POST',
                            body: formData
                        });
                        
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        
                        const result = await response.json();
                        alert('Post published successfully!');
                        this.showPublishModal = false;
                        this.resetPublishState();
                        window.location.reload();

                        // You might want to refresh the list of draft posts here
                    } catch (error) {
                        console.error('Error:', error);
                        alert('There was an error publishing the post. Please try again.');
                    } finally {
                        this.isPublishing = false;
                    }
                },
                
                resetPublishState() {
                    this.postToPublish = null;
                    this.previewImage = null;
                    this.selectedFile = null;
                    this.isPublishing = false;
                }
            }
        }

        function unpublishPost(postId) {
            if (confirm('Are you sure you want to unpublish this story?')) {
                const formData = new FormData();
                formData.append('action', 'unpublish'); // Ensure this matches the backend
                formData.append('post_id', postId);
                
                // // Debugging: Log FormData entries
                // for (let [key, value] of formData.entries()) {
                //     console.log(`${key}: ${value}`);
                // }
                
                fetch('PostProcess', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(result => {
                    alert('Post unpublished successfully!');
                    // Optionally, refresh the list of posts here
                    window.location.reload();

                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('There was an error unpublishing the post. Please try again.');
                });
            }
        }

    </script>



</body>
