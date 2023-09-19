<?php

$is_invalid = false;
//this first if statement checks if you are putting the admin login
if (($_SERVER["REQUEST_METHOD"] === "POST") && ($_POST["email"] == 'admin@gmail.com') && ($_POST["password"] == 'admin123')){
    session_start();
    session_regenerate_id();
    //admin login has an id of 0, which is not in the database
    //id of 0 bc it's temporary
    $_SESSION["user_id"] = 0;
    $_SESSION['admin'] = 1;
    //go to the admin home screen
    header("Location: ../admin.php");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //connect to database
    include ('../db_connect.php');
    //find the user that has the email submitted

    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $sql = "SELECT * FROM user WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    $user = $result->fetch_assoc();
    echo $user["id"];
    
    if ($user) {
        // Email exists in the users table
        if (password_verify($_POST["password"], $user["password_hash"])) {
            
            session_start();
            session_regenerate_id();
            //user id is the id found in the database for this user
            $_SESSION["user_id"] = $user["id"];

            //reset cart session
            //unset($_SESSION['c']);
            
            //head to user home screen
            header("Location: ../index.php");
            exit;
        }
    }

    //either the password was wrong or user with that email doesn't exist to reach this far
    $is_invalid = true;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <!-- bootstrap links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <!-- bootstrap icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
</head>
<body>
    
    <div class="mt-3 mx-1">
        <a href="../index.php" class="btn btn-outline-primary mb-2"><i class="bi bi-arrow-left"></i> Go back to the main page</a>
    </div>

    <div class="container mt-3 card">
        <h1 class="text-center mt-2">Login</h1>
        <form method="post">
            <div class="mb-3">
                <label for="email">Email</label>
                <input class="form-control" type="email" name="email" id="email" value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
            </div>
            <div class="mb-3">
                <label for="password">Password</label>
                <input class="form-control" type="password" name="password" id="password">
            </div>
            <button type="submit" class="btn btn-primary mb-2">Log in</button>
        </form>
    </div>
</body>
</html>








