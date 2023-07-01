<?php
if (!isset($_SESSION['username'])) {
?>
    <div class="welcome">
        <h1>Welcome to BNKS TMS</h1>
        <p>Login to continue</p>
    </div>
<?php
} else {
?>
    <div class="stats">
        <div class="individual-stat">
            <div>
                <div class="stat-title"> Hello <?php echo $_SESSION['username']; ?> </div>
                <div>
                    <center>
                        <img src="images/user.png" alt="" srcset="" style="border-radius: 50%; height: 100px;">
                    </center>
                </div><br>
                <!-- their rank/power -->
                <div>Power: <?php echo $_SESSION['user_type']; ?></div>
                <div>Role: </div>
            </div>
        </div>
        <div class="individual-stat">
            <div>
                <div class="stat-title">Activity Log</div>
                <ol>
                    <li>Random bs</li>
                </ol>
            </div>
        </div>
        <div class="individual-stat">
            <div>
                <div class="stat-title">Recent Logins</div>
            </div>
        </div>
        <div class="individual-stat">
            <div>
                <div class="stat-title">User Management</div>
                <div style="display: flex; flex-direction: column">
                    <a href="?page=users">View Users</a>
                    <a href="a">Delete Users</a>
                    <a href="a">Add Users</a>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>