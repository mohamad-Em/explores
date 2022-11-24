<?php
// Account_management 
function users_userType($userType)
{
    require 'connect.php';
    try {
        $query = "SELECT * FROM users WHERE userType = :userType";
        $stmt = $conn->prepare($query);
        $stmt->execute(
            [
                ':userType' => $userType
            ]
        );
        return $stmt;
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

function users_userStatus($userID, $userStatus)
{
    require 'connect.php';
    try {
        $query = "UPDATE users SET userStatus = :userStatus WHERE userID = :userID";
        $stmt = $conn->prepare($query);
        $stmt->execute(
            [
                ':userID' => $userID,
                ':userStatus' => $userStatus
            ]
        );
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}
// Activities_management
function activityschedule_activity_status($activity_status)
{
    require 'connect.php';
    try {
        $query = "SELECT * FROM activityschedule WHERE activity_status = :activity_status";
        $stmt = $conn->prepare($query);
        $stmt->execute(
            [
                ':activity_status' => $activity_status,
            ]
        );
        return $stmt;
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
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

function activityschedule_ActivityID($ActivityID)
{
    require 'connect.php';
    try {
        $query = "SELECT activityschedule.*, users.userName, users.userPic FROM activityschedule INNER JOIN users ON activityschedule.userID = users.userID WHERE ActivityID = :ActivityID";
        $stmt = $conn->prepare($query);
        $stmt->execute(
            [
                ':ActivityID' => $ActivityID,
            ]
        );
        return $stmt;
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
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

function activityschedule_userStatus($ActivityID, $activity_status)
{
    require 'connect.php';
    try {
        $query = "UPDATE activityschedule SET activity_status = :activity_status WHERE ActivityID = :ActivityID";
        $stmt = $conn->prepare($query);
        $stmt->execute(
            [
                ':ActivityID' => $ActivityID,
                ':activity_status' => $activity_status
            ]
        );
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

function activityschedule_reservation($ActivityID)
{
    require 'connect.php';
    try {
        $query = "SELECT COUNT(*) AS 'COUNT' FROM reservation WHERE ActivityID = :ActivityID";
        $stmt = $conn->prepare($query);
        $stmt->execute(
            [
                ':ActivityID' => $ActivityID,
            ]
        );
        $row = $stmt->fetch();
        return $row['COUNT'];
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}
// Complaints_management

function complaints_toReply($toReply)
{
    require 'connect.php';
    try {
        if ($toReply == false) {
            $query = "SELECT complaints.*, users.userName, users.userPic, activityschedule.ActivityID, activityschedule.activityPlace FROM complaints INNER JOIN users ON complaints.userID = users.userID INNER JOIN activityschedule ON complaints.ActivityID = activityschedule.ActivityID WHERE complaints.toReply = '' ORDER BY complaintReplyDate DESC";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            return $stmt;
        } elseif ($toReply == true) {
            $query = "SELECT complaints.*, users.userName, users.userPic, activityschedule.ActivityID, activityschedule.activityPlace FROM complaints INNER JOIN users ON complaints.userID = users.userID INNER JOIN activityschedule ON complaints.ActivityID = activityschedule.ActivityID WHERE complaints.toReply != '' ORDER BY complaintReplyDate ASC";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            return $stmt;
        }
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

function complaints_ComplaintID($ComplaintID)
{
    require 'connect.php';
    try {
        $query = "SELECT complaints.*, users.userName, users.userPic, activityschedule.ActivityID, activityschedule.activityPlace FROM complaints INNER JOIN users ON complaints.userID = users.userID INNER JOIN activityschedule ON complaints.ActivityID = activityschedule.ActivityID WHERE ComplaintID = :ComplaintID";
        $stmt = $conn->prepare($query);
        $stmt->execute(
            [
                ':ComplaintID' => $ComplaintID
            ]
        );
        return $stmt;
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

function complaints_reply($toReply, $complaintReplyDate, $ComplaintID)
{
    require 'connect.php';
    try {
        $query = "UPDATE complaints SET toReply = :toReply, complaintReplyDate = :complaintReplyDate WHERE ComplaintID = :ComplaintID";
        $stmt = $conn->prepare($query);
        $stmt->execute(
            [
                ':toReply' => $toReply,
                ':complaintReplyDate' => $complaintReplyDate,
                ':ComplaintID' => $ComplaintID
            ]
        );
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

function complaints_delete($ComplaintID)
{
    require 'connect.php';
    try {
        $query = "DELETE FROM complaints WHERE ComplaintID = :ComplaintID";
        $stmt = $conn->prepare($query);
        $stmt->execute(
            [
                ':ComplaintID' => $ComplaintID
            ]
        );
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}
// Affiliate_application_management
function affiliate_toReply($toReply)
{
    require 'connect.php';
    try {
        if ($toReply == 3) {
            $query = "SELECT affiliate.*, users.userName, users.userEmail
            FROM affiliate 
            INNER JOIN users ON affiliate.userID = users.userID 
            WHERE affiliate.toReply = 3 ORDER BY affiliate.orderDate DESC";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            return $stmt;
        } elseif ($toReply == 2) {
            $query = "SELECT affiliate.*, users.userName, users.userEmail
            FROM affiliate 
            INNER JOIN users ON affiliate.userID = users.userID 
            WHERE affiliate.toReply = 2 ORDER BY affiliate.orderDate DESC";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            return $stmt;
        } else {
            $query = "SELECT affiliate.*, users.userName, users.userEmail
            FROM affiliate 
            INNER JOIN users ON affiliate.userID = users.userID 
            WHERE affiliate.toReply = 1 ORDER BY affiliate.orderDate DESC";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            return $stmt;
        }
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

function affiliate_AffiliateID($AffiliateID)
{
    require 'connect.php';
    try {
        $query = "SELECT affiliate.*, users.userName, users.userPic, users.userType FROM affiliate INNER JOIN users ON affiliate.userID = users.userID WHERE affiliate.AffiliateID = :AffiliateID";
        $stmt = $conn->prepare($query);
        $stmt->execute(
            [
                ':AffiliateID' => $AffiliateID
            ]
        );
        return $stmt;
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

function affiliate_userType($userID,$toReply, $userType)
{
    require 'connect.php';
    try {
        $query = "UPDATE affiliate INNER JOIN users ON affiliate.userID = users.userID 
        SET affiliate.toReply = :toReply, users.userType = :userType WHERE affiliate.userID = :userID";
        $stmt = $conn->prepare($query);
        $stmt->execute(
            [
                ':userID' => $userID,
                ':toReply' => $toReply,
                ':userType' => $userType
            ]
        );
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

function affiliate_reply($toReply, $AffiliateID)
{
    require 'connect.php';
    try {
        $query = "UPDATE affiliate SET toReply = :toReply WHERE AffiliateID = :AffiliateID";
        $stmt = $conn->prepare($query);
        $stmt->execute(
            [
                ':toReply' => $toReply,
                ':AffiliateID' => $AffiliateID
            ]
        );
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}

function affiliate_delete($AffiliateID)
{
    require 'connect.php';
    try {
        $query = "DELETE FROM affiliate WHERE AffiliateID = :AffiliateID";
        $stmt = $conn->prepare($query);
        $stmt->execute(
            [
                ':AffiliateID' => $AffiliateID
            ]
        );
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error :: " . $e->getMessage();
    }
}
