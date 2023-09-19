<?php
session_start();

include ('../db_connect.php');
//need products to display them
$sql = 'SELECT name, price, image, id FROM product ORDER BY id';
$result = mysqli_query($conn, $sql);


?>


<!DOCTYPE html>
<?php
include('../templates/admin-navbar.php') 
?>

<div class="container" style="width: 65%">
        <h2>Shopping Cart</h2>
    </div>

<!-- grid cards --> 
<div class="row row-cols-1 row-cols-md-3 g-4">
  <!-- while loop to display products -->
  <?php 
    //make an array from the result
    while ($row = mysqli_fetch_assoc($result)){

        //then put each product
    ?>
    
    <div class="col">
        <div class="card h-100">
        <form action="browse.php" method="post">
        <img src="../images/<?php echo $row['image']?>" class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title"><?php echo $row['name']?></h5>
            <h5>
                <span class="price">$<?php echo number_format($row['price'],2)?> </span>
            </h5>
            <input type='hidden' name='product_id' value='<?php echo $row['id']?>'>
            </form>
        </div>
        </div>
    </div>


    <?php

    }

  ?>
  <!--  -->
    
    
</body>
</html>