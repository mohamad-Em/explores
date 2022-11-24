<?php
session_start();
ob_start();
require "includes/header.html";
require "connect.php";
require "functions.php";
?>

<link rel="stylesheet" href="layout/css/styling-forms.css">
<link rel="stylesheet" href="layout/css/profile.css">

<?php
require "includes/navbar.php";
?>
<div class="profile-container">
    <div class="profile-nav">
        <div class="my-data">
            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($_SESSION['userPic']) ?>" alt="">
        </div>
        <ul>
            <a href="?control=myInfo">my info</a>
            <a href="?control=myPosts">my posts</a>
            <a href="?control=myComplaints">my complaints</a>
            <a href="?control=signOut">sign out</a>
        </ul>
    </div>
    <?php
    $control = isset($_GET['control']) ? $_GET['control'] : "myInfo";
    if ($control == "myInfo") {
        $gender = '';
        $healthState = '';
        $physicalState = '';
        if ($_SESSION['gender'] == 1) {
            $gender = 'male';
        } else {
            $gender = 'female';
        }

        if ($_SESSION['Health_status'] == 1) {
            $healthState = 'excellent health';
        } elseif ($_SESSION['Health_status'] == 2) {
            $healthState = 'good health';
        } else {
            $healthState = 'bad health';
        }

        if ($_SESSION['physical_state'] == 1) {
            $physicalState = 'excellent physical';
        } elseif ($_SESSION['physical_state'] == 2) {
            $physicalState = 'good physical';
        } else {
            $physicalState = 'bad physical';
        }
        $affiliateCount = MyAffiliate($_SESSION['userID']);
        ?>
        <div class="container">
            <div class="section-title">
                <h2 class="text-primary">my information</h2>
                <?php
                if($_SESSION['userType'] == 3) {
                    if ($affiliateCount->rowCount() > 0) {
                    ?>
                        <span class="text-info">your affiliate was sent to website admin</span>
                    <?php
                    } else {
                    ?>
                        <a href="?control=sendAffiliate" class="btn btn-primary">send affiliate request</a>
                    <?php
                    }
                } elseif($_SESSION['userType'] == 2) {
                    ?>
                        <a href="../superVisor/manage-activities.php" class="btn btn-primary">go to dashboard</a>
                    <?php 
                }
                ?>
            </div>
            <div class="info-section">
                <div class="info-column">
                    <div class="info-row">
                        <span>user name</span>
                        <span class="value"><?php echo $_SESSION['userName'] ?></span>
                    </div>
                    <div class="info-row">
                        <span>full name</span>
                        <span class="value"><?php echo $_SESSION['userFullname'] ?></span>
                    </div>
                    <div class="info-row">
                        <span>email</span>
                        <span class="value"><?php echo $_SESSION['userEmail'] ?></span>
                    </div>
                    <div class="info-row">
                        <span>birth date</span>
                        <span class="value"><?php echo $_SESSION['birthDate'] ?></span>
                    </div>
                </div>
                <div class="info-column">
                    <div class="info-row">
                        <span>gender</span>
                        <span class="value"><?php echo $gender ?></span>
                    </div>
                    <div class="info-row">
                        <span>health state</span>
                        <span class="value"><?php echo $healthState ?></span>
                    </div>
                    <div class="info-row">
                        <span>physical state</span>
                        <span class="value"><?php echo $physicalState ?></span>
                    </div>
                    <div class="info-row">
                        <span>my age</span>
                        <span class="value"><?php echo (int)date("Y-m-d") - (int)$_SESSION['birthDate'] ?></span>
                    </div>
                </div>
                <div class="submit-field mt-4">
                    <a href="?control=editInfo" class="submitBtn">edit my info</a>
                </div>
            </div>
        </div>
    <?php
    } elseif ($control == "editInfo") {
        $userID = $_SESSION['userID'];
        ?>
        <div class="container">
            <div class="section-title">
                <h2 class="text-primary">edit information</h2>
            </div>
            <div class="alert alert-warning">note that you will sign out to update your information successfully</div>
            <form class="info-section" action="" method="POST" enctype="multipart/form-data">
                <div class="info-column">
                    <div class="info-row">
                        <span>user name</span>
                        <input class="value" type="text" name="userName" value="<?php echo $_SESSION['userName'] ?>">
                    </div>
                    <div class="info-row">
                        <span>email - <span class="text-danger"> you can't edit email</span></span>
                        <input class="value" type="text" name="userEmail" value="<?php echo $_SESSION['userEmail'] ?>" disabled>
                    </div>
                    <div class="info-row">
                        <span>full name</span>
                        <input class="value" type="text" name="userFullname" value="<?php echo $_SESSION['userFullname'] ?>">
                    </div>
                </div>
                <div class="info-column">
                    <div class="info-row">
                        <span>birth date</span>
                        <input class="value" type="date" name="birthDate" value="<?php echo $_SESSION['birthDate'] ?>">
                    </div>
                    <div class="info-row">
                        <span>picture</span>
                        <input class="value" type="file" name="userPic" value="">
                    </div>
                </div>
                <div class="submit-field">
                    <input type="submit" name="editInfo" class="submitBtn">
                </div>
            </form>
        </div>
        <?php
        if (isset($_POST['editInfo'])) {
            if (
                !empty($_POST['userName'])
                && !empty($_POST['userFullname'])
                && !empty($_POST['birthDate'])
                && !empty($_FILES['userPic']['name'])
            ) {
                $userName = $_POST['userName'];
                $userFullname = $_POST['userFullname'];
                $birthDate = $_POST['birthDate'];
                $fileName = basename($_FILES['userPic']['name']);
                $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
                $allowTypes = array('png', 'jpg', 'jpeg');
                if (in_array($fileType, $allowTypes)) {
                    $image = $_FILES['userPic']['tmp_name'];
                    $imgContent = addslashes(file_get_contents($image));
                    $updateInfo = updateInfo($userName, $userFullname, $imgContent, $birthDate, $userID);
                    if ($updateInfo > 0) {
                        session_unset();
                        session_destroy();
                        header('REFRESH:0;URL=../admin/index.php');
                    }
                }
            } elseif (
                !empty($_POST['userName'])
                && !empty($_POST['userFullname'])
                && !empty($_POST['birthDate'])
            ) {
                $userName = $_POST['userName'];
                $userFullname = $_POST['userFullname'];
                $birthDate = $_POST['birthDate'];
                $updateInfo = updateInfo_2($userName, $userFullname, $birthDate, $userID);
                if ($updateInfo > 0) {
                    session_unset();
                    session_destroy();
                    header('REFRESH:0;URL=../admin/index.php');
                }
            }
        }
    } elseif ($control == "myPosts") {
        $userID = $_SESSION['userID'];
        $stmt = viewPost_($userID, 2);
        ?>
        <div class="container">
            <div class="section-title">
                <h4 class="text-primary">all of my active activities posts</h4>
                <a href="?control=myInactivePosts" class="btn btn-primary">my posts requests</a>
            </div>
            <div class="card-container mt-2">
                <?php
                while ($row = $stmt->fetch()) {
                    $ActivityID = $row['ActivityID'];
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
                                <a href="?control=editPost&PublishedID=<?php echo $row['PublishedID'] ?>" class="btn btn-secondary mt-1">Edit post</a>
                                <a href="?control=deletePost&PublishedID=<?php echo $row['PublishedID'] ?>" class="btn btn-danger mt-1">Delete post</a>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    <?php
    } elseif ($control == 'myInactivePosts') {
        $userID = $_SESSION['userID'];
        $stmt = viewPost_($userID, 1);
        ?>
        <div class="container">
            <div class="section-title">
                <h4 class="text-primary">all of my inactive activities posts</h4>
                <a href="?control=myPosts" class="btn btn-primary">my active posts</a>
            </div>
            <div class="card-container mt-2">
                <?php
                while ($row = $stmt->fetch()) {
                    $ActivityID = $row['ActivityID'];
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
                                <a href="?control=deletePost&PublishedID=<?php echo $row['PublishedID'] ?>" class="btn btn-danger mt-1">Delete post</a>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    <?php
    } elseif ($control == 'editPost') {
        $PublishedID = $_GET['PublishedID'];

        $stmt = editPost($PublishedID);
        $row = $stmt->fetch();
        ?>
        <div class="container">
            <div class="section-title">
                <h4 class="text-primary">edit post information</h4>
            </div>
            <form action="" class="form add-form hz-form" autocomplete="off" enctype="multipart/form-data" method="POST">
                <h2 class="form-title">edit post information</h2>
                <div class="input-field">
                    <label class="input-field-label" for="">post title:</label>
                    <input class="text-input" type="text" name="publishedTitle" value="<?php echo $row['publishedTitle'] ?>">
                </div>
                <div class="input-field">
                    <label class="input-field-label" for="">post description:</label>
                    <textarea class="pass-input" type="text" name="postDetails"><?php echo $row['postDetails'] ?></textarea>
                </div>
                <div class="input-field">
                    <label class="input-field-label" for="">post picture:</label>
                    <input class="pass-input" type="file" name="files">
                </div>
                <div class="submit-2-field">
                    <input class="submit-btn" type="submit" value="Update" name="edit-post">
                </div>
            </form>
        </div>
        <?php
        if (isset($_POST['edit-post'])) {
            $publishedTitle = $_POST['publishedTitle'];
            $postDetails = $_POST['postDetails'];
            $PublishedID = $_GET['PublishedID'];
            $fileName = basename($_FILES['files']['name']);
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
            $allowTypes = array('png', 'jpg', 'jpeg');
            if (in_array($fileType, $allowTypes)) {
                $image = $_FILES['files']['tmp_name'];
                $imgContent = addslashes(file_get_contents($image));
                $updatePost = updatePost($publishedTitle, $postDetails, $imgContent, $PublishedID);
                if ($updatePost > 0) {
                    header('REFRESH:0;URL=?control=myPosts');
                }
            }
        }
    } elseif ($control == 'deletePost') {
        $PublishedID = $_GET['PublishedID'];
        $deletePost = deletePost($PublishedID);
        if ($deletePost > 0) {
            header('REFRESH:0;URL=?control=myPosts');
        }
    } elseif ($control == "myComplaints") {
        $complaints = complaints($_SESSION['userID']);
        ?>
        <div class="container">
            <div class="section-title">
                <h2 class="text-primary">my complaints</h2>
            </div>
            <div class="table-responsive mt-2">
                <table class="table table-hover text-center">
                    <thead class="table-dark">
                        <th class="col-1">#</th>
                        <th class="col-3">details</th>
                        <th class="col-2">sent date</th>
                        <th class="col-3">reply details</th>
                        <th class="col-2">reply date</th>
                        <th class="col-1">control</th>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = $complaints->fetch()) {
                            $ActivityID = $row['ActivityID'];
                        ?>
                            <tr>
                                <td>1</td>
                                <td><?php echo $row['details'] ?></td>
                                <td><?php echo $row['complaintDate'] ?></td>
                                <td><?php echo $row['toReply'] ?></td>
                                <td><?php echo $row['complaintReplyDate'] ?></td>
                                <td>
                                    <a href="activities.php?control=viewActivity&ActivityID=<?php echo $ActivityID ?>" class="btn btn-info">View Activity</a>
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
    } elseif ($control == "signOut") {
        session_unset();
        session_destroy();
        header("location: ../admin/index.php");
    } elseif ($control == 'sendAffiliate') {
        ?>
        <div class="container">
            <div class="section-title">
                <h4 class="text-primary">send affiliate request</h4>
            </div>
            <form action="" class="form add-form hz-form" autocomplete="off" enctype="multipart/form-data" method="POST">
                <h2 class="form-title">affiliate details</h2>
                <div class="input-field">
                    <label class="input-field-label" for="">affiliation Reason:</label>
                    <textarea class="pass-input" type="text" name="affiliationReason" placeholder="affiliationReason" required></textarea>
                </div>
                <div class="input-field">
                    <label class="input-field-label" for="">send pdf:</label>
                    <input class="pass-input" type="file" name="attachCV" required>
                </div>
                <div class="submit-2-field">
                    <input class="submit-btn" type="submit" value="send" name="send">
                </div>
            </form>
        </div>
    <?php
        if (isset($_POST['send'])) {
            $affiliationReason = $_POST['affiliationReason'];
            $userID = $_SESSION['userID'];
            // اسم الملف
            $fileName = basename($_FILES['attachCV']['name']);
            // تعريف اسم الملف ومكان المراد تخزين به 
            $targetFile = '../attachFiles/' . $fileName;
            // لجلب نوع الملف 
            $fileEx = pathinfo($targetFile, PATHINFO_EXTENSION);
            // صرحت عن مصفوفة لتخزين اللاحقات المسموح بها في الفورم 
            $fileType = array('pdf');
            // فحصت هل الملف الذي تم ادخاله هو ملف بي دي أف 
            if (in_array($fileEx, $fileType)) {
                // عملية نسخ الملف للمجلد الذي قمنا بأنشائه
                if (move_uploaded_file($_FILES['attachCV']['tmp_name'], $targetFile)) {
                    // وسوف يتم تخزين اسم الملف بالأضافة لمسار المجلد الموجود به 
                    $insertAffiliate = insertAffiliate($affiliationReason, $targetFile, $userID);
                    if ($insertAffiliate > 0) {
                        header('REFRESH:0;URL=?control=myInfo');
                    }
                }
            }
        }
    }

    ?>


</div>
<?php
require "includes/footer.html";
ob_get_flush();
