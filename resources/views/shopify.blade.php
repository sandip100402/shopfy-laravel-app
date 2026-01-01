<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Install App | Shopify</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #f6f6f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .install-card {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05), 0 1px 2px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .logo {
            width: 60px;
            height: 60px;
            background:rgb(0, 77, 128); /* Shopify Green */
            border-radius: 12px;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 24px;
        }

        h2 {
            margin: 0 0 8px 0;
            color: #1a1c1d;
            font-size: 24px;
            font-weight: 600;
        }

        p {
            color: #6d7175;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .form-group {
            text-align: left;
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 6px;
            color: #202223;
        }

        input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #c9cccf;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 15px;
            transition: border-color 0.2s;
        }

        input[type="text"]:focus {
            outline: none;
            border-color:rgb(0, 51, 128);
            box-shadow: 0 0 0 2px rgba(0, 128, 96, 0.1);
        }

        button {
            width: 100%;
            background-color:rgb(0, 41, 128);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        button:hover {
            background-color:rgb(0, 44, 110);
        }

        .footer-text {
            margin-top: 20px;
            font-size: 12px;
            color: #8c9196;
        }
    </style>
</head>
<body>

<div class="install-card">
    <div class="logo">S</div>
    <h2>Install App</h2>
    <p>Enter your store domain to get started.</p>

    <form method="GET" action="{{ route('shopify.auth') }}">
        <div class="form-group">
            <label for="shop">Shop Domain</label>
            <input 
                type="text" 
                id="shop"
                name="shop" 
                placeholder="example.myshopify.com" 
                required
            >
        </div>
        <button type="submit">Install to Store</button>
    </form>

    <div class="footer-text">
        By clicking install, you agree to our Terms of Service.
    </div>
</div>

</body>
</html>