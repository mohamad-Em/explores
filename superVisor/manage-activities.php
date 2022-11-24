<?php
    session_start();
    include "connect.php";
    include "includes/templates/header.html";
    require 'includes/functions/function.php';
    ?>
    <link rel="stylesheet" href="layout/css/styling-forms.css">
    <?php
    include "includes/templates/navbar.html";
    $control = isset($_GET['control']) ? $_GET['control'] : 'active';
    if($control == 'active') {
        $stmt = viewActivity_userID($_SESSION['userID'], 2);
            ?>
            <div class="container">
                <div class="heading">
                    <i class="fas fa-bars bar-menu" id="navbar-btn"></i>
                    <a href="sign-out.php">sign out</a>
                </div>
                <div class="main-title">
                    <h2>all active activities</h2>
                    <a href="manage-activity.php?control=add-activity" class="btn btn-primary">add new activity</a>
                </div>
                <a href="?control=inActive" class="btn btn-primary">inactive activities</a>
                <?php 
                if ($stmt->rowCount() > 0) {
                    ?>
                    <div class="card-container">
                        <?php 
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $activity_pic = photos_ActivityID($row['ActivityID'], 1);
                        ?>
                            <div class="blog-card">
                                <div class="image"> 
                                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($activity_pic) ?>" alt="">
                                </div>
                                <div class="details">
                                    <h4><?php echo $row['activityPlace'] ?></h4>
                                    <span><?php echo $row['Activity_start_date'] ?></span>
                                    <p>
                                    <?php 
                                    if(strlen($row['activityDescription']) > 80) {
                                        echo substr($row['activityDescription'], 0, 80) . '...';
                                    } else {
                                        echo $row['activityDescription'];
                                    }
                                    ?>
                                    </p>
                                    <div class="ctrl">
                                        <a href="?control=view&activityID=<?php echo $row['ActivityID'] ?>" class="text-danger">read full blog</a>
                                    </div>
                                </div>
                            </div>
                        <?php 
                        }
                        ?>
                    </div>
            </div>
        <?php
        }
    } elseif($control == 'inActive') {
        $stmt = viewActivity_userID($_SESSION['userID'], 1);
            ?>
            <div class="container">
                <div class="heading">
                    <i class="fas fa-bars bar-menu" id="navbar-btn"></i>
                    <a href="sign-out.php">sign out</a>
                </div>
                <div class="main-title">
                    <h2>all inActive activities</h2>
                    <a href="manage-activity.php?control=add-activity" class="btn btn-primary">add new activity</a>
                </div>
                <a href="?control=active" class="btn btn-primary">active activities</a>
                <?php 
                if ($stmt->rowCount() > 0) {
                    ?>
                    <div class="card-container">
                        <?php 
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $activity_pic = photos_ActivityID($row['ActivityID'], 1);
                        ?>
                            <div class="blog-card">
                                <div class="image"> 
                                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($activity_pic) ?>" alt="">
                                </div>
                                <div class="details">
                                    <h4><?php echo $row['activityPlace'] ?></h4>
                                    <span><?php echo $row['Activity_start_date'] ?></span>
                                    <p>
                                    <?php 
                                    if(strlen($row['activityDescription']) > 80) {
                                        echo substr($row['activityDescription'], 0, 80) . '...';
                                    } else {
                                        echo $row['activityDescription'];
                                    }
                                    ?>
                                    </p>
                                    <div class="ctrl">
                                        <a href="?control=view&activityID=<?php echo $row['ActivityID'] ?>" class="text-danger">read full blog</a>
                                    </div>
                                </div>
                            </div>
                        <?php 
                        }
                        ?>
                    </div>
            </div>
        <?php
        }
    } elseif($control == 'view') {
        $activityID =  $_GET['activityID'];
        $stmt = Activity($activityID);
        $row = $stmt->fetch();
        $ratingStatus = 2;
        $stmt_rating = rating_ActivityID($activityID, $ratingStatus);

        if ($row['severity_level'] == 1) {
            $severity_level = 'not dangerous';
        } elseif ($row['severity_level'] == 2) {
            $severity_level = 'moderate risk';
        } elseif ($row['severity_level'] == 3) {
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
        ?>
        <div class="container">
            <div class="heading">
                <i class="fas fa-bars bar-menu" id="navbar-btn"></i>
                <a href="sign-out.php">sign out</a>
            </div>
            <div class="main-title">
                <h2>activity title details</h2>
                <a href="manage-activity.php?control=edit-activity&activityID=<?php echo $activityID ?>" class="btn btn-primary">edit data</a>
                <a href="?control=approved-registration&activityID=<?php echo $activityID ?>" class="btn btn-warning">all registration</a>
                <a href="?control=approved-posts&activityID=<?php echo $activityID ?>" class="btn btn-info">all posts</a>
                <a href="?control=approvedRating&activityID=<?php echo $activityID ?>" class="btn btn-secondary">all ratings</a>
                <a href="?control=add-pic&activityID=<?php echo $activityID ?>" class="btn btn-dark">add new picture</a>
            </div>
            <div class="blog-container">
                <div class="blog-header">
                    <div class="carousel-images" data-carousel>
                        <button class="carousel-button prev" data-carousel-button="prev">&#8656</button>
                        <button class="carousel-button next" data-carousel-button="next">&#8658</button>
                        <ul data-slides>
                            <?php 
                            $picture = photos_ActivityID($activityID, 1);
                            ?>
                            <li class="slide" data-active>
                                <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($picture)?>" alt="">
                            </li>
                            <?php
                            $stmt_photos = photos_ActivityID($activityID, "*");
                            while ($row_photos = $stmt_photos->fetch()) {
                                ?>
                                <li class="slide">
                                    <a class="product-delete-btn btn btn-danger" href="?control=delete-pic&activityID=<?php echo $activityID ?>&picID=<?php echo $row_photos['PhotoID'] ?>">delete</a>
                                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row_photos['picture'])?>" alt="">
                                </li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="blog-counts">
                    <?php if ($stmt_rating->rowCount() > 0) { 
                        ?>
                        <span>
                            <i class="fas fa-comment" aria-hidden="true"></i> 
                            <?php echo $stmt_rating->rowCount() ?> ratings 
                        </span> 
                    <?php } else {
                    }
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
                            <li><span>gender: </span> <?php echo $activityschedule_gender ?></li>
                            <li><span>health state: </span> <?php echo $activityschedule_Health_status ?></li>
                            <li><span>physical state: </span> <?php echo $activityschedule_physical_state ?></li>
                            <li><span>specific age: </span> <?php echo $row['specific_age'] . ' and above' ?></li>
                            <li><span>severity level: </span> <?php echo $severity_level ?></li>
                        </ul>
                   </div>
                </div>
            </div>
        </div>
        <?php
    } elseif($control == 'approved-registration') {
        $activityID = $_GET['activityID'];
        $stmt = viewUsers_($activityID, 2);
        ?>
        <div class="container">
            <div class="heading">
                <i class="fas fa-bars bar-menu" id="navbar-btn"></i>
                <a href="sign-out.php">sign out</a>
            </div>
            <div class="main-title">
                <h2>all approved registration requests</h2>
                <a href="?control=view&activityID=<?php echo $activityID ?>" class="btn btn-warning">activity page</a>
            </div>
            <a href="?control=unapproved-registration&activityID=<?php echo $activityID ?>"" class="btn btn-primary mb-2">unapproved requests</a>
            <div class="table-responsive">
                <table class="table table-hover text-center">
                    <thead class="table-dark">
                        <th>userName</th>
                        <th>userEmail</th>
                        <th>gender</th>
                        <th>Health_status</th>
                        <th>physical_state</th>
                        <th>reservationDate</th>
                        <th>Approved</th>
                    </thead>
                    <tbody>
                        <?php 
                        while ($row = $stmt->fetch()) {
                            ?>
                            <tr>
                                <td><?php echo $row['userName'] ?></td>
                                <td><?php echo $row['userEmail'] ?></td>
                                <td>
                                   <?php 
                                    if ($row['activityschedule_gender'] == 1) {
                                        if ($row['gender'] == 1) {
                                            echo 'yes';
                                        } else {
                                            echo 'no';
                                        }
                                    } elseif($row['activityschedule_gender'] == 3) {
                                        if ($row['gender'] == 1) {
                                            echo 'yes';
                                        } elseif($row['gender'] == 2) {
                                            echo 'yes';
                                        }
                                    }
                                   ?>
                                </td>
                                <td>
                                    <?php 
                                    if ($row['Health_status'] <= $row['activityschedule_Health_status']) {
                                        echo 'yes';
                                    } else {
                                        echo 'no';
                                    }
                                   ?>
                                </td>
                                <td>
                                <?php 
                                    if ($row['physical_state'] <= $row['activityschedule_physical_state']) {
                                        echo 'yes';
                                    } else {
                                        echo 'no';
                                    }
                                   ?>
                                </td>
                                <td>
                                    <?php echo $row['reservationDate'] ?>
                                </td>
                                <td>
                                    <div class="text-success">
                                        approved
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
    } elseif($control == 'unapproved-registration') {
        $activityID = $_GET['activityID'];
        $stmt = viewUsers_($activityID, 1);
        ?>
        <div class="container">
            <div class="heading">
                <i class="fas fa-bars bar-menu" id="navbar-btn"></i>
                <a href="sign-out.php">sign out</a>
            </div>
            <div class="main-title">
                <h2>all unapproved registration requests</h2>
            </div>
            <a href="?control=approved-registration&activityID=<?php echo $activityID ?>"" class="btn btn-primary mb-2">approved requests</a>
            <div class="table-responsive">
                <table class="table table-hover text-center">
                    <thead class="table-dark">
                        <th>userName</th>
                        <th>userEmail</th>
                        <th>gender</th>
                        <th>Health_status</th>
                        <th>physical_state</th>
                        <th>reservationDate</th>
                        <th>controls</th>
                    </thead>
                    <tbody>
                        <?php 
                        while ($row = $stmt->fetch()) {
                            ?>
                            <tr>
                                <td><?php echo $row['userName'] ?></td>
                                <td><?php echo $row['userEmail'] ?></td>
                                <td>
                                   <?php 
                                    if ($row['activityschedule_gender'] == 1) {
                                        if ($row['gender'] == 1) {
                                            echo 'yes';
                                        } else {
                                            echo 'no';
                                        }
                                    } elseif($row['activityschedule_gender'] == 2) {
                                        if ($row['gender'] == 2) {
                                            echo 'yes';
                                        } else {
                                            echo 'no';
                                        }
                                    } elseif($row['activityschedule_gender'] == 3) {
                                        if ($row['gender'] == 1) {
                                            echo 'yes';
                                        } elseif($row['gender'] == 2) {
                                            echo 'yes';
                                        }
                                    }
                                   ?>
                                </td>
                                <td>
                                    <?php 
                                    if ($row['Health_status'] <= $row['activityschedule_Health_status']) {
                                        echo 'yes';
                                    } else {
                                        echo 'no';
                                    }
                                   ?>
                                </td>
                                <td>
                                <?php 
                                    if ($row['physical_state'] <= $row['activityschedule_physical_state']) {
                                        echo 'yes';
                                    } else {
                                        echo 'no';
                                    }
                                   ?>
                                </td>
                                <td>
                                    <?php echo $row['reservationDate'] ?>
                                </td>
                                <td>
                                    <?php
                                    if(
                                        ($row['activityschedule_gender'] == $row['gender'] || $row['activityschedule_gender'] == 3)
                                        && ($row['Health_status'] <= $row['activityschedule_Health_status'])
                                        && ($row['physical_state'] <= $row['activityschedule_physical_state'])
                                    ) {
                                        ?>
                                        <a href="?control=registrationApprove&reserveID=<?php echo $row['ReservationID']?>&activityID=<?php echo $activityID?>" class="btn btn-success">approve</a>
                                        <?php
                                    } else {
                                        ?>
                                        <div class="text-danger">no match</div>
                                        <a href="?control=registrationDelete&reserveID=<?php echo $row['ReservationID']?>&activityID=<?php echo $activityID?>" class="btn btn-danger">delete</a>
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
        </div>
        <?php   
    } elseif($control == 'registrationApprove') {
        $reserveID = $_GET['reserveID'];
        $activityID = $_GET['activityID'];
        $stmt = Approved_($reserveID, 2);
        if ($stmt > 0) {
            header('location:?control=unapproved-registration&activityID=' . $activityID);
        }
    } elseif($control == 'registrationDelete') {
        $reserveID = $_GET['reserveID'];
        $activityID = $_GET['activityID'];
        $stmt = deleteRegistration($reserveID);
        if ($stmt > 0) {
            header('location:?control=unapproved-registration&activityID=' . $activityID);
        }
    } elseif($control == 'approved-posts') {
        $activityID = $_GET['activityID'];
        $stmt = viewPost_($activityID, 2);
        ?>
        <div class="container">
            <div class="heading">
                <i class="fas fa-bars bar-menu" id="navbar-btn"></i>
                <a href="sign-out.php">sign out</a>
            </div>
            <div class="main-title">
                <h2>all enabled posts</h2>
                <a href="?control=view&activityID=<?php echo $activityID ?>" class="btn btn-info">activity page</a>
            </div>
            <a href="?control=unapproved-posts&activityID=<?php echo $activityID ?>"" class="btn btn-primary mb-2">disabled posts</a>
            <div class="card-container">
                <?php
                while ($row = $stmt->fetch()) {
                ?>
                    <div class="post-card">
                        <div class="image"> 
                            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['Picture']) ?>" alt="">
                        </div>
                        <div class="details">
                            <div class="post-title">
                                <h3><?php echo $row['publishedTitle'] ?></h3>
                                <span><?php echo $row['userName'] ?></span>
                            </div>
                            <p>
                                <?php echo $row['postDetails'] ?>
                            </p>
                            <div class="ctrl">
                                <a href="?control=disablePost&postID=<?php echo $row['PublishedID'] ?>&activityID=<?php echo $activityID?>" class="btn btn-danger mt-1">disable post</a>
                            </div>
                        </div>
                    </div>
                <?php 
                }
                ?>
            </div>
        </div>
        <?php
    } elseif($control == 'unapproved-posts') {
        $activityID = $_GET['activityID'];
        $stmt = viewPost_($activityID, 1);
        ?>
        <div class="container">
            <div class="heading">
                <i class="fas fa-bars bar-menu" id="navbar-btn"></i>
                <a href="sign-out.php">sign out</a>
            </div>
            <div class="main-title">
                <h2>all disabled posts</h2>
            </div>
            <a href="?control=approved-posts&activityID=<?php echo $activityID ?>"" class="btn btn-primary mb-2">enabled posts</a>
            <div class="card-container">
                <?php
                while ($row = $stmt->fetch()) {
                ?>
                    <div class="post-card">
                        <div class="image"> 
                            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['Picture']) ?>" alt="">
                        </div>
                        <div class="details">
                            <div class="post-title">
                                <h3><?php echo $row['publishedTitle'] ?></h3>
                                <span><?php echo $row['userName'] ?></span>
                            </div>
                            <p>
                                <?php echo $row['postDetails'] ?>
                            </p>
                            <div class="ctrl">
                                <a href="?control=enablePost&postID=<?php echo $row['PublishedID'] ?>&activityID=<?php echo $activityID?>" class="btn btn-success mt-1">enable post</a>
                            </div>
                        </div>
                    </div>
                <?php 
                }
                ?>
            </div>
        </div>
        <?php
    } elseif($control == 'enablePost') {
        $postID = $_GET['postID'];
        $activityID = $_GET['activityID'];
        $stmt = enablePosts($postID, 2);
        if ($stmt > 0) {
            header('location:?control=unapproved-posts&activityID='.$activityID);
        }
    } elseif($control == 'disablePost') {
        $postID = $_GET['postID'];
        $activityID = $_GET['activityID'];
        $stmt = disablePost($postID, 1);
        if ($stmt > 0) {
            header('location:?control=approved-posts&activityID='.$activityID);
        }
    } elseif($control == 'add-pic') {
        $activityID = $_GET['activityID'];
        ?>
        <div class="container">
            <div class="heading">
                <i class="fas fa-bars bar-menu" id="navbar-btn"></i>
                <a href="sign-out.php">sign out</a>
            </div>
            <div class="main-title">
                <h2>activity title details</h2>
                <a href="?control=view&activityID=<?php echo $activityID ?>" class="btn btn-dark">home</a>
            </div>
            <form action="" method="POST" class="form hz-form activity-form mt-5" enctype="multipart/form-data" autocomplete="off">
                <h2 class="form-title">add new activity picture</h2>
                <div class="input-field">
                    <label class="input-field-label" for="">activity picture:</label>
                    <input class="text-input" type="file" name="photos">
                </div> 
                <div class="submit-2-field">
                    <input class="submit-btn" type="submit" value="add" name="add-pic">
                </div>
            </form>
        </div>
        <?php 
        if(isset($_POST['add-pic'])) {
            $fileName = basename($_FILES['photos']['name']);
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
            $allowTypes = array('png', 'jpg', 'jpeg');
            if (in_array($fileType, $allowTypes)) {
                $image = $_FILES['photos']['tmp_name'];
                $imgContent = addslashes(file_get_contents($image));
                if(insertImage_($activityID, $imgContent) == 1) {
                    header('REFRESH:0;URL=manage-activities.php?control=view&activityID=' . $activityID);
                }
            }
        }
    } elseif($control == 'delete-pic') {
        $activityID = $_GET['activityID'];
        $picID = $_GET['picID'];
        if (delete_activity_pic($picID) == 1) {
            header('REFRESH:0;URL=?control=view&activityID=' . $activityID);
            echo "yes";
        } else {
            echo "no";
        }
    } elseif($control == 'unapprovedRating') {
        $activityID =  $_GET['activityID'];
        $ratingStatus = 1;
        $stmt_rating = rating_ActivityID($activityID, $ratingStatus);
        ?>
        <div class="container">
            <div class="heading">
                <i class="fas fa-bars bar-menu" id="navbar-btn"></i>
                <a href="sign-out.php">sign out</a>
            </div>
            <div class="main-title">
                <h2>all unapproved ratings</h2>
            </div>
            <a href="?control=approvedRating&activityID=<?php echo $activityID ?>" class="btn btn-primary">approved ratings</a>
            <div class="blog-comments">
                <div class="comments-container">
                    <?php 
                    if ($stmt_rating->rowCount() > 0) { 
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
                            <a href="?control=approveRating&ratingID=<?php echo $row_rating['RatingID'] ?>&activityID=<?php echo $activityID ?>" class="btn btn-success rating-btn">approve</a>
                        </div>
                    <?php 
                        }
                    } else {
                        ?>
                        <div class="alert alert-info">no unapproved rating yet!</div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    } elseif($control == 'approvedRating') {
        $activityID =  $_GET['activityID'];
        $ratingStatus = 2;
        $stmt_rating = rating_ActivityID($activityID, $ratingStatus);
        ?>
        <div class="container">
            <div class="heading">
                <i class="fas fa-bars bar-menu" id="navbar-btn"></i>
                <a href="sign-out.php">sign out</a>
            </div>
            <div class="main-title">
                <h2>all approved ratings</h2>
                <a href="?control=view&activityID=<?php echo $activityID ?>" class="btn btn-info">activity page</a>

            </div>
            <a href="?control=unapprovedRating&activityID=<?php echo $activityID ?>" class="btn btn-primary">unapproved ratings</a>
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
                            <div class="text-success rating-btn fw-bold">approved</div>
                        </div>
                    <?php 
                        }
                    } else {
                        ?>
                        <div class="alert alert-info">no approved rating yet!</div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    } elseif($control == 'approveRating') {
        $RatingID = $_GET['ratingID'];
        $activityID= $_GET['activityID'];
        $stmt = ApprovedRating($RatingID, '2');
        if ($stmt > 0) {
            header('location:?control=unapprovedRating&activityID=' . $activityID);
        }
    }
    include "includes/templates/footer.html";
?>