<?php
session_start();

// Database connection details
$dsn = "mysql:host=localhost;dbname=edufund";
$username = "root"; // Update with your MySQL username
$password = ""; // Update with your MySQL password

// Initialize message
$loginError = "";

try {
    // Connect to the database
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // For Applicant login
    if (isset($_POST['applicant-login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Check if the applicant exists
        $stmt = $pdo->prepare("SELECT id, password FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit();
        } else {
            $loginError = "Invalid username or password.";
        }
    }

    // For Sponsor login (Username instead of Unique ID)
    if (isset($_POST['sponsor-login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Check if the sponsor exists
        $stmt = $pdo->prepare("SELECT id, password FROM sponsors WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $sponsor = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($sponsor && password_verify($password, $sponsor['password'])) {
            $_SESSION['sponsor_id'] = $sponsor['id'];
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit();
        } else {
            $loginError = "Invalid username or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - EDUFUND</title>
</head>
<body style="background-color: lavender; font-family: Arial, sans-serif; color: #4B0082; margin: 0; padding: 0;">

    <div style="width: 50%; margin: 50px auto; padding: 20px; background-color: #f0e6f6; border-radius: 10px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
        <h1 style="text-align: center; color: #6A0DAD;">Login</h1>
        <p style="text-align: center; color: #6A0DAD;">Are you a Sponsor or Applicant?</p>
        
        <!-- Buttons to switch between Applicant and Sponsor Login -->
        <div style="text-align: center;">
            <button onclick="showApplicantLogin()" style="background-color: #6A0DAD; color: white; border: none; padding: 10px 20px; margin: 10px; cursor: pointer; border-radius: 5px;">Applicant</button>
            <button onclick="showSponsorLogin()" style="background-color: #6A0DAD; color: white; border: none; padding: 10px 20px; margin: 10px; cursor: pointer; border-radius: 5px;">Sponsor</button>
        </div>

        <!-- Applicant Login Form -->
        <div id="applicant-login" style="display:none; margin-top: 20px;">
            <form method="POST">
                <input type="text" name="username" placeholder="Username" required style="width: 100%; padding: 10px; margin: 10px 0; border-radius: 5px; border: 1px solid #ccc;">
                <input type="password" name="password" placeholder="Password" required style="width: 100%; padding: 10px; margin: 10px 0; border-radius: 5px; border: 1px solid #ccc;">
                <button type="submit" name="applicant-login" style="background-color: #6A0DAD; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 5px;">Login as Applicant</button>
            </form>
        </div>

        <!-- Sponsor Login Form -->
        <div id="sponsor-login" style="display:none; margin-top: 20px;">
            <form method="POST">
                <input type="text" name="username" placeholder="Username" required style="width: 100%; padding: 10px; margin: 10px 0; border-radius: 5px; border: 1px solid #ccc;">
                <input type="password" name="password" placeholder="Password" required style="width: 100%; padding: 10px; margin: 10px 0; border-radius: 5px; border: 1px solid #ccc;">
                <button type="submit" name="sponsor-login" style="background-color: #6A0DAD; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 5px;">Login as Sponsor</button>
            </form>
        </div>

        <!-- Error message -->
        <?php if ($loginError): ?>
            <p style="color: red; text-align: center;"><?php echo $loginError; ?></p>
        <?php endif; ?>

    </div>

    <script>
        // Toggle the visibility of login forms
        function showApplicantLogin() {
            document.getElementById('applicant-login').style.display = 'block';
            document.getElementById('sponsor-login').style.display = 'none';
        }

        function showSponsorLogin() {
            document.getElementById('sponsor-login').style.display = 'block';
            document.getElementById('applicant-login').style.display = 'none';
        }
    </script>

</body>
</html>
