<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Employee Leave Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }

        .login-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .login-header {
            background: linear-gradient(90deg, #2563eb 0%, #1e40af 100%);
            color: white;
            padding: 2rem 1.5rem;
            text-align: center;
        }

        .login-header h2 {
            margin: 0;
            font-weight: 700;
            font-size: 1.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }

        .login-header p {
            margin-top: 0.5rem;
            opacity: 0.9;
            font-size: 0.95rem;
        }

        .login-body {
            padding: 2.5rem 2rem;
            background: white;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: #334155;
            margin-bottom: 0.75rem;
            display: block;
        }

        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-control::placeholder {
            color: #cbd5e1;
        }

        .btn-login {
            background: linear-gradient(90deg, #2563eb 0%, #1e40af 100%);
            border: none;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            padding: 0.85rem 1.5rem;
            font-size: 1rem;
            width: 100%;
            transition: all 0.3s ease;
            margin-top: 0.5rem;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(37, 99, 235, 0.4);
            color: white;
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .error-message {
            background: #fee2e2;
            color: #7f1d1d;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
        }

        .demo-credentials {
            background: #f0f9ff;
            border-left: 4px solid #0ea5e9;
            padding: 1.5rem;
            border-radius: 8px;
            margin-top: 2rem;
            font-size: 0.9rem;
        }

        .demo-credentials h5 {
            color: #0369a1;
            margin-bottom: 1rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .credential-item {
            margin-bottom: 0.75rem;
            padding: 0.75rem;
            background: white;
            border-radius: 6px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .credential-label {
            font-weight: 600;
            color: #334155;
        }

        .credential-value {
            font-family: 'Courier New', monospace;
            color: #2563eb;
            font-weight: 500;
        }

        .role-badge {
            display: inline-block;
            font-size: 0.75rem;
            padding: 0.25rem 0.75rem;
            background: #dbeafe;
            color: #0369a1;
            border-radius: 20px;
            font-weight: 600;
            margin-left: 0.5rem;
        }

        .footer-text {
            text-align: center;
            color: #64748b;
            font-size: 0.85rem;
            margin-top: 2rem;
        }

        .footer-text a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
        }

        .footer-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h2>
                    <i class="fas fa-calendar-check"></i> LMS
                </h2>
                <p>Employee Leave Management System</p>
            </div>

            <div class="login-body">
                @if ($errors->any())
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        <div>
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <form action="{{ route('auth.login') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" 
                               name="email" placeholder="Enter your email" value="{{ old('email') }}" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" 
                               name="password" placeholder="Enter your password" required>
                    </div>

                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>
                </form>

                <!-- Demo Credentials -->
                <div class="demo-credentials">
                    <h5>
                        <i class="fas fa-key"></i> Demo Credentials
                    </h5>

                    <div class="credential-item">
                        <span class="credential-label">
                            Admin
                            <span class="role-badge">Admin</span>
                        </span>
                        <span class="credential-value">admin@lms.com</span>
                    </div>

                    <div class="credential-item">
                        <span class="credential-label">Password (All)</span>
                        <span class="credential-value">password123</span>
                    </div>

                    <hr style="margin: 1rem 0; border: none; border-top: 1px solid #e2e8f0;">

                    <div class="credential-item">
                        <span class="credential-label">
                            Employee 1
                            <span class="role-badge">Employee</span>
                        </span>
                        <span class="credential-value">john@lms.com</span>
                    </div>

                    <div class="credential-item">
                        <span class="credential-label">
                            Employee 2
                            <span class="role-badge">Employee</span>
                        </span>
                        <span class="credential-value">jane@lms.com</span>
                    </div>

                    <div class="credential-item">
                        <span class="credential-label">
                            Employee 3
                            <span class="role-badge">Employee</span>
                        </span>
                        <span class="credential-value">mike@lms.com</span>
                    </div>
                </div>

                <div class="footer-text">
                    Leave Management System v1.0 | Built with Laravel & Bootstrap
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
