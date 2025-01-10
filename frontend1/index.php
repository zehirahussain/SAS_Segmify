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
            overflow-x: hidden;
            background-color: #f3f6fa;
        }
        html {
    scroll-behavior: smooth;
}

        /* Header Styles */
        header {
            background-color: #1a1a1a;
            color: white;
            padding: 0px -5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);

        }

        header a {
            text-decoration: none;
            color: white;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Make logo bigger */
        .logo img {
            width: 80px; /* Increase size */
            height: auto;
        }

        .nav-buttons {
            display: flex;
            gap: 15px;
        }

        .SignIn {
            border: none;
            border-radius: 6px;
            background-color: #0077cc;
            color: white;
            font-family: Calibri, sans-serif;
            font-weight: bold;
            font-size: 15px;
            padding: 8px 15px;
            letter-spacing: 0.5px;
            transition: background-color 0.3s, transform 0.2s;
        }

        .SignIn:hover {
            background-color: #005288;
            cursor: pointer;
            transform: translateY(-2px);
        }

        /* Background Image Styling */
        .background-image {
            /* background-image: linear-gradient(to right, #6a11cb, #2575fc); Gradient Background */
            background-image:url('graph.jpeg') ;
            height: 100vh;
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Main Box Styling */
        .BOX {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            padding: 60px 30px;
            width: 90%;
            max-width: 600px;
            transition: transform 0.2s;
            transform: translateY(50px);
            animation: slideUp 1s ease-out forwards;
        }

        .BOX:hover {
            transform: scale(1.03);
        }

        @keyframes slideUp {
            0% { transform: translateY(50px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }

        h1 {
            color: #005288;
            font-size: 28px;
            margin-top: 0;
            font-family: 'Arial', sans-serif;
        }

        .description {
            color: #333;
            font-size: 18px;
            line-height: 1.6;
            margin-top: 10px;
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            header {
                flex-direction: column;
                text-align: center;
            }

            .nav-buttons {
                flex-direction: column;
                gap: 10px;
            }

            .SignIn {
                width: 100%;
                font-size: 14px;
            }

            .BOX {
                padding: 40px 20px;
            }

            .description {
                font-size: 16px;
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
        section {
    scroll-margin-top: 80px; /* Adjust based on your header height */
}

    </style>
</head>
<body>

<header>
    <!-- Logo and Site Name on the Left -->
    <div class="logo">
        <img src="SAS Segmify logo (2).png" alt="Logo">
        <span style="font-size: 24px; font-weight: bold; color: white;">SAS Segmify</span>
    </div>

    <!-- Navigation Buttons on the Right -->
    <div class="nav-buttons">
        <a href="#"><button class="SignIn">Home</button></a>
        <a href="aoutus.html"><button class="SignIn">About Us</button></a>
        <a href="contactus.html"><button class="SignIn">Contact Us</button></a>
        <a href="signuppppp.html"><button class="SignIn">Sign Up</button></a>
        <a href="loginnnn.html"><button class="SignIn">Sign In</button></a>
    </div>
</header>

<div class="background-image">
    <div class="container">
        <div class="BOX"> 
            <div class="centered">
                <h1><?php echo "Segmentation Simplified, Growth Amplified"; ?></h1>
                <p class="description">
                    <?php 
                        $description = "Unlock customer insights and drive growth. With SAS Segmify, segment customers, predict trends, and analyze feedback, all powered by advanced machine learning in one platform.";
                        echo $description; 
                    ?>
                </p>
            </div>
        </div>
    </div>
</div>
<!-- New sections added below the existing BOX -->
<section id="features">
    <div class="features-section" style="background: linear-gradient(to right, rgb(1, 32, 67), rgb(8, 49, 96)); padding: 60px 20px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
        <h2 style="text-align: center; color: #00ccff;">Features</h2>
        <div style="display: flex; justify-content: space-around; margin-top: 30px; flex-wrap: wrap;">
            <div style="width: 200px; text-align: center;">
                <h3 style="color: #00ccff;">RFM Segmentation</h3>
                <p style="color:rgb(229, 247, 251);">Segment customers based on Recency, Frequency, and Monetary value.</p>
            </div>
            <div style="width: 200px; text-align: center;">
                <h3 style="color: #00ccff;">Customer Reviews</h3>
                <p style="color:rgb(229, 247, 251);">Analyze customer feedback and uncover trends effortlessly.</p>
            </div>
            <div style="width: 200px; text-align: center;">
                <h3 style="color: #00ccff;">Revenue Insights</h3>
                <p style="color:rgb(229, 247, 251);">Monitor Monthly Recurring Revenue with clear visualizations.</p>
            </div>
        </div>
    </div>
</section>

<section id="how-it-works">
    <div class="how-it-works-section" style="background: linear-gradient(to right, rgb(2, 19, 58), rgb(13, 25, 39)); padding: 60px 20px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
        <h2 style="text-align: center; color: #00ccff;">How It Works</h2>
        <div style="display: flex; justify-content: space-around; margin-top: 30px; flex-wrap: wrap;">
            <div style="width: 300px; text-align: center;">
                <h3 style="color: #00ccff;">1. Upload Data</h3>
                <p style="color:rgb(229, 247, 251);">Upload your customer data securely to our platform.</p>
            </div>
            <div style="width: 300px; text-align: center;">
                <h3 style="color: #00ccff;">2. Analyze</h3>
                <p style="color:rgb(229, 247, 251);">Run advanced machine learning algorithms to get insights.</p>
            </div>
            <div style="width: 300px; text-align: center;">
                <h3 style="color: #00ccff;">3. Get Reports</h3>
                <p style="color:rgb(229, 247, 251);">View detailed, easy-to-understand reports and visualizations.</p>
            </div>
        </div>
    </div>
</section>


<!-- FAQ Section -->
<section id="faq">
    <div class="faq-section" style="background-color:rgb(13, 25, 39); padding: 60px 20px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
        <h2 style="text-align: center; color: #00ccff; font-size: 2em; margin-bottom: 40px;">Frequently Asked Questions (FAQs)</h2>
        
        <div class="faq-item" style="background-color:rgb(220, 235, 252); padding: 1px; margin-bottom: 20px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); text-align: center; position: relative;">
            <span style="position: absolute; left: 20px; top: 20px; font-size: 1.5em; color: #005288; cursor: pointer;">+</span>
            <h3 style="color: #005288; font-size: 1.2em; cursor: pointer; transition: color 0.3s;">What is SAS Segmify?</h3>
            <p style="color: #333; font-size: 1em; line-height: 1.5; display: none;">SAS Segmify is a powerful customer segmentation tool powered by machine learning, designed to segment customers, analyze feedback, and predict trends to drive business growth.</p>
        </div>
        
        <div class="faq-item" style="background-color: rgb(220, 235, 252); padding: 1px; margin-bottom: 20px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); text-align: center; position: relative;">
            <span style="position: absolute; left: 20px; top: 20px; font-size: 1.5em; color: #005288; cursor: pointer;">+</span>
            <h3 style="color: #005288; font-size: 1.2em; cursor: pointer; transition: color 0.3s;">How does customer segmentation work in SAS Segmify?</h3>
            <p style="color: #333; font-size: 1em; line-height: 1.5; display: none;">Customer segmentation in SAS Segmify is based on RFM (Recency, Frequency, and Monetary value), allowing you to group customers based on their purchase behavior, helping you identify high-value customers and opportunities for growth.</p>
        </div>

        <div class="faq-item" style="background-color: rgb(220, 235, 252); padding: 1px; margin-bottom: 20px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); text-align: center; position: relative;">
            <span style="position: absolute; left: 20px; top: 20px; font-size: 1.5em; color: #005288; cursor: pointer;">+</span>
            <h3 style="color: #005288; font-size: 1.2em; cursor: pointer; transition: color 0.3s;">How can I upload my data?</h3>
            <p style="color: #333; font-size: 1em; line-height: 1.5; display: none;">You can easily upload your customer data to SAS Segmify using our secure data upload feature. Simply navigate to the upload section, select your file, and follow the on-screen instructions.</p>
        </div>

        <div class="faq-item" style="background-color: rgb(220, 235, 252); padding: 1px; margin-bottom: 20px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); text-align: center; position: relative;">
            <span style="position: absolute; left: 20px; top: 20px; font-size: 1.5em; color: #005288; cursor: pointer;">+</span>
            <h3 style="color: #005288; font-size: 1.2em; cursor: pointer; transition: color 0.3s;">Is my data safe with SAS Segmify?</h3>
            <p style="color: #333; font-size: 1em; line-height: 1.5; display: none;">Yes, your data is completely safe with us. We use the latest security measures to ensure your data is stored securely and only accessible by authorized users.</p>
        </div>

        <div class="faq-item" style="background-color: rgb(220, 235, 252); padding: 1px; margin-bottom: 20px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); text-align: center; position: relative;">
            <span style="position: absolute; left: 20px; top: 20px; font-size: 1.5em; color: #005288; cursor: pointer;">+</span>
            <h3 style="color: #005288; font-size: 1.2em; cursor: pointer; transition: color 0.3s;">Can I get a demo before signing up?</h3>
            <p style="color: #333; font-size: 1em; line-height: 1.5; display: none;">Yes, we offer a demo for users who want to explore the features of SAS Segmify before committing to a subscription. Contact us through the "Contact Us" page to request a demo.</p>
        </div>
    </div>
</section>

<script>
    document.querySelectorAll('.faq-item h3').forEach(item => {
        item.addEventListener('click', () => {
            const content = item.nextElementSibling;
            const plusSign = item.previousElementSibling;
            content.style.display = content.style.display === 'none' ? 'block' : 'none';
            item.style.color = content.style.display === 'none' ? '#005288' : '#003366';
            plusSign.textContent = content.style.display === 'none' ? '+' : '-';
        });
    });
</script>



<footer style="background-color:rgb(0, 0, 0); color: #fff; padding: 40px 20px; text-align: center;">
    <div class="footer-top" style="display: flex; flex-wrap: wrap; justify-content: space-between; max-width: 1200px; margin: 0 auto; gap: 20px;">
        <!-- Quick Links -->
        <div class="footer-links" style="flex: 1; min-width: 200px;">
            <h3 style="color: #f3f6fa; margin-bottom: 20px;">Quick Links</h3>
            <ul style="list-style: none; padding: 0;">
                <li><a href="#features" style="color: #fff; text-decoration: none;">Features</a></li>
                <li><a href="#how-it-works" style="color: #fff; text-decoration: none;">How It Works</a></li>
                <li><a href="aoutus.html" style="color: #fff; text-decoration: none;">About Us</a></li>
                <li><a href="contactus.html" style="color: #fff; text-decoration: none;">Contact Us</a></li>
            </ul>
        </div>

        <!-- Contact Info -->
        <div class="footer-contact" style="flex: 1; min-width: 200px;">
            <h3 style="color: #f3f6fa; margin-bottom: 20px;">Contact Us</h3>
            <p>Email: <a href="mailto:info@sassegmify.com" style="color: #fff; text-decoration: none;">service@nexoskills.com</a></p>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom" style="margin-top: 40px; border-top: 1px solid #f3f6fa; padding-top: 20px;">
        <p style="margin: 0; font-size: 14px;">© 2025 SAS Segmify. All rights reserved.</p>
    </div>
</footer>


</body>
</html>
