<?php
// view/layout/sidebar.php
$current_page = $current_page ?? 'dashboard';
$B = BASE_URL;

$monitoring_pages  = ['academic-monitoring','student-information','student-add','student-edit','student-view',
                       'attendance-tracking','attendance-add','academic-performance','course-management',
                       'examination-management','exam-add','fee-financial','fee-add',
                       'communication','library-management','library-add','parent-portal','analytics'];
$institutes_pages  = ['institutes','institute-add','institute-edit','institute-types','institute-type-add',
                       'departments','department-add','department-edit','branches','branch-add','branch-edit'];
$programs_pages    = ['academic-programs','program-add','program-edit','batch-management','batch-add',
                       'batch-edit','subjects','subject-add','subject-edit','class-scheduling'];
$faculty_pages     = ['faculty','staff-add','staff-edit','staff-view','staff-categories','staff-designations','staff-allocations'];

function isActive(string $pg, string $current): string {
    return $pg === $current ? 'active' : '';
}
function inPageGroup(array $pages, string $current): bool {
    return in_array($current, $pages);
}
?>
<!-- ── SIDEBAR ── -->
<nav id="sidebar">
    <div class="sidebar-inner">

        <div class="d-none d-md-flex align-items-center mb-2" style="padding: 0 15px;">
            <button id="sidebar-toggle-btn" title="Toggle Sidebar">
                <i class="bi bi-layout-sidebar-inset"></i>
            </button>
        </div>

        <div class="sidebar-nav-scroll">
            <!-- Dashboard -->
            <ul class="sidebar-nav mt-2">
                <li class="<?php echo isActive('dashboard', $current_page); ?>">
                    <a href="<?php echo $B; ?>/index.php?page=dashboard">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
            </ul>

            <?php 
            $role = $_SESSION['user_role'] ?? 'faculty';
            ?>
            <!-- Academic Monitoring Group -->
            <div class="sidebar-section">Academic</div>
                <ul class="sidebar-nav">
                    <li class="<?php echo isActive('student-information', $current_page); ?>"><a href="<?php echo $B; ?>/index.php?page=student-information"><i class="bi bi-person-lines-fill"></i> Students (SIM)</a></li>
                    <li class="<?php echo isActive('attendance-tracking', $current_page); ?>"><a href="<?php echo $B; ?>/index.php?page=attendance-tracking"><i class="bi bi-calendar-check"></i> Attendance</a></li>
                    <li class="<?php echo isActive('academic-performance', $current_page); ?>"><a href="<?php echo $B; ?>/index.php?page=academic-performance"><i class="bi bi-bar-chart-line"></i> Performance</a></li>
                    <li class="<?php echo isActive('course-management', $current_page); ?>"><a href="<?php echo $B; ?>/index.php?page=course-management"><i class="bi bi-book"></i> Courses</a></li>
                    <li class="<?php echo isActive('examination-management', $current_page); ?>"><a href="<?php echo $B; ?>/index.php?page=examination-management"><i class="bi bi-pencil-square"></i> Examinations</a></li>
                    <li class="<?php echo isActive('fee-financial', $current_page); ?>"><a href="<?php echo $B; ?>/index.php?page=fee-financial"><i class="bi bi-cash-stack"></i> Fee & Financial</a></li>
                    <li class="<?php echo isActive('communication', $current_page); ?>"><a href="<?php echo $B; ?>/index.php?page=communication"><i class="bi bi-chat-dots"></i> Communication</a></li>
                    <li class="<?php echo isActive('library-management', $current_page); ?>"><a href="<?php echo $B; ?>/index.php?page=library-management"><i class="bi bi-journal-bookmark"></i> Library</a></li>
                    <li class="<?php echo isActive('parent-portal', $current_page); ?>"><a href="<?php echo $B; ?>/index.php?page=parent-portal"><i class="bi bi-people"></i> Parent Portal</a></li>
                    <li class="<?php echo isActive('analytics', $current_page); ?>"><a href="<?php echo $B; ?>/index.php?page=analytics"><i class="bi bi-graph-up-arrow"></i> Analytics</a></li>
                </ul>

            <?php if ($role === 'admin'): ?>
                <div class="sidebar-section">Institution</div>
                <ul class="sidebar-nav">
                    <li class="<?php echo isActive('institutes', $current_page); ?>"><a href="<?php echo $B; ?>/index.php?page=institutes"><i class="bi bi-building"></i> Institutes</a></li>
                    <li class="<?php echo isActive('institute-types', $current_page); ?>"><a href="<?php echo $B; ?>/index.php?page=institute-types"><i class="bi bi-tags"></i> Institute Types</a></li>
                    <li class="<?php echo isActive('departments', $current_page); ?>"><a href="<?php echo $B; ?>/index.php?page=departments"><i class="bi bi-diagram-3"></i> Departments</a></li>
                    <li class="<?php echo isActive('branches', $current_page); ?>"><a href="<?php echo $B; ?>/index.php?page=branches"><i class="bi bi-sign-merge-left"></i> Branches</a></li>
                </ul>
            <?php endif; ?>

            <?php if ($role === 'admin' || $role === 'faculty'): ?>
                <div class="sidebar-section">Programs</div>
                <ul class="sidebar-nav">
                    <li class="<?php echo isActive('academic-programs', $current_page); ?>"><a href="<?php echo $B; ?>/index.php?page=academic-programs"><i class="bi bi-mortarboard"></i> Programs</a></li>
                    <li class="<?php echo isActive('batch-management', $current_page); ?>"><a href="<?php echo $B; ?>/index.php?page=batch-management"><i class="bi bi-grid-3x3-gap"></i> Batches</a></li>
                    <li class="<?php echo isActive('subjects', $current_page); ?>"><a href="<?php echo $B; ?>/index.php?page=subjects"><i class="bi bi-journal-text"></i> Subjects</a></li>
                    <li class="<?php echo isActive('class-scheduling', $current_page); ?>"><a href="<?php echo $B; ?>/index.php?page=class-scheduling"><i class="bi bi-calendar-week"></i> Scheduling</a></li>
                </ul>
            <?php endif; ?>

            <?php if ($role === 'admin'): ?>
                <div class="sidebar-section">Staff</div>
                <ul class="sidebar-nav">
                    <li class="<?php echo isActive('faculty', $current_page); ?>"><a href="<?php echo $B; ?>/index.php?page=faculty"><i class="bi bi-person-badge"></i> All Staff</a></li>
                    <li class="<?php echo isActive('staff-categories', $current_page); ?>"><a href="<?php echo $B; ?>/index.php?page=staff-categories"><i class="bi bi-tag"></i> Categories</a></li>
                    <li class="<?php echo isActive('staff-designations', $current_page); ?>"><a href="<?php echo $B; ?>/index.php?page=staff-designations"><i class="bi bi-award"></i> Designations</a></li>
                    <li class="<?php echo isActive('staff-allocations', $current_page); ?>"><a href="<?php echo $B; ?>/index.php?page=staff-allocations"><i class="bi bi-shuffle"></i> Allocations</a></li>
                </ul>
            <?php endif; ?>
        </div>

        <!-- System group (Sticky Bottom) -->
        <div class="sidebar-bottom-group">
            <div class="sidebar-section">System</div>
            <ul class="sidebar-nav">
                <li class="<?php echo isActive('profile', $current_page); ?>"><a href="<?php echo $B; ?>/index.php?page=profile"><i class="bi bi-person-circle"></i> My Profile</a></li>
                <?php if ($role === 'admin'): ?>
                <li class="<?php echo isActive('logs', $current_page); ?>"><a href="<?php echo $B; ?>/index.php?page=logs"><i class="bi bi-shield-lock"></i> Audit Logs</a></li>
                <li class="<?php echo isActive('settings', $current_page); ?>"><a href="<?php echo $B; ?>/index.php?page=settings"><i class="bi bi-gear"></i> Settings</a></li>
                <?php endif; ?>
                <li><a href="<?php echo $B; ?>/controller/AuthController.php?action=logout"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
            </ul>
        </div>

    </div>
</nav>