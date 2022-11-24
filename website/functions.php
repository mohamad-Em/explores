<?php
function showActivities()
{
    require 'connect.php';
    try {
        $sql = "SELECT activityschedule.*, users.userFullname FROM activityschedule INNER JOIN
                users ON activityschedule.userID = users.userID
                WHERE activity_status=2";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    } catch (PDOException $e) {
        echo 'Error' . $e->getMessage();
    }
}
function showActivity($activityschedule_gender, $activityschedule_Health_status, $activityschedule_physical_state, $activity_status, $userID = null)
{
    require 'connect.php';
    try {
        $sql = "SELECT activityschedule.*, users.userFullname FROM activityschedule INNER JOIN
                users ON activityschedule.userID = users.userID
                WHERE (activityschedule_gender=:gender
                OR activityschedule_gender = 3)
                AND activityschedule_Health_status >=:Health_status
                AND activityschedule_physical_state>=:physical_state
                AND activity_status = :activity_status
                AND activityschedule.userID != :userID";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':gender' => $activityschedule_gender,
            ':Health_status' => $activityschedule_Health_status,
            ':physical_state' => $activityschedule_physical_state,
            ':activity_status' => $activity_status,
            ':userID' => $userID
        ]);
        return $stmt;
    } catch (PDOException $e) {
        echo 'Error' . $e->getMessage();
    }
}
function photos_ActivityID($ActivityID, $number)
{
    require 'connect.php';
    try {
        if ($number == 1) {
            $query = "SELECT picture FROM photos WHERE ActivityID = :ActivityID  LIMIT 1";
            $stmt = $conn->prepare($query);
            $stmt->execute(
                [
                    ':ActivityID' => $ActivityID,
                ]
            );
            $row = $stmt->fetch();
            return $row['picture'];
        } elseif ($number == '*') {
            $query = "SELECT picture FROM photos WHERE ActivityID = :ActivityID";
            $stmt = $conn->prepare($query);
            $stmt->execute(
                [
                    ':ActivityID' => $ActivityID,
                ]
            );
            return $stmt;
        }
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}
function searchActivities($severity_level = 0, $activityschedule_Health_status = 0, $activityschedule_physical_state = 0, $activity_status, $userID = 0)
{
    require 'connect.php';
    try {
        $sql = "SELECT activityschedule.*, users.userFullname FROM activityschedule INNER JOIN
                users ON activityschedule.userID = users.userID WHERE activity_status= :activity_status AND activityschedule.userID != :userID";
        if ($severity_level !== 0) {
            $sql .= " AND severity_level = '$severity_level'";
        }
        if ($activityschedule_Health_status !== 0) {
            $sql .= " AND activityschedule_Health_status = '$activityschedule_Health_status'";
        }
        if ($activityschedule_physical_state !== 0) {
            $sql .= " AND activityschedule_physical_state = '$activityschedule_physical_state'";
        }
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':activity_status' => $activity_status,
            ':userID' => $userID
        ]);
        return $stmt;
    } catch (PDOException $e) {
    }
}
function viewActivity($userID = null, $ActivityID = null)
{
    require 'connect.php';
    if ($userID == null && $ActivityID == null) {
        try {
            $sql = 'SELECT * FROM activityschedule';
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            echo 'Error' . $e->getMessage();
        }
    } elseif ($userID == null && $ActivityID != null) {
        $ActivityID = $_GET['ActivityID'];
        try {
            $sql = 'SELECT activityschedule.*, users.userFullName FROM activityschedule  INNER JOIN users 
            ON activityschedule.userID = users.userID WHERE ActivityID=:ActivityID';
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':ActivityID' => $ActivityID
            ]);
            return $stmt;
        } catch (PDOException $e) {
            echo 'Error' . $e->getMessage();
        }
    } elseif ($userID != null && $ActivityID == null) {
        require 'connect.php';
        try {
            $sql = 'SELECT activityschedule.*, users.UserFullname FROM activityschedule INNER JOIN users 
            ON activityschedule.userID = users.userID WHERE activityschedule.userID=:userID AND activityschedule.activity_status = 2';
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':userID' => $userID
            ]);
            return $stmt;
        } catch (PDOException $e) {
        }
    }
}
function viewRating_($ActivityID, $ratingStatus)
{
    require 'connect.php';
    $ActivityID = $_GET['ActivityID'];
    try {
        $sql = 'SELECT * FROM activityschedule
                INNER JOIN rating
                ON activityschedule.ActivityID=rating.ActivityID
                INNER JOIN users
                ON users.userID=rating.userID
                WHERE activityschedule.ActivityID=:ActivityID
                AND rating.ratingStatus=:ratingStatus';
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':ActivityID' => $ActivityID,
            ':ratingStatus' => $ratingStatus
        ]);
        return $stmt;
    } catch (PDOException $e) {
        echo 'Error' . $e->getMessage();
    }
}
function viewPosts_($ActivityID, $postStatus)
{
    require 'connect.php';
    $ActivityID = $_GET['ActivityID'];
    try {
        $sql = 'SELECT posts.*, activityschedule.ActivityID, users.userFullName FROM posts
                INNER JOIN activityschedule
                ON activityschedule.ActivityID=posts.ActivityID
                INNER JOIN users
                ON users.userID=posts.userID
                WHERE activityschedule.ActivityID=:ActivityID
                AND posts.postStatus=:postStatus';
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':ActivityID' => $ActivityID,
            ':postStatus' => $postStatus
        ]);
        return $stmt;
    } catch (PDOException $e) {
        echo 'Error' . $e->getMessage();
    }
}
function insertReservation_($reserveStatus, $ActivityID, $userID)
{
    require 'connect.php';
    try {
        $sql = 'INSERT INTO reservation(reserveStatus,ActivityID,userID)
                VALUES(:reserveStatus,:ActivityID,:userID)';
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':reserveStatus' => $reserveStatus,
            ':ActivityID' => $ActivityID,
            ':userID' => $userID
        ]);
        return $stmt->rowCount();
    } catch (PDOException $e) {
    }
}
function checkReservation_($ActivityID, $userID)
{
    require 'connect.php';
    try {
        $sql = 'SELECT reservation.* FROM reservation
                INNER JOIN  activityschedule
                ON reservation.ActivityID=activityschedule.ActivityID
                INNER JOIN users
                ON reservation.userID = users.userID
                WHERE reservation.ActivityID=:ActivityID
                AND reservation.userID=:userID';
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':ActivityID' => $ActivityID,
            ':userID' => $userID
        ]);
        return $stmt;
    } catch (PDOException $e) {
    }
}
function insertRating_($userID, $ActivityID, $evaluation, $ratingStatus)
{
    require 'connect.php';
    try {
        $sql = 'INSERT INTO rating(userID,ActivityID,evaluation,ratingStatus)
                VALUES(:userID,:ActivityID,:evaluation,:ratingStatus)';
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':userID' => $userID,
            ':ActivityID' => $ActivityID,
            ':evaluation' => $evaluation,
            ':ratingStatus' => $ratingStatus
        ]);
        return $stmt;
    } catch (PDOException $e) {
    }
}
function insertPost_($publishedTitle, $postDetails, $imgContent, $userId, $postStatus, $ActivityID)
{
    require 'connect.php';
    try {
        $sql = "INSERT INTO posts(publishedTitle,postDetails,Picture,userId,postStatus,ActivityID)
                VALUES(:publishedTitle,:postDetails,'$imgContent',:userId,:postStatus,:ActivityID)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':publishedTitle' => $publishedTitle,
            ':postDetails' => $postDetails,
            ':userId' => $userId,
            ':postStatus' => $postStatus,
            ':ActivityID' => $ActivityID
        ]);
        return $stmt->rowCount();
    } catch (PDOException $e) {
    }
}
function insertComplaints_($details, $ActivityID, $userID)
{
    require 'connect.php';
    try {
        $sql = 'INSERT INTO complaints(details,ActivityID,userID)
                VALUES(:details,:ActivityID,:userID)';
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':details' => $details,
            ':ActivityID' => $ActivityID,
            ':userID' => $userID
        ]);
        return $stmt->rowCount();
    } catch (PDOException $e) {
    }
}

