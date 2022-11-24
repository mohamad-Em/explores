<?php
// Account_management 
// function users_userType($userType)
// {
//     require 'connect.php';
//     try {
//         $query = "SELECT * FROM users WHERE userType = :userType";
//         $stmt = $conn->prepare($query);
//         $stmt->execute(
//             [
//                 ':userType' => $userType
//             ]
//         );
//         return $stmt;
//     } catch (PDOException $e) {
//         echo "Error :: " . $e->getMessage();
//     }
// }

// function users_userStatus($userID, $userStatus)
// {
//     require 'connect.php';
//     try {
//         $query = "UPDATE users SET userStatus = :userStatus WHERE userID = :userID";
//         $stmt = $conn->prepare($query);
//         $stmt->execute(
//             [
//                 ':userID' => $userID,
//                 ':userStatus' => $userStatus
//             ]
//         );
//         return $stmt->rowCount();
//     } catch (PDOException $e) {
//         echo "Error :: " . $e->getMessage();
//     }
// }
// // Activities_management
// function activityschedule_activity_status($activity_status)
// {
//     require 'connect.php';
//     try {
//         $query = "SELECT * FROM activityschedule WHERE activity_status = :activity_status";
//         $stmt = $conn->prepare($query);
//         $stmt->execute(
//             [
//                 ':activity_status' => $activity_status,
//             ]
//         );
//         return $stmt;
//     } catch (PDOException $e) {
//         echo "Error :: " . $e->getMessage();
//     }
// }

// function photos_ActivityID($ActivityID, $number)
// {
//     require 'connect.php';
//     try {
//         if ($number == 1) {
//             $query = "SELECT picture FROM photos WHERE ActivityID = :ActivityID  LIMIT 1";
//             $stmt = $conn->prepare($query);
//             $stmt->execute(
//                 [
//                     ':ActivityID' => $ActivityID,
//                 ]
//             );
//             $row = $stmt->fetch();
//             return $row['picture'];
//         } elseif ($number == '*') {
//             $query = "SELECT picture FROM photos WHERE ActivityID = :ActivityID";
//             $stmt = $conn->prepare($query);
//             $stmt->execute(
//                 [
//                     ':ActivityID' => $ActivityID,
//                 ]
//             );
//             return $stmt;
//         }
//     } catch (PDOException $e) {
//         echo "Error :: " . $e->getMessage();
//     }
// }

// function activityschedule_ActivityID($ActivityID)
// {
//     require 'connect.php';
//     try {
//         $query = "SELECT activityschedule.*, users.userName, users.userPic FROM activityschedule INNER JOIN users ON activityschedule.userID = users.userID WHERE ActivityID = :ActivityID";
//         $stmt = $conn->prepare($query);
//         $stmt->execute(
//             [
//                 ':ActivityID' => $ActivityID,
//             ]
//         );
//         return $stmt;
//     } catch (PDOException $e) {
//         echo "Error :: " . $e->getMessage();
//     }
// }

// function rating_ActivityID($ActivityID, $ratingStatus)
// {
//     require 'connect.php';
//     try {
//         $query = "SELECT rating.*, users.userName, users.userPic FROM rating INNER JOIN users ON rating.userID = users.userID WHERE ActivityID = :ActivityID AND ratingStatus = :ratingStatus";
//         $stmt = $conn->prepare($query);
//         $stmt->execute(
//             [
//                 ':ActivityID' => $ActivityID,
//                 ':ratingStatus' => $ratingStatus
//             ]
//         );
//         return $stmt;
//     } catch (PDOException $e) {
//         echo "Error :: " . $e->getMessage();
//     }
// }

// function activityschedule_userStatus($ActivityID, $activity_status)
// {
//     require 'connect.php';
//     try {
//         $query = "UPDATE activityschedule SET activity_status = :activity_status WHERE ActivityID = :ActivityID";
//         $stmt = $conn->prepare($query);
//         $stmt->execute(
//             [
//                 ':ActivityID' => $ActivityID,
//                 ':activity_status' => $activity_status
//             ]
//         );
//         return $stmt->rowCount();
//     } catch (PDOException $e) {
//         echo "Error :: " . $e->getMessage();
//     }
// }

// function activityschedule_reservation($ActivityID)
// {
//     require 'connect.php';
//     try {
//         $query = "SELECT COUNT(*) AS 'COUNT' FROM reservation WHERE ActivityID = :ActivityID";
//         $stmt = $conn->prepare($query);
//         $stmt->execute(
//             [
//                 ':ActivityID' => $ActivityID,
//             ]
//         );
//         $row = $stmt->fetch();
//         return $row['COUNT'];
//     } catch (PDOException $e) {
//         echo "Error :: " . $e->getMessage();
//     }
// }

