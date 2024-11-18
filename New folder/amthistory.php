<?php
session_start();

ob_start();
include 'db_connection.php';
ob_end_clean(); 

$query = "SELECT * FROM transaction_history";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Transaction History</title>
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
            text-align: left;
            padding: 30px;
            border: 1px solid #e6e6fa;
            border-radius: 15px;
            background-color: #f8f0ff; /* Lighter lavender */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 80%;
            max-width: 800px;
        }

        h1 {
            color: #4b0082;
            font-size: 2.2em;
            font-family: 'Georgia', serif;
            margin: 20px 0;
            text-align: center;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #4b0082;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f3e5f5;
        }

        tr:hover {
            background-color: #d1c4e9;
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
        }

        .button:hover {
            background-color: #6a0dad;
        }
    </style>
</head>
<body>
    <div class="container silver-box">
        <h1>Transaction History</h1>
        <table class="donation-table">
            <thead>
                <tr>
                    <th>Applicant Address</th> 
                    <th>Amount Donated (ETH)</th>
                    <th>Transaction Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['receiver_address']; ?></td>
                        <td><?php echo $row['amount']; ?></td>
                        <td><?php echo $row['transaction_status']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <br>
        <a href="index.php" class="button">Home</a>
    </div>
</body>
</html>
