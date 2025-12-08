<?php
include 'db.php';
include 'send_mailer.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_name = $_POST['task_name'];
    $user_id = $_SESSION['user_id'];

    if (!empty($task_name)) {
        $stmt = $conn->prepare("INSERT INTO tasks (task_name, user_id) VALUES (?, ?)");
        $stmt->bind_param('si', $task_name, $user_id);
        $stmt->execute();
        $stmt->close();

        $to = "mail@domain.com";
        $subject =  "New Task Made";
        $body =   "The task: $task_name is created for you.";
        sendEmail($to, $subject, $body);
    }
}

$user_id = $_SESSION['user_id'];

$open_tasks = $conn->prepare("SELECT * FROM tasks WHERE is_completed = 0 AND user_id = ?");
$open_tasks->bind_param('i', $user_id);
$open_tasks->execute();
$open_tasks_result = $open_tasks->get_result();


$completed_tasks = $conn->prepare("SELECT * FROM tasks WHERE is_completed = 1 AND user_id = ?");
$completed_tasks->bind_param('i', $user_id);
$completed_tasks->execute();
$completed_tasks_result = $completed_tasks->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do App</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .task-card {
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .task-card h2 {
            font-size: 1.4rem;
            border-bottom: 1px solid #e6e6e6;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .navbar-brand {
            font-weight: bold;
        }

        .list-group-item {
            border-radius: 6px !important;
            margin-bottom: 6px;
        }

        .btn-sm {
            padding: 4px 10px;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="index.php">To-Do App</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-controls="navbarNav"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>


<div class="container mt-5">

    <h1 class="text-center mb-4 fw-bold">Manage Your Tasks</h1>

    <form action="index.php" method="POST" class="mb-4">
        <div class="input-group input-group-lg">
            <input type="text" name="task_name" class="form-control" placeholder="Enter a new task..." required>
            <button type="submit" class="btn btn-primary">Add</button>
        </div>
    </form>

    <div class="row g-4">
        
        <div class="col-md-6">
            <div class="card task-card p-3">
                <h2 class="text-center">Open Tasks</h2>
                <ul class="list-group">
                    <?php if ($open_tasks_result->num_rows > 0): ?>
                        <?php while ($row = $open_tasks_result->fetch_assoc()): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo htmlspecialchars($row['task_name']); ?>
                                <div>
                                    <a href="complete_task.php?id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm">Complete</a>
                                    <a href="delete_task.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                                </div>
                            </li>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <li class="list-group-item text-center">No open tasks available</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card task-card p-3">
                <h2 class="text-center">Completed Tasks</h2>
                <ul class="list-group">
                    <?php if ($completed_tasks_result->num_rows > 0): ?>
                        <?php while ($row = $completed_tasks_result->fetch_assoc()): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center text-decoration-line-through">
                                <?php echo htmlspecialchars($row['task_name']); ?>
                                <a href="delete_task.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                            </li>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <li class="list-group-item text-center">No completed tasks available</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
