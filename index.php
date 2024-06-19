<?php

require 'config.php';

$dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try {
    $pdo = new PDO($dsn, $user, $password, $options);

    if ($pdo) {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $query = "SELECT * FROM `users` WHERE username = :username";
            $statement = $pdo->prepare($query);
            $statement->execute([':username' => $username]);

            $user = $statement->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if ('secret123' === $password) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];

                    header("Location: post2.php");
                    exit;
                } else {
                    echo "Invalid password!";
                }
            } else {
                echo "User not found!";
            }
        }
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #896b60ad; 
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
    
        .login-container {
            max-width: 400px; 
            padding: 40px; 
            border-radius: 20px; 
            background: rgba(255, 255, 255, 0.73);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1); 
        }
    
        input[type="text"],
        input[type="password"],
        button {
            width: 100%; 
            padding: 15px; 
            margin-bottom: 20px; 
            border: none; 
            border-radius: 25px; 
            background-color: #f2f2f2; 
            box-sizing: border-box; 
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1); 
        }
    
        button {
            background-color: #4a332d;
            color: #fff; 
            font-size: 16px;
            font-weight: bold; 
            cursor: pointer;
            transition: background-color 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); 
        }
    
        button:hover {
            background-color: #896b60; 
        }
    
        .error-message {
            color: #ff0000; 
            margin-top: 10px; 
            font-size: 14px; 
        }
    
        h1 {
            text-align: center;
            color: #333;
        }
    </style>
    
</head>
<body>
<div class="login-container">
        <h2>Login</h2>
        <form id="loginForm" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <input type="text" id="username" placeholder="Enter username" name="username" required>
            <input type="password" id="password" placeholder="Enter password" name="password" required>
            <button id="submit">Login</button>
        </form>
    </div>
</body>

</html>
