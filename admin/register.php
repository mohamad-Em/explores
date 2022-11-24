<?php

include "includes/templates/header.html";

if (isset($_POST['BTN-SINUP'])) {
    if (!empty($_POST['userName']) && !empty($_POST['userEmail']) && !empty($_POST['userPassword']) && !empty($_POST['userFullname']) && !empty($_FILES["userPic"]["name"]) && !empty($_POST['birthDate']) && !empty($_POST['gender']) && !empty($_POST['Health_status']) && !empty($_POST['physical_state'])) {
        $userName = $_POST['userName'];
        $userEmail = $_POST['userEmail'];
        $userPassword = sha1($_POST['userPassword']);
        $userFullname = $_POST['userFullname'];

        $birthDate = $_POST['birthDate'];
        $gender = $_POST['gender'];
        $Health_status = $_POST['Health_status'];
        $physical_state = $_POST['physical_state'];

        if (check_userEmail($userEmail) > 0) {
            echo 'This email is already reserved by another user. Please enter another email';
        } else {
            $fileName = basename($_FILES["userPic"]["name"]);
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
            $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
            if (in_array($fileType, $allowTypes)) {
                $image = $_FILES['userPic']['tmp_name'];
                $imgContent = addslashes(file_get_contents($image));
                SINUP($userName, $userEmail, $userPassword, $userFullname, $imgContent, $birthDate, $gender, $Health_status, $physical_state);
            } else {
?>
                <div class="alert alert-danger text-center fs-4" style="position: absolute; inset: 0; width: 100%; height: 70px;">Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.</div>
        <?php
            }
        }
    } else {
        ?>
        <div class="alert alert-danger text-center fs-4" style="position: absolute; inset: 0; width: 100%; height: 70px;">Please fill in all the data</div>
<?php
    }
}
?>
<link rel="stylesheet" href="layout/css/styling-forms.css">
</head>

<body style="background-image: url('layout/bg.png'); background-position: center; background-size: cover; background-repeat: no-repeat; height: 100vh;">
    <div class="form-container">
        <form action="" method="POST" class="form hz-form" enctype="multipart/form-data" autocomplete="off">
            <h2 class="form-title">sign up</h2>
            <span class="form-desc" style="color: #999;">
                <span style="color: rgb(255, 104, 104);">exploratory activities </span>
                is the right one to see people activities and share yours
            </span>
            <div class="field">
                <div class="input-field">
                    <label class="input-field-label" for="">User Name:</label>
                    <input class="text-input" type="text" name="userName" autocomplete="off">
                </div>
                <div class="input-field">
                    <label class="input-field-label" for="">full name:</label>
                    <input class="text-input" type="text" name="userFullname" autocomplete="off">
                </div>
            </div>
            <div class="field">
                <div class="input-field">
                    <label class="input-field-label" for="">email:</label>
                    <input class="text-input" type="text" name="userEmail" autocomplete="off">
                </div>
                <div class="input-field">
                    <label class="input-field-label" for="">password:</label>
                    <input class="pass-input" type="password" name="userPassword" autocomplete="new-password">
                </div>
            </div>
            <div class="field">
                <div class="input-field">
                    <label class="input-field-label" for="">birth date:</label>
                    <input class="text-input" type="date" name="birthDate">
                </div>
                <div class="input-field">
                    <label class="input-field-label" for="">user picture:</label>
                    <input class="pass-input" type="file" name="userPic">
                </div>
            </div>
            <div class="field">
                <div class="input-field">
                    <label for="" class="input-field-label">gender</label>
                    <div class="radios">
                        <input type="radio" class="input-radio" name="gender" value="1"> Male
                        <input type="radio" class="input-radio" name="gender" value="2"> Female <br>
                    </div>
                </div>
                <div class="input-field">
                    <label for="" class="input-field-label">Health state </label>
                    <div class="radios">
                        <input type="radio" class="input-radio" name="Health_status" value="1"> Excellent
                        <input type="radio" class="input-radio" name="Health_status" value="2"> good
                        <input type="radio" class="input-radio" name="Health_status" value="3"> bad
                    </div>
                </div>
            </div>
            <div class="input-field">
                <label for="" class="input-field-label">physical state </label>
                <div class="radios">
                    <input type="radio" class="input-radio" name="physical_state" value="1"> Excellent
                    <input type="radio" class="input-radio" name="physical_state" value="2"> good
                    <input type="radio" class="input-radio" name="physical_state" value="3"> bad
                </div>
            </div>
            <div class="submit-field">
                <input class="submit-btn" type="submit" value="sign in" name="BTN-SINUP">
                <a href="index.php">already have an account?</a>
            </div>
        </form>
    </div>
    <?php
    include "includes/templates/footer.html";

    function check_userEmail($userEmail)
    {
        require 'connect.php';
        try {
            $sql = "SELECT * FROM users WHERE userEmail = :userEmail";
            $stmt = $conn->prepare($sql);
            $stmt->execute(
                [
                    ':userEmail' => $userEmail
                ]
            );

            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo "Error :: " . $e->getMessage();
        }
    }

    function SINUP($userName, $userEmail, $userPassword, $userFullname, $imgContent, $birthDate, $gender, $Health_status, $physical_state)
    {
        require 'connect.php';
        try {
            $query = "INSERT INTO users (userName, userEmail, userPassword, userFullname, userPic, birthDate, gender, Health_status, physical_state) VALUES (:userName, :userEmail, :userPassword, :userFullname, '$imgContent', :birthDate, :gender, :Health_status, :physical_state)";

            $stmt = $conn->prepare($query);

            $stmt->execute(
                [
                    ':userName' => $userName,
                    ':userEmail' => $userEmail,
                    ':userPassword' => $userPassword,
                    ':userFullname' => $userFullname,

                    ':birthDate' => $birthDate,
                    ':gender' => $gender,
                    ':Health_status' => $Health_status,
                    ':physical_state' => $physical_state,
                ]
            );

            $userID = $conn->lastInsertId('users');

            $query = "SELECT * FROM users WHERE userID = :userID";

            $stmt = $conn->prepare($query);

            $stmt->execute(
                [
                    ':userID' => $userID,
                ]
            );

            $row = $stmt->fetch();

            session_start();
            $_SESSION['userID'] = $row['userID'];
            $_SESSION['userName'] = $row['userName'];
            $_SESSION['userType'] = $row['userType'];
            $_SESSION['userStatus'] = $row['userStatus'];
            $_SESSION['userPic'] = $row['userPic'];
            $_SESSION['userFullname'] = $row['userFullname'];
            $_SESSION['userEmail'] = $row['userEmail'];
            $_SESSION['gender'] = $row['gender'];
            $_SESSION['Health_status'] = $row['Health_status'];
            $_SESSION['physical_state'] = $row['physical_state'];
            $_SESSION['birthDate'] = $row['birthDate'];

            // نقوم بتوجيه المستخدم لصفحة معينة
            header('REFRESH:0;URL=index.php');
        } catch (PDOException $e) {
            echo "Error :: " . $e->getMessage();
        }
    }
    ?>