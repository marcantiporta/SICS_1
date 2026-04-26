<?php
session_start();
include "config.php";

$error = "";

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $sql = "SELECT * FROM users 
            WHERE username='$username' 
            AND password='$password' 
            AND role='$role'";

    $result = $conn->query($sql);

    if (!$result) {
        die("DB Error: " . $conn->error);
    }

    if ($result->num_rows > 0) {

        $user = $result->fetch_assoc();

        $_SESSION['role'] = $user['role'];
        $_SESSION['student_id'] = $user['student_id'];

        if ($role == "student") {
            header("Location: student_dashboard.php");
        } else {
            header("Location: teacher_dashboard.php");
        }

        exit();

    } else {
        $error = "Invalid credentials or role mismatch";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #4e54c8, #8f94fb);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            width: 380px;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
        }
    </style>
</head>

<body>

<div class="login-box">

    <h3 class="text-center">🎓 SICS Login</h3>

    <?php if ($error != "") { ?>
        <div class="alert alert-danger">
            <?php echo $error; ?>
        </div>
    <?php } ?>

    <form method="POST">

        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <!-- ROLE SELECTION -->
        <div class="mb-3">
            <label>Login As</label>
            <select name="role" class="form-control" required>
                <option value="">-- Select Role --</option>
                <option value="student">🎓 Student</option>
                <option value="teacher">👨‍🏫 Teacher</option>
            </select>
        </div>

        <button type="submit" name="login" class="btn btn-primary w-100">
            🔐 Login
        </button>

    </form>

</div>

</body>
</html>