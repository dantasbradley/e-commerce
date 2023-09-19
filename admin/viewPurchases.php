<?php
session_start();

include ('../db_connect.php');
//purchase history table to display
$sql = 'SELECT * FROM purchase ORDER BY date ASC';
$result = mysqli_query($conn, $sql);

?>


<!DOCTYPE html>
<?php
include('../templates/admin-navbar.php') 
?>


<table>
    <tr>
        <th>Purchase date</th>
        <th>Total price</th>
        <th>Name</th>
        <th>Email</th>
    </tr>

    <?php 
while ($row = mysqli_fetch_assoc($result)){ //while loop to display the purchase history table
    $sql = "SELECT * FROM user WHERE id = {$row["user_id"]}";
    $resultUser = mysqli_query($conn, $sql);
    $user = $resultUser->fetch_assoc();
?>
    <tr>
        <td><?php echo $row['date'];?></td>
        <td>$<?php echo number_format($row['total'],2);?></td>
        <td><?php echo $user['name'];?></td>
        <td><?php echo $user['email'];?></td>
    </tr>
<?php } ?>
<table>






    
    
</body>
</html>