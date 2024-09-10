<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #4facfe, #00f2fe);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
        }

        .container {
            text-align: center;
            padding: 40px;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        a {
            padding: 10px 30px;
            text-decoration: none;
            background-color: #ff4081;
            color: white;
            font-weight: bold;
            border-radius: 30px;
            box-shadow: 0 8px 15px rgba(255, 64, 129, 0.3);
            transition: all 0.3s ease;
        }

        a:hover {
            background-color: #ff1e70;
            box-shadow: 0 15px 20px rgba(255, 64, 129, 0.4);
            transform: translateY(-3px);
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Welcome to Our Website</h1>
    <p>We're glad to have you here. Explore and enjoy!</p>
    <a href="#">Get Started</a>
</div>
</body>
</html>
