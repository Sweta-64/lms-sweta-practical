<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Employee Leave Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #2563eb;
            --secondary: #64748b;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #0ea5e9;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(90deg, var(--primary) 0%, #1e40af 100%);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .navbar-brand i {
            font-size: 1.8rem;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .nav-link:hover {
            color: white !important;
            transform: translateY(-2px);
        }

        /* Main container */
        .main-container {
            padding: 40px 0;
        }

        /* Card styling */
        .card {
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            background: linear-gradient(90deg, var(--primary) 0%, #1e40af 100%);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            font-weight: 600;
            font-size: 1.1rem;
        }

        /* Buttons */
        .btn-primary {
            background: var(--primary);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            padding: 0.7rem 1.5rem;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #1e40af;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .btn-success {
            background: var(--success);
            border: none;
            border-radius: 8px;
        }

        .btn-danger {
            background: var(--danger);
            border: none;
            border-radius: 8px;
        }

        .btn-warning {
            background: var(--warning);
            border: none;
            border-radius: 8px;
            color: white;
        }

        /* Badge styling */
        .badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .badge-pending {
            background: var(--warning);
            color: white;
        }

        .badge-approved {
            background: var(--success);
            color: white;
        }

        .badge-rejected {
            background: var(--danger);
            color: white;
        }

        /* Form styling */
        .form-control, .form-select {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-label {
            font-weight: 600;
            color: #334155;
            margin-bottom: 0.5rem;
        }

        /* Table styling */
        .table {
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }

        .table thead {
            background: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
        }

        .table thead th {
            font-weight: 700;
            color: #334155;
            padding: 1rem;
        }

        .table tbody td {
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .table tbody tr:hover {
            background: #f8fafc;
        }

        /* Alert styling */
        .alert {
            border: none;
            border-radius: 8px;
            font-weight: 500;
            padding: 1rem 1.5rem;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
        }

        .alert-danger {
            background: #fee2e2;
            color: #7f1d1d;
        }

        .alert-warning {
            background: #fef3c7;
            color: #78350f;
        }

        /* Footer */
        .footer {
            background: linear-gradient(90deg, var(--primary) 0%, #1e40af 100%);
            color: white;
            padding: 2rem 0;
            margin-top: 4rem;
            text-align: center;
        }

        /* Helper classes */
        .text-muted-2 {
            color: var(--secondary);
            font-weight: 500;
        }

        .section-title {
            color: var(--primary);
            font-weight: 700;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
        }

        .leave-card {
            border-left: 5px solid var(--primary);
            padding: 1.5rem;
            margin-bottom: 1rem;
        }

        .leave-card.pending {
            border-left-color: var(--warning);
            background: rgba(245, 158, 11, 0.05);
        }

        .leave-card.approved {
            border-left-color: var(--success);
            background: rgba(16, 185, 129, 0.05);
        }

        .leave-card.rejected {
            border-left-color: var(--danger);
            background: rgba(239, 68, 68, 0.05);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .main-container {
                padding: 20px 0;
            }

            .section-title {
                font-size: 1.2rem;
            }

            .btn-primary {
                padding: 0.6rem 1.2rem;
                font-size: 0.9rem;
            }
        }
    </style>
    @yield('extra-css')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-calendar-check"></i>
                LMS
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('leaves.index') }}">
                                <i class="fas fa-list"></i> My Leaves
                            </a>
                        </li>
                        @if(auth()->user()->isEmployee())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('leaves.create') }}">
                                    <i class="fas fa-plus"></i> Apply for Leave
                                </a>
                            </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle"></i> {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#">Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-container">
        <div class="container">
            <!-- Display Alerts -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><i class="fas fa-exclamation-circle"></i> Error!</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2026 Employee Leave Management System | All Rights Reserved</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('extra-js')
</body>
</html>
