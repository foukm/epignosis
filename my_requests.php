<?php
session_start();
require_once "db.php";

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'employee') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user']['id'];

$stmt = $pdo->prepare("SELECT * FROM vacation_requests WHERE user_id = ?");
$stmt->execute([$user_id]);
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>My requests</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <a href="dashboard.php" class="back-link">
                <i class="bi bi-arrow-left-circle"></i> Go back
        </a>
        <br><br>
        <h2>My requests</h2>
        <?php if (isset($_GET['success']) && $_GET['success'] == "deleted"): ?>
    <div class="alert alert-success">The request has been successfully deleted!</div>
    <?php endif; ?>

    <?php if (isset($_GET['error']) && $_GET['error'] == "not_found"): ?>
        <div class="alert alert-danger">The request was not found or cannot be deleted!</div>
    <?php endif; ?>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Start Date</th>
                    <th>Expiration Date</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Creation Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($requests as $request): ?>
                    <tr>
                        <td><?= htmlspecialchars($request['start_date']); ?></td>
                        <td><?= htmlspecialchars($request['end_date']); ?></td>
                        <td><?= htmlspecialchars($request['reason']); ?></td>
                        <td><?= htmlspecialchars($request['status']); ?></td>
                        <td><?= htmlspecialchars($request['created_at']); ?></td>
                        <td>
                            <?php if ($request['status'] === 'pending'): ?>
                                <button class="btn btn-sm btn-danger d-block w-100" data-toggle="modal" data-target="#confirmDeleteModal" data-id="<?= $request['id']; ?>">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            <?php else: ?>
                                <span class="text-muted">It cannot be deleted</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        
    </div>

    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Delete Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure that you want to delete this request?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <a id="confirmDeleteBtn" class="btn btn-danger" href="#">Delete</a>
                </div>
            </div>
        </div>
    </div>
                               
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        
        $('#confirmDeleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var requestId = button.data('id');
            var modal = $(this);
            modal.find('#confirmDeleteBtn').attr('href', 'delete_request.php?id=' + requestId);
        });
    </script>
</body>
</html>
