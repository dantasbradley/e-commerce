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

//these errors will show up below each input
$errors = array(
  'product' => '',
  'price' => '',
  'image' => ''
);
$product = '';
$price = '';
if (isset($_POST['submit'])) {
  if (empty($_POST["product"])) { //input can't be empty
    $errors['product'] = "The product name is required";
  }
  else{ //input has to be letters and spaces
    $product = $_POST["product"];
    if (!preg_match("/^([a-zA-Z])+([a-zA-Z\s]+)?/", $_POST["product"])) {
      $errors['product'] = "The product name must start with a letter and contain only letters and spaces";
    }
  }

  if (empty($_POST["price"])) { //input can't be empty
    $errors['price'] = "The price is required";
  }
  else{ //input has to be number followed by decimal point and two more numbers
    $price = $_POST["price"];
    if ( ! preg_match("/[0-9]+\.[0-9]{2}/", $_POST["price"])) {
      $errors['price'] = "The price must contain number(s) followed by a decimal point and two more numbers";
    }
  }


  $file = $_FILES['image'];
  // File properties
  $file_name = $_FILES['image']['name'];
  $file_tmp = $_FILES['image']['tmp_name'];
  $file_size = $_FILES['image']['size'];
  $file_error = $_FILES['image']['error'];

  // Check for any file upload errors
  if ($file_error === 0) {
    $directory = "../images/";
    $path = $directory . $file_name;

    if(file_exists($path)){ //error if file exists already
      $errors['image'] = 'Image file has been used already';
    }
    
  } else { //error if you don't upload the file
    $errors['image'] = 'The image file is required';
  }
  

  //If everything successfull then upload and add to database
  if ($errors['product']=='' && $errors['price']=='' && $errors['image']==''){
    if (move_uploaded_file($file_tmp, $path)) {
      include ('../db_connect.php');
      $sql = "INSERT INTO product(name,price,image) VALUES('$product', $price, '$file_name')";
      //save to db and check
      if (mysqli_query($conn, $sql)){
          //success
      }
      else{
          echo 'query error: ' . mysqli_error($conn);
      }
      $product = '';
      $price = '';
      echo "<script>alertSuccess('Product has been added!')</script>";
    } else {
      // Failed to move the uploaded file
      echo "<script>alertFail('Failed to move the uploaded file')</script>";
    }
  }
  
}
?>




<!DOCTYPE html>
<?php
include('../templates/admin-navbar.php') 
?>


  <div class="container mt-4 card">
    <h1 class="text-center mt-2">Insert a product</h1>
    <form action="insert.php" method="POST" enctype="multipart/form-data">
      <div class="mb-3">
        <label>Product Name:</label>
        <input class="form-control" type="text" name="product" value="<?php echo $product;?>">
        <div class="text-danger"><?php echo $errors['product']; ?></div>
      </div>
      <div class="mb-3">
        <label>Product Price:</label>
        <input class="form-control" type="text" name="price" value="<?php echo $price; ?>">
        <div class="text-danger"><?php echo $errors['price']; ?></div>
      </div>
      <div class="mb-3">
        <input type="file" name="image" accept="image/*">
        <div class="text-danger"><?php echo $errors['image']; ?></div>
      </div>
      <button name="submit" type="submit" class="btn btn-primary mb-2">Submit</button>
    </form>
  </div>


</body>
</html>