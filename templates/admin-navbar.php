
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

    <!-- font awesome cdn: contains icons --> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- my own style sheet --> 
    <link rel="stylesheet" type="text/css" href="/styles.css">

    <title>Home</title>

    <style>
      #card_count{
        text-align: center;
        padding: 0 0.9rem 0.1 rem 0.9 rem;
        border-radius: 3rem;
        background-color: black;
        background: black;
      }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
  <a class="navbar-brand">Shopster</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/admin/manage.php">Manage Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/admin/viewProducts.php">View Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/admin/insert.php">Insert Product</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/admin/viewPurchases.php">View Payments</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/admin/viewUsers.php">View Users</a>
        </li>
      </ul>
        
      <a class="btn btn-outline-success" href="/login/logout.php">Log out</a>
    
    </div>
  </div>
</nav>




<?php 
if(isset($_SESSION['admin'])){ //admin tab if admin is in session
?>
<?php 
if(isset($_POST['user'])){
  $_SESSION['admin'] = 0; //set admin to zero meaning it's user view
  echo '<script>window.location.href = "/index.php"</script>';
}
if (isset($_POST['admin'])){
  $_SESSION['admin'] = 1; //set admin to one meaning it's admin view
}
$admin = $_SESSION['admin'];

?>
<ul class="nav nav-tabs">
  <li class="nav-item">
    <form method="post">
      <?php if ($admin==1): //admin tab active?>
        <button type="submit" name="admin" class="nav-link active" aria-current="page">Admin View</button>
      <?php else: //admin tab inactive?>
        <button type="submit" name="admin" class="nav-link" aria-current="page">Admin View</button>
      <?php endif; ?>
      
    </form>
  </li>
  <li class="nav-item">
    <form method="post">
      <?php if ($admin==1): //user tab inactive?>
        <button type="submit" name="user" class="nav-link" aria-current="page">User View</button>
      <?php else: //user tab active?>
        <button type="submit" name="user" class="nav-link active" aria-current="page">User View</button>
      <?php endif; ?>
    </form>
  </li>
</ul>
<?php
}
?>
