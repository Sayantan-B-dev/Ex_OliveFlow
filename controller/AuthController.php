<?php
// controller/AuthController.php
require_once __DIR__ . '/../config/config.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action === 'logout') {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4", DB_USER, DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    logActivity($pdo, 'User Logout', 'Auth');
    session_unset();
    session_destroy();
    header('Location: ' . BASE_URL . '/index.php');
    exit;
}
if ($action === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4", DB_USER, DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email=? AND status='active' LIMIT 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['user_name'] = $user['name'] ?? $user['full_name'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['user_email'] = $user['email'];
        
        logActivity($pdo, 'User Login', 'Auth', 'User logged in via email: '.$email);

        // Find link to professional/student ID
        if ($user['role'] === 'student') {
            $s = $pdo->prepare("SELECT id, admission_number FROM students WHERE user_id=? OR email=? LIMIT 1");
            $s->execute([$user['id'], $user['email']]);
            $stu = $s->fetch();
            $_SESSION['student_id'] = $stu['id'] ?? null;
            $_SESSION['admission_no'] = $stu['admission_number'] ?? null;
        } elseif ($user['role'] === 'faculty') {
            $f = $pdo->prepare("SELECT id, staff_id FROM staff WHERE user_id=? OR email=? LIMIT 1");
            $f->execute([$user['id'], $user['email']]);
            $fac = $f->fetch();
            $_SESSION['staff_db_id'] = $fac['id'] ?? null;
            $_SESSION['staff_id'] = $fac['staff_id'] ?? null;
        }

        header('Location: ' . BASE_URL . '/index.php?page=dashboard');
        exit;
    } else {
        $_SESSION['login_error'] = 'Invalid email or password.';
        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }
}

