<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Login</title>
        <style>
            :root {
                --primary-color: #3490dc;
                --error-color: #e3342f;
                --text-color: #333;
                --light-gray: #f8f9fa;
                --border-color: #ddd;
            }

            * {
                box-sizing: border-box;
                margin: 0;
                padding: 0;
            }

            body {
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI",
                    Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
                background-color: var(--light-gray);
                color: var(--text-color);
                line-height: 1.6;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                padding: 20px;
            }

            .auth-container {
                width: 100%;
                max-width: 450px;
                background: white;
                border-radius: 8px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                overflow: hidden;
            }

            .auth-header {
                background-color: var(--primary-color);
                color: white;
                padding: 20px;
                text-align: center;
            }

            .auth-header h2 {
                font-size: 1.5rem;
            }

            .auth-body {
                padding: 25px;
            }

            .form-group {
                margin-bottom: 20px;
            }

            .form-label {
                display: block;
                margin-bottom: 8px;
                font-weight: 500;
            }

            .form-control {
                width: 100%;
                padding: 12px;
                font-size: 1rem;
                border: 1px solid var(--border-color);
                border-radius: 4px;
                transition: border-color 0.3s ease;
            }

            .form-control:focus {
                border-color: var(--primary-color);
                outline: none;
            }

            .is-invalid {
                border-color: var(--error-color);
            }

            .invalid-feedback {
                color: var(--error-color);
                font-size: 0.875rem;
                margin-top: 5px;
            }

            .alert {
                padding: 12px;
                margin-bottom: 20px;
                border-radius: 4px;
            }

            .alert-danger {
                background-color: #f8d7da;
                color: #721c24;
                border: 1px solid #f5c6cb;
            }

            .btn {
                display: inline-block;
                padding: 12px 20px;
                font-size: 1rem;
                font-weight: 500;
                text-align: center;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            .btn-block {
                display: block;
                width: 100%;
            }

            .btn-primary {
                background-color: var(--primary-color);
                color: white;
            }

            .btn-primary:hover {
                background-color: #2779bd;
            }

            .text-center {
                text-align: center;
            }

            .mt-3 {
                margin-top: 15px;
            }

            .form-check {
                display: flex;
                align-items: center;
                margin-bottom: 20px;
            }

            .form-check-input {
                margin-right: 10px;
            }

            .auth-footer {
                margin-top: 20px;
                padding-top: 20px;
                border-top: 1px solid var(--border-color);
            }

            .auth-link {
                color: var(--primary-color);
                text-decoration: none;
            }

            .auth-link:hover {
                text-decoration: underline;
            }
        </style>
    </head>
    <body>
        <div class="auth-container">
            <div class="auth-header">
                <h2>Login</h2>
            </div>

            <div class="auth-body">
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul style="list-style: none; padding-left: 0">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email" class="form-label"
                            >Email Address</label
                        >
                        <input
                            id="email"
                            type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                            autofocus
                        />
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label"
                            >Password</label
                        >
                        <input
                            id="password"
                            type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            name="password"
                            required
                            autocomplete="current-password"
                        />
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox"
                        name="remember" id="remember"
                        {{ old("remember") ? "checked" : "" }}>
                        <label
                            class="form-label"
                            for="remember"
                            style="margin-bottom: 0"
                            >Remember Me</label
                        >
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">
                            Login
                        </button>
                    </div>

                    <div class="auth-footer text-center">
                        <a href="{{ route('register') }}" class="auth-link"
                            >Don't have an account? Register</a
                        >
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
