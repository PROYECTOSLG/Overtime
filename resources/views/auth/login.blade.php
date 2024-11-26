<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Quicksand:700&display=swap">
    <style>
        .floating-error {
            animation: fadeOutUp 5s forwards;
            position: fixed;
            top: 20px;
            left: 40%;
            z-index: 50; /* Aseguramos que esté por encima de otros elementos */
        }

        .floating-success {
            animation: fadeOutUp 5s forwards;
            position: fixed;
            top: 20px;
            left: 40%;
            z-index: 50; /* Aseguramos que esté por encima de otros elementos */
        }

        @keyframes fadeOutUp {
            0% {
                opacity: 1;
                transform: translateY(0);
            }
            90% {
                opacity: 1;
            }
            100% {
                opacity: 0;
                transform: translateY(-20px);
            }
        }
    </style>
    <script>
        function showLoading() {
            document.getElementById('login-button').style.display = 'none';
            document.getElementById('loading-image').style.display = 'inline';
        }

        function showChangePassword() {
            document.getElementById('login-form').style.display = 'none';
            document.getElementById('change-password-form').style.display = 'block';
        }

        function showLoginForm() {
            document.getElementById('change-password-form').style.display = 'none';
            document.getElementById('login-form').style.display = 'block';
        }

        function showPasswordChangeError(message) {
            var errorDiv = document.getElementById('password-change-error');
            errorDiv.innerText = message;
            errorDiv.style.display = 'block';
            setTimeout(function() {
                errorDiv.style.display = 'none';
            }, 5000);
        }

        function showPasswordChangeSuccess(message) {
            var successDiv = document.getElementById('password-change-success');
            successDiv.innerText = message;
            successDiv.style.display = 'block';
            setTimeout(function() {
                successDiv.style.display = 'none';
            }, 5000);
        }

        function handlePasswordChange(event) {
            event.preventDefault();
            var email = document.getElementById('email-change').value;
            var currentPassword = document.getElementById('current_password').value;
            var newPassword = document.getElementById('new_password').value;

            fetch('{{ route('change.password') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    email: email,
                    current_password: currentPassword,
                    new_password: newPassword
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    showPasswordChangeError(data.error);
                } else {
                    showPasswordChangeSuccess('Contraseña actualizada correctamente.');
                    setTimeout(() => {
                        location.reload();
                    }, 5000);
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    @if ($errors->has('loginError'))
        <div class="left-0 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-md flex items-center floating-error" role="alert">
            <img src="{{ asset('images/warning.png') }}" alt="Warning" class="w-6 h-6 mr-2">
            {{ $errors->first('loginError') }}
        </div>
    @endif

    <div id="password-change-error" class="left-0 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-md flex items-center floating-error" style="display: none;" role="alert">
        <img src="{{ asset('images/warning.png') }}" alt="Warning" class="w-6 h-6 mr-2">
        Error al cambiar la contraseña.
    </div>

    <div id="password-change-success" class="left-0 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-md flex items-center floating-success" style="display: none;" role="alert">
        <img src="{{ asset('images/check.png') }}" alt="Check" class="w-6 h-6 mr-2">
        Contraseña actualizada correctamente.
    </div>

    <div class="bg-white p-8 rounded-lg shadow-lg w-96">
        <form id="login-form" action="{{ route('login') }}" method="POST" onsubmit="showLoading()">
            @csrf
            <div class="flex flex-col items-center mb-6">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-48 mb-4">
                <h2 class="text-2xl font-bold custom-font text-gray-700">Overtime</h2>
            </div>
            <div class="mb-4 flex items-center">
                <img src="{{ asset('images/user.png') }}" alt="User" class="w-6 mr-3">
                <input type="email" name="email" id="email" required placeholder="Email" value="{{ old('email') }}" class="flex-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-6 flex items-center">
                <img src="{{ asset('images/password.png') }}" alt="Password" class="w-6 mr-3">
                <input type="password" name="password" id="password" required placeholder="Password" class="flex-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex justify-center mb-4">
                <button id="login-button" type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Login</button>
                <img id="loading-image" src="{{ asset('images/loading.gif') }}" alt="Loading" style="display: none;" class="w-6 h-6">
            </div>
            <div class="text-center">
                <a href="javascript:void(0)" onclick="showChangePassword()" class="text-blue-500 hover:underline">Cambiar Contraseña</a>
            </div>
        </form>

        <form id="change-password-form" onsubmit="handlePasswordChange(event)" method="POST" style="display: none;">
            @csrf
            <div class="flex flex-col items-center mb-6">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-48 mb-4">
                <h2 class="text-2xl font-bold custom-font text-gray-700">CONTROL IP</h2>
            </div>
            <div class="mb-4 flex items-center">
                <img src="{{ asset('images/user.png') }}" alt="User" class="w-6 mr-3">
                <input type="email" name="email" id="email-change" required placeholder="Email" class="flex-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4 flex items-center">
                <img src="{{ asset('images/password.png') }}" alt="Password" class="w-6 mr-3">
                <input type="password" name="current_password" id="current_password" required placeholder="Contraseña Actual" class="flex-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-6 flex items-center">
                <img src="{{ asset('images/password.png') }}" alt="Password" class="w-6 mr-3">
                <input type="password" name="new_password" id="new_password" required placeholder="Nueva Contraseña" class="flex-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex justify-center mb-4">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">Cambiar Contraseña</button>
            </div>
            <div class="text-center">
                <a href="javascript:void(0)" onclick="showLoginForm()" class="text-blue-500 hover:underline">Volver al Login</a>
            </div>
        </form>
    </div>
</body>
</html>
