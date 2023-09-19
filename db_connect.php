<?php 
    //DATABASE
    //database name: e-commerce_db
    //table names: "product" , "purchase" , "user"
    //PRODUCT
    //id int (primary)
    //name varchar 255
    //price int
    //image varchar 255
    //PURCHASE
    //purchase_id int (primary)
    //user_id int
    //total int
    //date timestamp
    //USER
    //id int (primary)
    //name varchar 255
    //email varchar 255 (unique)
    //password_hash varchar 255

    //connect to database
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "e-commerce_db";

    $conn = mysqli_connect($host, $username, $password, $dbname);

    //check connection
    if (!$conn){
        echo 'Connection error: ' . mysqli_connect_error();
    }
?>