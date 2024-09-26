@extends('admin.dashboard.master-admin')
@section('content')
    <body style="background: #2b2b2b">
{{--    <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">--}}
        <div class="container">
            <form method="POST" action="{{ route('admin.login') }}" class="bg-white p-8 rounded shadow-lg w-full max-w-md">
                @csrf

                <!-- Email Address -->
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">{{ __('Email address') }}</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    @error('email')
                    <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">{{ __('Password') }}</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="password" required autocomplete="current-password">
                    @error('password')
                    <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                    @enderror
                </div>


                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">
                    {{ __('log in') }}
                </button>
            </form>
        </div>
    </div>

    </body>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: whitesmoke;
            margin: 0;
        }

        .container {
            width: 100%;
            max-width: 400px;
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
@endsection
