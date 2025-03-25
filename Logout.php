<?php

session_start();
session_unset();
session_destroy();
header("location: /handphonestore/index.php");
exit();
?>