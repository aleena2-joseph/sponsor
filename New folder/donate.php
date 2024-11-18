<?php

session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $receiver_id = $_POST['receiver_id'];
    $wallet_address = $conn->real_escape_string($_POST['wallet_address']);
    $amount_needed = (float)$_POST['amount_needed'];

    
    $transaction_status = "Successful"; 

   
    $updateQuery = "UPDATE requests SET status = 'Approved' WHERE id = $receiver_id";
    $conn->query($updateQuery);

    $insertHistoryQuery = "
        INSERT INTO transaction_history (receiver_address, amount, transaction_status)
        VALUES ('$wallet_address', $amount_needed, '$transaction_status')
    ";
    $conn->query($insertHistoryQuery);

    header("Location: amthistory.php");
    exit();
}
?>