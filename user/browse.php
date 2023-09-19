<?php
session_start();
?>
<html>
    <!--swal.fire alert: allows for better looking alerts-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
    <script src="../addition/alert.js"></script>
</html>

<?php 
if(isset($_POST['add'])){ //when you press any add to cart
    //get product id and quantity into session
    if(isset($_SESSION['c'])){
        //array of all id in cart
        $item_array_id = array_column($_SESSION['c'],"product_id");
        
        if(in_array($_POST['product_id'], $item_array_id)){ //if the posted id is in cart
            echo "<script>alertFail('Product is already in the cart')</script>";
        }else{ //if the posted id is not in cart
            $count = count($_SESSION['c']);
            $item_array = array(
                'product_id' => $_POST['product_id'],
                'quantity' => 1

            );
            //create new session variable
            echo "<script>alertSuccess('The product has been added to cart!')</script>";
            $_SESSION['c'][$count] = $item_array;
        }

    }else{
        $item_array = array(
            'product_id' => $_POST['product_id'],
            'quantity' => 1
        );
        //create new session variable
        echo "<script>alertSuccess('The product has been added to cart!')</script>";
        $_SESSION['c'][0] = $item_array;
    }
}

include ('../db_connect.php');
//this sql has the products and we will use this to display product info later
$sql = 'SELECT name, price, image, id FROM product ORDER BY id';
$result = mysqli_query($conn, $sql);


?>


<!DOCTYPE html>
<?php include('../templates/navbar.php') ?>

<style>
    img{
        width: 100px;
        height: auto;
        background: lightblue;
        background: radial-gradient(white 30%, lightblue 70%);
    }

</style>

<div class="container">
    <h2 class="text-center">Shopping Cart</h2>
    <!-- grid cards --> 
    <div class="row row-cols-1 row-cols-md-3 g-4">
    <!-- while loop of to display products-->
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
                    <?php if (isset($_SESSION["user_id"])): ?>
                        <button type="submit" class="btn btn-warning my-3" name="add">Add to Cart <i class="fas fa-shopping-cart"></i></button>
                    <?php else: ?>
                        <button class="btn btn-warning my-3 disabled">Add to Cart(login first) <i class="fas fa-shopping-cart"></i></button>
                    <?php endif; ?>
                    <input type='hidden' name='product_id' value='<?php echo $row['id']?>'>
                </div>
                </form>
            </div>
        </div>
        <?php
        }
    ?>
    </div>
</div>

</body>

</html>