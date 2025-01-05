<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GugukAware Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen">
    <!-- Background Image Container -->
    <div class="min-h-screen bg-cover bg-center flex items-center justify-center p-4" 
         style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://images.unsplash.com/photo-1548199973-03cce0bbc87b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2069&q=80')">
        
        <!-- Login Form Container -->
        <div class="flex flex-col">
        <div class="text-center mb-8 text-lg">
            <p class="text-xl text-white">Pengalaman menjadi bagian dari</p>
            <h1 class="text-5xl font-bold text-white mb-2">GugukAware</h1>
        </div>
        <div class="bg-white/90 backdrop-blur-sm p-8 rounded-lg shadow-xl w-full max-w-md">
            <!-- Login Form -->
            <form id="loginForm" class="space-y-6">
                <!-- Name Input -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" 
                           id="name" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           required>
                </div>
                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" 
                           id="password" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           required>
                </div>

                <!-- Terms Checkbox -->
                <div class="flex items-start">
                    <input type="checkbox" 
                           id="terms" 
                           class="mt-1 h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                           required>
                    <label for="terms" class="ml-2 block text-sm text-gray-600">
                        Saya telah setuju syarat dan ketentuan yang ada
                    </label>
                </div>

                <!-- Login Button -->
                <button type="submit" 
                        class="w-full bg-black text-white py-2 px-4 rounded-md hover:bg-gray-800 transition duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">
                    Register
                </button>
            </form>
        </div>
    </div>
        </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const name = document.getElementById('name').value;
            const password = document.getElementById('password').value;
            const terms = document.getElementById('terms').checked;

            if (!terms) {
                alert('Please agree to the terms and conditions');
                return;
            }

            // Here you would typically send the data to your server
            console.log('Login attempt:', { name, password, terms });
            
            // For demo purposes, show success message
            alert('Login successful!');
        });
    </script>
</body>
</html>