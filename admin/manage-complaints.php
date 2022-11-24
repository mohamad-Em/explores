<?php
    session_start();
    ob_start();
    include "connect.php";
    include "includes/templates/header.html";
    require 'includes/functions/function.php';
?>
    <link rel="stylesheet" href="layout/css/styling-forms.css">
<?php
    include "includes/templates/navbar.html";
    $control = isset($_GET['control']) ? $_GET['control'] : 'unreplied';

    if($control == 'unreplied') {
        $toReply_false = false;
        $stmt_1 = complaints_toReply($toReply_false);
        ?>
        <div class="container">
            <div class="heading">
                <i class="fas fa-bars bar-menu" id="navbar-btn"></i>
                <a href="sign-out.php">sign out</a>
            </div>
            <div class="main-title">
                <h2>all complaints</h2>
            </div>
            <a href="?control=replied" class="btn btn-primary">replied complaints</a><br>
            <span class="fs-2">all unreplied complaints messages:</span>
            <?php  if ($stmt_1->rowCount() > 0) { ?>
                <div class="table-responsive">
                    <table class="table table-hover text-center">
                        <thead class="table-dark">
                            <th >#</th>
                            <th class="col-6">complaint detail</th>
                            <th >user name</th>
                            <th >activity</th>
                            <th >controls</th>
                        </thead>
                        <tbody>
                           <?php
                           $counter= 0;
                            while ($row_1 = $stmt_1->fetch()) { 
                                $counter++;
                                ?>
                                <tr>
                                    <td><?php echo $counter; ?></td>
                                    <td class="complaint-details"><?php echo $row_1['details'] ?></td>
                                    <td><?php echo $row_1['userName'] ?></td>
                                    <td>
                                        <a href="manage-activities.php?control=view&ActivityID=<?php echo $row_1['ActivityID']?>" style="color: red;"><?php echo $row_1['activityPlace'] ?></a>
                                    </td>
                                    <td>
                                        <a href="?control=addReply&complaintID=<?php echo $row_1['ComplaintID']?>" class="btn btn-primary">reply</a>
                                    </td>                               
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
            
        </div>
    <?php
    } elseif($control == 'replied') {
        $toReply_true = true;
        $stmt_1 = complaints_toReply($toReply_true);
        ?>
        <div class="container">
            <div class="heading">
            <i class="fas fa-bars bar-menu" id="navbar-btn"></i>
            <a href="sign-out.php">sign out</a>
            </div>
            <div class="main-title">
                <h2>all complaints</h2>
            </div>
            <a href="?control=unreplied" class="btn btn-primary mb-2">unreplied complaints</a><br>
            <span class="fs-2">all replied complaints messages:</span>
            <?php  if ($stmt_1->rowCount() > 0) { ?>
                <div class="table-responsive">
                    <table class="table table-hover text-center">
                        <thead class="table-dark">
                            <th >#</th>
                            <th class="col-4">complaint detail</th>
                            <th class="col-4">replied message</th>
                            <th >user name</th>
                            <th >activity</th>
                            <th >controls</th>
                        </thead>
                        <tbody>
                           <?php
                           $counter= 0;
                            while ($row_1 = $stmt_1->fetch()) { 
                                $counter++;
                                ?>
                                <tr>
                                    <td><?php echo $counter; ?></td>
                                    <td class="complaint-details"><?php echo $row_1['details'] ?></td>
                                    <td class="complaint-reply"><?php echo $row_1['toReply'] ?></td>
                                    <td><?php echo $row_1['userName'] ?></td>
                                    <td>
                                        <a href="manage-activities.php?control=view&ActivityID=<?php echo $row_1['ActivityID']?>" style="color: red;"><?php echo $row_1['activityPlace'] ?></a>
                                    </td>
                                    <td>
                                        <a href="?control=editReply&complaintID=<?php echo $row_1['ComplaintID']?>" class="btn btn-primary mb-1">edit reply</a>
                                        <a href="?control=delete&complaintID=<?php echo $row_1['ComplaintID'] ?>" class="btn btn-danger">delete</a>
                                    </td>                               
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php }
    } elseif($control == 'delete') {
        $ComplaintID = intval($_GET['complaintID']);
        if (complaints_delete($ComplaintID) == 1) {
            header('REFRESH:0;URL=?control=replied');
        }
    } elseif($control == 'addReply') {
        $ComplaintID = intval($_GET['complaintID']);
        $stmt = complaints_ComplaintID($ComplaintID);
        $row = $stmt->fetch();
        ?>
        <div class="container">
            <div class="heading">
                <i class="fas fa-bars bar-menu" id="navbar-btn"></i>
                <a href="sign-out.php">sign out</a>
            </div>
            <form class="form hz-form" style="margin: 0 auto;" action="" method="POST">
                <div class="input-field">
                    <h4>complaint message:</h4>
                    <p class="form-para"><?php echo $row['details'] ?></p>
                </div>
                <div class="input-field">
                    <label class="input-field-label" for="">reply:</label>
                    <textarea name="replyMessage" cols="30" rows="3"></textarea>
                </div>
                <div class="submit-field">
                    <input class="submit-btn" type="submit" value="reply" name="replyBTN">
                </div>
            </form>
        </div>
        <?php
        if(isset($_POST['replyBTN'])) {
            if (!empty($_POST['replyMessage'])) {
                $replyMessage = $_POST['replyMessage'];
                $ComplaintID = $_GET['complaintID'];
                $complaintReplyDate = date("Y-m-d H:i:s");  
                if (complaints_reply($replyMessage ,$complaintReplyDate, $ComplaintID) == 1) {
                    header('REFRESH:0;URL=manage-complaints.php');
                }
            } else {
                echo 'Please fill in all the data';
            }
        }
    } elseif($control == 'editReply') {
        $ComplaintID = intval($_GET['complaintID']);
        $stmt = complaints_ComplaintID($ComplaintID);
        $row = $stmt->fetch();
        ?>
        <div class="container">
            <div class="heading">
                <i class="fas fa-bars bar-menu" id="navbar-btn"></i>
                <a href="sign-out.php">sign out</a>
            </div>
            <form class="form hz-form" style="margin: 0 auto;" action="" method="POST">
                <div class="input-field">
                    <h4>complaint message:</h4>
                    <p class="form-para"><?php echo $row['details'] ?></p>
                </div>
                <div class="input-field">
                    <label class="input-field-label" for="">reply:</label>
                    <textarea name="replyMessage" cols="30" rows="3"><?php echo $row['toReply'] ?></textarea>
                </div>
                <div class="submit-field">
                    <input class="submit-btn" type="submit" value="reply" name="replyBTN">
                </div>
            </form>
        </div>
        <?php 
        if(isset($_POST['replyBTN'])) {
            if (!empty($_POST['replyMessage'])) {
                $replyMessage = $_POST['replyMessage'];
                $ComplaintID = $_GET['complaintID'];
                $complaintReplyDate = date("Y-m-d H:i:s");  
                if (complaints_reply($replyMessage ,$complaintReplyDate, $ComplaintID) == 1) {
                    header('REFRESH:0;URL=manage-complaints.php?control=replied');
                }
            } else {
                echo 'Please fill in all the data';
            }
        }
    }
?>
    
<?php
ob_end_flush();
    include "includes/templates/footer.html";
?>