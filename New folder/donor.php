<?php
session_start();
ob_start();
include 'db_connection.php';
ob_end_clean();

// Fetch pending requests
$query = "SELECT * FROM requests WHERE status = 'Pending'";
$result = $conn->query($query);

// Approve or Reject logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $requestId = $_POST['request_id'];
    $action = $_POST['action']; // 'approve' or 'reject'

    // Update status in the database
    if ($action === 'approve') {
        $updateQuery = "UPDATE requests SET status = 'Approved' WHERE id = $requestId";
    } elseif ($action === 'reject') {
        $updateQuery = "UPDATE requests SET status = 'Rejected' WHERE id = $requestId";
    }

    if ($conn->query($updateQuery)) {
        echo "<script>alert('Request has been " . ucfirst($action) . "d successfully.');</script>";
        header("Refresh:0"); // Refresh the page to reflect changes
    } else {
        echo "<script>alert('Error updating request status.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Sponsor Dashboard</title>
    <style>
        /* Lavender theme styles */
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #d1c4e9, #f3e5f5); /* Gradient lavender background */
            color: #4b0082; /* Dark purple for text */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
            padding: 30px;
            border: 1px solid #e6e6fa;
            border-radius: 15px;
            background-color: #f8f0ff; /* Lighter lavender */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 80%;
            max-width: 600px;
        }

        h1 {
            color: #4b0082;
            font-size: 3em; /* Larger font size */
            font-family: 'Georgia', serif; /* Elegant serif font */
            margin: 20px 0;
            text-transform: uppercase;
        }

        h2 {
            color: #4b0082;
            font-size: 1.8em; /* Slightly smaller size */
            margin-bottom: 20px;
            font-family: 'Arial', sans-serif;
        }

        p {
            font-size: 1.1em;
            color: #4b0082;
        }

        .button {
            text-decoration: none;
            font-size: 1em;
            padding: 12px 25px;
            margin: 10px;
            border: none;
            border-radius: 10px;
            color: #fff;
            background-color: #4b0082; /* Dark purple */
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #6a0dad; /* Slightly brighter purple */
        }

        .donation-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .donation-table th, .donation-table td {
            padding: 10px;
            border: 1px solid #e6e6fa;
        }

        .donation-table th {
            background-color: #e6e6fa;
        }

        .donation-table td {
            text-align: center;
        }

        .button-group {
            display: flex;
            justify-content: space-around;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome Sponsor</h1>
       
        <button id="connectMetaMask" class="button">Connect MetaMask</button>
        <p id="walletAddress" style="color: blue; margin-top: 10px;"></p>

        <h2>Pending Requests</h2>
        <table class="donation-table">
            <thead>
                <tr>
                    <th>Receiver Name</th>
                    <th>Amount Needed (ETH)</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['receiver_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['amount_needed']); ?></td>
                        <td><?php echo htmlspecialchars($row['reason']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td>
                            <form method="POST" action="">
                                <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="action" value="approve" class="button">Approve</button>
                                <button type="submit" name="action" value="reject" class="button" style="background-color: red;">Reject</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script>
        document.getElementById('connectMetaMask').addEventListener('click', async () => {
            // Check if MetaMask is installed
            if (typeof window.ethereum !== 'undefined') {
                try {
                    // Request account access
                    const accounts = await window.ethereum.request({ method: 'eth_requestAccounts' });
                    const walletAddress = accounts[0]; // Connected account

                    // Display connected wallet address
                    document.getElementById('walletAddress').textContent = "Connected Wallet: " + walletAddress;
                } catch (error) {
                    console.error("Error connecting to MetaMask:", error);
                    alert("Could not connect to MetaMask. Please try again.");
                }
            } else {
                alert("MetaMask is not installed. Please install MetaMask to proceed.");
            }
        });
    </script>
</body>
</html>
