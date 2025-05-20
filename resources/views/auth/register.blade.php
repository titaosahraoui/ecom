<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Register</title>
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
                max-width: 600px;
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

            .row {
                display: flex;
                flex-wrap: wrap;
                margin: 0 -10px;
            }

            .col {
                flex: 1;
                padding: 0 10px;
                min-width: 0;
            }

            @media (max-width: 600px) {
                .row {
                    flex-direction: column;
                }
                .col {
                    padding: 0;
                    margin-bottom: 15px;
                }
            }
        </style>
    </head>
    <body>
        <div class="auth-container">
            <div class="auth-header">
                <h2>Register</h2>
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

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="prenom" class="form-label"
                                    >First Name</label
                                >
                                <input
                                    id="prenom"
                                    type="text"
                                    class="form-control"
                                    name="prenom"
                                    value="{{ old('prenom') }}"
                                    required
                                    autofocus
                                />
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="nom" class="form-label"
                                    >Last Name</label
                                >
                                <input
                                    id="nom"
                                    type="text"
                                    class="form-control"
                                    name="nom"
                                    value="{{ old('nom') }}"
                                    required
                                />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label"
                            >Email Address</label
                        >
                        <input
                            id="email"
                            type="email"
                            class="form-control"
                            name="email"
                            value="{{ old('email') }}"
                            required
                        />
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label"
                            >Password</label
                        >
                        <input
                            id="password"
                            type="password"
                            class="form-control"
                            name="password"
                            required
                        />
                    </div>

                    <div class="form-group">
                        <label for="password-confirm" class="form-label"
                            >Confirm Password</label
                        >
                        <input
                            id="password-confirm"
                            type="password"
                            class="form-control"
                            name="password_confirmation"
                            required
                        />
                    </div>

                    <div class="form-group">
                        <label for="phone" class="form-label"
                            >Phone Number</label
                        >
                        <input
                            id="phone"
                            type="tel"
                            class="form-control"
                            name="phone"
                            value="{{ old('phone') }}"
                        />
                    </div>

                    <div class="form-group">
                        <label for="address" class="form-label">Address</label>
                        <input
                            id="address"
                            type="text"
                            class="form-control"
                            name="address"
                            value="{{ old('address') }}"
                        />
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="city" class="form-label"
                                    >City</label
                                >
                                <input
                                    id="city"
                                    type="text"
                                    class="form-control"
                                    name="city"
                                    value="{{ old('city') }}"
                                />
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="postal_code" class="form-label"
                                    >Postal Code</label
                                >
                                <input
                                    id="postal_code"
                                    type="text"
                                    class="form-control"
                                    name="postal_code"
                                    value="{{ old('postal_code') }}"
                                />
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="country" class="form-label"
                                    >Country</label
                                >
                                <input
                                    id="country"
                                    type="text"
                                    class="form-control"
                                    name="country"
                                    value="{{ old('country') }}"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">
                            Register
                        </button>
                    </div>

                    <div class="auth-footer text-center">
                        <a href="{{ route('login') }}" class="auth-link"
                            >Already have an account? Login</a
                        >
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
