<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDU-FUND</title>
    <style>
        /* General body styles */
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif; /* Modern font */
            background: linear-gradient(135deg, #e6e6fa, #dcd0ff); /* Lavender gradient */
            color: #4b0082; /* Dark purple text */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Container styles */
        .container {
            text-align: center;
            padding: 30px;
            border: 1px solid #e6e6fa;
            border-radius: 15px;
            background-color: #fff; /* White container for contrast */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 80%;
            max-width: 600px;
        }

        /* EDU-FUND text styles */
        h1 {
            font-size: 3em; /* Larger size */
            font-family: 'Roboto Slab', serif; /* Elegant serif font */
            color: #4b0082;
            margin: 20px 0;
            transition: transform 0.3s ease; /* Smooth zoom effect */
        }

        /* Zoom effect on hover */
        h1:hover {
            transform: scale(1.1); /* Zoom in slightly */
        }

        /* Paragraph styles */
        p {
            margin: 15px 0;
            font-size: 1.2em;
            color: #4b0082;
        }

        /* Button styles */
        a {
            text-decoration: none;
            font-size: 1em;
            padding: 12px 25px;
            margin: 10px;
            border: none;
            border-radius: 10px;
            color: #fff;
            background-color: #4b0082; /* Dark purple */
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease; /* Smooth hover effect */
        }

        /* Button hover effect */
        a:hover {
            background-color: #6a0dad; /* Brighter purple */
            transform: translateY(-3px); /* Lift effect */
        }

        /* Button group alignment */
        .button-group a {
            display: inline-block;
            font-size: 1.1em;
            box-shadow: 0 3px 5px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>EDU-FUND</h1>
        <p>Empowering Dreams Through Seamless Education Funding</p>

        <div class="button-group">
            <a href="donor.php">Sponsor</a>
            <a href="receiver.php">Applicant</a>
        </div>
    </div>
</body>
</html>
