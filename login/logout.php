<?php
session_start();
session_destroy();
//this session_destroy() destroys all sessions and we had the following:
//session containing the items in the cart,
//session saying if it's admin or not,
//session containing the current user

//then we head to home screen
header("Location: ../index.php");

exit;