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
        }

        header {
            background-color: #005288;
            color: white;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
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
        }

        .centered {
            /* No need for absolute positioning */
        }

        .lock {
            width: 200px;
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
            font-size: 24px;
            margin-top: 20px;
        }
        .BOX{
            border-radius: 27px;
            font-family: calibri;
            background-color: aliceblue;
            text-align: center;
            padding: 50px; /* Adjust padding */
            max-width: 600px; /* Adjust max-width */
        }
    </style>
</head>
<body>

<header>
    <div>
        <a href="#">About Us</a>
        <a href="#">Contact Us</a>
    </div>
    <a href="signuppppp.html"><button>Sign In</button></a>
</header>

<!--<img src="graph.jpeg" style= "height: 100vh; width: 100vw; position: absolute; z-index: -1;"> -->
  

<div class="background-image">
    <div class="container">
        <div class="BOX"> 
            <div class="centered">
                <img src="logo.png" alt="Lock" class="lock">
                <h1><?php echo "Customer Segmentation and Classification for SAS Company"; ?></h1>
                <p class="description" style="color: black;"> 
                    <?php 
                        $description = "As technology continues to evolve, businesses are increasingly leveraging data-driven insights to tailor their products and services to meet customer expectations. This project is undertaken to develop a robust customer segmentation, classification, and review analysis system, utilizing cutting-edge technologies such as machine learning and natural language processing.";
                        echo $description; 
                    ?>
                </p>
            </div>
        </div>
    </div>
</div>

</body>
</html>
