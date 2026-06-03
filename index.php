<?php
session_start();
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sistem Manajemen Data Siswa</title>
    <style>
       
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            box-sizing: border-box;
        }
        h1 {
            color: #333333;
            font-size: 24px;
            margin-bottom: 10px;
            font-weight: 700;
        }
        hr {
            border: 0;
            height: 2px;
            background: #e0e0e0;
            margin-bottom: 30px;
        }
        .form-control {
            margin-bottom: 20px;
            text-align: left;
        }
        .form-control input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #cccccc;
            border-radius: 5px;
            font-size: 14px;
            outline: none;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }
        .form-control input:focus {
            border-color: #1e5474;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #1e5474;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #153d54;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>PANEL LOGIN</h1>
        <hr>
        <form action="cek_login.php" method="POST">
            <div class="form-control">
                <input type="text" name="user" placeholder="Masukkan username" required>
            </div>
            <div class="form-control">
                <input type="password" name="pass" placeholder="Masukkan Password" required>
            </div>
            <div class="form-control">
                <button type="submit">LOGIN</button>
            </div>
        </form>
    </div>
</body>
</html>