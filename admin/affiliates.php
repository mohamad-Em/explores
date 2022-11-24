<?php
    session_start();
    include "connect.php";
    include "includes/templates/header.html";
    require 'includes/functions/function.php';
?>
    <link rel="stylesheet" href="layout/css/styling-forms.css">
<?php
    include "includes/templates/navbar.html";
    $control = isset($_GET['control']) ? $_GET['control'] : 'pending';
    if($control == 'pending') {
        $toReply = 3;
        $stmt = affiliate_toReply($toReply);
        ?>
        <div class="container">
            <div class="heading">
                <i class="fas fa-bars bar-menu" id="navbar-btn"></i>
                <a href="sign-out.php">sign out</a>
            </div>
            <div class="main-title">
                <h2>all affiliates</h2>
            </div>
            <a href="?control=Approved" class="btn btn-primary">approved affiliates</a>
            <a href="?control=unApproved" class="btn btn-info">unapproved affiliates</a><br>
            <span class="fs-2">all pending affiliates requests:</span>
            <?php if ($stmt->rowCount() > 0) { ?>
                <div class="table-responsive">
                    <table class="table table-hover text-center">
                        <thead class="table-dark">
                            <th>#</th>
                            <th class="col-4">affiliate reason</th>
                            <th>user name</th>
                            <th>user email</th>
                            <th>CV PDF</th>
                            <th>request date</th>
                            <th>controls</th>
                        </thead>
                        <tbody>
                           <?php
                           $counter = 0;
                            while ($row = $stmt->fetch()) {
                               $counter++;
                               ?>
                                <tr>
                                    <td><?php echo $counter ?></td>
                                    <td><?php echo  $row['affiliationReason']?></td>
                                    <td><?php echo $row['userName'] ?></td>
                                    <td><?php echo $row['userEmail'] ?></td>
                                    <td><a href="<?php echo $row['attachCV'] ?>" class="btn btn-info">view</a></td>
                                    <td><?php echo $row['orderDate']?></td>
                                    <td>
                                        <a href="?control=approve&userID=<?php echo $row['userID'] ?>" class="btn btn-primary mb-1">approve</a>
                                        <a href="?control=unapprove&userID=<?php echo $row['userID'] ?>"class="btn btn-danger">unapprove</a>
                                    </td>
                                </tr>

                            <?php 
                           }
                           ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
        </div>
    <?php
    } elseif($control == 'unApproved') {
        $toReply = 1;
        $stmt = affiliate_toReply($toReply);
        ?>
        <div class="container">
            <div class="heading">
            <i class="fas fa-bars bar-menu" id="navbar-btn"></i>
            <a href="sign-out.php">sign out</a>
            </div>
            <div class="main-title">
                <h2>all affiliates</h2>
            </div>
            <a href="?control=pending" class="btn btn-primary mb-2">pending affiliates</a><br>
            <span class="fs-2">all unapproved affiliates requests:</span>
            <?php if ($stmt->rowCount() > 0) { ?>
                <div class="table-responsive">
                    <table class="table table-hover text-center">
                        <thead class="table-dark">
                            <th>#</th>
                            <th class="col-4">affiliate reason</th>
                            <th>user name</th>
                            <th>user email</th>
                            <th>CV PDF</th>
                            <th>request date</th>
                            <th>request states</th>
                            <th>controls</th>
                        </thead>
                        <tbody>
                           <?php
                           $counter = 0;
                            while ($row = $stmt->fetch()) {
                               $counter++;
                               ?>
                                <tr>
                                    <td><?php echo $counter ?></td>
                                    <td><?php echo  $row['affiliationReason']?></td>
                                    <td><?php echo $row['userName'] ?></td>
                                    <td><?php echo $row['userEmail'] ?></td>
                                    <td><a href="<?php echo '../attachFiles/' . $row['attachCV'] ?>" class="btn btn-info">view</a></td>
                                    <td><?php echo $row['orderDate']?></td>
                                    <td>unApproved</td>
                                    <td>
                                        <a href="?control=delete&AffiliateID=<?php echo $row['AffiliateID'] ?>&attachCV=<?php echo $row['attachCV']?>"class="btn btn-danger">delete</a>
                                    </td>
                                </tr>

                            <?php 
                           }
                           ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
        </div>
    <?php
    } elseif($control == 'Approved') {
        $toReply = 2;
        $stmt = affiliate_toReply($toReply);
        ?>
        <div class="container">
            <div class="heading">
            <i class="fas fa-bars bar-menu" id="navbar-btn"></i>
            <a href="sign-out.php">sign out</a>
            </div>
            <div class="main-title">
                <h2>all affiliates</h2>
            </div>
            <a href="?control=pending" class="btn btn-primary mb-2">pending affiliates</a><br>
            <span class="fs-2">all approved affiliates requests:</span>
            <?php if ($stmt->rowCount() > 0) { ?>
                <div class="table-responsive">
                    <table class="table table-hover text-center">
                        <thead class="table-dark">
                            <th>#</th>
                            <th class="col-4">affiliate reason</th>
                            <th>user name</th>
                            <th>user email</th>
                            <th>CV PDF</th>
                            <th>request date</th>
                            <th>request states</th>
                            <th>controls</th>
                        </thead>
                        <tbody>
                           <?php
                           $counter = 0;
                            while ($row = $stmt->fetch()) {
                               $counter++;
                               ?>
                                <tr>
                                    <td><?php echo $counter ?></td>
                                    <td><?php echo  $row['affiliationReason']?></td>
                                    <td><?php echo $row['userName'] ?></td>
                                    <td><?php echo $row['userEmail'] ?></td>
                                    <td><a href="<?php echo '../attachFiles/' . $row['attachCV'] ?>" class="btn btn-info">view</a></td>
                                    <td><?php echo $row['orderDate']?></td>
                                    <td>approved</td>
                                    <td>
                                        <a href="?control=delete&AffiliateID=<?php echo $row['AffiliateID'] ?>&attachCV=<?php echo $row['attachCV']?>"class="btn btn-danger">delete</a>
                                    </td>
                                </tr>

                            <?php 
                           }
                           ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
        </div>
    <?php
    } elseif($control == 'approve') {
        $userID = $_GET['userID'];
        $toReply = 2;
        $userType = 2;
        if (affiliate_userType($userID,$toReply, $userType) >= 1) {
            header('REFRESH:0;URL=affiliates.php');
        }
    } elseif($control == 'unapprove') {
        $userID = $_GET['userID'];
        $toReply = 1;
        $userType = 3;
        if (affiliate_userType($userID,$toReply, $userType) >= 1) {
            header('REFRESH:0;URL=affiliates.php');
        }
    } elseif($control == 'delete') {
        $AffiliateID = intval($_GET['AffiliateID']);
        $attachCV = strval($_GET['attachCV']);

        if (affiliate_delete($AffiliateID) == 1) {

            if (file_exists('../attachFiles/' . $attachCV)) {
                unlink('../attachFiles/' . $attachCV);
            }

            header('REFRESH:0;URL=affiliates.php');
        }
    }
?>
    
<?php
    include "includes/templates/footer.html";
?>