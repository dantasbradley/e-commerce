<?php
session_start();

include ('../db_connect.php');
//need users because we going to display users
$sql = 'SELECT * FROM user ORDER BY id';
$result = mysqli_query($conn, $sql);

?>


<!DOCTYPE html>
<?php
include('../templates/admin-navbar.php') 
?>


<table>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Purchase History</th>
    </tr>

    <?php 
while ($row = mysqli_fetch_assoc($result)){ //this while loop is to display users
    //we getting the purchase history specific to this user
    $sql = "SELECT * FROM purchase WHERE user_id = {$row["id"]}";
    $resultHistory = mysqli_query($conn, $sql);
    //different ID for each accordion
    $accordionId = "accordion_" . $row['id'];
?>

    <tr>
        <td><?php echo $row['name'];?></td>
        <td><?php echo $row['email'];?></td>
<td>
        <div class="accordion" id="parent<?php echo $accordionId; ?>">
      <div class="accordion-item">
        <h2 class="accordion-header">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo $accordionId; ?>" aria-expanded="true" aria-controls="<?php echo $accordionId; ?>">
            Purchase History
        </button>
        </h2>
        <div id="<?php echo $accordionId; ?>" class="accordion-collapse collapse" data-bs-parent="#parent<?php echo $accordionId; ?>">
            <div class="accordion-body">
<table>
    <tr>
        <th>Purchase date</th>
        <th>Total price</th>
    </tr>
    <?php 
    while ($row = mysqli_fetch_assoc($resultHistory)){ //this while loop displays the purchase history of this user?>
    <tr>
        <td><?php echo $row['date'] ?></td>
        <td>$<?php echo number_format($row['total'],2) ?></td>
    </tr>
    <?php } //end of purchase history while loop?>
</table>
            </div>
        </div>
      </div>
    </div>
</td>

    </tr>
    <?php
} //end of users while loop
?>
</table>





    
    
</body>
</html>