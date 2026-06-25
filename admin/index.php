<?php
require_once '../config/database.php';
require_once 'check_auth.php';
$conn = getConnection();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Portfolio</title>
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
<body class="bg-admin-bg text-admin-text font-sans">
    <div class="flex h-screen">
        <!-- Mobile Menu Button -->
        <button id="mobile-menu-btn" class="lg:hidden fixed top-4 left-4 z-50 p-2 bg-admin-accent text-white rounded-lg shadow-lg">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 bg-admin-sidebar border-r border-admin-border flex flex-col fixed lg:static inset-y-0 left-0 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 z-40">
            <div class="p-6 border-b border-admin-border">
                <h1 class="text-xl font-bold text-white">Admin Panel</h1>
                <p class="text-xs text-admin-text-light mt-1">Portfolio Management</p>
            </div>
            
            <nav class="flex-1 p-4">
                <a href="index.php" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-admin-accent text-white mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>
                <a href="projects.php" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-admin-card text-admin-text transition-colors mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                    </svg>
                    Projects
                </a>
                <a href="about.php" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-admin-card text-admin-text transition-colors mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    About Me
                </a>
                <a href="skills.php" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-admin-card text-admin-text transition-colors mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                    Skills
                </a>
                <a href="contact.php" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-admin-card text-admin-text transition-colors mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Contact Info
                </a>
                <a href="change_password.php" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-admin-card text-admin-text transition-colors mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                    Change Password
                </a>
            </nav>
            
            <div class="p-4 border-t border-admin-border">
                <a href="../index.php" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-admin-card text-admin-text transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    View Website
                </a>
                <a href="logout.php" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-red-500/10 text-red-400 transition-colors mt-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Logout
                </a>
            </div>
        </aside>

        <!-- Overlay for mobile -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-30 hidden lg:hidden"></div>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto w-full">
            <header class="bg-admin-sidebar border-b border-admin-border px-8 py-6">
                <h2 class="text-2xl font-bold text-white">Dashboard</h2>
                <p class="text-admin-text-light text-sm mt-1">Welcome to your portfolio admin panel</p>
            </header>

            <div class="p-8">
                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-admin-card border border-admin-border rounded-xl p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-blue-500/10 rounded-lg">
                                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                </svg>
                            </div>
                        </div>
                        <?php
                        $projectCount = $conn->query("SELECT COUNT(*) as count FROM projects")->fetch_assoc();
                        ?>
                        <h3 class="text-3xl font-bold text-white mb-1"><?php echo $projectCount['count']; ?></h3>
                        <p class="text-admin-text-light text-sm">Total Projects</p>
                    </div>

                    <div class="bg-admin-card border border-admin-border rounded-xl p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-green-500/10 rounded-lg">
                                <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <?php
                        $publishedCount = $conn->query("SELECT COUNT(*) as count FROM projects WHERE status = 'published'")->fetch_assoc();
                        ?>
                        <h3 class="text-3xl font-bold text-white mb-1"><?php echo $publishedCount['count']; ?></h3>
                        <p class="text-admin-text-light text-sm">Published Projects</p>
                    </div>

                    <div class="bg-admin-card border border-admin-border rounded-xl p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-purple-500/10 rounded-lg">
                                <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                            </div>
                        </div>
                        <?php
                        $skillCount = $conn->query("SELECT COUNT(*) as count FROM skills")->fetch_assoc();
                        ?>
                        <h3 class="text-3xl font-bold text-white mb-1"><?php echo $skillCount['count']; ?></h3>
                        <p class="text-admin-text-light text-sm">Total Skills</p>
                    </div>

                    <div class="bg-admin-card border border-admin-border rounded-xl p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-orange-500/10 rounded-lg">
                                <svg class="w-6 h-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                        </div>
                        <?php
                        $draftCount = $conn->query("SELECT COUNT(*) as count FROM projects WHERE status = 'draft'")->fetch_assoc();
                        ?>
                        <h3 class="text-3xl font-bold text-white mb-1"><?php echo $draftCount['count']; ?></h3>
                        <p class="text-admin-text-light text-sm">Draft Projects</p>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-admin-card border border-admin-border rounded-xl p-6">
                    <h3 class="text-lg font-bold text-white mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="projects.php?action=add" class="flex items-center gap-3 p-4 bg-admin-accent hover:bg-admin-accent-hover rounded-lg transition-colors">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span class="text-white font-medium">Add New Project</span>
                        </a>
                        <a href="about.php" class="flex items-center gap-3 p-4 bg-admin-card border border-admin-border hover:border-admin-accent rounded-lg transition-colors">
                            <svg class="w-5 h-5 text-admin-text" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            <span class="text-admin-text font-medium">Edit About Section</span>
                        </a>
                        <a href="skills.php" class="flex items-center gap-3 p-4 bg-admin-card border border-admin-border hover:border-admin-accent rounded-lg transition-colors">
                            <svg class="w-5 h-5 text-admin-text" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                            </svg>
                            <span class="text-admin-text font-medium">Manage Skills</span>
                        </a>
                    </div>
                </div>

                <!-- Recent Projects -->
                <div class="bg-admin-card border border-admin-border rounded-xl p-6 mt-6">
                    <h3 class="text-lg font-bold text-white mb-4">Recent Projects</h3>
                    <div class="space-y-3">
                        <?php
                        $recentProjects = $conn->query("SELECT * FROM projects ORDER BY created_at DESC LIMIT 5");
                        while ($project = $recentProjects->fetch_assoc()):
                        ?>
                        <div class="flex items-center justify-between p-4 bg-admin-bg rounded-lg border border-admin-border">
                            <div class="flex items-center gap-4">
                                <img src="<?php echo $project['image'] ? strpos($project['image'], 'http') === 0 ? $project['image'] : '../uploads/' . $project['image'] : 'https://via.placeholder.com/50'; ?>" alt="<?php echo htmlspecialchars($project['title']); ?>" class="w-12 h-12 rounded-lg object-cover">
                                <div>
                                    <h4 class="text-white font-medium"><?php echo htmlspecialchars($project['title']); ?></h4>
                                    <p class="text-admin-text-light text-sm"><?php echo htmlspecialchars($project['category']); ?></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="px-3 py-1 rounded-full text-xs font-medium <?php echo $project['status'] === 'published' ? 'bg-green-500/10 text-green-400' : 'bg-yellow-500/10 text-yellow-400'; ?>">
                                    <?php echo ucfirst($project['status']); ?>
                                </span>
                                <a href="projects.php?action=edit&id=<?php echo $project['id']; ?>" class="p-2 hover:bg-admin-border rounded-lg transition-colors">
                                    <svg class="w-4 h-4 text-admin-text" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
        }

        mobileMenuBtn.addEventListener('click', toggleSidebar);
        sidebarOverlay.addEventListener('click', toggleSidebar);

        // Close sidebar when clicking on a link (mobile)
        const sidebarLinks = sidebar.querySelectorAll('a');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 1024) {
                    toggleSidebar();
                }
            });
        });
    </script>
</body>
</html>

<?php $conn->close(); ?>