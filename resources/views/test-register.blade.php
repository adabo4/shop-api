<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="UTF-8">
    <title>Vitalis Auth Test</title>
</head>

<body>
    <h1>Test registrácie</h1>

    <button onclick="register()">Registrovať</button>
    <button onclick="login()">Login</button>
    <button onclick="me()">Me</button>

    <pre id="result"></pre>

    <script>
        async function register() {
            const result = document.getElementById('result');

            try {
                await fetch('/sanctum/csrf-cookie', {
                    credentials: 'same-origin'
                });

                const xsrfCookie = document.cookie
                    .split('; ')
                    .find(cookie => cookie.startsWith('XSRF-TOKEN='));

                const xsrfToken = xsrfCookie ?
                    decodeURIComponent(xsrfCookie.split('=')[1]) :
                    '';

                const response = await fetch('/api/auth/register', {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-XSRF-TOKEN': xsrfToken
                    },
                    body: JSON.stringify({
                        first_name: 'Test',
                        last_name: 'Vitalis',
                        email: 'test@example.sk',
                        phone: '0901234567',
                        password: 'MojeHeslo123',
                        password_confirmation: 'MojeHeslo123'
                    })
                });

                const data = await response.json();

                result.textContent = JSON.stringify({
                    status: response.status,
                    data
                }, null, 2);
            } catch (error) {
                result.textContent = error.message;
            }
        }

        async function login() {
            const result = document.getElementById('result');

            try {
                await fetch('/sanctum/csrf-cookie', {
                    credentials: 'same-origin'
                });

                const xsrfCookie = document.cookie
                    .split('; ')
                    .find(cookie => cookie.startsWith('XSRF-TOKEN='));

                const xsrfToken = xsrfCookie ?
                    decodeURIComponent(xsrfCookie.split('=')[1]) :
                    '';

                const response = await fetch('/api/auth/login', {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-XSRF-TOKEN': xsrfToken
                    },
                    body: JSON.stringify({
                        "email": "test@example.sk",
                        "password": "MojeHeslo123"
                    })
                });

                const data = await response.json();

                result.textContent = JSON.stringify({
                    status: response.status,
                    data
                }, null, 2);
            } catch (error) {
                result.textContent = error.message;
            }
        }


        async function me() {
            const result = document.getElementById('result');

            try {
                const response = await fetch('/api/auth/me', {
                    method: 'GET',
                    credentials: 'same-origin',
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                result.textContent = JSON.stringify({
                    status: response.status,
                    data
                }, null, 2);

            } catch (error) {
                result.textContent = error.message;
            }
        }
    </script>
</body>

</html>