<?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings | Naujan Scholarship</title>
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #2e7d32;
            --primary-dark: #1b5e20;
            --primary-light: #e8f5e9;
            --secondary-color: #f5f5f5;
            --text-main: #1f2937;
            --text-muted: #6b7280;
            --white: #ffffff;
            --border-color: #e5e7eb;
            --success-color: #10b981;
            --error-color: #ef4444;
            --sidebar-width: 260px;
            --header-height: 70px;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --radius: 0.75rem;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--white);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            z-index: 50;
            transition: transform 0.3s ease;
        }

        .sidebar-brand {
            height: var(--header-height);
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .sidebar-brand h2 {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .sidebar-nav {
            padding: 1.5rem 1rem;
            flex: 1;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: var(--text-muted);
            text-decoration: none;
            border-radius: var(--radius);
            margin-bottom: 0.5rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .nav-item:hover, .nav-item.active {
            background-color: var(--primary-light);
            color: var(--primary-color);
        }

        .nav-item i {
            width: 24px;
            margin-right: 12px;
        }

        .sidebar-footer {
            padding: 1.5rem;
            border-top: 1px solid var(--border-color);
        }

        .user-mini-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .avatar {
            width: 40px;
            height: 40px;
            background-color: var(--primary-light);
            color: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .user-info h4 {
            font-size: 0.9rem;
            font-weight: 600;
        }

        .user-info span {
            font-size: 0.75rem;
            color: var(--text-muted);
            display: block;
        }

        /* Main Content Styles */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        header {
            height: var(--header-height);
            background-color: var(--white);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            position: sticky;
            top: 0;
            z-index: 40;
        }

        .header-title h1 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-main);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .btn-logout {
            padding: 0.5rem 1rem;
            border: 1px solid var(--border-color);
            background: white;
            color: var(--text-main);
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-logout:hover {
            background-color: #fee2e2;
            border-color: #fecaca;
            color: #ef4444;
        }

        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--text-main);
            cursor: pointer;
        }

        /* Dashboard Content */
        .dashboard-container {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
        }

        .welcome-section {
            margin-bottom: 2rem;
        }

        .welcome-section h2 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .welcome-section p {
            color: var(--text-muted);
        }

        /* Settings Cards */
        .settings-grid {
            display: grid;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .settings-card {
            background: var(--white);
            border-radius: var(--radius);
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
        }

        .settings-card-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .settings-card-header i {
            font-size: 1.5rem;
            color: var(--primary-color);
        }

        .settings-card-header h3 {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-main);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 0.5rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.875rem;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.1);
        }

        .help-text {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-top: 0.5rem;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background-color: var(--primary-color);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            transition: background 0.2s;
            border: none;
            cursor: pointer;
            font-size: 0.875rem;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
        }

        .btn-group {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        /* Alerts */
        .alert-container {
            margin-bottom: 2rem;
        }

        .alert {
            padding: 1rem 1.25rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            animation: slideDown 0.4s ease-out;
        }

        .alert-success {
            background-color: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert-error {
            background-color: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .close-alert {
            background: none;
            border: none;
            cursor: pointer;
            color: inherit;
            opacity: 0.6;
            font-size: 1.1rem;
        }

        /* Animations */
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive */
        @media (max-width: 1024px) {
            :root {
                --sidebar-width: 0px;
            }

            .sidebar {
                transform: translateX(-100%);
                width: 260px;
            }

            .sidebar.active {
                transform: translateX(0);
                width: 260px;
                box-shadow: 0 0 50px rgba(0,0,0,0.5);
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-menu-toggle {
                display: block;
            }

            .overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                background: rgba(0,0,0,0.4);
                z-index: 45;
            }
            
            .overlay.active {
                display: block;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 1.5rem 1rem;
            }

            .page-title {
                font-size: 24px;
            }

            .form-group {
                margin-bottom: 1.25rem;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 1.25rem;
            }

            .btn-group {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .main-content {
                padding: 1rem 0.75rem;
            }

            .page-title {
                font-size: 20px;
            }

            .card {
                padding: 1.25rem;
            }
        }
    </style>
</head>
<body>

    <!-- Mobile Overlay -->
    <div class="overlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <h2><i class="fas fa-graduation-cap"></i> Naujan<span style="font-weight:300">Educational Assistance</span></h2>
        </div>
        
        <nav class="sidebar-nav">
            <a href="/applicant/dashboard" class="nav-item">
                <i class="fas fa-th-large"></i> Dashboard
            </a>
            <a href="<?= BASE_URL ?? '' ?>/apply/form" class="nav-item">
                <i class="fas fa-file-signature"></i> Apply Now
            </a>
            <a href="/applicant/my-applications" class="nav-item">
                <i class="fas fa-folder-open"></i> My Applications
            </a>
            <a href="/applicant/profile" class="nav-item">
                <i class="fas fa-user-circle"></i> Profile
            </a>
            <a href="/applicant/settings" class="nav-item active">
                <i class="fas fa-cog"></i> Settings
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="user-mini-profile">
                <div class="avatar">
                    <?php 
                        $fullname = $_SESSION['user']['fullname'] ?? 'Guest User';
                        $initial = strtoupper(substr($fullname, 0, 1));
                        echo $initial;
                    ?>
                </div>
                <div class="user-info">
                    <h4><?= htmlspecialchars($fullname) ?></h4>
                    <span>Applicant</span>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <header>
            <div class="header-title">
                <button class="mobile-menu-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 style="display:inline-block; margin-left: 10px;">Settings</h1>
            </div>
            
            <div class="header-actions">
                <a href="/logout" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </header>

        <div class="dashboard-container">
            
            <!-- Welcome Section -->
            <div class="welcome-section">
                <h2>Account Settings</h2>
                <p>Manage your account preferences and security settings.</p>
            </div>

            <!-- Alerts -->
            <div class="alert-container">
                <?php if (!empty($_SESSION['success_message'])): ?>
                    <div class="alert alert-success" id="alert-success">
                        <span><i class="fas fa-check-circle" style="margin-right:8px"></i> <?= htmlspecialchars($_SESSION['success_message']); ?></span>
                        <button class="close-alert" onclick="this.parentElement.remove()">×</button>
                    </div>
                    <?php unset($_SESSION['success_message']); ?>
                <?php endif; ?>

                <?php if (!empty($_SESSION['error_message'])): ?>
                    <div class="alert alert-error" id="alert-error">
                        <span><i class="fas fa-exclamation-circle" style="margin-right:8px"></i> <?= htmlspecialchars($_SESSION['error_message']); ?></span>
                        <button class="close-alert" onclick="this.parentElement.remove()">×</button>
                    </div>
                    <?php unset($_SESSION['error_message']); ?>
                <?php endif; ?>
            </div>

            <!-- Settings Cards -->
            <div class="settings-grid">
                
                <!-- Account Information -->
                <div class="settings-card">
                    <div class="settings-card-header">
                        <i class="fas fa-user"></i>
                        <h3>Account Information</h3>
                    </div>
                    <form method="POST" action="/applicant/settings/update-account">
                        <div class="form-group">
                            <label for="fullname">Full Name</label>
                            <input 
                                type="text" 
                                id="fullname" 
                                name="fullname" 
                                class="form-control" 
                                value="<?= htmlspecialchars($_SESSION['user']['fullname'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                required
                            >
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                class="form-control" 
                                value="<?= htmlspecialchars($_SESSION['user']['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                required
                            >
                        </div>
                        <div class="btn-group">
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-save"></i>
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Change Password -->
                <div class="settings-card">
                    <div class="settings-card-header">
                        <i class="fas fa-lock"></i>
                        <h3>Change Password</h3>
                    </div>
                    <form method="POST" action="/applicant/settings/change-password">
                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <input 
                                type="password" 
                                id="current_password" 
                                name="current_password" 
                                class="form-control" 
                                required
                            >
                        </div>
                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <input 
                                type="password" 
                                id="new_password" 
                                name="new_password" 
                                class="form-control" 
                                required
                                minlength="6"
                            >
                            <span class="help-text">Password must be at least 6 characters long</span>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirm New Password</label>
                            <input 
                                type="password" 
                                id="confirm_password" 
                                name="confirm_password" 
                                class="form-control" 
                                required
                            >
                        </div>
                        <div class="btn-group">
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-key"></i>
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </main>

    <script>
        // Sidebar Toggle for Mobile
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('active');
            document.querySelector('.overlay').classList.toggle('active');
        }

        // Auto-dismiss alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', () => {
            const alerts = document.querySelectorAll('.alert');
            if (alerts.length > 0) {
                setTimeout(() => {
                    alerts.forEach(alert => {
                        alert.style.opacity = '0';
                        alert.style.transform = 'translateY(-10px)';
                        alert.style.transition = 'all 0.5s ease';
                        setTimeout(() => alert.remove(), 500);
                    });
                }, 5000);
            }
        });
    </script>
</body>
</html>

