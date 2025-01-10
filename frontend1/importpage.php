<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Data</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #001f3f; /* Dark Blue */
            height: 110vh;

            background-size: cover;
        }

       
      
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .BOX {
            border-radius: 27px;
            padding: 170px 20px 120px 30px;
            font-family: calibri;
            background-color: aliceblue;
            text-align: center;
            width: 625px;
            /* margin: 0 auto; */
            margin-left: 230px; /* Add this line to shift it to the right */

            opacity: 0;
        transform: translateY(30px);
        transition: all 1s ease-out;
      }

      .BOX.active {
        opacity: 1;
        transform: translateY(0);
      }
        .button {
            background-color: #005288;
            border: none;
            color: white;
            padding: 10px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            transition: all 0.3s;
            margin-top: 15px;
        }
        .button:hover {
            background-color: #003d66;
            cursor: pointer;
        }
        form {
            margin-top: 20px;
        }
        .dropbox {
            border: 2px dashed #005288;
            padding: 20px;
            margin: 20px 0;
            border-radius: 10px;
            transition: background-color 0.3s ease;
        }
        .dropbox.dragover {
            background-color: #e0e0e0;
        }
        .dropbox p {
            margin: 0;
            font-size: 16px;
        }
        .dropbox button {
            background-color: #005288;
            color: white;
            border: none;
            padding: 5px 15px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        .dropbox button:hover {
            background-color: #003d66;
        }
        .filename {
            margin-top: 10px;
            font-weight: bold;
            font-size: 14px;
        }

        .progress {
        height: 30px;
        border-radius: 5px;
        background-color: #f0f0f0;
        margin-top: 20px;
        margin-bottom: 10px;
    }

    .progress-bar {
        background-color: #005288;
        height: 100%;
        text-align: center;
        color: white;
        line-height: 30px;
        font-size: 16px;
        transition: width 0.4s ease;
    }
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


    
<div class="BOX">
    
    <h1 class="text-center mt-5">Import Dataset</h1>
    <!-- Import File Form -->
    <form id="uploadForm" action="upload.php" method="post" enctype="multipart/form-data">
        <!-- Drag and Drop Box -->
        <div class="dropbox" id="dropbox">
            <p>Drag and drop files here</p>
            <p>or</p>
            <button type="button" onclick="document.getElementById('fileInput').click()">Select Files</button>
            <input type="file" id="fileInput" class="file-input" name="file" accept=".xlsx" style="display:none;" required>
            <!-- Display the file name here -->
            <div id="fileName" class="filename"></div>
        </div>

        <!-- Progress Bar -->
        <div id="progressContainer" style="display: none;">
            <div class="progress">
                <div class="progress-bar" id="progressBar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <p id="progressText" class="text-center mt-2">Uploading...</p>
        </div>

        <button type="submit" class="button" id="uploadBtn">Upload File</button>
    </form>
    
    <!-- Back Button -->
    <a href="decisionn.html"><button class="button">Back</button></a>
</div>



<script>
    const form = document.getElementById('uploadForm');
    const progressBar = document.getElementById('progressBar');
    const progressContainer = document.getElementById('progressContainer');
    const uploadBtn = document.getElementById('uploadBtn');
    
    form.addEventListener('submit', (event) => {
        event.preventDefault();  // Prevent normal form submission

        // Show the progress bar and reset its progress
        progressContainer.style.display = 'block';
        progressBar.style.width = '0%';
        progressBar.setAttribute('aria-valuenow', 0);
        document.getElementById('progressText').innerText = `Uploading... 0%`;
        
        const formData = new FormData(form);

        // Upload the file via AJAX with progress tracking
        const xhr = new XMLHttpRequest();

        xhr.upload.addEventListener("progress", (e) => {
            if (e.lengthComputable) {
                const percentComplete = Math.round((e.loaded / e.total) * 100);
                progressBar.style.width = percentComplete + '%';
                progressBar.setAttribute('aria-valuenow', percentComplete);
                document.getElementById('progressText').innerText = `Uploading... ${percentComplete}%`;
            }
        });

        xhr.onload = () => {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    // Update progress bar for preprocessing stage
                    progressBar.style.width = '100%';
                    document.getElementById('progressText').innerText = `Upload Complete. Preprocessing...`;

                    // Poll for preprocessing completion (AJAX to check backend status)
                    checkPreprocessingProgress();
                } else {
                    alert('Error: ' + response.message);
                }
            } else {
                alert('An error occurred during the upload.');
            }
        };

        xhr.onerror = () => {
            alert('An error occurred while uploading the file.');
        };

        xhr.open('POST', 'upload.php', true);
        xhr.send(formData);
    });

    function checkPreprocessingProgress() {
        const interval = setInterval(() => {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'preprocessing_status.php', true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.completed) {
                        clearInterval(interval);
                        document.getElementById('progressText').innerText = 'Preprocessing Complete!';
                        window.location.href = 'segmentationandrevenue.html';  // Redirect after preprocessing is done
                    } else {
                        document.getElementById('progressText').innerText = `Preprocessing: ${response.progress}%`;
                        progressBar.style.width = response.progress + '%';
                        progressBar.setAttribute('aria-valuenow', response.progress);
                    }
                }
            };
            xhr.send();
        }, 1000);  // Check every 1 second
    }
</script>

    <!-- Include Bootstrap JS and dependencies -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        const dropbox = document.getElementById('dropbox');
        const fileInput = document.getElementById('fileInput');
        const fileNameDisplay = document.getElementById('fileName');
        
        dropbox.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropbox.classList.add('dragover');
        });

        dropbox.addEventListener('dragleave', () => {
            dropbox.classList.remove('dragover');
        });

        dropbox.addEventListener('drop', (e) => {
            e.preventDefault();
            dropbox.classList.remove('dragover');
            // Get the dropped files and set them as the file input's files
            const files = e.dataTransfer.files;
            fileInput.files = files;
            displayFileName(files[0].name);  // Display file name
        });

        fileInput.addEventListener('change', (e) => {
            const files = e.target.files;
            displayFileName(files[0].name);  // Display file name
        });

        function displayFileName(name) {
            fileNameDisplay.textContent = `Selected file: ${name}`;
        }
    </script>

<script>
        $(document).ready(function() {
            setTimeout(function() {
                $('.BOX').addClass('active');
            }, 300);
        });
    </script>
</body>
</html>