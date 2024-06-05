<?php include('db_connect.php') ?>

<?php if ($_SESSION['login_type'] == 1): ?>
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Customers</span>
                    <span class="info-box-number">
                        <?php echo $conn->query("SELECT * FROM customers")->num_rows; ?>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-user"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Staff</span>
                    <span class="info-box-number">
                        <?php echo $conn->query("SELECT * FROM staff")->num_rows; ?>
                    </span>
                </div>
            </div>
        </div>

        <div class="clearfix hidden-md-up"></div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-columns"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Departments</span>
                    <span class="info-box-number">
                        <?php 
                        $enum_roles_query = $conn->query("SHOW COLUMNS FROM staff LIKE 'role'");
                        $enum_roles_row = $enum_roles_query->fetch_assoc();
                        preg_match("/^enum\(\'(.*)\'\)$/", $enum_roles_row['Type'], $matches);
                        $enum_roles = explode("','", $matches[1]);
                        echo count($enum_roles);
                        ?>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-ticket-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Queue</span>
                    <span class="info-box-number">
                        <?php echo $conn->query("SELECT * FROM tickets")->num_rows; ?>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-columns"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Tables</span>
                    <span class="info-box-number">
                        <?php echo $conn->query("SELECT * FROM tables")->num_rows; ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <?php
    $staff_id = $_SESSION['login_id'];
    $login_type = $_SESSION['login_type'];
    $staff_data = null;
    $table_code = null;

    if ($login_type == 3) { 
        $staff_query = $conn->query("SELECT table_id FROM staff WHERE id = $staff_id");
        $staff_data = $staff_query->fetch_assoc();
        
        if ($staff_data['table_id']) {
            $table_query = $conn->query("SELECT code FROM tables WHERE id = " . $staff_data['table_id']);
            $table_code = $table_query->fetch_assoc()['code'];
        }
    } elseif ($login_type == 4) { 
    }
    ?>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <?php if ($login_type == 3): ?>
                    <?php if ($table_code): ?>
                        Welcome <?php echo $_SESSION['login_name']; ?>, your customer is waiting for you at table number <?php echo $table_code; ?>.
                    <?php else: ?>
                        Welcome <?php echo $_SESSION['login_name']; ?>, no table assignment found.
                    <?php endif; ?>
                <?php elseif ($login_type == 4): ?>
                    Welcome <?php echo $_SESSION['login_name']; ?>!
                <?php elseif ($login_type == 2): ?>
                    Welcome <?php echo $_SESSION['login_name']; ?>!
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
