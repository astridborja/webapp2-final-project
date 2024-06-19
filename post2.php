<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts Page</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #896b60ad;
            margin: 0;
            padding: 0;
        }

        .posts-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #ffffffb4;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 10px;
            background-color: white;
            cursor: pointer;
            transition: background-color 0.3s ease; 
        }

        li:hover {
            background-color: #4a332db6;
            color: white;
        }
    </style>
</head>
<body>
    <div class="posts-container">
        <h1>Posts Page</h1>
        <ul id="postLists">
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
                    $user_id = $_SESSION['user_id'];

                    $query = "SELECT * FROM `posts` WHERE user_id = :id";
                    $statement = $pdo->prepare($query);
                    $statement->execute([':id' => $user_id]);

                    /*
                     * First approach using fetchAll and foreach loop
                     */
                    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($rows as $row) {
                        // echo '<li data-id="' . $row['id'] . '">' . $row['title'] . '</li>';
                        echo '<li><a href="post.php?id=' . $row['id'] . '">' . $row['title'] . '</li>';
                    }

                    /*
                     * Second approach using fetch and while loop
                     */
                    // while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                    // echo '<li data-id="' . $row['id'] . '">' . $row['title'] . '</li>';
                    // echo '<li><a href="post.php?id=' . $row['id'] . '">' . $row['title'] . '</li>';
                    // }
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            ?>
        </ul>
    </div>

</body>
</html>