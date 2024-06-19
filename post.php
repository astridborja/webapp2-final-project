<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Page</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #896b60ad;
            margin: 0;
            padding: 0;
        }
        
        .post-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #ffffffbd;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333; 
        }
        
        #postDetails {
            padding: 20px;
            border-radius: 10px;
            background-color: #f9f9f9;
            transition: background-color 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); 
        }
        
        #postDetails:hover {
            background-color: #f0f0f0;
        }
        
        #postDetails h3 {
            margin-bottom: 10px;
            color: #4a332d; 
        }
        
        #postDetails p {
            color: #666; 
        }
        
        #postDetails a {
            color: #4a332d;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        #postDetails a:hover {
            color: #4a332d; 
        }
        
    </style>
</head>
<body>
    <div class="post-container">
        <h1>Post Page</h1>
        <div id="postDetails">
            <?php

            require 'config.php';

            if (!isset($_SESSION['user_id'])) {
                header("Location: index.php");
                exit;
            }

            $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
            $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

            try {
                $pdo = new PDO($dsn, $user, $password, $options);

                if ($pdo) {
                    if (isset($_GET['id'])) {
                        $id = $_GET['id'];

                        $query = "SELECT * FROM `posts` WHERE id = :id";
                        $statement = $pdo->prepare($query);
                        $statement->execute([':id' => $id]);

                        $post = $statement->fetch(PDO::FETCH_ASSOC);

                        if ($post) {
                            echo '<h3>Title: ' . $post['title'] . '</h3>';
                            echo '<p>Body: ' . $post['body'] . '</p>';
                        } else {
                            echo "No post found with ID $id!";
                        }
                    } else {
                        echo "No post ID provided!";
                    }
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            ?>
        </div>
    </div>
    
</body>
</html>