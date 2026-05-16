<?php
// view/layout/header.php
if (session_status() == PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . '/view/auth/login.php');
    exit;
}
$current_page = $current_page ?? (isset($_GET['page']) ? $_GET['page'] : 'dashboard');
$B = BASE_URL;

// Helper: is the current page in a group?
function inGroup(array $pages, string $current): bool {
    return in_array($current, $pages);
}

$monitoring_pages  = ['academic-monitoring','student-information','student-add','student-edit','student-view',
                       'attendance-tracking','attendance-add','academic-performance','course-management',
                       'examination-management','exam-add','fee-financial','fee-add',
                       'communication','library-management','library-add','parent-portal','analytics'];
$institutes_pages  = ['institutes','institute-add','institute-edit','institute-types','institute-type-add',
                       'departments','department-add','department-edit','branches','branch-add','branch-edit'];
$programs_pages    = ['academic-programs','program-add','program-edit','batch-management','batch-add',
                       'batch-edit','subjects','subject-add','subject-edit','class-scheduling'];
$faculty_pages     = ['faculty','staff-add','staff-edit','staff-view','staff-categories','staff-designations','staff-allocations'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OliveFlow - <?php echo ucwords(str_replace('-', ' ', $current_page)); ?></title>
    <link rel="icon" href="assets/images/favicon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?php echo $B; ?>/assets/css/custom.css?v=<?php echo time(); ?>">
</head>
<body>

<!-- ── TOP NAVBAR ── -->
<nav class="topbar">
    <!-- Sidebar toggle (Mobile Only) -->
    <button id="sidebar-toggle-mobile" class="d-md-none" title="Toggle Sidebar" style="background:none;border:none;color:#fff;font-size:1.35rem;cursor:pointer;padding:4px 8px;border-radius:6px;transition:all 0.3s ease;">
        <i class="bi bi-list"></i>
    </button>

    <!-- Brand -->
    <a class="topbar-brand" href="<?php echo $B; ?>/index.php?page=dashboard">
        <div>
            <img src="<?php echo $B; ?>/assets/images/favicon.png" alt="OliveFlow Logo" style="width:24px; margin-right:4px;">
            <span class="d-none d-sm-inline">OliveFlow</span>
        </div>
    </a>

    <!-- Top Nav Links with Hover Dropdowns -->
    <ul class="top-nav d-none d-lg-flex">

        <!-- Dashboard -->
        <li class="<?php echo $current_page === 'dashboard' ? 'active' : ''; ?>">
            <a href="<?php echo $B; ?>/index.php?page=dashboard">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>

        <?php 
        $role = $_SESSION['user_role'] ?? 'faculty';
        ?>

        <!-- Academic Monitoring -->
        <li class="<?php echo inGroup($monitoring_pages, $current_page) ? 'active' : ''; ?>">
            <a href="<?php echo $B; ?>/index.php?page=student-information">
                <i class="bi bi-clipboard-data"></i> Academic <i class="bi bi-chevron-down ms-1" style="font-size:.65rem"></i>
            </a>
            <ul class="drop-menu">
                <li><a href="<?php echo $B; ?>/index.php?page=student-information"><i class="bi bi-person-lines-fill"></i> Student Information</a></li>
                <li><a href="<?php echo $B; ?>/index.php?page=attendance-tracking"><i class="bi bi-calendar-check"></i> Attendance Tracking</a></li>
                <li><a href="<?php echo $B; ?>/index.php?page=academic-performance"><i class="bi bi-bar-chart-line"></i> Academic Performance</a></li>
                <li><a href="<?php echo $B; ?>/index.php?page=course-management"><i class="bi bi-book"></i> Course Management</a></li>
                <li><a href="<?php echo $B; ?>/index.php?page=examination-management"><i class="bi bi-pencil-square"></i> Examinations</a></li>
                <li><a href="<?php echo $B; ?>/index.php?page=fee-financial"><i class="bi bi-cash-stack"></i> Fee & Financial</a></li>
                <li><a href="<?php echo $B; ?>/index.php?page=communication"><i class="bi bi-chat-dots"></i> Communication</a></li>
                <li><a href="<?php echo $B; ?>/index.php?page=library-management"><i class="bi bi-journal-bookmark"></i> Library</a></li>
                <li><a href="<?php echo $B; ?>/index.php?page=parent-portal"><i class="bi bi-people"></i> Parent Portal</a></li>
                <li><a href="<?php echo $B; ?>/index.php?page=analytics"><i class="bi bi-graph-up-arrow"></i> Analytics</a></li>
            </ul>
        </li>

        <?php if ($role === 'admin'): ?>
        <!-- Institutes -->
        <li class="<?php echo inGroup($institutes_pages, $current_page) ? 'active' : ''; ?>">
            <a href="<?php echo $B; ?>/index.php?page=institutes">
                <i class="bi bi-building"></i> Institutes <i class="bi bi-chevron-down ms-1" style="font-size:.65rem"></i>
            </a>
            <ul class="drop-menu">
                <li><a href="<?php echo $B; ?>/index.php?page=institutes"><i class="bi bi-building"></i> Manage Institutes</a></li>
                <li><a href="<?php echo $B; ?>/index.php?page=institute-types"><i class="bi bi-tags"></i> Institute Types</a></li>
                <li><a href="<?php echo $B; ?>/index.php?page=departments"><i class="bi bi-diagram-3"></i> Departments</a></li>
                <li><a href="<?php echo $B; ?>/index.php?page=branches"><i class="bi bi-sign-merge-left"></i> Branches</a></li>
            </ul>
        </li>
        <?php endif; ?>

        <?php if ($role === 'admin' || $role === 'faculty'): ?>
        <!-- Academic Programs -->
        <li class="<?php echo inGroup($programs_pages, $current_page) ? 'active' : ''; ?>">
            <a href="<?php echo $B; ?>/index.php?page=academic-programs">
                <i class="bi bi-book-half"></i> Programs <i class="bi bi-chevron-down ms-1" style="font-size:.65rem"></i>
            </a>
            <ul class="drop-menu">
                <li><a href="<?php echo $B; ?>/index.php?page=academic-programs"><i class="bi bi-mortarboard"></i> Programs & Courses</a></li>
                <li><a href="<?php echo $B; ?>/index.php?page=batch-management"><i class="bi bi-grid-3x3-gap"></i> Batch Management</a></li>
                <li><a href="<?php echo $B; ?>/index.php?page=subjects"><i class="bi bi-journal-text"></i> Subjects</a></li>
                <li><a href="<?php echo $B; ?>/index.php?page=class-scheduling"><i class="bi bi-calendar-week"></i> Class Scheduling</a></li>
            </ul>
        </li>
        <?php endif; ?>

        <?php if ($role === 'admin'): ?>
        <!-- Faculty -->
        <li class="<?php echo inGroup($faculty_pages, $current_page) ? 'active' : ''; ?>">
            <a href="<?php echo $B; ?>/index.php?page=faculty">
                <i class="bi bi-person-badge"></i> Faculty <i class="bi bi-chevron-down ms-1" style="font-size:.65rem"></i>
            </a>
            <ul class="drop-menu">
                <li><a href="<?php echo $B; ?>/index.php?page=faculty"><i class="bi bi-person-badge"></i> All Staff</a></li>
                <li><a href="<?php echo $B; ?>/index.php?page=staff-categories"><i class="bi bi-tag"></i> Categories</a></li>
                <li><a href="<?php echo $B; ?>/index.php?page=staff-designations"><i class="bi bi-award"></i> Designations</a></li>
                <li><a href="<?php echo $B; ?>/index.php?page=staff-allocations"><i class="bi bi-shuffle"></i> Allocations</a></li>
            </ul>
        </li>
        <?php endif; ?>

    </ul>

    <!-- Right side -->
    <div class="topbar-right">
        <!-- User dropdown -->
        <div class="dropdown">
            <a class="topbar-user dropdown-toggle" href="#" data-bs-toggle="dropdown" id="userMenu">
                <i class="bi bi-person-circle" style="font-size:1.3rem;"></i>
                <span class="d-none d-md-inline"><?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Admin'); ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="border-radius:12px;min-width:190px;">
                <li><a class="dropdown-item" href="<?php echo $B; ?>/index.php?page=profile"><i class="bi bi-person me-2 text-muted"></i>My Profile</a></li>
                <li><a class="dropdown-item" href="<?php echo $B; ?>/index.php?page=settings"><i class="bi bi-gear me-2 text-muted"></i>Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="<?php echo $B; ?>/controller/AuthController.php?action=logout"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- ── LAYOUT WRAPPER ── -->
<div class="layout-wrapper">
<?php
if (isset($_SESSION['flash'])) {
    echo '<div class="flash-msg alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> ' . htmlspecialchars($_SESSION['flash']) . '
          </div>';
    unset($_SESSION['flash']);
}
if (isset($_SESSION['flash_error'])) {
    echo '<div class="flash-msg alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> ' . htmlspecialchars($_SESSION['flash_error']) . '
          </div>';
    unset($_SESSION['flash_error']);
}
?>