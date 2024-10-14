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
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('graph.jpeg');
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
            margin: 0 auto;
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

    </style>
</head>
<body>
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

<!-- <script>
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
                    window.location.href = 'segmentationandrevenue.html';  // Redirect after processing is done
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
</script> -->

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
</body>
</html>