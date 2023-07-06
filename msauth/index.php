<?php

session_start();

require("../vendor/autoload.php");

use App\Classes\User;
use myPHPnotes\Microsoft\Auth;

$tenant = "common";
$client_secret = "2Gk8Q~1z3tYbuRRisCiIsI1Rz3jkemTi6dHF9ctw";
$callback = "http://localhost/bud/msauth/callback.php";
$client_id = "670a6b86-37e5-4351-bacf-5c3284ca30b0";
$scopes = ["User.Read"];


$microsoft = new Auth($tenant, $client_id, $client_secret, $callback, $scopes);

header("Location: " . $microsoft->getAuthUrl());