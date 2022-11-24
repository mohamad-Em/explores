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
$control = isset($_GET['control']) ? $_GET['control'] : '';
if ($control == 'add-activity') {
?>
    <div class="container">
        <div class="heading">
            <i class="fas fa-bars bar-menu" id="navbar-btn"></i>
            <a href="sign-out.php">sign out</a>
        </div>
        <div class="main-title">
            <h2>add new activity</h2>
        </div>
        <form action="" method="POST" class="form hz-form activity-form" enctype="multipart/form-data" autocomplete="off">
            <h2 class="form-title">add activity details</h2>
            <p class="alert alert-warning text-center" style="width: 100%;">please fill all fields</p>
            <div class="field">
                <div class="input-field">
                    <label class="input-field-label" for="">activity Place:</label>
                    <input class="text-input" type="text" name="activityPlace" autocomplete="off">
                </div>
                <div class="input-field">
                    <label class="input-field-label" for="">presence:</label>
                    <input class="pass-input" type="number" name="presence" autocomplete="new-password">
                </div>
            </div>
            <div class="field">
                <div class="input-field">
                    <label class="input-field-label" for="">activity Description:</label>
                    <textarea class="text-input" type="text" name="activityDescription" autocomplete="off"></textarea>
                </div>
            </div>
            <div class="field">
                <div class="input-field">
                    <label class="input-field-label" for="">Registration start date:</label>
                    <input class="text-input" type="date" name="Registration_start_date" autocomplete="off">
                </div>
                <div class="input-field">
                    <label class="input-field-label" for="">Registration expiration date:</label>
                    <input class="pass-input" type="date" name="Registration_expiration_date" autocomplete="new-password">
                </div>
            </div>
            <div class="field">
                <div class="input-field">
                    <label class="input-field-label" for="">activity Supplies:</label>
                    <textarea class="pass-input" type="password" name="activitySupplies" autocomplete="new-password"></textarea>
                </div>
            </div>
            <div class="field">
                <div class="input-field">
                    <label class="input-field-label" for="">Weighing activity supplies: -KG</label>
                    <input class="text-input" type="text" placeholder="KG" name="Weighing_activity_supplies" autocomplete="off">
                </div>
                <div class="input-field">
                    <label class="input-field-label" for="">registration Cost:</label>
                    <input class="text-input" type="number" name="registrationCost" autocomplete="off">
                </div>
            </div>
            <div class="field">
                <div class="input-field">
                    <label class="input-field-label" for="">Activity start date:</label>
                    <input class="pass-input" type="date" name="Activity_start_date" autocomplete="new-password">
                </div>
                <div class="input-field">
                    <label class="input-field-label" for="">Activity end date:</label>
                    <input class="text-input" type="date" name="Activity_end_date" autocomplete="off">
                </div>
            </div>
            <div class="field">
                <div class="input-field">
                    <label class="input-field-label" for="">severity level:</label>
                    <div class="radios">
                        <input type="radio" class="input-radio" name="severity_level" value="1"> H
                        <input type="radio" class="input-radio" name="severity_level" value="2"> M
                        <input type="radio" class="input-radio" name="severity_level" value="3"> E
                    </div>
                </div>
                <div class="input-field">
                    <label for="" class="input-field-label">activity schedule physical state</label>
                    <div class="radios">
                        <input type="radio" class="input-radio" name="activityschedule_physical_state" value="1"> Excellent
                        <input type="radio" class="input-radio" name="activityschedule_physical_state" value="2"> good
                        <input type="radio" class="input-radio" name="activityschedule_physical_state" value="3"> bad
                    </div>
                </div>
            </div>
            <div class="field">
                <div class="input-field">
                    <label for="" class="input-field-label">activity schedule gender</label>
                    <div class="radios">
                        <input type="radio" class="input-radio" name="activityschedule_gender" value="1"> Male
                        <input type="radio" class="input-radio" name="activityschedule_gender" value="2"> Female <br>
                        <input type="radio" class="input-radio" name="activityschedule_gender" value="3"> both gender <br>
                    </div>
                </div>
                <div class="input-field">
                    <label for="" class="input-field-label">Health state </label>
                    <div class="radios">
                        <input type="radio" class="input-radio" name="activityschedule_Health_status" value="1"> Excellent
                        <input type="radio" class="input-radio" name="activityschedule_Health_status" value="2"> good
                        <input type="radio" class="input-radio" name="activityschedule_Health_status" value="3"> bad
                    </div>
                </div>
            </div>
            <div class="field">
                <div class="input-field">
                    <label class="input-field-label" for="">specific age:</label>
                    <input class="text-input" type="number" name="specific_age" autocomplete="off">
                </div>
                <div class="input-field">
                    <label class="input-field-label" for="">notes:</label>
                    <textarea class="pass-input" type="password" name="note" autocomplete="new-password"></textarea>
                </div>
            </div>
            <div class="input-field">
                <label class="input-field-label" for="">activity picture:</label>
                <input class="pass-input" type="file" name="picture">
            </div>
            <div class="submit-2-field">
                <input class="submit-btn" type="submit" value="add" name="add-ectivity">
            </div>
        </form>
    </div>

    <?php
    if (isset($_POST['add-ectivity'])) {
        if (
            !empty($_POST['activityPlace'])
            && !empty($_POST['presence'])
            && !empty($_POST['activityDescription'])
            && !empty($_POST['Registration_start_date'])
            && !empty($_POST['Registration_expiration_date'])
            && !empty($_POST['activitySupplies'])
            && !empty($_POST['Weighing_activity_supplies'])
            && !empty($_POST['registrationCost'])
            && !empty($_POST['Activity_start_date'])
            && !empty($_POST['Activity_end_date'])
            && !empty($_POST['severity_level'])
            && !empty($_POST['activityschedule_physical_state'])
            && !empty($_POST['activityschedule_gender'])
            && !empty($_POST['activityschedule_Health_status'])
            && !empty($_POST['specific_age'])
            && !empty($_POST['note'])
            && !empty($_FILES['picture']['name'])
        ) {
            $userID = $_SESSION['userID'];
            $activityPlace = $_POST['activityPlace'];
            $activityDescription = $_POST['activityDescription'];
            $Registration_start_date = $_POST['Registration_start_date'];
            $Registration_expiration_date = $_POST['Registration_expiration_date'];
            $registrationCost = $_POST['registrationCost'];
            $note = $_POST['note'];
            $activitySupplies = $_POST['activitySupplies'];
            $Weighing_activity_supplies = $_POST['Weighing_activity_supplies'];
            $specific_age = $_POST['specific_age'];
            $severity_level = $_POST['severity_level'];
            $Activity_start_date = $_POST['Activity_start_date'];
            $Activity_end_date = $_POST['Activity_end_date'];
            $presence = $_POST['presence'];
            $activityschedule_gender = $_POST['activityschedule_gender'];
            $activityschedule_Health_status = $_POST['activityschedule_Health_status'];
            $activityschedule_physical_state = $_POST['activityschedule_physical_state'];
            $fileName = basename($_FILES["picture"]["name"]);
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
            $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
            if (in_array($fileType, $allowTypes)) {
                $image = $_FILES['picture']['tmp_name'];
                $imgContent = addslashes(file_get_contents($image));
                if (addActivity(
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
                    $_SESSION['userID'],
                    $imgContent
                ) == 1) {
                    header('REFRESH:0;URL=manage-activities.php');
                }
            } else {
                echo 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
            }
        }
    }
} elseif ($control == 'edit-activity') {
    $activityID = $_GET['activityID'];
    $stmt = Activity($activityID);
    $row = $stmt->fetch();
    ?>
    <div class="container">
        <div class="heading">
            <i class="fas fa-bars bar-menu" id="navbar-btn"></i>
            <a href="sign-out.php">sign out</a>
        </div>
        <div class="main-title">
            <h2>add new activity</h2>
        </div>
        <form action="" method="POST" class="form hz-form activity-form" autocomplete="off">
            <h2 class="form-title">add activity details</h2>
            <p class="alert alert-warning text-center" style="width: 100%;">please fill all fields</p>
            <div class="field">
                <div class="input-field">
                    <label class="input-field-label" for="">activity Place:</label>
                    <input class="text-input" type="text" name="activityPlace" value="<?php echo $row['activityPlace'] ?>">
                </div>
                <div class="input-field">
                    <label class="input-field-label" for="">presence:</label>
                    <input class="pass-input" type="text" name="presence" value="<?php echo $row['presence'] ?>">
                </div>

            </div>
            <div class="field">
                <div class="input-field">
                    <label class="input-field-label" for="">activity Description:</label>
                    <textarea class="text-input" type="text" name="activityDescription"><?php echo $row['activityDescription'] ?></textarea>
                </div>
            </div>
            <div class="field">
                <div class="input-field">
                    <label class="input-field-label" for="">Registration start date:</label>
                    <input class="text-input" type="date" name="Registration_start_date" value="<?php echo $row['Registration_start_date'] ?>">
                </div>
                <div class="input-field">
                    <label class="input-field-label" for="">Registration expiration date:</label>
                    <input class="pass-input" type="date" name="Registration_expiration_date" value="<?php echo $row['Registration_expiration_date'] ?>">
                </div>
            </div>
            <div class="field">
                <div class="input-field">
                    <label class="input-field-label" for="">activity Supplies:</label>
                    <textarea class="pass-input" name="activitySupplies"><?php echo $row['activitySupplies'] ?></textarea>
                </div>
            </div>
            <div class="field">
                <div class="input-field">
                    <label class="input-field-label" for="">Weighing activity supplies:</label>
                    <input class="text-input" type="text" name="Weighing_activity_supplies" value="<?php echo $row['Weighing_activity_supplies'] ?>" autocomplete="off">
                </div>
                <div class="input-field">
                    <label class="input-field-label" for="">registration Cost:</label>
                    <input class="text-input" type="number" name="registrationCost" value="<?php echo $row['registrationCost'] ?>" autocomplete="off">
                </div>
            </div>
            <div class="field">
                <div class="input-field">
                    <label class="input-field-label" for="">Activity start date:</label>
                    <input class="pass-input" type="date" name="Activity_start_date" value="<?php echo $row['Activity_start_date'] ?>">
                </div>
                <div class="input-field">
                    <label class="input-field-label" for="">Activity end date:</label>
                    <input class="text-input" type="date" name="Activity_end_date" value="<?php echo $row['Activity_end_date'] ?>">
                </div>
            </div>
            <div class="field">
                <div class="input-field">
                    <label class="input-field-label" for="">severity level:</label>
                    <div class="radios">
                        <input type="radio" class="input-radio" <?php if ($row['severity_level'] == 1) echo "checked" ?> name="severity_level" value="1"> H
                        <input type="radio" class="input-radio" <?php if ($row['severity_level'] == 2) echo "checked" ?> name="severity_level" value="2"> M
                        <input type="radio" class="input-radio" <?php if ($row['severity_level'] == 3) echo "checked" ?> name="severity_level" value="3"> E
                    </div>
                </div>
                <div class="input-field">
                    <label for="" class="input-field-label">activity schedule physical state</label>
                    <div class="radios">
                        <input type="radio" class="input-radio" <?php if ($row['activityschedule_physical_state'] == 1) echo "checked" ?> name="activityschedule_physical_state" value="1"> Excellent
                        <input type="radio" class="input-radio" <?php if ($row['activityschedule_physical_state'] == 2) echo "checked" ?> name="activityschedule_physical_state" value="2"> good
                        <input type="radio" class="input-radio" <?php if ($row['activityschedule_physical_state'] == 3) echo "checked" ?> name="activityschedule_physical_state" value="3"> bad
                    </div>
                </div>
            </div>
            <div class="field">
                <div class="input-field">
                    <label for="" class="input-field-label">activity schedule gender</label>
                    <div class="radios">
                        <input type="radio" class="input-radio" <?php if ($row['activityschedule_gender'] == 1) echo "checked" ?> name="activityschedule_gender" value="1"> Male
                        <input type="radio" class="input-radio" <?php if ($row['activityschedule_gender'] == 2) echo "checked" ?> name="activityschedule_gender" value="2"> Female
                        <input type="radio" class="input-radio" <?php if ($row['activityschedule_gender'] == 3) echo "checked" ?> name="activityschedule_gender" value="2"> both
                    </div>
                </div>
                <div class="input-field">
                    <label for="" class="input-field-label">Health state </label>
                    <div class="radios">
                        <input type="radio" class="input-radio" <?php if ($row['activityschedule_Health_status'] == 1) echo "checked" ?> name="activityschedule_Health_status" value="1"> Excellent
                        <input type="radio" class="input-radio" <?php if ($row['activityschedule_Health_status'] == 2) echo "checked" ?> name="activityschedule_Health_status" value="2"> good
                        <input type="radio" class="input-radio" <?php if ($row['activityschedule_Health_status'] == 3) echo "checked" ?> name="activityschedule_Health_status" value="3"> bad
                    </div>
                </div>
            </div>
            <div class="field">
                <div class="input-field">
                    <label class="input-field-label" for="">specific age:</label>
                    <input class="text-input" type="text" name="specific_age" value="<?php echo $row['specific_age'] ?>" autocomplete="off">
                </div>
                <div class="input-field">
                    <label class="input-field-label" for="">notes:</label>
                    <textarea class="pass-input" name="note" autocomplete="new-password"><?php echo $row['note'] ?></textarea>
                </div>
            </div>
            <div class="submit-2-field">
                <input class="submit-btn" type="submit" value="add" name="edit-activity">
            </div>
        </form>
    </div>

<?php
    if (isset($_POST['edit-activity'])) {
        if (
            !empty($_POST['activityPlace'])
            && !empty($_POST['presence'])
            && !empty($_POST['activityDescription'])
            && !empty($_POST['Registration_start_date'])
            && !empty($_POST['Registration_expiration_date'])
            && !empty($_POST['activitySupplies'])
            && !empty($_POST['Weighing_activity_supplies'])
            && !empty($_POST['registrationCost'])
            && !empty($_POST['Activity_start_date'])
            && !empty($_POST['Activity_end_date'])
            && !empty($_POST['severity_level'])
            && !empty($_POST['activityschedule_physical_state'])
            && !empty($_POST['activityschedule_gender'])
            && !empty($_POST['activityschedule_Health_status'])
            && !empty($_POST['specific_age'])
            && !empty($_POST['note'])
        ) {
            $activityPlace = $_POST['activityPlace'];
            $activityDescription = $_POST['activityDescription'];
            $Registration_start_date = $_POST['Registration_start_date'];
            $Registration_expiration_date = $_POST['Registration_expiration_date'];
            $registrationCost = $_POST['registrationCost'];
            $note = $_POST['note'];
            $activitySupplies = $_POST['activitySupplies'];
            $Weighing_activity_supplies = $_POST['Weighing_activity_supplies'];
            $specific_age = $_POST['specific_age'];
            $severity_level = $_POST['severity_level'];
            $Activity_start_date = $_POST['Activity_start_date'];
            $Activity_end_date = $_POST['Activity_end_date'];
            $presence = $_POST['presence'];
            $activityschedule_gender = $_POST['activityschedule_gender'];
            $activityschedule_Health_status = $_POST['activityschedule_Health_status'];
            $activityschedule_physical_state = $_POST['activityschedule_physical_state'];
            if (
                editActivity(
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
                ) == 1
            ) {
                header('REFRESH:0;URL=manage-activities.php?control=view&activityID=' . $activityID);
            } else {
            }
        }
    }
}

include "includes/templates/footer.html";
ob_end_flush();
?>