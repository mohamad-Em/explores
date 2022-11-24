<?php
    session_start();
    include "connect.php";
    include "includes/templates/header.html";
    require 'includes/functions/function.php';
    include "includes/templates/navbar.html";

    $control = isset($_GET['control']) ? $_GET['control'] : 'main';
    if($control == 'main') { 
        $superStmt = $conn->prepare("SELECT `userID` FROM `users` WHERE `userType` = 2");
        $superStmt->execute();
        $superVisorsCount = $superStmt->rowCount();
        $userStmt = $conn->prepare("SELECT `userID` FROM `users` WHERE `userType` = 3");
        $userStmt->execute();
        $usersCount = $userStmt->rowCount();
        ?>
        <div class="container">
            <div class="heading">
                <i class="fas fa-bars bar-menu" id="navbar-btn"></i>
                <a href="sign-out.php">sign out</a>
            </div>
            <div class="main-title">
                <h2>overview obout the accounts:</h2>
            </div>
            <div class="counts-card-con mt-5">
                <a href="?control=manage&accountType=3" class="count-card">
                    <span>total users accounts</span>
                    <span class="count-num"><?php echo $usersCount ?></span>
                </a>
                <a href="?control=manage&accountType=2" class="count-card">
                    <span>total supervisor accounts</span>
                    <span class="count-num"><?php echo $superVisorsCount ?></span>
                </a>
            </div>
        </div>
        <?php
    }
    elseif($control == 'manage') { 
        $accountType = intval($_GET['accountType']);
        $stmt = users_userType($accountType);
        ?>
        <div class="container">
            <div class="heading">
                <i class="fas fa-bars bar-menu" id="navbar-btn"></i>
                <a href="sign-out.php">sign out</a>
            </div>
            <div class="main-title">
                <h2>manage users page:</h2>
            </div>

            <a href="?control=inActiveAccounts&accountType=<?php echo $accountType?>" class="btn btn-primary mb-2">inactive accounts</a><br>

            <span class="fs-2">all active accounts:</span>
            
            <div class="card-container">
                <?php
                if ($stmt->rowCount() > 0) { 
                    while ($row = $stmt->fetch()) {
                        if ($row['gender'] == 1) {
                            $gender = "Male";
                        } elseif ($row['gender'] == 2) {
                            $gender = "Female";
                        }
    
                        if ($row['Health_status'] == 1) {
                            $Health_status = "Excellent";
                        } elseif ($row['Health_status'] == 2) {
                            $Health_status = "good";
                        } elseif ($row['Health_status'] == 3) {
                            $Health_status = "bad";
                        }
    
                        if ($row['physical_state'] == 1) {
                            $physical_state = "Excellent";
                        } elseif ($row['physical_state'] == 2) {
                            $physical_state = "good";
                        } elseif ($row['physical_state'] == 3) {
                            $physical_state = "bad";
                        }
                        $birthDate = $row['birthDate'];
                        $age = date("Y") - date('Y', strtotime($birthDate));
                        if ($row['userStatus'] == 2) {
                            ?>
                            <div class="card-view">
                                <div class="image">
                                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['userPic']) ?>" alt="">
                                </div>
                                <div class="content">
                                    <div class="content-column">name: <span><?php echo $row['userName'] ?></span></div>
                                    <div class="content-column">full name:<span><?php echo $row['userFullname'] ?></span></div>
                                    <div class="content-column">email: <span><?php echo $row['userEmail'] ?></span></div>
                                    <div class="content-column">age: <span><?php echo $age; ?></span></div>
                                    <div class="content-column">gender: <span><?php echo $gender ?></span></div>
                                    <div class="content-column">health state: <span><?php echo $Health_status ?></span></div>
                                    <div class="content-column">physical state: <span><?php echo $physical_state ?></span></div>
                                </div>
                                <div class="controls">
                                    <a href="?control=inActive&userID=<?php echo $row['userID'] ?>" class="btn btn-danger">Deactivate</a>
                                </div>
                            </div>
                        <?php 
                        }
                    }
                }
                ?>
            </div>
        </div>
        <?php
    } elseif($control == 'inActiveAccounts') { 
        $accountType = intval($_GET['accountType']);
        $stmt = users_userType($accountType);
        ?>
          <div class="container">
            <div class="heading">
            <i class="fas fa-bars bar-menu" id="navbar-btn"></i>
            <a href="sign-out.php">sign out</a>
            </div>
            <div class="main-title">
                <h2>manage users page:</h2>
                <a href="?control=manage&accountType=<?php echo $accountType ?>" class="btn btn-primary mb-2">active accounts</a><br>
            </div>
            <span class="fs-2">all inactive accounts:</span>
            <div class="card-container">
            <?php
                if ($stmt->rowCount() > 0) { 
                    while ($row = $stmt->fetch()) {
                        if ($row['gender'] == 1) {
                            $gender = "Male";
                        } elseif ($row['gender'] == 2) {
                            $gender = "Female";
                        }
    
                        if ($row['Health_status'] == 1) {
                            $Health_status = "Excellent";
                        } elseif ($row['Health_status'] == 2) {
                            $Health_status = "good";
                        } elseif ($row['Health_status'] == 3) {
                            $Health_status = "bad";
                        }
    
                        if ($row['physical_state'] == 1) {
                            $physical_state = "Excellent";
                        } elseif ($row['physical_state'] == 2) {
                            $physical_state = "good";
                        } elseif ($row['physical_state'] == 3) {
                            $physical_state = "bad";
                        }
                        $birthDate = $row['birthDate'];
                        $age = date("Y") - date('Y', strtotime($birthDate));

                        if ($row['userStatus'] == 1) {
                            ?>
                            <div class="card-view">
                                <div class="image"><img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['userPic']) ?>" alt=""></div>
                                <div class="content">
                                    <div class="content-column">name: <span><?php echo $row['userName'] ?></span></div>
                                    <div class="content-column">full name:<span><?php echo $row['userFullname'] ?></span></div>
                                    <div class="content-column">email: <span><?php echo $row['userEmail'] ?></span></div>
                                    <div class="content-column">age: <span><?php echo $age; ?></span></div>
                                    <div class="content-column">gender: <span><?php echo $gender ?></span></div>
                                    <div class="content-column">health state: <span><?php echo $Health_status ?></span></div>
                                    <div class="content-column">physical state: <span><?php echo $physical_state ?></span></div>
                                </div>
                                <div class="controls">
                                    <a href="?control=active&userID=<?php echo $row['userID'] ?>" class="btn btn-danger">activite</a>
                                </div>
                            </div>
                        <?php 
                        }
                    }
                }
                ?>
            </div>
        </div>
        <?php
    } elseif($control == 'active') {
        $userID = intval($_GET['userID']);
        $userStatus = 2;
        if (users_userStatus($userID, $userStatus) == 1) {
            header('REFRESH:0;URL=manage-users.php');
        }
    } elseif($control == 'inActive') {
        $userID = intval($_GET['userID']);
        $userStatus = 1;
        if (users_userStatus($userID, $userStatus) == 1) {
            header('REFRESH:0;URL=manage-users.php');
        }
    }
    include "includes/templates/footer.html";
?>