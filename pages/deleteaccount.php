<?php

require("./includes/conn.php");

if(!isset($_GET['id'])){
    header("Location: ?page=viewusers");
    exit();
}

$id = $_GET['id'];

$sql = "DELETE FROM msauth WHERE id='$id'";

mysqli_query($conn, $sql);

header("Location: ?page=viewusers&status=success");