<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Decision</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
      * {
        margin: 0;
        padding: 0;
      }

      /* Sidebar and background styles */
      #sidebar {
        background-color: #000000;
        height: 100vh;
        width: 250px;
        padding: 20px;
        position: fixed;
        left: 0;
        top: 0;
        overflow-y: auto;
      }

      .sidebar-button {
        background-color: #005288;
        border: none;
        color: white;
        padding: 3px 30px;
        text-align: center;
        text-decoration: none;
        display: block;
        font-size: 15px;
        margin: -2.5px 0;
        border-radius: 10px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        transition: all 0.3s;
        flex: 1;
        font-family: Arial;

      }

      .dash {
        color: white;
        padding: 10px 25px;
        font-weight: bold;
        display: block;
        font-size: 18px;
        margin: 10px 10;
        font-family: Arial;

      }

      .sidebar-button:hover {
        background-color: #05424b;
        box-shadow: 0 6px 12px 0 rgba(0, 0, 0, 0.3);
      }

      .content {
        margin-left: 250px;
        padding: 20px;
        background-color: #001f3f;
        height: 110vh;
        color: white;
      }

      .nav-link {
        border-radius: 5px;
        padding: 8px 16px;
        margin: 5px 0;
        display: inline-flex;
      }

      .footer {
        color: white;
        font-size: 14px;
        background-color: #000000;
        text-align: center;
        padding: 10px;
        position: fixed;
        bottom: 0;
        left: 0;
        width: 250px;
      }

      /* White Box animation */
      .BOX {
        border-radius: 27px;
        padding: 20px 50px 50px 53px;
        background-color: aliceblue;
        text-align: center;
        width: 34vw;
        margin: 50px auto 0 auto; /* Adjusted margin to move the box up */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);

        /* Animation Defaults */
        opacity: 0;
        transform: translateY(30px);
        transition: all 1s ease-out;
      }

      .BOX.active {
        opacity: 1;
        transform: translateY(0);
      }

      /* Headings and buttons */
      h {
        font-size: 32px;
        font-family: calibri;
        font-weight: bold;
        letter-spacing: -1px;  
        color: black;    
      }

      p {
        color: black;
      }

      .decision {
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

      .decision:hover {
        cursor: pointer;
        color: lightblue;
      }

      .logOut {
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

      .logOut:hover {
        cursor: pointer;
        color: lightblue;
      }
      hr.rounded {
            border-top: 4px solid #4d5357;
            border-radius: 5px;
        }

      
        .username {
            font-size: 20px;
            color: #d9e0e6;
            font-weight: bold;
            display: inline-block;
            margin-left: 10px;
        }
        hr.solid {
            border-top: 3px solid #1e3673;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div id="sidebar">
        <li class="dash"> &#128202; Dashboard</li>
        <nav class="nav flex-column">
            <a class="nav-link" href="#"><button class="sidebar-button">Segmentation & Revenue</button></a>
            <a class="nav-link" href="#"><button class="sidebar-button">Review Analysis</button></a>
            <a class="nav-link" href="#"><button class="sidebar-button">Visualize Data</button></a>
            <a class="nav-link" href="#"><button class="sidebar-button">Presentation</button></a>
            <a class="nav-link" href="#"><button class="sidebar-button">Report</button></a>
            <a class="nav-link" href="#"><button class="sidebar-button">Back</button></a>
        </nav>
        <footer class="footer flex-column">
            <div><a class="nav-link" href="#"><button class="sidebar-button">Settings</button></a></div>
            <div><a class="nav-link" href="#"><button class="sidebar-button">Log Out</button></a></div>
            <hr class="rounded">
            <span id="username" class="username loading-name"></span>

        </footer>
    </div>

    <!-- Main Content -->
    <div class="content">
        <main role="main">
            <div class="BOX">
                <h>Would you like to...</h><br>
                <!-- Decision buttons -->
                <a href="importpage.php"><button class="decision" type="decision" style="height: 35px; width: 238px; margin-bottom: 16px;"> Perform Analysis </button></a>
                <p style="font-weight: bold;  font-size: 19px;"> or </p>
                <a href="portal2_page3_notification.html"><button class="decision" type="decision" style=" height: 35px; width: 238px; margin-top: 18px;"> View Report </button><br></a>

                <!-- logIn button -->
                <a href="logout.php"><button class="logOut" type="logOut" style="margin-top: 200px; height: 35px; width: 178px;"> Log out </button></a><br><br><br>
            </div>
        </main>
    </div>

    <!-- jQuery Script -->
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('.BOX').addClass('active');
            }, 300);
        });
    </script>
</body>
</html>
