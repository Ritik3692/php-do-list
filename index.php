<?php
session_start();
include 'db.php';


// Check if the user is logged in; if not, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}


$user_id = $_SESSION['user_id'];
$showList = isset($_GET['showList']) && $_GET['showList'] === '1';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addTask'])) {
    $task_name = trim($_POST['task_name']); // Trim the input to remove any leading/trailing spaces

    // Backend validation: Check if the task name is empty
    if (!empty($task_name)) {
        $stmt = $conn->prepare("INSERT INTO tasks (user_id, task_name) VALUES (?, ?)");
        // $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $user_id, $task_name);
        $stmt->execute();
        $stmt->close();
    } else {
        echo "<script>alert('You must write something!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/icon.png" type="png/image">
    <link rel="stylesheet" href="style.css">
    <title>To-Do-list</title>
    <style>
        /* Add your CSS styling here */
        a {
            text-decoration: none;
            color: aliceblue;
        }
    </style>

</head>

<body>

    <div id="loader"></div>
    <div class="main-box">

        <form method="GET" action="">
            <input type="hidden" name="showList" value="<?php echo $showList ? '0' : '1'; ?>">
            <button type="submit" name="toggleView"><?php echo $showList ? 'Go Back' : 'Show List'; ?></button>
            <button name="toggleView"><a href="logout">Logout</a></button>
        </form>

        <?php if ($showList): ?>
            <?php include('show.php'); ?>
        <?php else: ?>
            <div class="to-do-box">
                <h2>To-Do-List <img src="images/icon.png" alt=""></h2>

                <form method="POST" action="" onsubmit="return validateForm()">
                    <div class="row">
                        <input type="text" id="input-box" name="task_name" placeholder="Write some task">
                        <button class="add" type="submit" name="addTask">Add</button>
                    </div>
                </form>
            </div>
        <?php endif; ?>

    </div>

    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
        let loaders = document.querySelector("#loader");

        window.addEventListener("load", function() {
            loaders.style.display = "none";
        });

        // Frontend validation function
        function validateForm() {
            const inputBox = document.getElementById("input-box");
            if (inputBox.value.trim() === "") { // Check if the input is empty after trimming spaces
                alert("You must write something!");
                return false; // Prevent the form from being submitted
            }
            return true;
        }

        // Confirmation before deleting a task
        document.getElementById('list-container').addEventListener('click', function(e) {
            if (e.target.tagName === 'SPAN') {
                let taskId = e.target.getAttribute('data-id');
                let confirmDelete = confirm("Are you sure you want to delete this task?");
                if (confirmDelete) {
                    window.location.href = `delete?id=${taskId}`;
                }
            }
        });
    </script>

</body>

</html>