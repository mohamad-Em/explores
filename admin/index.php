<?php
include "connect.php";
include "includes/templates/header.html";
require 'includes/functions/function.php';
session_start();
if (isset($_SESSION['userName'])) {
    header('location:Check_account_type.php');
    exit();
}
function login($userEmail, $userPassword)
{
    require 'connect.php';
    try {
        $query = "SELECT * FROM users WHERE userEmail = :userEmail AND userPassword = :userPassword";
        $stmt = $conn->prepare($query);
        $stmt->execute(
            [
                ':userEmail' => $userEmail,
                ':userPassword' => $userPassword
            ]
        );
        $count = $stmt->rowCount();
        if ($count == 1) {
            $row = $stmt->fetch();
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
            header('REFRESH:0;URL=Check_account_type.php');
        } else {
?>
            <div class="alert alert-danger text-center fs-4" style="position: absolute; inset: 0; width: 100%; height: 70px;">please check your info there is an arror</div>
        <?php
        }
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}
if (isset($_POST['BTN-LOGIN'])) {
    if (!empty($_POST['userEmail']) && !empty($_POST['userPassword'])) {
        $userEmail = $_POST['userEmail'];
        $userPassword = sha1($_POST['userPassword']);

        login($userEmail, $userPassword);
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
        <form action="" class="form" autocomplete="off" method="POST">
            <h2 class="form-title">sign in</h2>
            <span style="color: #999;">
                <span style="color: rgb(255, 104, 104);">exploratory activities </span>
                is the right one to see people activities and share yours
            </span>
            <div class="input-field">
                <label class="input-field-label" for="">email:</label>
                <input class="text-input" type="text" name="userEmail" autocomplete="off">
            </div>
            <div class="input-field">
                <label class="input-field-label" for="">password:</label>
                <input class="pass-input" type="password" name="userPassword" autocomplete="new-password">
            </div>
            <div class="submit-field">
                <input class="submit-btn" type="submit" name="BTN-LOGIN" value="sign in" name="BTNlogin">
                <a href="register.php">don't have an account?</a>
            </div>
        </form>
    </div>
    <?php
    include "includes/templates/footer.html";
    ?>