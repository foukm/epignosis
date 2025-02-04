<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body style="min-height:100vh !important ">
    <div class="container dashboard-container">
        <h2 class="text-center mb-4">Welcome, <strong><?= htmlspecialchars($_SESSION['user']['username']) ?></strong>!</h2>
        
        <div class="row g-4">
            <?php if ($_SESSION['user']['role'] == 'employee'): ?>
                <div class="col-md-6">
                    <a href="request_vacation.php" class="text-decoration-none">
                        <div class="dashboard-card p-4">
                            <i class="bi bi-pencil-square"></i>
                            <h5 class="mt-3">New request</h5>
                        </div>
                    </a>
                </div>

                <div class="col-md-6">
                    <a href="my_requests.php" class="text-decoration-none">
                        <div class="dashboard-card p-4">
                            <i class="bi bi-card-list"></i>
                            <h5 class="mt-3">My requests</h5>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 offset-md-3">
                    <a href="logout.php" class="text-decoration-none">
                        <div class="dashboard-card p-4 logout-card">
                            <i class="bi bi-box-arrow-right"></i>
                            <h5 class="mt-3">Logout</h5>
                        </div>
                    </a>
                </div>
            <?php else: ?>
                <div class="col-md-6">
                    <a href="manager_dashboard.php" class="text-decoration-none">
                        <div class="dashboard-card p-4">
                            <i class="bi bi-file-earmark-check"></i>
                            <h5 class="mt-3">Request Management</h5>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="users.php" class="text-decoration-none">
                        <div class="dashboard-card p-4">
                            <i class="bi bi-people"></i>
                            <h5 class="mt-3">Users</h5>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="create_user.php" class="text-decoration-none">
                        <div class="dashboard-card p-4">
                            <i class="bi bi-person-plus"></i>
                            <h5 class="mt-3">Create new user</h5>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="logout.php" class="text-decoration-none">
                        <div class="dashboard-card p-4 logout-card">
                            <i class="bi bi-box-arrow-right"></i>
                            <h5 class="mt-3">Logout</h5>
                        </div>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php
        require_once "footer.php";
    ?>
  
</body>
</html>
