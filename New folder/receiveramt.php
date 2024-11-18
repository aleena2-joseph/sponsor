<?php
session_start();

$statusMessage = "";
$statusRow = "";

// Database connection details
$dsn = "mysql:host=localhost;dbname=edufundd";
$username = "root"; // Update with your MySQL username
$password = ""; // Update with your MySQL password

try {
    // Connect to the database
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create the users table if it doesn't exist
    $pdo->exec("
    CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        wallet_address VARCHAR(255) NOT NULL
    )");

    // Create the requests table if it doesn't exist
    $pdo->exec("
    CREATE TABLE IF NOT EXISTS requests (
        id INT AUTO_INCREMENT PRIMARY KEY,
        wallet_address VARCHAR(255) NOT NULL,
        status VARCHAR(50) NOT NULL DEFAULT 'Pending',
        FOREIGN KEY (wallet_address) REFERENCES users(wallet_address)
    )");

    // Initialize session variables
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['wallet_address'])) {
        // Simulate user login for testing purposes
        $user_name = "testuser";
        $pass_word = "testpassword";
        $wallet_address = "testwalletaddress";

        // Check if the user exists
        $stmt = $pdo->prepare("SELECT id, wallet_address FROM users WHERE username = :username");
        $stmt->execute(['username' => $user_name]);
        if ($stmt->rowCount() === 0) {
            // Insert a test user
            $hashedPassword = password_hash($pass_word, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password, wallet_address) VALUES (:username, :password, :wallet_address)");
            $stmt->execute(['username' => $user_name, 'password' => $hashedPassword, 'wallet_address' => $wallet_address]);
            $_SESSION['user_id'] = $pdo->lastInsertId();
            $_SESSION['wallet_address'] = $wallet_address;
        } else {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['wallet_address'] = $user['wallet_address'];
        }
    }

    // Retrieve wallet address from session
    $wallet_address = $_SESSION['wallet_address'];

    // Fetch request status
    $stmt = $pdo->prepare("SELECT status FROM requests WHERE wallet_address = :wallet_address");
    $stmt->execute(['wallet_address' => $wallet_address]);
    $statusRow = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($statusRow && $statusRow['status'] === 'Approved') {
        $statusMessage = "Approved. You can proceed with withdrawal.";
    } else {
        $statusMessage = "Your request is not approved yet. Please wait for donor approval.";
    }

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['withdraw'])) {
            // Simulate the transfer and update the status to "Completed"
            $stmt = $pdo->prepare("UPDATE requests SET status = 'Completed' WHERE wallet_address = :wallet_address AND status = 'Approved'");
            if ($stmt->execute(['wallet_address' => $wallet_address])) {
                $statusMessage = "Withdrawal successful. Status updated to Completed.";
                echo "<script>alert('Amount successfully transferred!');</script>";
            } else {
                $statusMessage = "Error updating status.";
            }
        } elseif (isset($_POST['submitRequest'])) {
            // Handle the request submission
            $stmt = $pdo->prepare("INSERT INTO requests (wallet_address, status) VALUES (:wallet_address, 'Pending')");
            if ($stmt->execute(['wallet_address' => $wallet_address])) {
                $statusMessage = "Your request has been submitted and is pending approval.";
            } else {
                $statusMessage = "Error submitting request: " . $pdo->errorInfo()[2];
            }
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Receiver Amount Withdrawal</title>
    <style>
        /* Lavender theme styles */
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #d1c4e9, #f3e5f5); /* Lavender gradient */
            color: #4b0082; /* Dark purple text color */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center; /* Center text inside the container */
            padding: 30px;
            border: 1px solid #e6e6fa;
            border-radius: 15px;
            background-color: #f8f0ff; /* Lighter lavender */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 80%;
            max-width: 600px; /* Adjusted for centering */
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            color: #4b0082;
            font-size: 2.2em;
            font-family: 'Georgia', serif;
            margin: 20px 0;
            text-align: center;
            text-transform: uppercase;
        }

        label {
            font-size: 1.1em;
            margin-bottom: 10px;
        }

        input[type="number"] {
            padding: 10px;
            width: 60%; /* Adjusted for centering */
            margin-bottom: 20px;
            font-size: 1em;
            border: 1px solid #ddd;
            border-radius: 5px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        p {
            font-size: 1.2em;
            color: #4b0082;
        }

        button {
            padding: 12px 25px;
            background-color: #4b0082;
            color: #fff;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 1.1em;
            margin-top: 20px;
            transition: background-color 0.3s ease;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        button:hover {
            background-color: #6a0dad; /* Slightly brighter purple */
        }

        .button {
            text-decoration: none;
            font-size: 1.1em;
            padding: 12px 25px;
            margin-top: 20px;
            border: none;
            border-radius: 10px;
            color: #fff;
            background-color: #4b0082;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .button:hover {
            background-color: #6a0dad;
        }
    </style>
</head>
<body>
    <div class="container silver-box">
        <h1>Receiver Amount Withdrawal</h1><br>

        <form method="POST" action="receiveramt.php">
            <label for="amountNeeded">Enter Amount Needed (ETH):</label>
            <input type="number" name="amountNeeded" id="amountNeeded" step="0.01" placeholder="e.g., 1.00" required><br><br>

            <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') { ?>
                <p>Status: <span id="requestStatus" style="color:blue;"><?php echo $statusMessage; ?></span></p>
            <?php } ?>

            <?php if ($statusRow && $statusRow['status'] === 'Approved') { ?>
                <button type="submit" name="withdraw" id="withdrawButton" class="button">Withdraw</button>
            <?php } else { ?>
                <button type="submit" name="submitRequest" class="button">Submit Request</button>
            <?php } ?>
        </form>
       
        <a href="index.php" class="button">Home</a>
    </div>
</body>
</html>
