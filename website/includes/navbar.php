</head>
<body>
    <nav class="website-nav">
        <div class="logo">
           <span>EX-activities</span>
        </div>
        <ul class="nav-list">
            <li>
                <a href="activities.php" class="nav-btn">
                    activities
                </a>
            </li>
            <li>
                <a href="supervisors.php" class="nav-btn">
                    supervisors
                </a>
            </li>
            <?php 
            if(isset($_SESSION['userID'])) {
                ?>
                <li>
                    <a href="myActivities.php" class="nav-btn">
                        activities requests
                    </a>
                </li>
                <?php 
            }
            ?>
        </ul>
        <div class="controls">
            <?php 
            if(isset($_SESSION['userID'])) {
                ?>
                <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($_SESSION['userPic']) ?>" alt="">
                <a href="profile.php" class="text-danger">my profile</a>
            <?php
            } else {
                ?>
                <a href="../admin/index.php" class="text-danger">login | register</a>
                <?php
            }
            ?>
        </div>
    </nav>