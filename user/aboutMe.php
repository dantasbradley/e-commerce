<?php
session_start();
?>

<!DOCTYPE html>
<?php include('../templates/navbar.php') ?>
<style>
    .background-image {
        background-image: url('../images/background.jpeg');
        background-repeat: no-repeat;
        height: 100vh;
        background-size: cover;
    }

    .about{
        text-align: right;
        color: white;
        margin-right: 10px;
        font-size: 25px;
    }

</style>
    <div class="background-image">
        <div class="about">
            Developer: <br>
            Bradley Dantas <br>
            <br>
            Purpose: <br>
            Personal Project <br>
        </div>
    </div>
    
    
</body>
</html>