if ($action === 'register' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4", DB_USER, DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];
    $pass = $_POST['password'];
    $conf = $_POST['confirm_password'];

    if ($pass !== $conf) {
        $_SESSION['reg_error'] = "Passwords do not match.";
        header('Location: '.BASE_URL.'/view/auth/register.php'); exit;
    }

    $c = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email=?");
    $c->execute([$email]);
    if ($c->fetchColumn() > 0) {
        $_SESSION['reg_error'] = "Email already registered.";
        header('Location: '.BASE_URL.'/view/auth/register.php'); exit;
    }

    $masterEmail = getenv('MASTER_EMAIL');
    if (!$masterEmail) {
        $_SESSION['reg_error'] = "System error: Master email not configured in .env.";
        header('Location: '.BASE_URL.'/view/auth/register.php'); exit;
    }

    $otp = str_pad((string)mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
    $_SESSION['reg_otp'] = $otp;
    $_SESSION['reg_otp_expires'] = time() + 600; // 10 minutes
    $_SESSION['pending_reg_data'] = [
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'role' => $role,
        'password' => $pass
    ];

    $subject = "Registration Approval OTP - Student ERP";
    $message = "
    <div style='font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 40px 0; color: #333;'>
        <div style='max-width: 550px; margin: 0 auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.05);'>
            <div style='background: #4a7c59; padding: 25px; text-align: center; color: #fff;'>
                <h2 style='margin: 0; font-weight: 600;'>Registration Request</h2>
                <p style='margin: 5px 0 0 0; opacity: 0.9; font-size: 14px;'>Action required for new user</p>
            </div>
            <div style='padding: 35px;'>
                <p style='margin-top: 0; font-size: 16px;'>Hello Admin,</p>
                <p style='color: #555; line-height: 1.5;'>A new user is requesting access to the <strong>Student ERP</strong> platform. Please review their details below:</p>
                
                <div style='background: #fdfdfd; border: 1px solid #eee; border-radius: 8px; padding: 20px; margin: 25px 0;'>
                    <table style='width: 100%; border-collapse: collapse; font-size: 15px;'>
                        <tr><td style='padding: 8px 0; color: #777; width: 35%;'>Name:</td><td style='padding: 8px 0; font-weight: 500;'>{$name}</td></tr>
                        <tr><td style='padding: 8px 0; color: #777;'>Account Role:</td><td style='padding: 8px 0; font-weight: 500; text-transform: capitalize;'>{$role}</td></tr>
                        <tr><td style='padding: 8px 0; color: #777;'>Email Address:</td><td style='padding: 8px 0; font-weight: 500;'><a href='mailto:{$email}' style='color: #4a7c59; text-decoration: none;'>{$email}</a></td></tr>
                        <tr><td style='padding: 8px 0; color: #777;'>Phone Number:</td><td style='padding: 8px 0; font-weight: 500;'>{$phone}</td></tr>
                    </table>
                </div>

                <div style='background: rgba(74, 124, 89, 0.05); border: 1px dashed #4a7c59; padding: 25px; text-align: center; border-radius: 8px; margin: 30px 0;'>
                    <p style='margin: 0 0 10px 0; color: #555; font-size: 14px; font-weight: 500;'>Your One-Time Password (OTP)</p>
                    <h1 style='margin: 0; color: #4a7c59; font-size: 42px; letter-spacing: 8px;'>{$otp}</h1>
                </div>
                
                <p style='color: #888; font-size: 13px; text-align: center; margin: 0;'>
                    This OTP is valid for exactly <strong>10 minutes</strong>.<br>If you did not expect this request, please ignore this email.
                </p>
            </div>
        </div>
    </div>
    ";
    
    // Send email using PHPMailer
    require_once __DIR__ . '/../libs/PHPMailer/src/Exception.php';
    require_once __DIR__ . '/../libs/PHPMailer/src/PHPMailer.php';
    require_once __DIR__ . '/../libs/PHPMailer/src/SMTP.php';

    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
    try {
        if (getenv('SMTP_HOST')) {
            $mail->isSMTP();
            $mail->Host       = getenv('SMTP_HOST');
            $mail->SMTPAuth   = true;
            $mail->Username   = getenv('SMTP_USER');
            $mail->Password   = getenv('SMTP_PASS');
            $mail->SMTPSecure = getenv('SMTP_SECURE') ?: \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = getenv('SMTP_PORT') ?: 465;
        }

        $mail->setFrom(getenv('SMTP_USER') ?: 'no-reply@studenterp.com', 'Student ERP Admin');
        $mail->addAddress($masterEmail);
        $mail->Subject = $subject;
        $mail->isHTML(true);
        $mail->Body    = $message;
        $mail->AltBody = "A new {$role} ({$name}) is trying to register.\nEmail: {$email}\nPhone: {$phone}\nOTP: {$otp}\nThis OTP is valid for 10 minutes.";

        $mail->send();
    } catch (Exception $e) {
        $_SESSION['reg_error'] = "Mailer Error: {$mail->ErrorInfo}";
        header('Location: '.BASE_URL.'/view/auth/register.php'); exit;
    }

    header('Location: '.BASE_URL.'/view/auth/otp_verify.php'); exit;
}

if ($action === 'verify_otp' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4", DB_USER, DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $submitted_otp = trim($_POST['otp'] ?? '');

    if (!isset($_SESSION['reg_otp']) || !isset($_SESSION['pending_reg_data'])) {
        $_SESSION['reg_error'] = "No pending registration found.";
        header('Location: '.BASE_URL.'/view/auth/register.php'); exit;
    }

    if (time() > $_SESSION['reg_otp_expires']) {
        $_SESSION['reg_error'] = "OTP has expired. Please register again.";
        unset($_SESSION['reg_otp'], $_SESSION['reg_otp_expires'], $_SESSION['pending_reg_data']);
        header('Location: '.BASE_URL.'/view/auth/register.php'); exit;
    }

    if ($submitted_otp !== $_SESSION['reg_otp']) {
        $_SESSION['otp_error'] = "Invalid OTP.";
        header('Location: '.BASE_URL.'/view/auth/otp_verify.php'); exit;
    }

    $data = $_SESSION['pending_reg_data'];
    $name = $data['name'];
    $email = $data['email'];
    $phone = $data['phone'];
    $role = $data['role'];
    $pass = $data['password'];

    $hashed = password_hash($pass, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role, status) VALUES (?,?,?,?,?)");
    $stmt->execute([$name, $email, $hashed, $role, 'active']);
    $user_id = $pdo->lastInsertId();

    logActivity($pdo, 'User Registration', 'Auth', "New $role registered: $email");

    if ($role === 'faculty') {
        $staff_id = 'TCH'.date('Y').str_pad(mt_rand(100, 999), 3, '0', STR_PAD_LEFT);
        $pdo->prepare("INSERT INTO staff (user_id, staff_id, first_name, last_name, category_id, designation_id, email, phone, status) VALUES (?,?,?,?,?,?,?,?,?)")
            ->execute([$user_id, $staff_id, $name, '', 1, 1, $email, $phone, 'active']);
    }

    unset($_SESSION['reg_otp'], $_SESSION['reg_otp_expires'], $_SESSION['pending_reg_data']);

    $_SESSION['flash'] = "Account created. Please login.";
    header('Location: '.BASE_URL.'/index.php'); exit;
}

if ($action === 'cancel_registration') {
    unset($_SESSION['reg_otp'], $_SESSION['reg_otp_expires'], $_SESSION['pending_reg_data']);
    header('Location: '.BASE_URL.'/view/auth/register.php'); exit;
}

header('Location: ' . BASE_URL . '/index.php');
exit;