function viewPost_($userID, $postStatus)
{
    require 'connect.php';
    try {
        $sql = 'SELECT * FROM activityschedule
                                INNER JOIN posts
                                ON activityschedule.ActivityID=posts.ActivityID
                                INNER JOIN users
                                ON users.userID=posts.userID
                                WHERE users.userID=:userID
                                AND posts.postStatus=:postStatus';
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':userID' =>  $userID,
            ':postStatus' => $postStatus
        ]);
        return $stmt;
    } catch (PDOException $e) {
        echo 'Error' . $e->getMessage();
    }
}
function editPost($PublishedID)
{
    require 'connect.php';
    try {
        $sql = 'SELECT * FROM posts WHERE PublishedID=:PublishedID';
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':PublishedID' => $PublishedID
        ]);
        return $stmt;
    } catch (PDOException $e) {
    }
}
function updatePost($publishedTitle, $postDetails, $imgContent, $PublishedID)
{
    require 'connect.php';
    try {
        $sql = "UPDATE posts SET publishedTitle=:publishedTitle, 
                                postDetails=:postDetails,
                                Picture='$imgContent'
                WHERE PublishedID=:PublishedID";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':publishedTitle' => $publishedTitle,
            ':postDetails' => $postDetails,
            ':PublishedID' => $PublishedID
        ]);
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo 'Error' . $e->getMessage();
    }
}
function deletePost($PublishedID)
{
    require 'connect.php';
    try {
        $sql = 'DELETE FROM posts WHERE PublishedID=:PublishedID';
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':PublishedID' => $PublishedID
        ]);
        return $stmt->rowCount();
    } catch (PDOException $e) {
    }
}
function complaints($userID)
{
    require 'connect.php';
    try {
        $sql = 'SELECT * FROM complaints  WHERE userID=:userID';
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':userID' => $userID
        ]);
        return $stmt;
    } catch (PDOException $e) {
    }
}



