<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <!-- font awesome cdn: contains icons --> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- my own style sheet
    <link rel="stylesheet" type="text/css" href="/styles.css">
    -->
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
          <a class="nav-link active" aria-current="page" href="/index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../user/aboutMe.php">About Me</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../user/browse.php">Browse Products</a>
        </li>
        <?php if (isset($_SESSION["user_id"])): //if logged in?>
          <li class="nav-item">
            <a class="nav-link" href="../user/purchaseHistory.php">Purchase History</a>
          </li>
        <?php else: //if not logged in, block purchase history?>
          <li class="nav-item">
            <a class="nav-link disabled" href=/purchaseHistory.php>Purchase History (login first)</a>
          </li>
        <?php endif; ?>


          <li class="nav-item">
          <?php if (isset($_SESSION["user_id"])): //if user logged in?>
          <a class="nav-item nav-link active" aria-current="page" href="../user/cart.php">
            <h6 class="cart">
              <i class="fas fa-shopping-cart"></i> Cart
              <?php
              if (isset($_SESSION['c'])){ //if there is items in the cart, show count
                $count = count($_SESSION['c']);
                echo " <span id=\"card_count\" class=\"text-warning bg-light\"> $count </span> ";
              }else{ //if no items in cart, show 0
                echo " <span id=\"card_count\" class=\"text-warning bg-light\"> 0 </span> ";
              }
              ?>
            </h6>
          </a>
          <?php else: //if user not logged in, block the cart?>
          <a class="nav-item nav-link disabled" aria-current="page">
            <h6 class="cart"> 
              <i class="fas fa-shopping-cart"></i> Cart (login first)
            </h6>
          </a>
          <?php endif; ?>
          </li>


      </ul>
    
    </div>
  </div>
</nav>

<div>
  <?php if (isset($_SESSION["user_id"])): //if user logged in, you can log out ?>

    <div class="d-flex align-items-center">
      <a class="btn btn-outline-success" href="/login/logout.php">Log out</a>
      <p> - -- -- Logged in -- -- - </p>
    </div>
  <?php else: //if user not logged in, you can sign/log in?>
    
    <div class="d-flex align-items-center">
      <a class="btn btn-outline-success" href="/login/signup.php">Sign up</a>
      <a class="btn btn-outline-success" href="/login/login.php">Log in</a>
      <p> - -- -- Guest -- -- - </p>
    </div>

  <?php endif; ?>
</div>



<?php 
if(isset($_SESSION['admin'])){ //admin tab if admin is in session
?>
<?php 
if(isset($_POST['user'])){
  $_SESSION['admin'] = 0; //set admin to zero meaning it's user view
}
if (isset($_POST['admin'])){
  $_SESSION['admin'] = 1; //set admin to one meaning it's admin view
  echo '<script>window.location.href = "admin.php"</script>';
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