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
            background-color: #1b1b1c;
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
         
            max-width: 600px; /* Adjust max-width */
            padding: 40px 35px 90px 35px;
        }
        .SignIn{
        border: 1px solid;
        border-radius: 6px;
        background-color: #005288;
        color: white;
        font-family: calibri;
        font-weight: bold;
        font-size: 15px;
        letter-spacing: 0.6px;
      }    
    .SignIn:hover{
      cursor: pointer;
      color: rgb(28, 29, 29);
    }
    </style>
</head>
<body>

<header>
   
    <div>
        <a href="#"><img src="output-onlinepngtools.png" style="width: 20px;"></a>
        <a href="aoutus.html"><button class="SignIn" style="height: 28px; width: 80px; margin-right: 1px; font-weight: bold;"> About Us</button></a>
        <a href="contactus.html"><button class="SignIn" style="height: 28px; width: 100px; margin-right: 1px; font-weight: bold;">Contact Us</button></a>
    </div>
    <a href="signuppppp.html"><button class="SignIn" style="height: 28px; width: 80px; margin-right: 20px; font-weight: bold;"> Sign In </button></a>
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
                        $description = "Technology continues to evolve, businesses are increasingly involved in data-driven insights to improve their products and services to meet customer expectations. SAS Segmify generates a robust customer segmentation, classification, and review analysis system, utilizing innovative technologies such as machine learning and natural language processing.";
                        echo $description; 
                    ?>
                </p>
            </div>
        </div>
    </div>
</div>

</body>
</html>
