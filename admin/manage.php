<?php
session_start();
?>
<html>
    <!--swal.fire alert: allows for better looking alerts-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script> -->
    <!-- <script src="/alert.js"></script> -->
</html>

<?php 

include ('../db_connect.php');
//need products to display them
$sql = 'SELECT name, price, image, id FROM product ORDER BY id';
$result = mysqli_query($conn, $sql);

$success = false;
if(isset($_POST['remove'])){ //when you press remove
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    //delete the product with the id pressed
    $sql = "DELETE FROM product WHERE id = $id";
    if(mysqli_query($conn, $sql)){
        //success removing from database

        //remove file from images
        $imageName = $_POST['image'];
        //echo $imageName;
        $file = "../images/$imageName"; // Specify the file path
        //echo $file;
        if (file_exists($file)) {
            if (unlink($file)) {
                //success removing file
                $success = true;
                
            } else {
                //unable to delete
            }
        } else {
            //file not found
        }
    } else {
        //failed
        echo 'query error: ' . mysqli_error($conn);
    }
    if ($success == true){ //if successful

        //refresh
        echo '<script>window.location.href = window.location.href;</script>';

    }


}
?>


<!DOCTYPE html>
<?php
include('../templates/admin-navbar.php') 
?>


<table>
    <tr>
        <th>Image</th>
        <th>Product</th>
        <th>Price</th>
        <th>Actions</th>
    </tr>

<!-- while loop to put products into the table -->
<?php 
    //make an array from the result
    while ($row = mysqli_fetch_assoc($result)){
    //then put each product info
    ?>
    <tr>
        <td>
            <img src="../images/<?php echo $row['image']?>" style="height: 70px;" alt="...">
            <div><?php echo $row['image']?></div>
        </td>
        <td>
            <?php echo $row['name']?>
        </td>
        <td>
            $<?php echo number_format($row['price'],2)?>
        </td>
        <td>
            <form action="manage.php" method="post">
                <input type="hidden" name="id" value="<?php echo $row['id']?>"> 
                <input type="hidden" name="image" value="<?php echo $row['image']?>"> 
                <input type="hidden" name="name" value="<?php echo $row['name']?>"> 
                <button type="submit" class="btn btn-danger mx-2" name="remove">Remove</button>
            </form>
        </td>
    </tr>
    <?php }
?>

<table>

    
</body>
</html>