<?php

session_start();

include ('../db_connect.php');
//get the purchase history table of the current user
$sql = "SELECT * FROM purchase WHERE user_id = {$_SESSION["user_id"]}";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<?php include('../templates/navbar.php') ?>
<!-- my own style sheet --> 
<link rel="stylesheet" type="text/css" href="/styles.css">

<style>
    body {
        background-color: white;
    }
</style>

<table>
    <tr>
        <th>Purchase date</th>
        <th>Total price</th>
    </tr>
    <?php 
    while ($row = mysqli_fetch_assoc($result)){ //while loop through purchases?>
    <tr>
        <td><?php echo $row['date'] ?></td>
        <td>$<?php echo number_format($row['total'],2) ?></td>
    </tr>
    <?php } ?>
</table>
    
</body>
</html>