//profile page functions
function updateInfo($userName, $userFullname, $imgContent, $birthDate, $userID)
{
    require 'connect.php';
    try {
        $sql = "UPDATE users SET 
                        userName=:userName,
                        userFullname=:userFullname,
                        userPic='$imgContent',
                        birthDate=:birthDate
                WHERE userID=:userID";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':userName' => $userName,
            ':userFullname' => $userFullname,
            ':birthDate' => $birthDate,
            ':userID' => $userID
        ]);
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo 'Error' . $e->getMessage();
    }
}
function updateInfo_2($userName, $userFullname, $birthDate, $userID)
{
    require 'connect.php';
    try {
        $sql = "UPDATE users SET 
                        userName=:userName,
                        userFullname=:userFullname,
                        birthDate=:birthDate
                WHERE userID=:userID";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':userName' => $userName,
            ':userFullname' => $userFullname,
            ':birthDate' => $birthDate,
            ':userID' => $userID
        ]);
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo 'Error' . $e->getMessage();
    }
}
function insertAffiliate($affiliationReason, $targetFile, $userID)
{
    require 'connect.php';
    try {
        $sql = 'INSERT INTO affiliate(affiliationReason,attachCV,userID)
        VALUES(:affiliationReason,:attachCV,:userID)';
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':affiliationReason' => $affiliationReason,
            ':attachCV' => $targetFile,
            ':userID' => $userID
        ]);
        return $stmt->rowCount();
    } catch (PDOException $e) {
    }
}
function MyAffiliate($userID)
{
    require 'connect.php';
    try {
        $sql = 'SELECT * FROM affiliate WHERE userID=:userID';
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':userID' => $userID
        ]);
        return $stmt;
    } catch (PDOException $e) {
    }
}

////////////
// supervisor 
function supervisor($userType, $userID)
{
    require 'connect.php';
    try {
        $sql = 'SELECT * FROM users WHERE userType = :userType AND userID != :userID';
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':userType' => $userType,
            ':userID' => $userID
        ]);
        return $stmt;
    } catch (PDOException $e) {
    }
}
function search_supervisor($searchField, $userID)
{
    require 'connect.php';
    try {
        $sql = "SELECT * FROM users WHERE userName LIKE '%$searchField%' AND userType=2 AND userID != :userID";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':userID' => $userID
        ]);
        return $stmt;
    } catch (PDOException $e) {
    }
}
////
//user registered activities
function reservationUser($userID, $reserveStatus)
{
    require 'connect.php';
    try {
        $sql = 'SELECT * FROM activityschedule
                                INNER JOIN reservation
                                ON activityschedule.ActivityID=reservation.ActivityID 
                                INNER JOIN users
                                ON users.userID=reservation.userID
                                WHERE users.userID=:userID
                                AND reservation.reserveStatus=:reserveStatus';
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':userID' => $userID,
            ':reserveStatus' => $reserveStatus
        ]);
        return $stmt;
    } catch (PDOException $e) {
        echo 'Error' . $e->getMessage();
    }
}
function deleteRegistration($ReservationID)
{
    require 'connect.php';
    try {
        $sql = ('DELETE FROM reservation WHERE ReservationID = :ReservationID');
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':ReservationID' => $ReservationID
        ]);
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo 'Error' . $e->getMessage();
    }
}
