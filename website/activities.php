<?php 
session_start();
ob_start();
require "includes/header.html";
require "connect.php";
require "functions.php";
?>
<link rel="stylesheet" href="layout/css/styling-forms.css">
<?php
require "includes/navbar.php";
if(!empty($_SESSION['userID'])) {
    $control = isset($_GET['control']) ? $_GET['control'] : 'activities';   

    if($control == 'activities') {
        $gender = $_SESSION['gender'];
        $Health_status = $_SESSION['Health_status'];
        $physical_state = $_SESSION['physical_state'];
        $stmt = showActivity($gender, $Health_status, $physical_state, 2, $_SESSION['userID']);
        ?>
        <div class="container">
            <div class="section-title">
                <h4 class="text-primary">all activities</h4>
            </div>
            <div class="main-activities-container">
                <div class="card-container">
                    <?php 
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $ActivityID = $row['ActivityID'];
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
                        // get photos 
                        $activity_pic = photos_ActivityID($ActivityID, 1);
                        ?>
                        <div class="blog-card">
                            <div class="image"> 
                                <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($activity_pic)?>" alt="">
                            </div>
                            <div class="details">
                                <h4><?php echo $row['activityPlace'] ?></h4>
                                <span><?php echo $row['userFullname'] ?></span>
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
                                    <a href="?control=viewActivity&ActivityID=<?php echo $ActivityID ?>" class="text-danger">read full blog</a>
                                    <span class="text-primary">
                                    <?php 
                                    if ($rowPost > 0) {
                                        echo  $rowPost . ' posts';
                                    } else {
                                        echo 'No posts';
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
                <div class="filter-section">
                    <form action="?control=filterActivities" method="POST" class="filter-form">
                        <div class="section-title">
                            <h4 class="text-primary">filter activities</h4>
                        </div>
                        <div class="input-field">
                            <label for="">severity level</label>
                            <div class="radios">
                                <div class="radio">
                                    <input type="radio" name="severity_level" value="1">hard
                                </div>
                                <div class="radio">
                                    <input type="radio" name="severity_level" value="2">normal 
                                </div>
                                <div class="radio">
                                    <input type="radio" name="severity_level" value="3">easy
                                </div>
                            </div>
                        </div>
                        <div class="input-field">
                            <?php
                            if ($_SESSION['Health_status'] == 1) {
                            ?>
                            <label for="">health state</label>
                            <div class="radios">
                                <div class="radio">
                                    <input type="radio" name="activityschedule_Health_status" value="1">excellent
                                </div>
                                <div class="radio">
                                    <input type="radio" name="activityschedule_Health_status" value="2">good
                                </div>
                                <div class="radio">
                                    <input type="radio" name="activityschedule_Health_status" value="3">bad
                                </div>
                            </div>
                        </div>
                        <div class="input-field">
                            <?php
                            } elseif($_SESSION['Health_status'] == 2) {
                            ?>
                            <label for="">health state</label>
                            <div class="radios">
                                <div class="radio">
                                    <input type="radio" name="activityschedule_Health_status" value="2">good
                                </div>
                                <div class="radio">
                                    <input type="radio" name="activityschedule_Health_status" value="3">bad
                                </div>
                            </div>
                            <?php
                            }?>
                        </div>
                        <div class="input-field">
                            <?php
                            if ($_SESSION['physical_state'] == 1) {
                            ?>
                            <label for="">physical state</label>
                            <div class="radios">
                                <div class="radio">
                                    <input type="radio" name="activityschedule_physical_state" value="1">excellent
                                </div>
                                <div class="radio">
                                    <input type="radio" name="activityschedule_physical_state" value="2">good
                                </div>
                                <div class="radio">
                                    <input type="radio" name="activityschedule_physical_state" value="3">bad
                                </div>
                            </div>
                        </div>
                        <div class="input-field">
                            <label for="">physical state</label>
                            <?php 
                            } elseif($_SESSION['physical_state'] == 2) {
                            ?>
                            <label for="">physical state</label>
                            <div class="radios">
                                <div class="radio">
                                    <input type="radio" name="activityschedule_physical_state" value="2">good
                                </div>
                                <div class="radio">
                                    <input type="radio" name="activityschedule_physical_state" value="3">bad
                                </div>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                        <input type="submit" value="filter" class="btn btn-primary" style="margin: 10px auto 0 auto; display: block;">
                    </form>
                </div>
            </div>
        </div>
        <?php 
    } elseif($control == 'filterActivities') {
        $severity_level = isset($_POST['severity_level']) ? $_POST['severity_level'] : 0;
        $activityschedule_Health_status = isset($_POST['activityschedule_Health_status']) ? $_POST['activityschedule_Health_status'] : 0;
        $activityschedule_physical_state = isset($_POST['activityschedule_physical_state']) ? $_POST['activityschedule_physical_state'] : 0;
        $serach = searchActivities($severity_level, $activityschedule_Health_status, $activityschedule_physical_state, 2, $_SESSION['userID']);
        ?>
        <div class="container">
            <div class="section-title">
                <h4 class="text-primary">filter results</h4>
            </div>
            <?php
            if($serach->rowCount() > 0) { 
            ?>
            <div class="card-container">
                <?php
                while ($row = $serach->fetch(PDO::FETCH_ASSOC)) {
                    $ActivityID = $row['ActivityID'];
                    //get posts count for activity
                    $sql = 'SELECT * FROM activityschedule
                                INNER JOIN posts
                                ON activityschedule.ActivityID=posts.ActivityID
                                WHERE activityschedule.ActivityID=:ActivityID';
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([
                        ':ActivityID' => $ActivityID
                    ]);
                    $rowPost = $stmt->rowCount();
                    // get photos 
                    $activity_pic = photos_ActivityID($ActivityID, 1);
                    ?>
                    <div class="blog-card">
                        <div class="image"> 
                            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($activity_pic)?>" alt="">
                        </div>
                        <div class="details">
                            <h4><?php echo $row['activityPlace'] ?></h4>
                            <span><?php echo $row['userFullname'] ?></span>
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
                                <a href="?control=viewActivity&ActivityID=<?php echo $ActivityID ?>" class="text-danger">read full blog</a>
                                <span class="text-primary">
                                <?php 
                                if ($rowPost > 0) {
                                    echo  $rowPost . 'posts';
                                } else {
                                    echo 'No posts';
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
                <div class="alert alert-info">no filtered results found!</div>
                <?php
            }
            ?>
        </div>
        <?php 
    } elseif($control == 'viewActivity') {
        $ActivityID = $_GET['ActivityID'];
        $userID = $_SESSION['userID'];
        $stmt = viewActivity('', $_GET['ActivityID']);
        $row = $stmt->fetch();

        $checkReservation = checkReservation_($ActivityID, $userID);
        $checkReservation_rows = $checkReservation->rowCount();
        $checkReservation_data = $checkReservation->fetch();
        ?>
        <div class="container">
            <div class="section-title">
                <h4 class="text-primary">activity details:</h4>
                <?php 
                if (isset($_SESSION['userType']) == 3) {
                    if ($checkReservation_rows > 0) {
                        if($checkReservation_data['reserveStatus'] == 2) {
                        ?>
                        <div class="registered">
                            <span class="text-success">registered</span>
                            <a href="?control=addComplaint&ActivityID=<?php echo $_GET['ActivityID'] ?>" class="btn btn-primary">addComplaints</a>
                        </div>
                        <?php 
                        } else {
                            ?>
                            <span class="text-info fw-bold">Register on hold</span>
                            <?php 
                        }
                    } else {
                        ?>
                        <a href="?control=register&ActivityID=<?php echo $_GET['ActivityID']; ?>" class="btn btn-primary">register now</a>
                        <?php
                    }
                }
                ?>
            </div>
            <div class="blog-container">
                <div class="blog-header">
                    <div class="blog-header-content">
                        <div class="content">
                            <span>activity maker:</span> <?php echo $row['userFullName'] ?>
                        </div>
                        <div class="content">
                            <span>activity place:</span> <?php echo $row['activityPlace'] ?>
                        </div>
                        <div class="content">
                            <span>registration cost:</span> <?php echo $row['registrationCost'] . ' S.P' ?>
                        </div>
                        <div class="content">
                            <span>registeration start date:</span> <?php echo $row['Registration_start_date'] ?>
                        </div>
                        <div class="content">
                            <span>registeration end date:</span> <?php echo $row['Registration_expiration_date'] ?>
                        </div>
                    </div>
                    <div class="carousel-images" data-carousel>
                        <button class="carousel-button prev" data-carousel-button="prev">&#8656</button>
                        <button class="carousel-button next" data-carousel-button="next">&#8658</button>
                        <ul data-slides>
                            <?php 
                            $picture = photos_ActivityID($ActivityID, 1);
                            ?>
                            <li class="slide" data-active>
                                <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($picture)?>" alt="">
                            </li>
                            <?php
                            $stmt_photos = photos_ActivityID($ActivityID, "*");
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
                </div>
                <div class="blog-details">
                    <div class="blog-details-con">
                        <p>
                        <?php echo $row['activityDescription'] ?>
                        </p>
                        <div class="blog-details-content">
                            <div class="blog-content-field">
                                <div class="content">
                                    <span>activity Supplies:</span> <?php echo $row['activitySupplies'] ?>
                                </div>
                                <div class="content">
                                    <span>activity Supplies weight:</span> <?php echo $row['Weighing_activity_supplies'] . ' KG' ?>
                                </div>
                                <div class="content">
                                    <span>presence:</span> <?php echo $row['presence'] ?>
                                </div>
                                <div class="content">
                                    <span>specific age:</span> <?php echo $row['specific_age'] ?>
                                </div>
                                <div class="content">
                                    <span>severity level:</span>
                                    <?php
                                    if($row['severity_level'] == 1) {
                                        echo "hard";
                                    }elseif($row['severity_level'] == 2) {
                                        echo "normal";
                                    }elseif($row['severity_level'] == 3) {
                                        echo "easy";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="blog-content-field">
                                <div class="content">
                                    <span>Activity start date:</span> <?php echo $row['Activity_start_date'] ?>
                                </div>
                                <div class="content">
                                    <span>Activity end date:</span> <?php echo $row['Activity_end_date'] ?>
                                </div>
                                <div class="content">
                                    <span>specific gender:</span>
                                    <?php 
                                    if($row['activityschedule_gender'] == 1) {
                                        echo "male only";
                                    }elseif($row['activityschedule_gender'] == 2) {
                                        echo "female only";
                                    }elseif($row['activityschedule_gender'] == 3) {
                                        echo "both genders";
                                    }
                                    ?>
                                </div>
                                <div class="content">
                                    <span>specific health state:</span> 
                                    <?php 
                                    if($row['activityschedule_Health_status'] == 1) {
                                        echo "excellent";
                                    }elseif($row['activityschedule_Health_status'] == 2) {
                                        echo "good";
                                    }elseif($row['activityschedule_Health_status'] == 3) {
                                        echo "bad";
                                    }
                                    ?>
                                </div>
                                <div class="content">
                                    <span>specific physical state:</span> 
                                    <?php 
                                    if($row['activityschedule_physical_state'] == 1) {
                                        echo "excellent";
                                    }elseif($row['activityschedule_physical_state'] == 2) {
                                        echo "good";
                                    }elseif($row['activityschedule_physical_state'] == 3) {
                                        echo "bad";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <h3 class="text-primary">notes:</h3>
                        <p>
                        <?php echo $row['note'] ?>
                        </p>
                    </div>
                </div>
                <?php
                $rating_stmt = viewRating_($ActivityID, 2);
                ?>
                <div class="section-title">
                    <h4 class="text-primary">activity ratings:</h4>
                    <?php 
                    if (isset($_SESSION['userType']) == 3) {
                        if ($checkReservation_rows > 0) {
                            if($checkReservation_data['reserveStatus'] == 2) {
                            ?>
                            <form action="?control=insertRating&ActivityID=<?php echo $ActivityID ?>" method="POST" class="add-rating-form">
                                <div class="input-field">
                                    <input name="evaluation" type="text">
                                    <label for="">type your rating</label>
                                </div>
                                <input type="submit" value="submit">
                            </form>
                            <?php 
                            } else {
                                ?>
                                <span class="text-danger fw-bold">Register on hold can't make any rating</span>
                                <?php 
                            }
                        } else {
                            ?>
                            <span class="text-primary">please register first</span>
                            <?php
                        }
                    }
                    ?>
                    
                </div>
                <?php 
                if($rating_stmt->rowCount() > 0) {
                ?>
                <div class="blog-comments">
                    <div class="comments-container">
                        <?php 
                        while ($rating_row = $rating_stmt->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <div class="comment">
                                <div class="comment-header">
                                    <div class="image">
                                        <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($rating_row['userPic'])?>" alt="">
                                    </div>
                                    <div class="info">
                                        <div class="name"><?php echo $rating_row['userName'] ?></div>
                                        <div class="date"><i class="fas fa-calendar"></i><?php echo $rating_row['ratingDate']?></div>
                                    </div>
                                </div>
                                <div class="comment-details">
                                    <?php echo $rating_row['evaluation'] ?>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        
                    </div>
                </div>
                <?php 
                } else {
                ?>
                <div class="alert alert-info mt-2">
                    no ratings yet!
                </div>
                <?php
                }?>
                <div class="section-title">
                    <h4 class="text-primary">activity posts:</h4>
                    <?php 
                    if (isset($_SESSION['userType']) == 3) {
                        if ($checkReservation_rows > 0) {
                            if($checkReservation_data['reserveStatus'] == 2) {
                            ?>
                            <a href="?control=addPost&ActivityID=<?php echo $ActivityID;?>" class="btn btn-primary">add new post</a>
                            <?php 
                            } else {
                                ?>
                                <span class="text-danger fw-bold">Register on hold can't make any post</span>
                                <?php 
                            }
                        } else {
                            ?>
                            <span class="text-primary">please register first</span>
                            <?php
                        }
                    }
                    ?>
                    
                </div>
                <?php
                $posts_stmt = viewPosts_($ActivityID, 2);
                if($posts_stmt->rowCount() > 0) {
                ?>
                <div class="card-container m-2">
                    <?php
                    while ($posts_row = $posts_stmt->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <div class="post-card">
                            <div class="image"> 
                                <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($posts_row['Picture'])?>" alt="">
                            </div>
                            <div class="details">
                                <div class="post-title">
                                    <h3><?php echo $posts_row['publishedTitle']?></h3>
                                    <span><?php echo $posts_row['userFullName']?></span>
                                </div>
                                <p>
                                <?php echo $posts_row['postDetails']?>
                                </p>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    
                </div>
                <?php 
                } else {
                ?>
                <div class="alert alert-info">
                    no posts yet!
                </div>
                <?php
                }
                ?>
            </div>
        </div>
        <?php
    } elseif($control == 'register') {
        $reserveStatus = 1;
        $ActivityID = $_GET['ActivityID'];
        $userID = $_SESSION['userID'];
        if (insertReservation_($reserveStatus, $ActivityID, $userID) == 1) {
            header('location:activities.php?control=viewActivity&ActivityID=' . $_GET['ActivityID']);
        }
    } elseif($control == 'addPost') {
        $ActivityID = $_GET['ActivityID'];
        ?>
        <div class="container">
            <div class="section-title">
                <h3 class="text-danger">add new post</h3>
            </div>
            <form action="" class="form add-form hz-form" autocomplete="off" enctype="multipart/form-data" method="POST">
                <h2 class="form-title">add new post</h2>
                <div class="input-field">
                    <label class="input-field-label" for="">post title:</label>
                    <input class="text-input" type="text" name="publishedTitle">
                </div>  
                <div class="input-field">
                    <label class="input-field-label" for="">post description:</label>
                    <textarea class="pass-input" type="text" name="postDetails"></textarea>
                </div>
                <div class="input-field">
                    <label class="input-field-label" for="">post picture:</label>
                    <input class="pass-input" type="file" name="Picture">
                </div>
                <div class="submit-2-field">
                    <input class="submit-btn" type="submit" name="insertPost" value="add">
                </div>
            </form>
        </div>
        <?php
        if(isset($_POST['insertPost'])) {
            $publishedTitle = $_POST['publishedTitle'];
            $postDetails = $_POST['postDetails'];
            $userID = $_SESSION['userID'];
            $ActivityID = $ActivityID;
            $postStatus = 1;
            $fileName = basename($_FILES['Picture']['name']);
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
            $allowTypes = array('png', 'jpg', 'jpeg');
            if (in_array($fileType, $allowTypes)) {
                $image = $_FILES['Picture']['tmp_name'];
                $imgContent = addslashes(file_get_contents($image));
                if (insertPost_($publishedTitle, $postDetails, $imgContent, $userID, $postStatus, $ActivityID) > 0) {
                    header('location:activities.php?control=viewActivity&ActivityID=' . $ActivityID);
                }
            }
        }
    } elseif ($control == 'insertRating') {
        if (!empty($_POST['evaluation'])) {
            $evaluation = $_POST['evaluation'];
            $ActivityID = $_GET['ActivityID'];
            $userID = $_SESSION['userID'];
            $ratingStatus = 1;
            $insertRating = insertRating_($userID, $ActivityID, $evaluation, $ratingStatus);
            if ($insertRating->rowCount() > 0) {
                header('location:activities.php?control=viewActivity&ActivityID=' . $ActivityID);
            }
        }
    } elseif($control == 'addComplaint') {
        $ActivityID = $_GET['ActivityID'];
        ?>
        <div class="container">
            <div class="section-title">
                <h3 class="text-danger">add new complaint</h3>
            </div>
            <form action="" class="form add-form hz-form" autocomplete="off" method="POST">
                <h2 class="form-title">add complaint</h2>
                <div class="input-field">
                    <label class="input-field-label" for="">complaint description:</label>
                    <textarea class="pass-input" type="text" name="details"></textarea>
                </div>
                <div class="submit-2-field">
                    <input class="submit-btn" type="submit" name="insertComplaint" value="add">
                </div>
            </form>
        </div>
        <?php
        if(isset($_POST['insertComplaint'])) {
            $details = $_POST['details'];
            $userID = $_SESSION['userID'];
            $postStatus = 1;
            $insertComplaints = insertComplaints_($details, $ActivityID, $userID);
            if ($insertComplaints > 0) {
                header('location:activities.php?control=viewActivity&ActivityID=' . $ActivityID);
            }
        }
    }
} else {
    $control = isset($_GET['control']) ? $_GET['control'] : 'activities';   
    if($control == 'activities') {
        $stmt= showActivities();
        ?>
        <div class="container">
            <div class="section-title">
                <h4 class="text-primary">all activities</h4>
            </div>
            <div class="main-activities-container">
                <div class="card-container">
                    <?php 
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $ActivityID = $row['ActivityID'];
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
                        // get photos 
                        $activity_pic = photos_ActivityID($ActivityID, 1);
                        ?>
                        <div class="blog-card">
                            <div class="image"> 
                                <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($activity_pic)?>" alt="">
                            </div>
                            <div class="details">
                                <h4><?php echo $row['activityPlace'] ?></h4>
                                <span><?php echo $row['userFullname'] ?></span>
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
                                    <a href="?control=viewActivity&ActivityID=<?php echo $ActivityID ?>" class="text-danger">read full blog</a>
                                    <span class="text-primary">
                                    <?php 
                                    if ($rowPost > 0) {
                                        echo  $rowPost . ' posts';
                                    } else {
                                        echo 'No posts';
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
                <div class="filter-section">
                    <form action="?control=filterActivities" method="POST" class="filter-form">
                        <div class="section-title">
                            <h4 class="text-primary">filter activities</h4>
                        </div>
                        <div class="input-field">
                            <label for="">severity level</label>
                            <div class="radios">
                                <div class="radio">
                                    <input type="radio" name="severity_level" value="1">hard
                                </div>
                                <div class="radio">
                                    <input type="radio" name="severity_level" value="2">normal
                                </div>
                                <div class="radio">
                                    <input type="radio" name="severity_level" value="3">Easy
                                </div>
                            </div>
                        </div>
                        <div class="input-field">
                            <label for="">health state</label>
                            <div class="radios">
                                <div class="radio">
                                    <input type="radio" name="activityschedule_Health_status" value="1">excellent
                                </div>
                                <div class="radio">
                                    <input type="radio" name="activityschedule_Health_status" value="2">good
                                </div>
                                <div class="radio">
                                    <input type="radio" name="activityschedule_Health_status" value="3">bad
                                </div>
                            </div>
                        </div>
                        <div class="input-field">
                            <label for="">physical state</label>
                            <div class="radios">
                                <div class="radio">
                                    <input type="radio" name="activityschedule_physical_state" value="1">excellent
                                </div>
                                <div class="radio">
                                    <input type="radio" name="activityschedule_physical_state" value="2">good
                                </div>
                                <div class="radio">
                                    <input type="radio" name="activityschedule_physical_state" value="3">bad
                                </div>
                            </div>
                        </div>
                        <input type="submit" value="filter" class="btn btn-primary" style="margin: 10px auto 0 auto; display: block;">
                    </form>
                </div>
            </div>
        </div>
        <?php
    } elseif($control == 'filterActivities') {
        $severity_level = isset($_POST['severity_level']) ? $_POST['severity_level'] : 0;
        $activityschedule_Health_status = isset($_POST['activityschedule_Health_status']) ? $_POST['activityschedule_Health_status'] : 0;
        $activityschedule_physical_state = isset($_POST['activityschedule_physical_state']) ? $_POST['activityschedule_physical_state'] : 0;
        $serach = searchActivities($severity_level, $activityschedule_Health_status, $activityschedule_physical_state, 2);
        ?>
        <div class="container">
            <div class="section-title">
                <h4 class="text-primary">filter results</h4>
            </div>
            <?php 
            if($serach->rowCount() > 0) {
            ?>
            <div class="card-container">
                <?php
                while ($row = $serach->fetch(PDO::FETCH_ASSOC)) {
                    $ActivityID = $row['ActivityID'];
                    //get posts count for activity
                    $sql = 'SELECT * FROM activityschedule
                                INNER JOIN posts
                                ON activityschedule.ActivityID=posts.ActivityID
                                WHERE activityschedule.ActivityID=:ActivityID';
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([
                        ':ActivityID' => $ActivityID
                    ]);
                    $rowPost = $stmt->rowCount();
                    // get photos 
                    $activity_pic = photos_ActivityID($ActivityID, 1);
                    ?>
                    <div class="blog-card">
                        <div class="image"> 
                            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($activity_pic)?>" alt="">
                        </div>
                        <div class="details">
                            <h4><?php echo $row['activityPlace'] ?></h4>
                            <span><?php echo $row['userFullname'] ?></span>
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
                                <a href="?control=viewActivity&ActivityID=<?php echo $ActivityID ?>" class="text-danger">read full blog</a>
                                <span class="text-primary">
                                <?php 
                                if ($rowPost > 0) {
                                    echo  $rowPost . 'posts';
                                } else {
                                    echo 'No posts';
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
                <div class="alert alert-info text-center fw-bold fs-3">there is no activities with this info</div>
                <?php 
            }
            ?>
        </div>
        <?php 
    } elseif($control == 'viewActivity') {
        $ActivityID = $_GET['ActivityID'];

        $stmt = viewActivity('', $_GET['ActivityID']);
        $row = $stmt->fetch();
        ?>
        <div class="container">
            <div class="section-title">
                <h4 class="text-primary">activity details:</h4>
                <span class="text-danger">register or sign in to join the activity</span>
            </div>
            <div class="blog-container">
                <div class="blog-header">
                    <div class="blog-header-content">
                        <div class="content">
                            <span>activity maker:</span> <?php echo $row['userFullName'] ?>
                        </div>
                        <div class="content">
                            <span>activity place:</span> <?php echo $row['activityPlace'] ?>
                        </div>
                        <div class="content">
                            <span>registration cost:</span> <?php echo $row['registrationCost'] . ' S.P' ?>
                        </div>
                        <div class="content">
                            <span>registeration start date:</span> <?php echo $row['Registration_start_date'] ?>
                        </div>
                        <div class="content">
                            <span>registeration end date:</span> <?php echo $row['Registration_expiration_date'] ?>
                        </div>
                    </div>
                    <div class="carousel-images" data-carousel>
                        <button class="carousel-button prev" data-carousel-button="prev">&#8656</button>
                        <button class="carousel-button next" data-carousel-button="next">&#8658</button>
                        <ul data-slides>
                            <?php 
                            $picture = photos_ActivityID($ActivityID, 1);
                            ?>
                            <li class="slide" data-active>
                                <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($picture)?>" alt="">
                            </li>
                            <?php
                            $stmt_photos = photos_ActivityID($ActivityID, "*");
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
                </div>
                <div class="blog-details">
                    <div class="blog-details-con">
                        <p>
                        <?php echo $row['activityDescription'] ?>
                        </p>
                        <div class="blog-details-content">
                            <div class="blog-content-field">
                                <div class="content">
                                    <span>activity Supplies:</span> <?php echo $row['activitySupplies'] ?>
                                </div>
                                <div class="content">
                                    <span>activity Supplies weight:</span> <?php echo $row['Weighing_activity_supplies'] . ' KG' ?>
                                </div>
                                <div class="content">
                                    <span>presence:</span> <?php echo $row['presence'] ?>
                                </div>
                                <div class="content">
                                    <span>specific age:</span> <?php echo $row['specific_age'] ?>
                                </div>
                                <div class="content">
                                    <span>severity level:</span>
                                    <?php
                                    if($row['severity_level'] == 1) {
                                        echo "hard";
                                    }elseif($row['severity_level'] == 2) {
                                        echo "normal";
                                    }elseif($row['severity_level'] == 3) {
                                        echo "easy";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="blog-content-field">
                                <div class="content">
                                    <span>Activity start date:</span> <?php echo $row['Activity_start_date'] ?>
                                </div>
                                <div class="content">
                                    <span>Activity end date:</span> <?php echo $row['Activity_end_date'] ?>
                                </div>
                                <div class="content">
                                    <span>specific gender:</span>
                                    <?php 
                                    if($row['activityschedule_gender'] == 1) {
                                        echo "male only";
                                    }elseif($row['activityschedule_gender'] == 2) {
                                        echo "female only";
                                    }elseif($row['activityschedule_gender'] == 3) {
                                        echo "both genders";
                                    }
                                    ?>
                                </div>
                                <div class="content">
                                    <span>specific health state:</span> 
                                    <?php 
                                    if($row['activityschedule_Health_status'] == 1) {
                                        echo "excellent";
                                    }elseif($row['activityschedule_Health_status'] == 2) {
                                        echo "good";
                                    }elseif($row['activityschedule_Health_status'] == 3) {
                                        echo "bad";
                                    }
                                    ?>
                                </div>
                                <div class="content">
                                    <span>specific physical state:</span> 
                                    <?php 
                                    if($row['activityschedule_physical_state'] == 1) {
                                        echo "excellent";
                                    }elseif($row['activityschedule_physical_state'] == 2) {
                                        echo "good";
                                    }elseif($row['activityschedule_physical_state'] == 3) {
                                        echo "bad";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <h3 class="text-primary">notes:</h3>
                        <p>
                        <?php echo $row['note'] ?>
                        </p>
                    </div>
                </div>
                <?php
                $rating_stmt = viewRating_($ActivityID, 2);
                ?>
                <div class="section-title">
                    <h4 class="text-primary">activity ratings:</h4>
                </div>
                <?php 
                if($rating_stmt->rowCount() > 0) {
                ?>
                <div class="blog-comments">
                    <div class="comments-container">
                        <?php 
                        while ($rating_row = $rating_stmt->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <div class="comment">
                                <div class="comment-header">
                                    <div class="image">
                                        <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($rating_row['userPic'])?>" alt="">
                                    </div>
                                    <div class="info">
                                        <div class="name"><?php echo $rating_row['userName'] ?></div>
                                        <div class="date"><i class="fas fa-calendar"></i><?php echo $rating_row['ratingDate']?></div>
                                    </div>
                                </div>
                                <div class="comment-details">
                                    <?php echo $rating_row['evaluation'] ?>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        
                    </div>
                </div>
                <?php 
                } else {
                ?>
                <div class="alert alert-info mt-2">
                    no ratings yet!
                </div>
                <?php
                }?>
                <div class="section-title">
                    <h4 class="text-primary">activity posts:</h4>
                    <?php 
                    if (isset($_SESSION['userType']) == 3) {
                        if ($checkReservation_rows > 0) {
                            if($checkReservation_data['reserveStatus'] == 2) {
                            ?>
                            <a href="?control=addPost&ActivityID=<?php echo $ActivityID;?>" class="btn btn-primary">add new post</a>
                            <?php 
                            } else {
                                ?>
                                <span class="text-danger fw-bold">Register on hold can't make any post</span>
                                <?php 
                            }
                        } else {
                            ?>
                            <span class="text-primary">please register first</span>
                            <?php
                        }
                    }
                    ?>
                    
                </div>
                <?php
                $posts_stmt = viewPosts_($ActivityID, 2);
                if($posts_stmt->rowCount() > 0) {
                ?>
                <div class="card-container m-2">
                    <?php
                    while ($posts_row = $posts_stmt->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <div class="post-card">
                            <div class="image"> 
                                <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($posts_row['Picture'])?>" alt="">
                            </div>
                            <div class="details">
                                <div class="post-title">
                                    <h3><?php echo $posts_row['publishedTitle']?></h3>
                                    <span><?php echo $posts_row['userFullName']?></span>
                                </div>
                                <p>
                                <?php echo $posts_row['postDetails']?>
                                </p>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    
                </div>
                <?php 
                } else {
                ?>
                <div class="alert alert-info">
                    no posts yet!
                </div>
                <?php
                }
                ?>
            </div>
        </div>
        <?php
    }
    
}
require "includes/footer.html";
ob_end_flush();