<!-- resources/views/auth/verify-email.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email Address</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-header {
            background-color: #007bff;
            color: white;
        }
        .btn-link {
            color: #007bff;
        }
        .btn-link:hover {
            text-decoration: underline;
        }
        .btn-back {
            background-color: #28a745;
            color: white;
        }
        .btn-back:hover {
            background-color: #218838;
        }
    </style>
</head>
<body class="bg-light">
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-md-6">
        <div class="card shadow-lg">
            <div class="card-header text-center">
                <h4>Verify Your Email Address</h4>
            </div>
            <div class="card-body">
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        A fresh verification link has been sent to your email address.
                    </div>
                @endif

                @if (session('message'))
                    <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                    </div>
                @endif

                <p class="mb-4">
                    Before proceeding, please check your email for a verification link.
                </p>

                <p class="mb-0">
                    If you did not receive the email,
                <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn btn-link p-0 m-0 align-baseline">
                        click here to request another
                    </button>.
                </form>
                </p>

                <div class="mt-4 text-center">
                    <a href="{{ url('dashboard') }}" class="btn btn-back">Go to Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
