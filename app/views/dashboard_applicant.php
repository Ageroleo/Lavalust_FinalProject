<?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Dashboard | Naujan Scholarship</title>
    
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

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .card {
            background: var(--white);
            border-radius: var(--radius);
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }

        .card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-4px);
            border-color: var(--primary-light);
        }

        .card-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: var(--primary-light);
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-main);
        }

        .card-desc {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }

        .btn-card-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            background-color: var(--primary-color);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            transition: background 0.2s;
            margin-top: auto;
        }

        .btn-card-action:hover {
            background-color: var(--primary-dark);
        }

        .btn-card-action.secondary {
            background-color: white;
            border: 1px solid var(--border-color);
            color: var(--text-main);
        }

        .btn-card-action.secondary:hover {
            background-color: var(--secondary-color);
            border-color: #d1d5db;
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

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .action-cards {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .main-content {
                padding: 1rem 0.75rem;
            }

            .page-title {
                font-size: 20px;
            }

            .stats-card {
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
            <a href="#" class="nav-item active">
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
            <a href="/applicant/settings" class="nav-item">
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
                <h1 style="display:inline-block; margin-left: 10px;">Dashboard</h1>
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
                <h2>Welcome back, <?= htmlspecialchars(explode(' ', $fullname)[0]) ?>!</h2>
                <p>Track your scholarship applications and manage your profile from here.</p>
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

            <!-- Action Cards -->
            <div class="stats-grid">
                
                <!-- Card 1: Apply -->
                <div class="card">
                    <div>
                        <div class="card-icon">
                            <i class="fas fa-file-import"></i>
                        </div>
                        <h3 class="card-title">New Application</h3>
                        <p class="card-desc">Start a new scholarship application for the upcoming academic year. Submit requirements online.</p>
                    </div>
                    <a href="<?= BASE_URL ?? '' ?>/apply/form" class="btn-card-action">
                        Apply Now <i class="fas fa-arrow-right" style="margin-left: 8px;"></i>
                    </a>
                </div>

                <!-- Card 2: Status -->
                <div class="card">
                    <div>
                        <div class="card-icon" style="background-color: #fff7ed; color: #ea580c;">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <h3 class="card-title">Track Status</h3>
                        <p class="card-desc">View the status of your submitted applications. Check for updates or required actions.</p>
                    </div>
                    <a href="/applicant/my-applications" class="btn-card-action secondary">
                        View Applications
                    </a>
                </div>

                <!-- Card 3: Profile -->
                <div class="card">
                    <div>
                        <div class="card-icon" style="background-color: #eff6ff; color: #2563eb;">
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <h3 class="card-title">My Profile</h3>
                        <p class="card-desc">Keep your personal information, contact details, and academic records up to date.</p>
                    </div>
                    <a href="/applicant/profile" class="btn-card-action secondary">
                        Update Profile
                    </a>
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
