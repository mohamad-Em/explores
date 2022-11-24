<?php
    session_start();
    include "connect.php";
    include "includes/templates/header.html";
    require 'includes/functions/function.php';
    
    include "includes/templates/navbar.html";
    $control = isset($_GET['control']) ? $_GET['control'] : 'active';
    if($control == 'active') {
        $activity_status_1 = 2;
        $stmt_1 = activityschedule_activity_status($activity_status_1);
        ?>
        <div class="container">
            <div class="heading">
                <i class="fas fa-bars bar-menu" id="navbar-btn"></i>
                <a href="sign-out.php">sign out</a>
            </div>

            <div class="main-title">
                <h2>all added activities</h2>
            </div>

            <a href="?control=inActive" class="btn btn-primary">inActive activities</a>

            <div class="card-container">
                <?php 
                if ($stmt_1->rowCount() > 0) {
                    while ($row_1 = $stmt_1->fetch()) {
                        $picture = photos_ActivityID($row_1['ActivityID'], 1);
                        if (strlen($row_1['activityDescription']) > 80) {
                            $activityDescription = substr($row_1['activityDescription'], 0, 80) . '...';
                        } else {
                            $activityDescription = $row_1['activityDescription'];
                        }
                        ?>
                        <div class="blog-card">
                            <div class="image"> 
                                <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($picture) ?>" alt="">
                            </div>
                            <div class="details">
                                <h4><?php echo $row_1['activityPlace'] ?></h4>
                                <span><?php echo $row_1['Activity_start_date'] ?></span>
                                <p>
                                    <?php echo $activityDescription ?>
                                </p>
                                <a href="?control=view&ActivityID=<?php echo $row_1['ActivityID'] ?>" class="text-danger">read full blog</a>
                            </div>
                        </div>
                    <?php
                    }
                }
                ?>
            </div>
        </div>
    <?php
    } elseif($control == 'inActive') {
        $activity_status_1 = 1;
        $stmt_1 = activityschedule_activity_status($activity_status_1);
        ?>
        <div class="container">
            <div class="heading">
                <i class="fas fa-bars bar-menu" id="navbar-btn"></i>
                <a href="sign-out.php">sign out</a>
            </div>

            <div class="main-title">
                <h2>all added activities</h2>
            </div>

            <a href="?control=active" class="btn btn-primary">active activities</a>

            <div class="card-container">
            <?php 
                if ($stmt_1->rowCount() > 0) {
                    while ($row_1 = $stmt_1->fetch()) {
                        $picture = photos_ActivityID($row_1['ActivityID'], 1);
                        if (strlen($row_1['activityDescription']) > 80) {
                            $activityDescription = substr($row_1['activityDescription'], 0, 80) . '...';
                        } else {
                            $activityDescription = $row_1['activityDescription'];
                        }
                        ?>
                        <div class="blog-card">
                            <div class="image"> 
                                <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($picture) ?>" alt="">
                            </div>
                            <div class="details">
                                <h4><?php echo $row_1['activityPlace'] ?></h4>
                                <span><?php echo $row_1['Activity_start_date'] ?></span>
                                <p>
                                    <?php echo $activityDescription ?>
                                </p>
                                <div class="ctrl">
                                    <a href="?control=view&ActivityID=<?php echo $row_1['ActivityID'] ?>" class="text-danger">read full blog</a>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                }
                ?>
            </div>
        </div>
    <?php
    } elseif($control == 'view') {
        $ActivityID = $_GET['ActivityID'];
        $stmt_photos = photos_ActivityID($ActivityID, "*");
        $stmt = activityschedule_ActivityID($ActivityID);
        $row = $stmt->fetch();
        $ratingStatus = 2;
        $stmt_rating = rating_ActivityID($ActivityID, $ratingStatus);

        if ($row['activity_status'] == 1) {
            $activity_status = 'active';
        } elseif ($row['activity_status'] == 2) {
            $activity_status = 'Inactive';
        }

        if ($row['severity_level'] == 3) {
            $severity_level = 'not dangerous';
        } elseif ($row['severity_level'] == 2) {
            $severity_level = 'moderate risk';
        } elseif ($row['severity_level'] == 1) {
            $severity_level = 'dangerous';
        }

        if ($row['activityschedule_gender'] == 1) {
            $activityschedule_gender = "Male";
        } elseif ($row['activityschedule_gender'] == 2) {
            $activityschedule_gender = "Female";
        } elseif ($row['activityschedule_gender'] == null) {
            $activityschedule_gender = "both genders";
        }

        if ($row['activityschedule_Health_status'] == 1) {
            $activityschedule_Health_status = "Excellent";
        } elseif ($row['activityschedule_Health_status'] == 2) {
            $activityschedule_Health_status = "good";
        } elseif ($row['activityschedule_Health_status'] == 3) {
            $activityschedule_Health_status = "bad";
        }

        if ($row['activityschedule_physical_state'] == 1) {
            $activityschedule_physical_state = "Excellent";
        } elseif ($row['activityschedule_physical_state'] == 2) {
            $activityschedule_physical_state = "good";
        } elseif ($row['activityschedule_physical_state'] == 3) {
            $activityschedule_physical_state = "bad";
        }
        $dateNow = date("Y-m-d");
        if($dateNow >= $row['Registration_expiration_date'] ) {
            $endMessage = "<div class='alert alert-info text-center'>Registration for this activity is closed due to the expiry date of registration</div>";
        } else {
            $endMessage = '';
        }
        $COUNT = activityschedule_reservation($ActivityID);
        if($COUNT >= $row['presence']) {
            $endMessageCount = "<div class='alert alert-info text-center'>Registration for this activity is closed due to overbooked seats</div>";
        } else {
            $endMessageCount = '';
        }
        ?>
        <div class="container">
            <div class="heading">
                <i class="fas fa-bars bar-menu" id="navbar-btn"></i>
                <a href="sign-out.php">sign out</a>
            </div>
            <div class="main-title">
                <h2>activity title details</h2>
            </div>
            <?php
                if($row['activity_status'] == '2') {
                    ?>
                    <a href="?control=deactivite&activityID=<?php echo $ActivityID; ?>" class="btn btn-primary">deactivite</a>
                    <?php 
                } else {
                    ?>
                    <a href="?control=activite&activityID=<?php echo $ActivityID; ?>" class="btn btn-primary">activite</a>
                    <?php 
                }
            ?>
            <div class="blog-container">
                <?php echo $endMessage; ?>
                <?php echo $endMessageCount; ?>
                <div class="blog-header">
                    <div class="blog-maker">
                        <div class="image">
                            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['userPic']) ?>" alt="">
                        </div>
                        <div class="name">
                            <?php echo $row['userName'] ?>
                        </div>
                    </div>
                    <?php 
                    if ($stmt_photos->rowCount() > 0) {
                        ?>
                        <div class="carousel-images" data-carousel>
                            <button class="carousel-button prev"  data-carousel-button="prev">&#8656</button>
                            <button class="carousel-button next"  data-carousel-button="next">&#8658</button>
                            <ul data-slides>
                                <?php 
                                $picture = photos_ActivityID($ActivityID, 1);
                                ?>
                                <li class="slide" data-active>
                                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($picture)?>" alt="">
                                </li>
                                <?php
                                while ($row_photos = $stmt_photos->fetch()) {
                                    ?>
                                    <li class="slide">
                                        <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row_photos['picture'])?>" alt="">
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="blog-counts">
                    <?php if ($stmt_rating->rowCount() > 0) { 
                        ?>
                        <span>
                            <i class="fas fa-comment" aria-hidden="true"></i> 
                            <?php echo $stmt_rating->rowCount() ?> ratings 
                        </span> 
                    <?php }
                    ?>
                </div>
                <div class="blog-details">
                   <div class="blog-details-con">
                        <p>
                            <?php echo $row['activityDescription'] ?>
                        </p>
                        <h5>blog details: </h5>
                        <ul class="blog-list-info">
                            <li><span>location: </span><?php echo $row['activityPlace'] ?></li>
                            <li><span>registration Cost: </span><?php echo $row['registrationCost'] ?></li>
                            <li><span>activity Supplies: </span><?php echo $row['activitySupplies'] ?></li>
                            <li><span>Weighing activity supplies: </span><?php echo $row['Weighing_activity_supplies'] . ' KG' ?></li>
                            <li><span>Activity start date: </span><?php echo $row['Activity_start_date'] ?></li>
                            <li><span>Activity end date: </span><?php echo $row['Activity_end_date'] ?></li>
                            <li><span>presence: </span><?php echo $row['presence'] ?></li>
                            <li><span>note: </span><?php echo $row['note']  ?></li>
                        </ul>
                        <h5>Activity Terms: </h5>
                        <ul class="blog-list-info">
                            <li><span>Registration start date: </span><?php echo  $row['Registration_start_date'] ?></li>
                            <li><span>Registration end date: </span><?php echo $row['Registration_expiration_date'] ?></li>
                            <li><span>gender: </span><?php echo $activityschedule_gender ?></li>
                            <li><span>health state: </span><?php echo  $activityschedule_Health_status ?></li>
                            <li><span>physical state: </span><?php echo $activityschedule_physical_state ?></li>
                            <li><span>specific age: </span><?php echo $row['specific_age'] . " and above" ?></li>
                            <li><span>severity level: </span><?php echo $severity_level ?></li>
                        </ul>
                   </div>
                </div>
                <div class="main-title">
                    <h2>all ratings</h2>
                </div>
                <div class="blog-comments">
                    <div class="comments-container">
                        <?php if ($stmt_rating->rowCount() > 0) { 
                             while ($row_rating = $stmt_rating->fetch()) {
                            ?>
                            <div class="comment">
                                <div class="comment-header">
                                    <div class="image">
                                        <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row_rating['userPic']) ?>" alt="">
                                    </div>
                                    <div class="info">
                                        <div class="name"><?php echo $row_rating['userName'] ?></div>
                                        <div class="date"><i class="fas fa-calendar"></i><?php echo $row_rating['ratingDate'] ?></div>
                                    </div>
                                </div>
                                <div class="comment-details">
                                    <?php  echo $row_rating['evaluation'] ?>
                                </div>
                            </div>
                        <?php 
                             }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    <?php
    } elseif ($control == 'activite') {
        $ActivityID = intval($_GET['activityID']);
        $activity_status = 2;
        if (activityschedule_userStatus($ActivityID, $activity_status) == 1) {
            header('REFRESH:0;URL=?control=view&ActivityID=' . $ActivityID);
        }
    }  elseif ($control == 'deactivite') {
        $ActivityID = intval($_GET['activityID']);
        $activity_status = 1;
        if (activityschedule_userStatus($ActivityID, $activity_status) == 1) {
            header('REFRESH:0;URL=?control=view&ActivityID=' . $ActivityID);
        }
    }

    include "includes/templates/footer.html";
?>