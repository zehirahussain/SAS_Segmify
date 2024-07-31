<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            overflow-x: hidden; /* Prevent horizontal scroll */
        }

        header {
            background-color: #1b1b1c;
            color: white;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        header a {
            color: white;
            text-decoration: none;
            margin-right: 20px;
        }

        .container {
            position: relative;
            text-align: center;
            height: 100vh; /* Set the height of container to full viewport height */
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .lock {
            width: 100%;
            max-width: 300px;
            height: auto;
        }

        .background-image {
            background-image: url('graph.jpeg');
            height: 100vh; /* Set the height of background image to full viewport height */
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .description {
            color: white;
            font-size: 20px;
            margin-top: 20px;
        }
        
        .BOX {
            border-radius: 27px;
            font-family: calibri;
            background-color: aliceblue;
            text-align: center;
            padding: 40px 35px;
            width: 90vw;
            max-width: 620px;
            margin-top: -20px; /* Adjusted to move the box up */
        }

        @media (max-width: 768px) {
            .BOX {
                width: 80vw;
            }
        }

        @media (max-width: 480px) {
            .BOX {
                width: 90vw;
            }
        }

        .SignIn {
            border: 1px solid;
            border-radius: 6px;
            background-color: #005288;
            color: white;
            font-family: calibri;
            font-weight: bold;
            font-size: 15px;
            letter-spacing: 0.6px;
        }

        .SignIn:hover {
            cursor: pointer;
            color: rgb(28, 29, 29);
        }

        .h1 {
            color: darkblue;
        }

        /* Media Queries for Responsiveness */
        @media (max-width: 768px) {
            header {
                flex-direction: column;
                align-items: flex-start;
            }

            header a {
                margin-right: 0;
                margin-bottom: 10px;
            }

            .SignIn {
                width: 100%;
            }

            .BOX {
                width: 100%;
                padding: 20px;
                margin-top: 0; /* Remove top margin on smaller screens */
            }

            .description {
                font-size: 15px;
            }
        }

        @media (max-width: 480px) {
            .description {
                font-size: 15px;
            }

            .SignIn {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<header>
    <div style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
        <div style="display: flex; align-items: center;">
            <a href="#"><img src="SAS Segmify logo (2).png" style="width: 60px;"></a>
            <a href="aoutus.html"><button class="SignIn" style="height: 28px; width: 80px; margin-left: 10px; font-weight: bold;">About Us</button></a>
            <a href="contactus.html"><button class="SignIn" style="height: 28px; width: 100px; margin-left: 10px; font-weight: bold;">Contact Us</button></a>
        </div>
        <div>
            <a href="signuppppp.html"><button class="SignIn" style="height: 28px; width: 80px; margin-right: 20px; font-weight: bold;">Sign Up</button></a>
        </div>
    </div>
</header>

<div class="background-image">
    <div class="container">
        <div class="BOX"> 
            <div class="centered">
                <img src="SAS Segmify logo (1).png" alt="Lock" class="lock">
                <h1><?php echo "Customer Segmentation and Classification for SAS Company"; ?></h1>
                <p class="description" style="color: black;"> 
                    <?php 
                        $description = "Harness data-driven insights with SAS Segmify for advanced customer segmentation, classification, and review analysis using cutting-edge machine learning.";
                        echo $description; 
                    ?>
                </p>
            </div>
        </div>
    </div>
</div>

</body>
</html>
