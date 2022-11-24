<?php 
session_start();
ob_start();
require "includes/header.html";
require "functions.php";
require "connect.php";
?>
<link rel="stylesheet" href="layout/css/main.css">
<?php
require "includes/navbar.php";
$control = isset($_GET['control']) ? $_GET['control'] : 'myActivities';
if($control == 'myActivities') {
    $userID = $_SESSION['userID'];
    $stmt = reservationUser($userID, 2);
    ?>
    <div class="container">
        <div class="section-title">
            <h2 class="text-primary">all registered activities</h2>
            <a href="?control=myRequests" class="btn btn-primary">pending requests</a>
        </div>
        <?php
        if($stmt->rowCount() > 0) {
        ?>
        <div class="card-container">
            <?php 
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $ActivityID = $row['ActivityID'];
                $activity_pic = photos_ActivityID($ActivityID, 1);
                // get posts count for activity
                $sql_2 = 'SELECT * FROM activityschedule
                            INNER JOIN posts
                            ON activityschedule.ActivityID=posts.ActivityID
                            WHERE activityschedule.ActivityID=:ActivityID';
                $stmt_2 = $conn->prepare($sql_2);
                $stmt_2->execute([
                    ':ActivityID' => $ActivityID
                ]);
                $rowPost = $stmt_2->rowCount();
                $activityEndDate = $row['Registration_expiration_date'];
                ?>
                <div class="blog-card">
                    <div class="image"> 
                        <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($activity_pic)?>" alt="">
                    </div>
                    <div class="details">
                        <h4><?php echo $row['activityPlace'] ?></h4>
                        <p>
                            <?php 
                            if(strlen($row['activityDescription']) > 60) {
                                echo substr($row['activityDescription'], 0, 60) . ' .....';
                            } else {
                                echo $row['activityDescription'];
                            }
                            ?>
                        </p>
                        <div class="ctrl">
                            <a href="activities.php?control=viewActivity&ActivityID=<?php echo $ActivityID ?>" class="text-danger">read full blog</a>
                                <?php 
                                // echo date("Y-m-d");
                                // echo $activityEndDate;
                                if($activityEndDate > date("Y-m-d") ) {
                                    ?>
                                    <a href="?control=deleteRegister&ReservationID=<?php echo $row['ReservationID']?>" class="btn btn-danger">delete</a>
                                    <?php 
                                } else {
                                    ?>
                                    <span class="text-warning">you can't delete it</span>
                                    <?php
                                }
                                ?>
                            </span>
                        </div>
                    </div>
                </div>
                <?php 
            }
            ?>
        </div>
        <?php 
        } else {
            ?>
            <div class="alert alert-info">no any registered activities yet!</div>
            <?php
        }
        ?>
    </div>
    <?php
} elseif($control == 'myRequests') {
    $userID = $_SESSION['userID'];
    $stmt = reservationUser($userID, 1);
    ?>
    <div class="container">
        <div class="section-title">
            <h2 class="text-primary">all pending activities requests</h2>
            <a href="?control=myActivities" class="btn btn-primary">registered activities</a>
        </div>
        <?php 
        if($stmt->rowCount() > 0) {
        ?>
        <div class="table-responsive">
            <table class="table table-hover text-center" style="width: 60%; margin: 10px auto;">
                <thead class="table-dark">
                    <th>#</th>
                    <th>activity place</th>
                    <th>controls</th>
                </thead>
                <tbody>
                <?php 
                $counter = 1;
                $activityEndDate  = '';
                while ($row = $stmt->fetch()) {
                    $activityEndDate = $row['Registration_expiration_date'];
                    ?>
                    <tr>
                        <td><?php echo $counter++; ?></td>
                        <td><a href="activities.php?control=viewActivity&ActivityID=<?php echo $row['ActivityID'] ?>" class="text-primary"><?php echo $row['activityPlace'] ?></a> </td>
                        <td>
                        <?php 
                        if($activityEndDate > date("Y-m-d") ) {
                            ?>
                            <a href="?control=deleteRegister&ReservationID=<?php echo $row['ReservationID']?>" class="btn btn-danger">delete</a>
                            <?php 
                        } else {
                            ?>
                            <span class="text-warning">you can't delete it</span>
                            <?php
                        }
                        ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
        <?php 
        } else {
            ?>
            <div class="alert alert-info">no any pending requests</div>
            <?php
        }?>
    </div>
    <?php 
} elseif($control == 'deleteRegister') {
    if(deleteRegistration($_GET['ReservationID']) > 0 ) {
        header("location:?control=myActivities");
    }
}
require "includes/footer.html";
ob_end_flush();