<?php
session_start();

require_once '../config/database.php';
$conn = getConnection();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (!empty($username) && !empty($password)) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            if (password_verify($password, $user['password'])) {
                // Update last login
                $stmt = $conn->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
                $stmt->bind_param("i", $user['id']);
                $stmt->execute();
                $stmt->close();
                
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['logged_in'] = true;
                $_SESSION['login_time'] = time();
                
                // Redirect to dashboard
                header('Location: index.php');
                exit;
            } else {
                $error = 'Invalid password';
            }
        } else {
            $error = 'Username not found';
        }
        $stmt->close();
    } else {
        $error = 'Please fill in all fields';
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Portfolio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'admin-bg': '#1e1e1e',
                        'admin-sidebar': '#252526',
                        'admin-card': '#2d2d30',
                        'admin-border': '#3e3e42',
                        'admin-text': '#cccccc',
                        'admin-text-light': '#858585',
                        'admin-accent': '#007acc',
                        'admin-accent-hover': '#005a9e',
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif']
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-admin-bg text-admin-text font-sans min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo/Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-admin-accent rounded-2xl mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-white mb-2">Admin Login</h1>
            <p class="text-admin-text-light text-sm">Portfolio Management System</p>
        </div>

        <!-- Login Form -->
        <div class="bg-admin-card border border-admin-border rounded-2xl p-8">
            <?php if ($error): ?>
            <div class="mb-6 p-4 bg-red-500/10 border border-red-500 text-red-400 rounded-lg">
                <?php echo htmlspecialchars($error); ?>
            </div>
            <?php endif; ?>

            <form method="POST" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-admin-text mb-2">Username</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-admin-text-light">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </span>
                        <input 
                            type="text" 
                            name="username" 
                            required
                            autofocus
                            class="w-full bg-admin-bg border border-admin-border rounded-lg pl-12 pr-4 py-3 text-white focus:outline-none focus:border-admin-accent focus:ring-1 focus:ring-admin-accent"
                            placeholder="Enter username"
                        >
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-admin-text mb-2">Password</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-admin-text-light">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </span>
                        <input 
                            type="password" 
                            name="password" 
                            required
                            class="w-full bg-admin-bg border border-admin-border rounded-lg pl-12 pr-4 py-3 text-white focus:outline-none focus:border-admin-accent focus:ring-1 focus:ring-admin-accent"
                            placeholder="Enter password"
                        >
                    </div>
                </div>

                <button 
                    type="submit" 
                    class="w-full bg-admin-accent hover:bg-admin-accent-hover text-white rounded-lg py-3 font-medium transition-colors flex items-center justify-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    Sign In
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-admin-border">
                <p class="text-xs text-admin-text-light text-center">
                    Default credentials:<br>
                    <span class="text-admin-text">Username:</span> admin | 
                    <span class="text-admin-text">Password:</span> admin123
                </p>
            </div>
        </div>

        <!-- Back to Website -->
        <div class="text-center mt-6">
            <a href="../index.php" class="text-admin-text-light hover:text-admin-text text-sm transition-colors">
                ← Back to Website
            </a>
        </div>
    </div>
</body>
</html>