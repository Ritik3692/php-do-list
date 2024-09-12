<?php
// login.php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($user_id, $hashed_password);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;
            header("Location: index");
            exit;
        } else {
            // echo "Incorrect password.";
            echo '<div class="error-message">Incorrect password!</div>';
        }
    } else {
        // echo "No user found!";
        echo '<div class="error-message">No user found!</div>';
    }

    $stmt->close();
    $conn->close();
}
?>
<!-- <h3> Login Now</h3>
<form method="POST" action="login.php">
    Username: <input type="text" name="username" required><br>
    Password: <input type="password" name="password" required><br>
    <input type="submit" value="Login">
</form> -->

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
    <title>Login</title>
    <style>
        .error-message {
            color: red;
            font-size: 1.8em;
            display: flex;
            margin: auto;
            width: 250px;
            height: 25px;
            /* background: red; */
        }

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
    </style>
</head>

<body>

    <div class="container  my-4">
        <div class="row justify-content-center">
            <div class="col-md-6 minbox">
                <div class="form-container">
                    <h2 class="form-title text-center">Login Now</h2>
                    <form action="login" class="" method="POST" enctype="multipart/form-data">

                        <div class="mb-3">
                            <label for="name" class="form-label"> Username:</label>

                            <input type="text" name="username" class="form-control" id="name" minlength="3" maxlength="30" placeholder="Enter your username" required>

                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Password:</label>
                            <!-- <input type="text" name="name" class="form-control" id="name" minlength="3" maxlength="30" value="{{old('name')}}" placeholder="Enter your name"> -->
                            <input type="password" name="password" class="form-control" id="name" minlength="3" maxlength="30" placeholder="Enter your Password" required>

                        </div>

                        <button type="submit" class="btn  w-100">Login</button>
                        <!-- <button name="toggleView" class="btn  mt-2 w-100"><a href="signup" class="signup-btu">sign up</a></button> -->

                    </form>
                    <form action="signup">
                        <button type="submit" class="btn mt-3 w-100">sign up</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


</body>

</html>