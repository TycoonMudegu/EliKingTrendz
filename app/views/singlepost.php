<?php 
require_once 'app/views/partials/navbar.php';

// Initialize variables
$post = null;
$errorMessage = '';

// Check if the 'url' parameter is set and matches the post route
if (isset($_GET['url']) && preg_match('/^post\/([0-9]+)$/', $_GET['url'], $matches)) {
    $id = (int) $matches[1]; // Extract and cast to integer for safety

    // Prepare and execute the query
    try {
        $stmt = $pdo->prepare('SELECT * FROM posts WHERE posts_id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT); // Bind the parameter correctly
        $stmt->execute();
        $post = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$post) {
            $errorMessage = 'Post not found.';
        }
    } catch (PDOException $e) {
        $errorMessage = 'An error occurred: ' . htmlspecialchars($e->getMessage());
    }
} else {
    $errorMessage = 'Invalid post ID.';
}
?>


<!-- HTML Content -->
<div class="container mx-auto py-8">
    <?php if ($errorMessage): ?>
        <p class="text-red-500"><?php echo htmlspecialchars($errorMessage); ?></p>
    <?php elseif ($post): ?>
        <h1 class="text-4xl font-bold mb-6"><?php echo htmlspecialchars($post['title']); ?></h1>
        <img src="../assets/images/<?php echo htmlspecialchars($post['image']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>" class="w-full h-96 object-cover rounded mb-6">
        <p class="text-gray-700"><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
    <?php endif; ?>
</div>


<script>
document.addEventListener("DOMContentLoaded", function() {
    // Get post ID from PHP
    const postId = <?php echo $id; ?>;
    const viewTimeLimit = 10000; // 5 seconds

    // Check if this post has been viewed recently (i.e., avoid counting page refreshes)
    const lastViewedPostId = localStorage.getItem('lastViewedPostId');

    if (lastViewedPostId !== String(postId)) {
        // Set a timeout to count the view after 5 seconds
        setTimeout(function() {
            // Fetch API to send a request to the backend to count the view
            fetch('Trending', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ postId: postId }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('View counted successfully');
                    // Save this post ID in local storage to avoid multiple counts on refresh
                    localStorage.setItem('lastViewedPostId', postId);
                } else {
                    console.error('Failed to count view:', data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }, viewTimeLimit);
    } else {
        console.log('This post was recently viewed. Not counting as a new view.');
    }
});
</script>


<?php include 'app/views/partials/footer.php'; ?>
