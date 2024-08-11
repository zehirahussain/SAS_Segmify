<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Decision</title>
    <style>
      *{
        margin: 0px;
        padding: 0px;
      }
/* decision buttons */
      .BOX{
        
        border-radius: 27px;
      padding: 30px 50px 0px 30px;
      font-family: calibri;
      background-color: aliceblue;
      text-align: center;
      width: 70%; /* Adjust the width as needed */
      margin: 0 auto; /* Centers the div horizontally */
      padding: 120px 33px 90px 33px; /* Vertical padding remains */
      
      }
/* would you like to---heading */
      h{
        font-size: 32px;
        font-family: calibri;
        font-weight: bold;
        letter-spacing: -1px;      
      }
/* decision buttons */
      .decision{
        color: white;
        background-color: #005288;
        font-family: calibri;
        font-weight: bold;
        font-size: 17px;
        letter-spacing: 0.6px;
        margin-top: 75px;
        border: none;
        border-radius: 3px;
      }
      .decision:hover{
        cursor: pointer;
        color: lightblue;
      }
/* logOut button */
      .logOut{
        border: 1px solid;
        border-radius: 8px;
        background-color: #005288;
        color: white;
        font-family: calibri;
        font-weight: bold;
        font-size: 17px;
        letter-spacing: 0.6px;
        margin-top: 65px;
      }
      .logOut:hover{
        cursor: pointer;
        color: lightblue;
      }
    </style>
</head>
<body>
    <img src="graph.jpeg" style= "height: 100vh; width: 100vw; position: absolute; z-index: -1;">
    <div class= "BOX" style="height: 71.9vh; width: 34vw;">
        <h> Would you like to... </h><br>
<!-- decision buttons -->
        <a href="segmentationandrevenue.html"><button class="decision" type="decision" style="height: 35px; width: 238px; margin-bottom: 16px;"> Perform Analysis </button></a>
        <p style="font-weight: bold;  font-size: 19px;"> or </p>
        <a href="portal2_page3_notification.html"><button class="decision" type="decision" style=" height: 35px; width: 238px; margin-top: 18px;"> View Report </button><br></a>

<!-- logIn button -->
        <a href="logout.php"><button class="logOut" type="logOut" style="margin-top: 200px; height: 35px; width: 178px;"> Log out </button></a><br><br><br>
    </div>
</body>
</html>