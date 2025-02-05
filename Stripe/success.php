<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment Confirmation</title>
  <style>
    /* Global Styles */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Arial", sans-serif;
    }

    body {
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: #f0f8ff;
      color: #333;
    }

    .thank-you-container {
      background-color: #ffffff;
      padding: 30px 50px;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
      text-align: center;
      max-width: 500px;
      width: 90%;
    }

    .thank-you-container h1 {
      font-size: 2em;
      color: #4caf50;
      margin-bottom: 15px;
    }

    .thank-you-container p {
      font-size: 1.2em;
      color: #555;
      margin-bottom: 20px;
    }

    .thank-you-container .btn-home {
      display: inline-block;
      text-decoration: none;
      background-color: #4caf50;
      color: #fff;
      padding: 10px 25px;
      border-radius: 5px;
      font-size: 1em;
      font-weight: bold;
      transition: background-color 0.3s ease;
    }

    .thank-you-container .btn-home:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>
  <div class="thank-you-container">
    <h1>Thank You!</h1>
    <p>Your payment was successfully processed.</p>
    <a href="../Home/home.php" class="btn-home">Go to Home</a>
  </div>
</body>
</html>
