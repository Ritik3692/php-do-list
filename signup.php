<?php
include 'db.php';

$error_message = "";
$username = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];

    // Check if the username already exists
    $sql = "SELECT id FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $error_message = "Username already in use. Please choose another.";
    } else {
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $password);

        if ($stmt->execute()) {
            header("Location: index");
            exit;
        } else {
            $error_message = "Error: " . $stmt->error;
        }
    }

    $stmt->close();
    $conn->close();
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/icon.png" type="png/image">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="">
    <title>Sign up</title>
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #003285, #2A629A);
        }

        .minbox {
            background: #D4D2D2;
            padding: 20px;
            border-radius: 25px;
        }

        a {
            text-decoration: none;
            color: aliceblue;
        }

        .btn {
            color: #ffff;
            background-color: #FF5945;
            &:hover {
                color: #D4D2D2;
                background-color: #FF5931;
            }
        }

        .error-message {
            color: red;
            font-size: 0.9em;
        }
    </style>
</head>

<body>

    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-md-6 minbox">
                <div class="form-container">
                    <h2 class="form-title text-center">Sign up</h2>
                    <form action="signup.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">Username:</label>
                            <input type="text" name="username" class="form-control" id="name" minlength="3" maxlength="30" placeholder="Enter your username" value="<?php echo htmlspecialchars($username); ?>" required>
                            <?php if (!empty($error_message)): ?>
                                <div class="error-message"><?php echo $error_message; ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" name="password" class="form-control" id="password" minlength="3" maxlength="30" placeholder="Enter your Password" required>
                        </div>
                        <button type="submit" class="btn w-100">Sign up</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>
