<?php

use myPHPnotes\Microsoft\Auth;
use myPHPnotes\Microsoft\Handlers\Session;
use myPHPnotes\Microsoft\Models\User;

session_start();
require "../vendor/autoload.php";
$auth = new Auth(Session::get("tenant_id"), Session::get("client_id"), Session::get("client_secret"), Session::get("redirect_uri"), Session::get("scopes"));
$tokens = $auth->getToken($_REQUEST['code']);
$accessToken = $tokens->access_token;
$auth->setAccessToken($accessToken);
$user = new User;
$_SESSION['access_token'] = $accessToken;
$_SESSION['username'] = $user->data->getDisplayName();
$_SESSION['email'] = $user->data->getUserPrincipalName();

require("../includes/conn.php");
// check if user exists in users table, if not, dont insert but set user_type to 0
$sql = "SELECT * FROM msauth WHERE email='" . $_SESSION['email'] . "'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
  // user exists
  $row = mysqli_fetch_assoc($result);
  $_SESSION['user_type'] = $row['user_type'];
} else {
  // user does not exist
  $_SESSION['user_type'] = "local";
}

header("Location: ../index.php?page=home");
