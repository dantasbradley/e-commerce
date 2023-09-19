<?php 
session_start();
?>

<html>
    <!--swal.fire alert: allows for better looking alerts-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
    <script src="/alert.js"></script>
</html>

<?php
//unset($_SESSION['c']);
if(isset($_SESSION['c'])){
    //gets the id of the products in the cart session
    $item_array_id = array_column($_SESSION['c'],"product_id");
}
$id_to_quantity;
$id_to_key;
if(isset($_SESSION['c'])){
    foreach ($_SESSION['c'] as $key => $value){
        //from product id to the amount you want to purchase
        $id_to_quantity[$value["product_id"]] = $value["quantity"];
        //from the product id to the key of the cart
        $id_to_key[$value["product_id"]] = $key;
    }
}

//this function will display the product and its info in a html card
function cartElement($product_name, $product_price, $product_image, $product_id, $id_to_quantity){
    $quantity = $id_to_quantity[$product_id];
    $money = number_format($product_price,2);
    $minusLine = "";
    if ($quantity == 1){
        $minusLine = "";
    }
    else{
        $minusLine = "<div><button name=\"minus\" type=\"submit\" class=\"btn bg-light border rounded-circle\"><i class=\"fas fa-minus\"></i></button></div>";
    }
    $element = "
    <form action=\"cart.php?action=remove&id=$product_id cart.php?action=plus&id=$product_id cart.php?action=minus&id=$product_id cart.php?action=inputQuantity&id=$product_id\" method=\"post\" class=\"cart-items\">
        <div class=\"border rounded\">
            <div class=\"row bg-white\">
                <div class=\"col-md-3 pl-0\">
                    <img src=../images/$product_image alt=\"\" class=\"img-fluid\">
                </div>
                <div class=\"col-md-6\">
                    <h5 class=\"pt-2\">$product_name</h5>
                    <small class=\"text-secondary\"> Seller: me</small>
                    <h5 class=\"pt-2\"> $$money </h5>
                    <button type=\"update\" class=\"btn btn-warning\">Update Quantity</button>
                    <button type=\"submit\" class=\"btn btn-danger mx-2\" name=\"remove\">Remove</button>
                </div>
                <div class=\"col-md-3 container\">
                    <div>
                        <div><button name=\"plus\" type=\"submit\" class=\"btn bg-light border rounded-circle\"><i class=\"fas fa-plus\"></i></button></div>
                        <div><input type=\"text\" value=\"$quantity\" name=\"inputQuantity\" class=\"form-control d-inline\"style=\"width: 50%\"></div>
                        $minusLine
                    </div>
                </div>
            </div>
        </div>
    </form>
    ";
    echo $element;
}

include ('../db_connect.php');
//get the product table which contains all the products
$sql = 'SELECT name, price, image, id FROM product ORDER BY id';
$result = mysqli_query($conn, $sql);



