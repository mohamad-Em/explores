<?php 
session_start();
require "includes/header.html";
require "functions.php";
?>
<link rel="stylesheet" href="layout/css/main.css">
<link rel="stylesheet" href="layout/css/styling-forms.css">
<?php
require "includes/navbar.php";
$control = isset($_GET['control']) ? $_GET['control'] : 'superVisors';
$userID = '';   
if($control == 'superVisors') {
    $userType = 2;
    if(isset($_SESSION['userID'])) {
        $userID = $_SESSION['userID'];
    }
    $supervisor = supervisor($userType, $userID);
    ?>
    <div class="container">
        <div class="section-title">
            <h2 class="text-primary">all super visors</h2>
            <form action="?control=search" method="POST" class="add-rating-form">
                <div class="input-field">
                    <input name="searchField" type="text">
                    <label for="">search for suprevisor name only</label>
                </div>
                <input type="submit" value="search">
            </form>
        </div>
        <div class="card-container">
            <?php
            while ($row = $supervisor->fetch()) {
            ?>
                <div class="card-view">
                    <div class="image">
                        <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['userPic']) ?>" alt="">
                    </div>
                    <div class="content">
                        <div class="content-column">name: <span><?php echo $row['userName'] ?></span></div>
                        <div class="content-column">email: <span><?php echo $row['userEmail'] ?></span></div>
                    </div>
                    <div class="controls">
                        <a href="?control=showActivities&userID=<?php echo $row['userID'] ?>" class="btn btn-danger">show activities</a>
                    </div>
                </div>
            <?php 
            }
            ?>
        </div>
    </div>
    <?php
} elseif($control == 'search') {
    $searchField = $_POST['searchField'];
    if(isset($_SESSION['userID'])) {
        $userID = $_SESSION['userID'];
    }
    $search_supervisor = search_supervisor($searchField, $userID);
    ?>
    <div class="container">
        <div class="section-title">
            <h2 class="text-primary">all super visors</h2>
            <form action="?control=search" method="POST" class="add-rating-form">
                <div class="input-field">
                    <input name="searchField" type="text">
                    <label for="">search for suprevisor name only</label>
                </div>
                <input type="submit" value="search">
            </form>
        </div>
        <?php 
        if($search_supervisor->rowCount() > 0) {
            ?>
            <div class="card-container">
                <?php
                while ($row = $search_supervisor->fetch()) {
                ?>
                    <div class="card-view">
                        <div class="image">
                            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['userPic']) ?>" alt="">
                        </div>
                        <div class="content">
                            <div class="content-column">name: <span><?php echo $row['userName'] ?></span></div>
                            <div class="content-column">email: <span><?php echo $row['userEmail'] ?></span></div>
                        </div>
                        <div class="controls">
                            <a href="?control=showActivities&userID=<?php echo $row['userID'] ?>" class="btn btn-danger">show activities</a>
                        </div>
                    </div>
                <?php 
                }
                ?>
            </div>
            <?php 
        } else {
            ?>
            <div class="alert alert-info">there is no supervisors with this name</div>
            <?php
        }
        ?>
    </div>
    <?php
} elseif($control == 'showActivities') {
    $userID = $_GET['userID'];
    $viewActivity = viewActivity($userID);
    ?>
    <div class="container">
        <div class="section-title">
            <h2 class="text-primary">all activities</h2>
        </div>
        <div class="card-container">
            <?php 
            while ($row = $viewActivity->fetch()) {
                $ActivityID = $row['ActivityID'];
                $activityPic = photos_ActivityID($ActivityID, 1);
            ?>
                <div class="blog-card">
                    <div class="image"> 
                        <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($activityPic)?>" alt="">
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
require "includes/footer.html";