<?php
session_start();
if (!isset($_SESSION['reg_otp']) || !isset($_SESSION['pending_reg_data'])) {
    header('Location: register.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student ERP – Verify Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        :root { --olive:#4a7c59; --maroon:#800000; --charcoal:#4a3c31; }
        body {
            min-height:100vh;
            background: linear-gradient(135deg, #1a2a1a 0%, #2c4a2c 40%, #4a3c31 100%);
            display:flex; align-items:center; justify-content:center;
            font-family:'Inter',system-ui,sans-serif;
            padding: 20px 0;
        }
        .verify-card {
            background:rgba(255,255,255,.96);
            border-radius:20px;
            box-shadow:0 30px 80px rgba(0,0,0,.45);
            overflow:hidden; width:100%; max-width:450px;
        }
        .verify-header {
            background: linear-gradient(135deg, var(--olive), var(--olive-dark));
            padding:2rem; text-align:center; color:#fff;
        }
        .verify-body { padding:2rem; }
        .form-control {
            border-radius:10px; border:1.5px solid #ddd;
            padding:.6rem 1rem; text-align: center; font-size: 1.5rem; letter-spacing: 5px;
        }
        .btn-verify {
            width:100%; padding:.75rem; border-radius:10px; font-weight:700;
            background: var(--olive); border:none; color:#fff;
        }
    </style>
</head>
<body>
<div class="verify-card">
    <div class="verify-header">
        <h4 class="fw-bold mb-1">Verify Registration</h4>
        <p style="opacity:.7;font-size:.88rem;color:black">An OTP has been sent to the master email for approval.</p>
    </div>
    <div class="verify-body">
        <?php if (isset($_SESSION['otp_error'])): ?>
        <div class="alert alert-danger mb-3 py-2 small text-center"><?php echo $_SESSION['otp_error']; unset($_SESSION['otp_error']); ?></div>
        <?php endif; ?>
        
        <form action="../../controller/AuthController.php?action=verify_otp" method="POST">
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label small fw-bold text-center w-100">Enter 6-Digit OTP</label>
                    <input type="text" name="otp" class="form-control" placeholder="000000" maxlength="6" required>
                </div>
                
                <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-verify py-2">Verify & Complete Registration</button>
                    <div class="text-center mt-3 small">
                        <a href="../../controller/AuthController.php?action=cancel_registration" class="text-muted text-decoration-none">Cancel Registration</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>
