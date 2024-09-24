<?php

require_once 'app/Model/PostsModel.php';

class PostController
{
    private $postModel;

    public function __construct($pdo)
    {
        $this->postModel = new Post($pdo);
    }

    // Create a new post
public function createPost($title, $body, $image, $categoryId, $isBreaking = 0)
{
    if (!isset($_SESSION['user_id'])) {
        return ['error' => 'User not logged in.'];
    }
    
    $userId = $_SESSION['user_id'];
    
    // Call the model to insert the post into the database
    $result = $this->postModel->createPost($title, $body, $userId, $image, $categoryId, $isBreaking);
    
    // Return success or error response
    if (isset($result['success'])) {
        return ['success' => 'Post created successfully.'];
    } else {
        return ['error' => 'Failed to create post.'];
    }
}

 //updatepost
 public function updatePost($postId, $title, $userid, $content, $image, $categoryId, $isBreaking)
 {
    //  if (!isset($_SESSION['user_id'])) {
    //      return ['error' => 'User not logged in.'];
    //  }
     

     // Call the model to update the post with the correct argument order
     $result = $this->postModel->updatePost($postId, $title, $userid, $content, $image, $categoryId, $isBreaking);
     
     // Return success or error response
    //  if (isset($result['success'])) {
    //      return ['success' => 'Post updated successfully.'];
    //  } else {
    //      return ['error' => 'Failed to update post.'];
    //  }
    return $result; // Return the result directly from the model

 }
 


    
    

    // List all posts by status ('draft' or 'published')
    public function listPosts($status = 'draft')
    {
        if (!isset($_SESSION['user_id'])) {
            return ['error' => 'User not logged in.'];
        }

        $userId = $_SESSION['user_id'];
        $posts = $this->postModel->getPosts($userId, $status);
        return $posts;
    }

    // Publish a post
    public function publishPost($postid, $image, $uploadDir)
    {
        return $this->postModel->publishPost($postid, $image, $uploadDir);
    }

    public function unpublishPost($postid)
    {
        return $this->postModel->unpublishPost($postid);
    }
    
    // View a single post
    public function viewPost($postId)
    {
        $post = $this->postModel->getPostById($postId); // Correct method name
        return $post ?: ['error' => 'Post not found.'];
    }

            // Fetch posts by category
        public function getPostsByCategory($categoryId, $limit = 5)
        {
            return $this->postModel->getPostsByCategory($categoryId, $limit);
        }


    // Fetch the latest posts
    public function getLatestPosts($limit = 6)
    {
        $posts = $this->postModel->getLatestPosts($limit);
        return $posts;
    }

    // Fetch breaking news
    public function getBreakingNews($limit = 5)
        {
            return $this->postModel->getBreakingNews($limit);
        }

        // Fetch most recent news
        public function getMostRecentNews($limit = 5)
        {
            return $this->postModel->getMostRecentPosts($limit);
        }

        // Fetch trending news
        public function getTrendingNews($limit = 5)
        {
            return $this->postModel->getTrendingNews($limit);
        }

        // Increment views for a post
        public function incrementPostViews($postId)
        {
            $this->postModel->incrementPostViews($postId);
        }

        public function getCategories()
        {
            return $this->postModel->getCategories();
        }

        public function showCategoryNews($categoryName) {
            // Fetch breaking news if available, else fetch the most recent news
            $breakingNews = $this->postModel->getBreakingNewsByCategory($categoryName);
            if (!$breakingNews) {
                $mainNews = $this->postModel->getMostRecentNewsByCategory($categoryName);
            } else {
                $mainNews = $breakingNews;
            }
    
            // Fetch more news from that category
            $moreNews = $this->postModel->getMoreNewsByCategory($categoryName);
    
            // Return the data to be used in the view
            return [
                'mainNews' => $mainNews,
                'moreNews' => $moreNews,
                'categoryName' => $categoryName
            ];
        }
}
