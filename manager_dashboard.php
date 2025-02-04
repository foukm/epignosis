<?php
session_start();
require_once "db.php";

if ($_SESSION['user']['role'] !== 'manager') {
    die("Δεν έχετε δικαίωμα πρόσβασης σε αυτή τη σελίδα.");
}

$stmt = $pdo->query("SELECT vr.id, u.username, vr.start_date, vr.end_date, vr.reason, vr.status, vr.created_at 
                     FROM vacation_requests vr
                     JOIN users u ON vr.user_id = u.id");
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $request_id = $_POST['request_id'];
    $action = $_POST['action'];

    if ($action == 'approve') {
        $status = 'approved';
    } elseif ($action == 'reject') {
        $status = 'rejected';
    }

    if ($action == 'approve' || $action == 'reject') {
        $stmt = $pdo->prepare("UPDATE vacation_requests SET status = ? WHERE id = ?");
        $stmt->execute([$status, $request_id]);

      
        header("Location: manager_dashboard.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requests</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <a href="dashboard.php" class="back-link">
                <i class="bi bi-arrow-left-circle"></i> Go back
        </a>
        <br><br>
        <h2>Requests</h2>

        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Employee</th>
                    <th>Start Date</th>
                    <th>Expiration Date</th>
                    <th>Reason</th>
                    <th>Creation Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($requests as $request): ?>
                    <tr>
                        <td><?= htmlspecialchars($request['username']); ?></td>
                        <td><?= htmlspecialchars($request['start_date']); ?></td>
                        <td><?= htmlspecialchars($request['end_date']); ?></td>
                        <td><?= htmlspecialchars($request['reason']); ?></td>
                        <td><?= htmlspecialchars($request['created_at']); ?></td>
                        <td><?= htmlspecialchars($request['status']); ?></td>
                        <td>
                            <?php if ($request['status'] == 'pending'): ?>
                                <div class="btn-group" role="group">
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="request_id" value="<?= $request['id']; ?>">
                                        <button type="submit" name="action" value="approve" class="btn btn-success btn-sm">
                                            <i class="bi bi-check-circle"></i> Approved
                                        </button>
                                    </form>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="request_id" value="<?= $request['id']; ?>">
                                        <button type="submit" name="action" value="reject" class="btn btn-danger btn-sm">
                                            <i class="bi bi-x-circle"></i> Rejected
                                        </button>
                                    </form>
                                </div>
                            <?php else: ?>
                                <span>The decision has been made</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        
        
    </div>
                              
  
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
