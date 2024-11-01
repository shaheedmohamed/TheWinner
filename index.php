<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'user_db');

// متغيرات لتخزين الأخطاء والنجاح
$nameError = '';
$emailError = '';
$successMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // التحقق من وجود البريد الإلكتروني
    $checkEmail = $conn->query("SELECT * FROM users WHERE email = '$email'");

    if ($checkEmail->num_rows > 0) {
        $emailError = "هذا البريد الإلكتروني مستخدم بالفعل.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $password);
        if ($stmt->execute()) {
            $successMessage = "تم تسجيلك بنجاح. يمكنك <a href='./login&signup/login.php' style='color: blue;'>تسجيل الدخول الآن</a>";
            
            // تفريغ الحقول
            $name = '';
            $email = '';
            $password = '';
        }
        $stmt->close();
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>تسجيل جديد</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #4CAF50, #81C784);
        }
        .container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            padding: 2em;
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        h2 {
            color: #333;
            font-size: 1.8em;
        }
        .form-group {
            margin-bottom: 1em;
            text-align: left;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 0.8em;
            margin-top: 0.5em;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 0.8em;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #45a049;
        }
        .error-message {
            color: red;
            font-size: 0.9em;
            margin-top: 0.5em;
        }
        .success-message {
            color: green;
            font-size: 1em;
            margin-top: 1em;
        }
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1em 0;
            color: #888;
        }
        .divider::before, .divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid #ccc;
        }
        .divider:not(:empty)::before {
            margin-right: .5em;
        }
        .divider:not(:empty)::after {
            margin-left: .5em;
        }
        .login-link a {
            color: #4CAF50;
            font-weight: bold;
            text-decoration: none;
        }
        .login-link a:hover {
            color: #81C784;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>تسجيل جديد</h2>
        <hr>
        <form action="./index.php" method="POST">
            <div class="form-group">
                <label for="name">الاسم</label>
                <input type="text" name="name" placeholder="الاسم" value="<?php echo htmlspecialchars($name); ?>" required>
                <div class="error-message"><?php echo $nameError; ?></div>
            </div>
            <div class="form-group">
                <label for="email">البريد الإلكتروني</label>
                <input type="email" name="email" placeholder="البريد الإلكتروني" value="<?php echo htmlspecialchars($email); ?>" required>
                <div class="error-message"><?php echo $emailError; ?></div>
            </div>
            <div class="form-group">
                <label for="password">كلمة المرور</label>
                <input type="password" name="password" placeholder="كلمة المرور" required>
            </div>
            <button type="submit">تسجيل جديد</button>
        </form>
        <div class="success-message"><?php echo $successMessage; ?></div>
        <div class="divider">or</div>
        <div class="login-link">
            <a href="./login&signup/login.php">تسجيل الدخول</a>
        </div>
    </div>
</body>
</html>
