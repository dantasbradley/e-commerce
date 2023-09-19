<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") { //if made a submit to form
    //this scrambles the password so it's encrypted and we can't see the actual password
    $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
    
    // //connect to database
    include ('../db_connect.php');
    //connect to the user table and insert the name, email, and encrypted password
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    
    // Check if the email already exists in the database
    $check_query = "SELECT * FROM user WHERE email = '$email'";
    $check_result = mysqli_query($conn, $check_query);
    
    if (mysqli_num_rows($check_result) > 0) { //email in use
        $invalidEmail = "Email (" .$email. ") already in use. Please choose another email.";
    }
    else{ //email not in use
        $sql = "INSERT INTO user(name,email,password_hash) VALUES('$name', '$email', '$password_hash')";
        //save to db and check
        if (mysqli_query($conn, $sql)){
            header("Location: login.php");
        }
        else{
            echo 'query error: ' . mysqli_error($conn);
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
    <meta charset="UTF-8">
    <!-- bootstrap links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <!-- these scripts are for validation checking the inputs -->
    <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js" defer></script>
    <script src="validation.js" defer></script>
    <!-- bootstrap icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
</head>
<body>
    <div class="mt-3 mx-1">
        <a href="../index.php" class="btn btn-outline-primary mb-2"><i class="bi bi-arrow-left"></i> Go back to the main page</a>
    </div>
    <div class="container mt-3 card">
        <h1 class="text-center mt-2">Signup</h1>
        <form action="signup.php" method="post" id="signup" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo $name; ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo $email; ?>" required>
                <div class="text-danger"><?php echo $invalidEmail; ?></div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" value="<?php echo $password; ?>" required>
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Repeat password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" value="<?php echo $password; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary mb-2">Sign up</button>
        </form>
    </div>
</body>
</html>
