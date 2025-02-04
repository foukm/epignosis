<?php
session_start();
require_once "db.php";


if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}


if ($_SESSION['user']['role'] !== 'employee') {
    die();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user']['id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $reason = $_POST['reason'];

    
    if ($start_date > $end_date) {
        die("Η ημερομηνία λήξης πρέπει να είναι μετά την ημερομηνία έναρξης.");
    }


    $stmt = $pdo->prepare("INSERT INTO vacation_requests (user_id, start_date, end_date, reason) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $start_date, $end_date, $reason]);

    
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Request</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        
    </style>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="request-form">
        <h2 class="text-center mb-4">New request</h2>
        
        <form method="POST" id="vacationForm">
            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date:</label>
                <input type="date" name="start_date" id="start_date" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="end_date" class="form-label">Expiration Date:</label>
                <input type="date" name="end_date" id="end_date" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="reason" class="form-label">Reason:</label>
                <textarea name="reason" id="reason" class="form-control" rows="4" required></textarea>
            </div>

            <button type="submit" class="btn btn-custom w-100 mb-3" id="submitBtn">Submit</button>
        </form>

        <a href="dashboard.php" class="back-link d-block text-center">
            <i class="bi bi-arrow-left-circle"></i> Go back
        </a>

        <div id="errorMessage" class="error-message" style="display: none;">
            The expiration date must be after the start date.
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
          function validateDates() {
            const startDate = document.getElementById("start_date").value;
            const endDate = document.getElementById("end_date").value;
            const submitButton = document.getElementById("submitBtn");
            const errorMessage = document.getElementById("errorMessage");

            if (startDate && endDate) {
                
                if (new Date(startDate) < new Date(endDate)) {
                    submitButton.disabled = false;
                    errorMessage.style.display = "none";
                } else {
                    submitButton.disabled = true;
                    errorMessage.style.display = "block";
                }
            } else {
                submitButton.disabled = true;
                errorMessage.style.display = "none";
            }
        }

        document.getElementById("start_date").addEventListener("change", validateDates);
        document.getElementById("end_date").addEventListener("change", validateDates);
    </script>
        
</body>
</html>
