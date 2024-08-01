<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];
    $role = 'customer'; // default role

    // Re-establish connection if lost
    if ($conn->ping() === FALSE) {
        $conn = getDBConnection();
    }

    $sql = "INSERT INTO users (username, password, email, role) VALUES ('$username', '$password', '$email', '$role')";

    if ($conn->query($sql) === TRUE) {
        echo "New user registered successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Sign Up</title>
    <link href="css/app.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <div class="main">
            <main class="content">
                <div class="container-fluid p-0">
                    <div class="mb-3">
                        <h1 class="h3 d-inline align-middle">Sign Up</h1>
                    </div>
                    <form method="post" action="signup.php" name="signup">
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <input type="text" class="form-control" placeholder="Username" name="username">
                                    </div>
                                    <div class="card-body">
                                        <input type="password" class="form-control" placeholder="Password"
                                            name="password">
                                    </div>
                                    <div class="card-body">
                                        <input type="email" class="form-control" placeholder="Email" name="email">
                                    </div>
                                </div>
                                <div class="card">
                                    <button class="btn btn-secondary">Sign Up</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
    <script src="js/app.js"></script>
</body>

</html>