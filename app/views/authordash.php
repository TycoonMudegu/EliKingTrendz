<?php require_once 'app/views/partials/navbar.php'; ?>

<style>
        .input-icon {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: #718096;
        }
        .input-with-icon {
            padding-left: 35px;
        }
        .loader {
            border-top-color: #3498db;
            -webkit-animation: spinner 1.5s linear infinite;
            animation: spinner 1.5s linear infinite;
        }
        @-webkit-keyframes spinner {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }
        @keyframes spinner {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>



<body class="bg-gray-100" x-data="{ activeTab: 'about', modalOpen: false }">
    <div class="max-w-4xl mx-auto py-10">
        <!-- Profile Header -->
        <div class="flex justify-between items-center border-b pb-4">
            <h1 class="text-4xl font-bold"><?php echo htmlspecialchars($_SESSION['full_name'] ?? ''); ?></h1>
            <div class="flex items-center">
                <img src="<?php echo htmlspecialchars($_SESSION['user_picture'] ?? ''); ?>" alt="Profile Picture" class="w-16 h-16 rounded-full mr-4">
                <div>
                    <p class="font-semibold"><?php echo htmlspecialchars($_SESSION['full_name'] ?? ''); ?></p>
                    <p class="text-gray-500">1 Follower</p>
                    <a href="#" @click.prevent="modalOpen = true" class="text-green-600 hover:underline">Edit profile</a>
                </div>
            </div>
        </div>
        <!-- Navigation Tabs -->
        <div class="flex space-x-6 py-4 border-b">
            <button @click="activeTab = 'home'" :class="{ 'text-black font-medium': activeTab === 'home', 'text-gray-500': activeTab !== 'home' }" class="hover:text-green-600">Home</button>
            <button @click="activeTab = 'about'" :class="{ 'text-black font-medium': activeTab === 'about', 'text-gray-500': activeTab !== 'about' }" class="hover:text-green-600">About</button>
        </div>
        <!-- Content Section -->
        <div class="mt-8">
            <div x-show="activeTab === 'home'" class="bg-white p-6 rounded-lg shadow-lg">
                <!-- Home Section Content -->
                <div class="flex items-center space-x-4 mb-6">
                    <img src="<?php echo htmlspecialchars($_SESSION['user_picture'] ?? ''); ?>" alt="User Profile" class="w-12 h-12 rounded-full">
                    <div>
                        <p class="text-2xl font-semibold"><?php echo htmlspecialchars($_SESSION['full_name'] ?? ''); ?></p>
                        <p class="text-gray-600 text-lg">Reading list</p>
                        <p class="text-gray-600 text-lg">No stories <span class="inline-block text-sm">🔒</span></p>
                    </div>
                </div>

                <!-- Published and Draft Posts Count -->
                <div class="mb-6">
                    <div class="flex justify-between items-center border-b pb-4 mb-4">
                        <div class="flex flex-col">
                            <h2 class="text-xl font-bold text-gray-800">Published Posts</h2>
                            <p class="text-2xl font-semibold text-gray-900 mt-2" id="published-posts-count">0</p>
                        </div>
                        <div class="flex flex-col">
                            <h2 class="text-xl font-bold text-gray-800">Draft Posts</h2>
                            <p class="text-2xl font-semibold text-gray-900 mt-2" id="draft-posts-count">0</p>
                        </div>
                    </div>

                    <!-- View All Posts Button -->
                    <div class="text-center mt-6">
                        <a href="#" class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow hover:bg-blue-700 transition duration-300">View All Posts</a>
                    </div>
                </div>
            </div>

            <div x-show="activeTab === 'about'" class="bg-white p-6 rounded shadow">
                <!-- About Section Content -->
                <div>
                    <!-- Bio Content -->
                    <div class="text-gray-700 mb-4">
                        <p>This is your bio content. You can describe yourself here.</p>
                    </div>
                    <!-- Trigger Button -->
                    <button @click="modalOpen = true" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Edit Profile
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div x-data="profileModal()" x-show="modalOpen" @click.away="closeModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg mx-4 w-full max-w-md sm:max-w-lg md:max-w-xl lg:max-w-2xl xl:max-w-3xl max-h-[90vh] overflow-auto">
            <div class="p-4 sm:p-6 lg:p-8 relative">
                <!-- Close button -->
                <button @click="closeModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
                <!-- Loader (visible when loading) -->
                <div x-show="loading" class="flex items-center justify-center mb-4">
                    <div class="loader border-t-4 border-blue-500 rounded-full w-12 h-12 animate-spin"></div>
                    <p class="ml-3 text-lg font-medium text-gray-700">Loading your details...</p>
                </div>
                <!-- Error message -->
                <div x-show="error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline" x-text="errorMessage"></span>
                </div>
                <!-- Form (hidden while loading) -->
                <div x-show="!loading && !error">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4 sm:mb-6">Update Your Profile</h2>
                    <form @submit.prevent="updateProfile" class="space-y-4 sm:space-y-6 lg:space-y-8">
                        <!-- Form fields -->
                        <div class="mb-4 flex w-full items-center justify-center">
                            <label for="dropzone-file" class="flex h-32 sm:h-40 w-full cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 transition duration-300 hover:bg-gray-100">
                                <div class="flex flex-col items-center justify-center pb-4 pt-3">
                                    <i class="fas fa-user-circle mb-3 text-4xl sm:text-5xl text-gray-400"></i>
                                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                    <p class="text-xs text-gray-500">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                                </div>
                                <input id="dropzone-file" type="file" class="hidden" />
                            </label>
                        </div>

                        <!-- Inputs Side by Side -->
                        <div class="flex flex-col sm:flex-row gap-4">
                            <div class="flex-1 relative">
                                <i class="fas fa-at input-icon"></i>
                                <input type="text" id="username" name="username" class="input-with-icon w-full rounded-lg border-2 border-gray-300 px-4 py-3 transition duration-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Username" />
                            </div>
                            <div class="flex-1 relative">
                                <i class="fas fa-link input-icon"></i>
                                <input type="text" id="website" name="website" class="input-with-icon w-full rounded-lg border-2 border-gray-300 px-4 py-3 transition duration-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Website" />
                            </div>
                        </div>

                        <div>
                            <textarea id="bio" name="bio" rows="4" class="w-full rounded-lg border-2 border-gray-300 px-4 py-3 transition duration-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Tell us about yourself..."></textarea>
                        </div>

                        <div class="space-y-4">
                            <h3 class="text-lg sm:text-xl font-medium text-gray-700">Social Media Handles</h3>
                            <div class="flex flex-col sm:flex-row gap-4">
                                <div class="flex-1 relative">
                                    <i class="fab fa-github input-icon"></i>
                                    <input type="text" name="github" class="input-with-icon w-full rounded-lg border-2 border-gray-300 px-4 py-3 transition duration-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="GitHub username" />
                                </div>
                                <div class="flex-1 relative">
                                    <i class="fab fa-twitter input-icon"></i>
                                    <input type="text" name="twitter" class="input-with-icon w-full rounded-lg border-2 border-gray-300 px-4 py-3 transition duration-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Twitter handle" />
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-lg shadow hover:bg-green-700 transition duration-300 w-full" :disabled="submitting">
                            <span x-show="!submitting">Save Changes</span>
                            <span x-show="submitting" class="flex items-center justify-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Saving...
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('profileModal', () => ({
            modalOpen: false,
            loading: true,
            error: false,
            errorMessage: '',
            submitting: false,

            init() {
                this.$watch('modalOpen', (value) => {
                    if (value) {
                        this.fetchUserDetails();
                    }
                });
            },

            closeModal() {
                this.modalOpen = false;
                this.error = false;
                this.errorMessage = '';
            },

            fetchUserDetails() {
                this.loading = true;
                this.error = false;

                fetch('Author', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'action=getUser'
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data) {
                        document.getElementById('username').value = data.username || '';
                        document.getElementById('website').value = data.website || '';
                        document.getElementById('bio').value = data.bio || '';
                        document.getElementsByName('github')[0].value = data.github || '';
                        document.getElementsByName('twitter')[0].value = data.twitter || '';
                    } else {
                        throw new Error('No data received from server');
                    }
                })
                .catch(error => {
                    console.error('Error fetching user details:', error);
                    this.error = true;
                    this.errorMessage = 'Failed to load user details. Please try again later.';
                })
                .finally(() => {
                    this.loading = false;
                });
            },

            updateProfile(event) {
                event.preventDefault();
                this.submitting = true;
                this.error = false;

                const formData = new FormData(event.target);
                formData.append('action', 'updateUser');

                fetch('Author', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        alert('Profile updated successfully!');
                        this.closeModal();
                    } else {
                        throw new Error(data.message || 'Unknown error occurred');
                    }
                })
                .catch(error => {
                    console.error('Error updating profile:', error);
                    this.error = true;
                    this.errorMessage = 'Failed to update profile. Please try again later.';
                })
                .finally(() => {
                    this.submitting = false;
                });
            }
        }));
    });
    </script>
</body>