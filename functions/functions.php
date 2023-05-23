<?php

// loggedin function and usertype function

function loggedin()
{
    if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
        return true;
    } else {
        return false;
    }
}

function usertype()
{
    if (isset($_SESSION['user_type']) && !empty($_SESSION['user_type'])) {
        return $_SESSION['user_type'];
    } else {
        return false;
    }
}


// check if superadmin

function is_super_admin()
{
    if (isset($_SESSION['user_type']) && !empty($_SESSION['user_type'])) {
        if ($_SESSION['user_type'] == "super_admin") {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function username(){
    if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
        return $_SESSION['username'];
    } else {
        return false;
    }
}

// if not admin, display error page

function superadmin_only()
{
    if (!is_super_admin()) {
        ?>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <h1>Access Denied !</h1>
                    <h2>This action requires you to be a superadmin</h2>
                </div>
            </div>
        </div>
        <?php
        exit();
    }
}

// if not logged in, display error page
function loggedin_only(){
    if (!loggedin()) {
        ?>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <h1>Access Denied !</h1>
                    <h2>This action requires you to be logged in</h2>
                </div>
            </div>
        </div>
        <?php
        exit();
    }
}