<?php

session_start();

if ($_SESSION['userType'] == 1) {
    header('location:manage-users.php');
    exit();
} elseif ($_SESSION['userType'] == 2) {
    header('location:../superVisor/manage-activities.php');
} elseif ($_SESSION['userType'] == 3) {
    header('location:../website/activities.php');
}
