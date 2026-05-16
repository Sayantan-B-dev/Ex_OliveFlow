<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student ERP – Login</title>
    <link rel="icon" href="assets/images/favicon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        :root { --olive:#4a7c59; --maroon:#800000; --charcoal:#4a3c31; }
        *, *::before, *::after { box-sizing:border-box; }
        body {
            min-height:100vh;
            background: linear-gradient(135deg, #1a2a1a 0%, #2c4a2c 40%, #4a3c31 100%);
            display:flex; align-items:center; justify-content:center;
            font-family:'Inter',system-ui,sans-serif;
        }
        .login-card {
            background:rgba(255,255,255,.96);
            border-radius:20px;
            box-shadow:0 30px 80px rgba(0,0,0,.45);
            overflow:hidden; width:100%; max-width:460px;
        }
        .login-header {
            background: linear-gradient(135deg, var(--maroon), #4a1010);
            padding:2.5rem 2rem 2rem;
            text-align:center; color:#fff;
        }
        .login-header .logo-ring {
            width:70px; height:70px; border-radius:50%;
            background:rgba(255,255,255,.15);
            margin:0 auto 16px;
            display:flex; align-items:center; justify-content:center;
            border:2px solid rgba(255,255,255,.3);
        }
        .login-body { padding:2rem; }
        .form-control {
            border-radius:10px; border:1.5px solid #ddd;
            padding:.6rem 1rem; transition:border-color .2s, box-shadow .2s;
        }
        .form-control:focus { border-color:var(--olive); box-shadow:0 0 0 3px rgba(74,124,89,.15); }
        .input-icon { position:relative; }
        .input-icon .bi { position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#aaa; }
        .input-icon .form-control { padding-left:38px; }
        .btn-login {
            width:100%; padding:.75rem; border-radius:10px; font-weight:700;
            background: linear-gradient(135deg, var(--maroon), #600000);
            border:none; color:#fff; font-size:1rem;
            letter-spacing:.5px; transition:opacity .2s, transform .1s;
        }
        .btn-login:hover { opacity:.9; transform:translateY(-1px); color:#fff; }
        .demo-hint { background:#f9f9f9; border-radius:10px; padding:1rem; font-size:.82rem; }
        .demo-hint code { background:#e9ecef; padding:2px 6px; border-radius:4px; }
    </style>
</head>
<body>
<div class="login-card">
    <div class="login-header">
        <div class="logo-ring"><i class="bi bi-mortarboard-fill" style="font-size:2rem"></i></div>
        <h4 class="fw-bold mb-1">Student ERP System</h4>
        <p style="opacity:.7;font-size:.88rem">Comprehensive Education Management Platform</p>
    </div>
    <div class="login-body">
        <?php if (isset($_SESSION['login_error'])): ?>
        <div class="alert alert-danger rounded-3 mb-3 py-2 small"><i class="bi bi-exclamation-triangle me-2"></i><?php echo $_SESSION['login_error']; unset($_SESSION['login_error']); ?></div>
        <?php endif; ?>
        <form action="<?php echo defined('BASE_URL') ? BASE_URL : ''; ?>/controller/AuthController.php?action=login" method="POST">
            <div class="mb-3">
                <label class="form-label fw-semibold small text-muted">Email Address</label>
                <div class="input-icon">
                    <i class="bi bi-envelope"></i>
                    <input type="email" name="email" class="form-control" placeholder="admin@college.edu" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold small text-muted">Password</label>
                <div class="input-icon">
                    <i class="bi bi-lock"></i>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
            </div>
            <button type="submit" class="btn btn-login mb-3"><i class="bi bi-box-arrow-in-right me-2"></i>Sign In</button>
            <div class="text-center small">
                Don't have an account? <a href="view/auth/register.php" class="text-olive fw-bold text-decoration-none">Register Now</a>
            </div>
        </form>

    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>