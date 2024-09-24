<?php
require_once 'app/views/partials/navbar.php';
include 'app/config/dbconfig.php';
require_once 'app/Controllers/PostsController.php';

$postController = new PostController($pdo);

// Extract post ID from the URL
$postIdEncoded = isset($_GET['id']) ? $_GET['id'] : null;

// Initialize variables
$post = [
    'title' => '',
    'content' => '',
    'category_id' => '',
    'updated_at' => ''
];
$editingPost = false;
$postId = '';

// Check if post ID is provided
if ($postIdEncoded) {
    // Decode the post ID
    $postId = base64_decode($postIdEncoded);

    // Load the post details using the decoded ID
    $post = $postController->viewPost($postId);
    if (isset($post['title'])) {
        $editingPost = true;
    }
}
?>
<section class="bg-gray-100 min-h-screen p-2 sm:p-4 font-PTserif">
  <div class="max-w-4xl mx-auto bg-white shadow-sm p-2 sm:p-4">
    <?php if (isset($post['error'])): ?>
      <p class="text-red-500"><?php echo htmlspecialchars($post['error']); ?></p>
    <?php else: ?>
      <form id="blog-post-form" method="POST">
        <div class="flex flex-col sm:flex-row sm:items-center mb-2 sm:space-x-2">
          <input 
            type="text" 
            id="title" 
            name="title" 
            class="flex-grow text-xl sm:text-2xl font-bold p-1 sm:p-2 focus:outline-none" 
            placeholder="Enter your blog post title" 
            spellcheck="true" 
            value="<?php echo htmlspecialchars($post['title']); ?>"
          >
          <input type="hidden" id="userid" name="userid" value="<?php echo $_SESSION['user_id']?>">
          <div class="flex items-center space-x-2 mt-2 sm:mt-0">
            <?php if (!empty($categories)): ?>
              <select id="category" name="category" class="p-1 text-sm bg-gray-100 rounded">
                <option value="">Select A News Category</option>
                <?php foreach ($categories as $category): ?>
                  <option 
                    value="<?php echo htmlspecialchars($category['category_id']); ?>"
                    <?php echo ($category['category_id'] == $post['category_id']) ? 'selected' : ''; ?>
                  >
                    <?php echo htmlspecialchars($category['name']); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            <?php else: ?>
              <li><a href="#" class="text-white text-sm md:text-base">No categories found</a></li>
            <?php endif; ?>
            <button id="save-draft" class="px-2 py-1 bg-gray-200 text-sm rounded" type="submit">
            <?php echo $editingPost ? 'Save New Changes' : 'Save'; ?>
          </button>           
          <button id="publish" class="px-2 py-1 bg-blue-500 text-white text-sm rounded cursor-not-allowed" type="" disabled>Publish</button>
          </div>
        </div>
        <hr class="my-2 border-gray-200">
        <div 
          id="editor" 
          class="w-full h-[calc(100vh-150px)] p-2 focus:outline-none overflow-y-auto font-PTserif" 
          spellcheck="true"
        >
          <?php echo $post['content']; ?>
        </div>
        <input type="hidden" name="content" id="content" value="<?php echo htmlspecialchars($post['content']); ?>">
      </form>
      <?php if ($editingPost): ?>
        <p class="text-gray-600 mt-2">Last edited: 
            <?php echo date('M d, Y h:i A', strtotime($post['updated_at'])); ?>
        </p>
      <?php endif; ?>
    <?php endif; ?>

    <!-- Modal HTML -->
    <div id="progress-modal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
      <div class="bg-white p-4 rounded shadow-lg w-1/3 text-center">
        <h2 class="text-lg font-semibold mb-2">Creating Post...</h2>
        <p id="progress-message">Your post is being created. Please wait.</p>
      </div>
    </div>
  </div>
</section>



<script>
  var toolbarOptions = [
    [{ 'font': ['ptserif', 'roboto', 'courier'] }],
    [{ 'header': [1, 2, 3, false] }],
    ['bold', 'italic', 'underline'],
    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
    [{ 'script': 'sub'}, { 'script': 'super' }],
    [{ 'indent': '-1'}, { 'indent': '+1' }],
    [{ 'direction': 'rtl' }],
    [{ 'size': ['small', false, 'large', 'huge'] }],
    [{ 'color': [] }, { 'background': [] }],
    [{ 'align': [] }],
    ['link', 'image', 'video'],
    ['blockquote', 'code-block'],
    ['clean']
  ];

  var quill = new Quill('#editor', {
    modules: { toolbar: toolbarOptions },
    theme: 'snow'
  });

  // Get the post ID from the URL
  var urlParams = new URLSearchParams(window.location.search);
  var encodedPostId = urlParams.get('id');
  var postId = encodedPostId ? atob(encodedPostId) : null;

  document.getElementById('blog-post-form').addEventListener('submit', function(e) {
    e.preventDefault();

    var title = document.getElementById('title').value;
    var userid = document.getElementById('userid').value;
    var category = document.getElementById('category').value;
    var content = document.querySelector('#editor .ql-editor').innerHTML;

    // Add 'action' to the formData
    var formData = {
      title: title,
      category: category,
      content: content,
      userid: userid,
      action: 'update'  // Add the 'action' field here
    };

    // Show the progress modal
    document.getElementById('progress-modal').classList.remove('hidden');

    // Send request to the same endpoint
    fetch('PostProcess', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ ...formData, id: postId }) // Include postId if present
    })
    .then(response => response.json())
    .then(data => {
      // Hide the progress modal
      document.getElementById('progress-modal').classList.add('hidden');

      if (data.success) {
        alert(postId ? 'Post updated successfully' : 'Post saved as draft');
        // Redirect to the stories page
        window.location.href = 'Stories'; // Change this to your actual stories page URL
      } else {
        alert('Error: ' + data.error);
      }
    })
    .catch(error => {
      // Hide the progress modal
      document.getElementById('progress-modal').classList.add('hidden');
      console.error('Error:', error);
    });
  });
</script>




