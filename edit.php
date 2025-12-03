<?php
session_start();
require_once 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$sql = "SELECT * FROM users WHERE id=$id";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matric = mysqli_real_escape_string($conn, $_POST['matric']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $accessLevel = mysqli_real_escape_string($conn, $_POST['accessLevel']);
    
    $sql = "UPDATE users SET matric='$matric', name='$name', email='$email', accessLevel='$accessLevel' WHERE id=$id";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: dashboard.php");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
</head>
<body>
    <h2>Edit User</h2>
    <form method="POST">
        Matric: <input type="text" name="matric" value="<?php echo $user['matric']; ?>" required><br><br>
        Name: <input type="text" name="name" value="<?php echo $user['name']; ?>" required><br><br>
        Email: <input type="email" name="email" value="<?php echo $user['email']; ?>" required><br><br>
        Access Level: 
        <select name="accessLevel">
            <option value="user" <?php echo ($user['accessLevel'] == 'user') ? 'selected' : ''; ?>>User</option>
            <option value="admin" <?php echo ($user['accessLevel'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
        </select><br><br>
        <input type="submit" value="Update">
        <a href="dashboard.php">Cancel</a>
    </form>
</body>
</html>