if(isset($_POST['inputQuantity'])){
    //session has arrays containing id and quantity
    //find the key that contains the array of id and quantity
    $key = $id_to_key[$_GET['id']];
    if ($_POST['inputQuantity'] < 1){//if they input invalid quantity
        echo "<script>alertFail('Quantity number needs to be more than 0')</script>";
    }
    else{//for valid quantity
        //update the quantity number
        $_SESSION['c'][$key]['quantity'] = $_POST['inputQuantity'];
        //refresh
        echo '<script>window.location.href = window.location.href;</script>';
        //header("Location: " . $_SERVER['REQUEST_URI']);
    }

}
if(isset($_POST['plus'])){ //plus button
    //session has arrays containing id and quantity
    //find the key that contains the array of id and quantity
    $key = $id_to_key[$_GET['id']];
    //add to the quantity at that location
    $_SESSION['c'][$key]['quantity']++;
    //refresh
    echo '<script>window.location.href = window.location.href;</script>';

}
if(isset($_POST['minus'])){ //minus button
    //session has arrays containing id and quantity
    //find the key that contains the array of id and quantity
    $key = $id_to_key[$_GET['id']];
    //add to the quantity at that location
    $_SESSION['c'][$key]['quantity']--;
    //refresh
    echo '<script>window.location.href = window.location.href;</script>';
}
if(isset($_POST['purchase'])){ //purchase button
    $total = $_GET['total'];
    $id = $_SESSION["user_id"];
    //insert the total price and user id into the purchase history table
    $sql = "INSERT INTO purchase(user_id,total) VALUES($id, $total)";
    //save to db and check
    if (mysqli_query($conn, $sql)){
        //success
    }
    else{
        echo 'query error: ' . mysqli_error($conn);
    }
    //reset cart session
    unset($_SESSION['c']);
    //success alert
    echo "<script>alertSuccess('Purchase successful')</script>";
}
if(isset($_POST['remove'])){ //remove button
    if($_GET['action'] == 'remove'){
        foreach ($_SESSION['c'] as $key => $value){ //go through the cart session
            if($value["product_id"] == $_GET['id']){ //if the pressed id matches with this cart key
                //delete this cart key
                unset($_SESSION['c'][$key]);
                if (count($_SESSION['c'])<1){
                    //delete cart session
                    unset($_SESSION['c']);
                }
                //refresh
                echo '<script>window.location.href = window.location.href;</script>';
                print_r($_SESSION['c']);
            }
        }
    }
}

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
    .shopping-cart{
        padding: 3% 0;
    }
    .container{
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

</style>

    <div class="container" style="width: 65%">
        <h2>Shopping Cart</h2>
    </div>

<div class="container-fluid">
    <div class="row px-5">
        <div class="col-md-7">
            <div class="shopping-cart">
                <h6>My Cart</h6>
                <hr>
                <?php
                $total = 0; //start with 0
                if(isset($_SESSION['c'])){ //if there is items in cart
                    while ($row = mysqli_fetch_assoc($result)){ //loop through products in the database table
                        foreach ($item_array_id as $id){
                            //if there is an id from the cart id array
                            if($row['id'] == $id){
                                //display the products
                                cartElement($row['name'], $row['price'], $row['image'], $row['id'], $id_to_quantity);
                                $quantity = $id_to_quantity[$row['id']];
                                //add to total
                                $total = $total + $row['price']*$quantity;
                            }
                        }
                    }
                }
                else{ //no items in cart
                    echo "<h5>Cart is Empty</h5>";
                }
                
                
                ?>
                <!-- <form action="cart.php" method="get" class="cart-items">
                    <div class="border rounded">
                        <div class="row bg-white">
                            <div class="col-md-3 pl-0">
                                <img src="" alt="" class="img-fluid">
                            </div>
                            <div class="col-md-6">
                                <h5 class="pt-2">Product1</h5>
                                <small class="text-secondary"> Seller: me</small>
                                <h5 class="pt-2"> $599 </h5>
                                <button type="submit" class="btn btn-danger mx-2" name="remove">Remove</button>
                            </div>
                            <div class="col-md-3 container">
                                <div>
                                   <div><button type="button" class="btn bg-light border rounded-circle"><i class="fas fa-plus"></i></button></div>
                                    <div><input type="text" value="1" class="form-control d-inline" style="width: 50%"></div>
                                    <div><button type="button" class="btn bg-light border rounded-circle"><i class="fas fa-minus"></i></button></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form> -->
            </div>
        </div>
        <div class="col-md-4 offset-md-1 border rounded mt-5 bg-white h-25">
            <div class="pt-4">
                <h6>Price Details</h6>
                <hr>
                <div class="row price-details">
                    <div class="col-md-6">
                        <?php
                        if(isset($_SESSION['c'])){ //if there is items in cart
                            $count = count($_SESSION['c']);
                            //display count
                            echo "<h6>Price ($count product(s))</h6>";
                        }else{//if no items in cart
                            //display 0
                            echo "<h6>Price (0 items)</h6>";
                        }
                        ?>
                    </div>
                    <div class="col-md-6">
                        <h6>$<?php echo number_format($total,2) //display total price?></h6>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?php
if(isset($_SESSION['admin'])){ //if it's admin then you can't buy?>
    <div class="container">
        <button class="btn btn-info disabled"> Purchase(admin can't buy) </button>
    </div>
<?php
}else if(isset($_SESSION['c'])){ //if there is items in cart and not admin then you can buy?>
    <div class="container">
        <form action="cart.php?action=purchase&total=<?php echo $total?>" method="post" class="cart-items">
            <button name="purchase" type="submit" class="btn btn-info"> Purchase </button>
        </form>
    </div>
<?php 
}else{ //no items in cart so you can't buy?>
    <div class="container">
        <button class="btn btn-info disabled"> Purchase(need items) </button>
    </div>
<?php 
} ?>


</body>

</html>


