<?php

class Post
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Fetch the latest posts
    public function getLatestPosts($limit = 6)
    {
        try {
            $stmt = $this->pdo->query('SELECT * FROM posts ORDER BY created_at DESC LIMIT ' . (int)$limit);
            $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return array_map([$this, 'sanitizePost'], $posts);
        } catch (PDOException $e) {
            return ['error' => htmlspecialchars($e->getMessage())];
        }
    }

    // Fetch a single post by ID
    public function getPostById($id)
{
    try {
        $query = "
            SELECT p.*, u.full_name AS author_name, a.bio AS author_bio, u.picture
            FROM posts p
            JOIN authors a ON p.author_id = a.author_id
            JOIN users u ON a.user_id = u.user_id
            WHERE p.posts_id = :id
        ";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $post = $stmt->fetch(PDO::FETCH_ASSOC);

        return $post ? $post : null;
    } catch (PDOException $e) {
        return ['error' => htmlspecialchars($e->getMessage())];
    }
}

    // Create a new post (as a draft)
public function createPost($title, $body, $userId, $image, $categoryId, $isBreaking = 0)
{
    try {
        // Fetch the author_id using user_id from the authors table
        $stmtAuthor = $this->pdo->prepare("SELECT author_id FROM authors WHERE user_id = ?");
        $stmtAuthor->execute([$userId]);
        $author = $stmtAuthor->fetch(PDO::FETCH_ASSOC);
        
        if (!$author) {
            throw new Exception("Author not found for the given user ID");
        }
        
        $authorId = $author['author_id'];
        
        // Prepare the SQL query with the new columns and default values
        $stmt = $this->pdo->prepare("
            INSERT INTO posts (
                title, image, category_id, author_id, created_at, 
                status, is_breaking, content, views_count
            ) VALUES (
                ?, ?, ?, ?, NOW(), 
                'draft', ?, ?, 0
            )
        ");
        
        // Execute the SQL query and check if it was successful
        $success = $stmt->execute([$title, $image, $categoryId, $authorId, $isBreaking, $body]);
        
        if ($success) {
            return ['success' => true];
        } else {
            return ['error' => true];
        }
    } catch (PDOException $e) {
        return ['error' => true];
    } catch (Exception $e) {
        return ['error' => true];
    }
}

//update post

public function updatePost($postId, $userId, $title, $content, $image, $categoryId, $isBreaking)
{
    try {
        // Typecast input parameters
        $postId = (int) $postId;
        $userId = (int) $userId;
        $categoryId = (int) $categoryId;
        $isBreaking = (bool) $isBreaking;

        // Fetch the author ID using user ID
        $stmtAuthor = $this->pdo->prepare("SELECT author_id FROM authors WHERE user_id = :userId");
        $stmtAuthor->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmtAuthor->execute();
        $authorId = $stmtAuthor->fetchColumn();

        if (!$authorId) {
            return ['error' => true, 'message' => 'Author not found'];
        }

        // Prepare and execute the SQL query to update the post
        $stmt = $this->pdo->prepare("
            UPDATE posts
            SET 
                title = :title, 
                image = :image, 
                category_id = :categoryId, 
                author_id = :authorId, 
                updated_at = NOW(), 
                is_breaking = :isBreaking, 
                content = :content
            WHERE 
                posts_id = :postId
        ");
        
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':image', $image, PDO::PARAM_STR);
        $stmt->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
        $stmt->bindParam(':authorId', $authorId, PDO::PARAM_INT);
        $stmt->bindParam(':isBreaking', $isBreaking, PDO::PARAM_BOOL);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $stmt->bindParam(':postId', $postId, PDO::PARAM_INT);
        $stmt->execute();

        // Check if the post was updated
        if ($stmt->rowCount() > 0) {
            return ['success' => true, 'message' => 'Post updated successfully'];
        }

        return ['error' => true, 'message' => 'No changes made or post not found'];
    } catch (PDOException $e) {
        return ['error' => true, 'message' => 'Database error occurred'];
    } catch (Exception $e) {
        return ['error' => true, 'message' => 'An unexpected error occurred'];
    }
}




    

    // Fetch all posts by user with a specific status
    public function getPosts($userId, $status) {
        // Query to join posts, authors, and users tables
        $query = "
            SELECT posts.*
            FROM posts 
            JOIN authors ON posts.author_id = authors.author_id
            JOIN users ON authors.user_id = users.user_id
            WHERE users.user_id = :userId AND posts.status = :status
            ORDER BY created_at DESC
        ";
    
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    // Publish a post by ID
    public function publishPost($postid, $imagePath, $uploadDir)
{
    try {
        $response = [];

        // // Debug: Output received parameters
        // $response['debug']['received_postid'] = $postid;
        // $response['debug']['received_imagePath'] = $imagePath;
        // $response['debug']['received_uploadDir'] = $uploadDir;

        // Validate and handle the image upload
        if ($imagePath && is_string($imagePath)) {
            // Debug: Output the base name of the imagePath
            $imageBaseName = basename($imagePath);
            // $response['debug']['image_baseName'] = $imageBaseName;

            // Ensure the image path is relative to the upload directory
            $imageFilePath = $uploadDir . $imageBaseName;

            // Debug: Output the final image file path
            // $response['debug']['image_filePath'] = $imageFilePath;

            // Prepare the SQL statement
            $stmt = $this->pdo->prepare("UPDATE posts SET status = 'published', image = ?, published_at = NOW() WHERE posts_id = ?");
            if ($stmt === false) {
                // Debug: SQL preparation failed
                // $response['error'] = 'SQL preparation failed.';
                // $response['debug']['sql_preparation'] = 'Failed';
                return json_encode($response);
            }

            // Execute the SQL statement
            $result = $stmt->execute([$imageFilePath, $postid]);
            if ($result === false) {
                // Debug: SQL execution failed
                // $response['error'] = 'SQL execution failed.';
                // $response['debug']['sql_execution'] = 'Failed';
                return json_encode($response);
            }

            // Debug: SQL execution successful
            $response['success'] = true;
            $response['debug']['sql_execution'] = 'Successful';
            return json_encode($response);
        } else {
            // Debug: Invalid image path
            // $response['error'] = 'Invalid image path.';
            $response['debug']['image_path_validity'] = 'Invalid';
            return json_encode($response);
        }
    } catch (PDOException $e) {
        // Debug: Exception caught
        $response['error'] = 'Exception caught: ' . htmlspecialchars($e->getMessage());
        $response['debug']['exception'] = $e->getMessage();
        return json_encode($response);
    }
}

public function unpublishPost($postid)
{
    try {
        $stmt = $this->pdo->prepare(
            "UPDATE posts 
             SET status = 'draft', 
                 published_at = NULL 
             WHERE posts_id = ?"
        );
        $stmt->execute([$postid]);

        return ['success' => 'Post unpublished successfully.'];
    } catch (PDOException $e) {
        return ['error' => htmlspecialchars($e->getMessage())];
    }
}

    
    public function getPostsByCategory($categoryId, $limit = 5)
        {
            $query = "SELECT * FROM posts WHERE category_id = :category_id AND status = 'published' ORDER BY created_at DESC LIMIT :limit";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }


        // Fetch breaking posts posts
        public function getBreakingNews($limit = 5)
        {
            $query = "SELECT * FROM posts WHERE is_breaking = 1 AND status = 'published' ORDER BY created_at DESC LIMIT :limit";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Fetch the most recent posts
        public function getMostRecentPosts($limit = 5)
            {
                $query = "SELECT * FROM posts WHERE status = 'published' ORDER BY created_at DESC LIMIT :limit";
                $stmt = $this->pdo->prepare($query);
                $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            public function incrementPostViews($postId)
            {
                $query = "UPDATE posts SET views_count = views_count + 1 WHERE posts_id = :postId";
                $stmt = $this->pdo->prepare($query);
                $stmt->bindParam(':postId', $postId, PDO::PARAM_INT);
                $stmt->execute();
            }

            // Fetch trending posts by views
            public function getTrendingNews($limit = 5)
            {
                $query = "SELECT * FROM posts WHERE status = 'published' ORDER BY views_count DESC LIMIT :limit";
                $stmt = $this->pdo->prepare($query);
                $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            // Example method in your controller to fetch categories
            public function getCategories() {
                // Assuming you have a PDO connection in $this->pdo
                $query = "SELECT * FROM categories ORDER BY name"; // Adjust the query as needed
                $statement = $this->pdo->prepare($query);
                $statement->execute();
                
                // Fetch all categories
                $categories = $statement->fetchAll(PDO::FETCH_ASSOC);
                
                // Return the fetched categories
                return $categories;
            }

         // Fetch category ID based on category name
         private function getCategoryIdByName($categoryName) {
            $stmt = $this->pdo->prepare("
                SELECT category_id FROM categories 
                WHERE name = ?
            ");
            $stmt->execute([$categoryName]); // Correctly bind the parameter using execute with an array
        
            // Fetch the result correctly using PDO
            $category = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $category ? $category['category_id'] : null; // Corrected typo 'categoty_id' to 'category_id'
        }
        
            // Fetch author name based on author ID
            private function getAuthorNameById($authorId) {
                $stmt = $this->pdo->prepare("
                    SELECT full_name FROM users 
                    WHERE user_id = ?
                ");
                $stmt->bindParam('i', $authorId);
                $stmt->execute();
                $result = $stmt->get_result();
                $author = $result->fetch_assoc();
                return $author ? $author['name'] : 'Unknown';
            }

            // Fetch breaking news by category
            public function getBreakingNewsByCategory($categoryName) {
                // Get the category ID using the helper function
                $categoryId = $this->getCategoryIdByName($categoryName);
                
                // If no category ID is found, return null
                if (!$categoryId) return null;
            
                // Prepare the SQL statement with a placeholder for the category ID
                $stmt = $this->pdo->prepare("
                    SELECT posts.*, users.full_name AS author_name FROM posts 
                    JOIN users ON posts.author_id = users.user_id
                    WHERE category_id = ? AND is_breaking = 1 
                    ORDER BY created_at DESC LIMIT 1
                ");
            
                // Execute the statement with the category ID bound to the placeholder
                $stmt->execute([$categoryId]);
            
                // Fetch the result as an associative array
                $breakingNews = $stmt->fetch(PDO::FETCH_ASSOC);
            
                return $breakingNews;
            }
            
            // Fetch the most recent news if no breaking news is available
            public function getMostRecentNewsByCategory($categoryName) {
                // Get the category ID from the category name
                $categoryId = $this->getCategoryIdByName($categoryName);
                if (!$categoryId) return null;
            
                // Prepare the SQL query with a placeholder for the category ID
                $stmt = $this->pdo->prepare("
                    SELECT posts.*, users.full_name AS author_name FROM posts 
                    JOIN users ON posts.author_id = users.user_id
                    WHERE category_id = ? 
                    ORDER BY created_at DESC LIMIT 1
                ");
            
                // Execute the statement with the category ID
                $stmt->execute([$categoryId]);
            
                // Fetch the result as an associative array
                $news = $stmt->fetch(PDO::FETCH_ASSOC);
            
                return $news;
            }
            

            // Fetch more news for the category (excluding the breaking or main article)
            public function getMoreNewsByCategory($categoryName) {
                // Get the category ID from the category name
                $categoryId = $this->getCategoryIdByName($categoryName);
                if (!$categoryId) return [];
            
                // Prepare the SQL statement with a placeholder for the category ID
                $stmt = $this->pdo->prepare("
                    SELECT posts.*, users.full_name AS author_name FROM posts 
                    JOIN users ON posts.author_id = users.user_id
                    WHERE category_id = ? 
                    ORDER BY created_at DESC LIMIT 5 OFFSET 1
                ");
            
                // Execute the statement with the category ID as the parameter
                $stmt->execute([$categoryId]);
            
                // Fetch all results as an associative array
                $news = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
                return $news;
            }
            // public function getPostById($id) {
            //     $query = "SELECT * FROM  posts WHERE posts_id = :id LIMIT 1";
            //     $stmt = $this->pdo->prepare($query);
            //     $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            //     $stmt->execute();
        
            //     return $stmt->fetch(PDO::FETCH_ASSOC);
            // }


            

    // Sanitize post data
    private function sanitizePost($post)
    {
        return [
            'id' => htmlspecialchars($post['posts_id']),
            'title' => htmlspecialchars($post['title']),
            'body' => htmlspecialchars($post['content']),
            'user_id' => htmlspecialchars($post['author_id']),
            'status' => htmlspecialchars($post['status']),
            'created_at' => htmlspecialchars($post['created_at']),
        ];
    }
}