function viewActivity_userID($userID, $activityStatus)
{
    require 'connect.php';
    if ($userID) {
        try {
            $sql = 'SELECT * FROM activityschedule WHERE userID = :userID AND activity_status = :activity_status';
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':userID' => $userID,
                ':activity_status' => $activityStatus
            ]);
            return $stmt;
        } catch (PDOException $e) {
            echo "Error" . $e->getMessage();
        }
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
            $query = "SELECT * FROM photos WHERE ActivityID = :ActivityID";
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
function addActivity (
    $activityPlace,
    $activityDescription,
    $Registration_start_date,
    $Registration_expiration_date,
    $registrationCost,
    $note,
    $activitySupplies,
    $Weighing_activity_supplies,
    $specific_age,
    $severity_level,
    $Activity_start_date,
    $Activity_end_date,
    $presence,
    $activityschedule_gender,
    $activityschedule_Health_status,
    $activityschedule_physical_state,
    $userID,
    $imgContent
) {
    require 'connect.php';
    try {
            $sql = 'INSERT INTO 
                    activityschedule(
                    activityPlace,
                    activityDescription,
                    Registration_start_date,
                    Registration_expiration_date,
                    registrationCost,
                    note,
                    activitySupplies,
                    Weighing_activity_supplies,
                    specific_age,severity_level,
                    Activity_start_date,
                    Activity_end_date,
                    presence,
                    userID,
                    activityschedule_gender,
                    activityschedule_Health_status,
                    activityschedule_physical_state) 
                    VALUES(:activityPlace,
                        :activityDescription,
                        :Registration_start_date,
                        :Registration_expiration_date,
                        :registrationCost,
                        :note,
                        :activitySupplies,
                        :Weighing_activity_supplies,
                        :specific_age,:severity_level,
                        :Activity_start_date,
                        :Activity_end_date,
                        :presence,
                        :userID,
                        :activityschedule_gender,
                        :activityschedule_Health_status,
                        :activityschedule_physical_state)';
            $stmt = $conn->prepare($sql);
            $stmt->execute(
                [
                ':activityPlace' => $activityPlace,
                ':activityDescription' => $activityDescription,
                ':Registration_start_date' => $Registration_start_date,
                ':Registration_expiration_date' => $Registration_expiration_date,
                ':registrationCost' => $registrationCost,
                ':note' => $note,
                ':activitySupplies' => $activitySupplies,
                ':Weighing_activity_supplies' => $Weighing_activity_supplies,
                ':specific_age' => $specific_age,
                ':severity_level' => $severity_level,
                ':Activity_start_date' => $Activity_start_date,
                ':Activity_end_date' => $Activity_end_date,
                ':presence' => $presence,
                ':userID' => $userID,
                ':activityschedule_gender' => $activityschedule_gender,
                ':activityschedule_Health_status' => $activityschedule_Health_status,
                ':activityschedule_physical_state' => $activityschedule_physical_state
            ]
            );
            if($stmt->rowCount() > 0) {
                $x = $conn->lastInsertId('ActivityID');
                $query = "INSERT INTO photos(picture,ActivityID) VALUES('$imgContent', '$x')";
                $stmt_photos = $conn->prepare($query);
                $stmt_photos->execute();
            }
            return $stmt->rowCount();

    }
    catch (PDOException $e) {
    }
}
function editActivity (
    $activityPlace,
    $activityDescription,
    $Registration_start_date,
    $Registration_expiration_date,
    $registrationCost,
    $note,
    $activitySupplies,
    $Weighing_activity_supplies,
    $specific_age,
    $severity_level,
    $Activity_start_date,
    $Activity_end_date,
    $presence,
    $activityschedule_gender,
    $activityschedule_Health_status,
    $activityschedule_physical_state,
    $activityID
) {
    require 'connect.php';
    try {
        $sql = "UPDATE activityschedule SET 
                activityPlace=:activityPlace,
                activityDescription=:activityDescription,
                Registration_start_date='$Registration_start_date',
                Registration_expiration_date='$Registration_expiration_date',
                registrationCost=:registrationCost,
                note=:note,
                activitySupplies=:activitySupplies,
                Weighing_activity_supplies=:Weighing_activity_supplies,
                specific_age=:specific_age,
                severity_level=:severity_level,
                Activity_start_date='$Activity_start_date',
                Activity_end_date='$Activity_end_date',
                presence=:presence,
                activityschedule_gender=:activityschedule_gender,
                activityschedule_Health_status=:activityschedule_Health_status,
                activityschedule_physical_state=:activityschedule_physical_state 
                WHERE ActivityID=:ActivityID";
            $stmt = $conn->prepare($sql);
            $stmt->execute(
                [
                ':activityPlace' => $activityPlace,
                ':activityDescription' => $activityDescription,
                ':registrationCost' => $registrationCost,
                ':note' => $note,
                ':activitySupplies' => $activitySupplies,
                ':Weighing_activity_supplies' => $Weighing_activity_supplies,
                ':specific_age' => $specific_age,
                ':severity_level' => $severity_level,
                ':presence' => $presence,
                ':activityschedule_gender' => $activityschedule_gender,
                ':activityschedule_Health_status' => $activityschedule_Health_status,
                ':activityschedule_physical_state' => $activityschedule_physical_state,
                ':ActivityID' => $activityID
            ]
            );
            return $stmt->rowCount();

    }
    catch (PDOException $e) {
    }
}
function Activity($ActivityID)
{
    require 'connect.php';
    try {
        $sql = 'SELECT * FROM activityschedule WHERE ActivityID=:ActivityID';
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':ActivityID' => $ActivityID
        ]);
        return $stmt;
    } catch (PDOException $e) {
        echo 'Error' . $e->getMessage();
    }
}
function rating_ActivityID($ActivityID, $ratingStatus)
{
    require 'connect.php';
    try {
        $query = "SELECT rating.*, users.userName, users.userPic FROM rating INNER JOIN users ON rating.userID = users.userID WHERE ActivityID = :ActivityID AND ratingStatus = :ratingStatus";
        $stmt = $conn->prepare($query);
        $stmt->execute(
            [
                ':ActivityID' => $ActivityID,
                ':ratingStatus' => $ratingStatus
            ]
        );
        return $stmt;
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}
function insertImage_($ActivityID, $imgContent)
{
    require 'connect.php';
    try {
        $stmt = $conn->prepare("INSERT INTO photos(picture,ActivityID)
                                VALUES('$imgContent',:ActivityID)");
        $stmt->execute([
            ':ActivityID' => $ActivityID
        ]);
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo 'Error' . $e->getMessage();
    }
}
function delete_activity_pic($activity_pic)
{
    require 'connect.php';
    try {
        $sql = "DELETE FROM photos WHERE PhotoID = :picture";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':picture', $activity_pic, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

/// peoples
function viewUsers_($ActivityID, $Approved)
{
    require 'connect.php';
    try {
        $sql = 'SELECT * FROM activityschedule
                                INNER JOIN reservation
                                ON activityschedule.ActivityID=reservation.ActivityID 
                                INNER JOIN users
                                ON users.userID=reservation.userID
                                WHERE activityschedule.ActivityID=:ActivityID
                                AND reservation.reserveStatus=:Approved';
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':ActivityID' => $ActivityID,
            ':Approved' => $Approved
        ]);
        return $stmt;
    } catch (PDOException $e) {
        echo 'Error' . $e->getMessage();
    }
}
function ApprovedRating($RatingID, $ratingStatus)
{
    try {
        require 'connect.php';
        $sql = 'UPDATE rating SET ratingStatus=:ratingStatus WHERE RatingID=:RatingID';
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':ratingStatus' => $ratingStatus,
            ':RatingID' => $RatingID
        ]);
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo 'Error' . $e->getMessage();
    }
}
function Approved_($ReservationID, $reserveStatus)
{
    require 'connect.php';
    try {
        $sql = ('UPDATE reservation
                                    SET reserveStatus=:reserveStatus
                                WHERE ReservationID=:ReservationID');
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':ReservationID' => $ReservationID,
            ':reserveStatus' => $reserveStatus
        ]);
        return $stmt->rowCount();
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



function viewPost_($ActivityID, $postStatus)
{
    require 'connect.php';
    try {
        $sql = 'SELECT * FROM activityschedule
                                INNER JOIN posts
                                ON activityschedule.ActivityID=posts.ActivityID
                                INNER JOIN users
                                ON users.userID=posts.userID
                                WHERE activityschedule.ActivityID=:ActivityID
                                AND posts.postStatus=:postStatus';
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':ActivityID' =>  $ActivityID,
            ':postStatus' => $postStatus
        ]);
        return $stmt;
    } catch (PDOException $e) {
        echo 'Error' . $e->getMessage();
    }
}

function enablePosts($PublishedID, $postStatus)
{
    require 'connect.php';
    try {
        $sql = 'UPDATE posts SET postStatus=:postStatus WHERE PublishedID=:PublishedID';
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':PublishedID' => $PublishedID,
            ':postStatus' => $postStatus
        ]);
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo 'Error' . $e->getMessage();
    }
}
function disablePost($PublishedID, $postStatus)
{
    require 'connect.php';
    try {
        $sql = 'UPDATE posts SET postStatus=:postStatus WHERE PublishedID=:PublishedID';
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':PublishedID' => $PublishedID,
            ':postStatus' => $postStatus
        ]);
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo 'Error' . $e->getMessage();
    }
}