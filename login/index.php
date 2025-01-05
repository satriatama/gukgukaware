<?php
session_start();

// Cek jika user sudah login
// if (isset($_SESSION['user_id'])) {
//     header("Location: dashboard.php");
//     exit();
// }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GugukAware - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen">
    <main class="flex min-h-screen">
        <!-- Left side - Image -->
        <div class="hidden lg:block lg:w-1/2 relative">
            <img 
                src="./anjing.jpg" 
                alt="Dog protection awareness" 
                class="object-cover h-full w-full"
            />
            <!-- make left side of images gradient transparent -->
            <div class="absolute inset-y-0 right-0 w-1/4 bg-gradient-to-l from-white to-transparent"></div>
        </div>

        <!-- Right side - Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white">
            <div class="w-full max-w-md space-y-8">
                <div class="text-center">
                    <h1 class="text-4xl font-bold mb-2">GugukAware</h1>
                    <p class="text-gray-600 text-sm">
                        Sistem untuk memonitoring penjualan warung makan daging anjing ilegal di Kota Surakarta
                    </p>
                </div>

                <div class="mt-8">
                    <h2 class="text-2xl font-semibold mb-6">Masuk</h2>
                    
                    <?php if (isset($error)): ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline"><?php echo htmlspecialchars($error); ?></span>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="login_action.php" class="space-y-6">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                email
                            </label>
                            <input 
                                type="text" 
                                id="email" 
                                name="email" 
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400"
                                placeholder="your email"
                            >
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                Sandi
                            </label>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400"
                                placeholder="your password"
                            >
                        </div>

                        <?php
                            // Cek apakah ada pesan error di session
                            if (isset($_SESSION['error'])) {
                                echo "<div class='error text-red-500'>" . $_SESSION['error'] . "</div>";
                                unset($_SESSION['error']); // Hapus pesan setelah ditampilkan
                            }
                        ?>

                        <div class="space-y-4">
                            <button 
                                type="submit"
                                class="w-full bg-gray-900 text-white py-2 px-4 rounded-md hover:bg-gray-800 transition duration-200"
                            >
                                Sign In
                            </button>
                            
                            <div class="text-center">
                                <span class="text-sm text-gray-600">Belum punya akun? </span>
                                <a href="registration.php" class="text-sm text-gray-900 hover:underline">Daftar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
</html>