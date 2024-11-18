<?php
session_start();

// Database connection details
$dsn = "mysql:host=localhost;dbname=edufundd";
$username = "root"; // Update with your MySQL username
$password = ""; // Update with your MySQL password

try {
    // Connect to the database
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create the users table if it doesn't exist
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        wallet_address VARCHAR(255) NOT NULL
    )");
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - EDUFUND</title>
</head>
<body style="background-color: lavender; font-family: Arial, sans-serif; color: #4B0082; margin: 0; padding: 0;">

    <div style="width: 50%; margin: 50px auto; padding: 20px; background-color: #f0e6f6; border-radius: 10px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
        <h1 style="text-align: center; color: #6A0DAD;">Register</h1>
        <p style="text-align: center; color: #6A0DAD;">Are you a Sponsor or Applicant?</p>
        
        <!-- Buttons to switch between Applicant and Sponsor Forms -->
        <div style="text-align: center;">
            <button onclick="showApplicantForm()" style="background-color: #6A0DAD; color: white; border: none; padding: 10px 20px; margin: 10px; cursor: pointer; border-radius: 5px;">Applicant</button>
            <button onclick="showSponsorForm()" style="background-color: #6A0DAD; color: white; border: none; padding: 10px 20px; margin: 10px; cursor: pointer; border-radius: 5px;">Sponsor</button>
        </div>

        <!-- Applicant Form -->
        <div id="applicant-form" style="display:none; margin-top: 20px;">
            <input type="text" id="applicant-name" placeholder="Name" required style="width: 100%; padding: 10px; margin: 10px 0; border-radius: 5px; border: 1px solid #ccc;">
            <input type="email" id="applicant-email" placeholder="Email" required style="width: 100%; padding: 10px; margin: 10px 0; border-radius: 5px; border: 1px solid #ccc;">
            <input type="text" id="applicant-username" placeholder="Username" required style="width: 100%; padding: 10px; margin: 10px 0; border-radius: 5px; border: 1px solid #ccc;">
            <input type="date" id="applicant-dob" placeholder="Date of Birth" required style="width: 100%; padding: 10px; margin: 10px 0; border-radius: 5px; border: 1px solid #ccc;">
            <input type="password" id="applicant-password" placeholder="Password" required style="width: 100%; padding: 10px; margin: 10px 0; border-radius: 5px; border: 1px solid #ccc;">
            <input type="password" id="applicant-confirm-password" placeholder="Confirm Password" required style="width: 100%; padding: 10px; margin: 10px 0; border-radius: 5px; border: 1px solid #ccc;">
            
            <label for="proof-file" style="display: block; margin-top: 10px;">Upload Proof:</label>
            <input type="file" id="proof-file" accept=".pdf,.png,.jpg,.jpeg" required style="width: 100%; padding: 10px; margin: 10px 0; border-radius: 5px; border: 1px solid #ccc;">
            
            <button onclick="registerApplicant()" style="background-color: #6A0DAD; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 5px;">Register as Applicant</button>
        </div>

        <!-- Sponsor Form -->
        <div id="sponsor-form" style="display:none; margin-top: 20px;">
            <input type="text" id="sponsor-name" placeholder="Name" required style="width: 100%; padding: 10px; margin: 10px 0; border-radius: 5px; border: 1px solid #ccc;">
            <input type="email" id="sponsor-email" placeholder="Email" required style="width: 100%; padding: 10px; margin: 10px 0; border-radius: 5px; border: 1px solid #ccc;">
            <input type="password" id="sponsor-password" placeholder="Password" required style="width: 100%; padding: 10px; margin: 10px 0; border-radius: 5px; border: 1px solid #ccc;">
            <input type="password" id="sponsor-confirm-password" placeholder="Confirm Password" required style="width: 100%; padding: 10px; margin: 10px 0; border-radius: 5px; border: 1px solid #ccc;">
            
            <button onclick="registerSponsor()" style="background-color: #6A0DAD; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 5px;">Register as Sponsor</button>
        </div>
    </div>

    <script>
        // Toggle the visibility of forms
        function showApplicantForm() {
            document.getElementById('applicant-form').style.display = 'block';
            document.getElementById('sponsor-form').style.display = 'none';
        }

        function showSponsorForm() {
            document.getElementById('sponsor-form').style.display = 'block';
            document.getElementById('applicant-form').style.display = 'none';
        }

        function registerApplicant() {
            // Handle applicant registration logic here
            // You will need to handle the form submission with PHP for actual registration
            alert('Applicant registration submitted!');
        }

        function registerSponsor() {
            // Handle sponsor registration logic here
            // You will need to handle the form submission with PHP for actual registration
            alert('Sponsor registration submitted!');
        }
    </script>
</body>
</html>
