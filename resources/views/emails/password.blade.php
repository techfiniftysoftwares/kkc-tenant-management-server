<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <title>Your Account Password</title>
   <style>
       body {
           font-family: Arial, sans-serif;
       }
       .container {
           max-width: 600px;
           margin: 0 auto;
           padding: 20px;
           background-color: #f4f4f4;
       }
       h2 {
           color: #333;
       }
       p {
           margin-bottom: 20px;
       }
       .password {
           background-color: #fff;
           padding: 10px;
           border: 1px solid #ccc;
           border-radius: 4px;
           font-size: 18px;
           font-weight: bold;
       }
       .login-link {
           display: inline-block;
           margin-top: 20px;
           padding: 10px 20px;
           background-color: #007bff;
           color: #fff;
           text-decoration: none;
           border-radius: 4px;
       }
   </style>
</head>
<body>
   <div class="container">
       <h2>Welcome, {{ $user->firstname }}!</h2>
       <p>Your account has been created successfully.</p>
       <p>Your login password is: <span class="password">{{ $password }}</span></p>
       <p>Please keep this password safe and secure.</p>
       <a href="https://ifms.kusoya.com/demo" class="login-link">Login to Your Account</a>
   </div>
</body>
</html>
