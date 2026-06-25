<?php
require_once '../config/database.php';
require_once 'check_auth.php';
$conn = getConnection();

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update contact info
    if (isset($_POST['contact_info'])) {
        foreach ($_POST['contact_info'] as $info_type => $data) {
            $label = $data['label'] ?? '';
            $value = $data['value'] ?? '';
            $icon_class = $data['icon_class'] ?? '';
            
            // Check if exists
            $check = $conn->prepare("SELECT id FROM contact_info WHERE info_type = ?");
            $check->bind_param("s", $info_type);
            $check->execute();
            $result = $check->get_result();
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $stmt = $conn->prepare("UPDATE contact_info SET label = ?, value = ?, icon_class = ? WHERE info_type = ?");
                $stmt->bind_param("ssss", $label, $value, $icon_class, $info_type);
            } else {
                $stmt = $conn->prepare("INSERT INTO contact_info (info_type, label, value, icon_class) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $info_type, $label, $value, $icon_class);
            }
            
            if ($stmt->execute()) {
                $message = "Contact info updated successfully!";
            } else {
                $error = "Error updating contact info: " . $conn->error;
            }
            $stmt->close();
            $check->close();
        }
    }
    
    // Update social media
    if (isset($_POST['social_media'])) {
        foreach ($_POST['social_media'] as $platform => $data) {
            $url = $data['url'] ?? '';
            
            // Check if exists
            $check = $conn->prepare("SELECT id FROM social_media WHERE platform = ?");
            $check->bind_param("s", $platform);
            $check->execute();
            $result = $check->get_result();
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $stmt = $conn->prepare("UPDATE social_media SET url = ? WHERE platform = ?");
                $stmt->bind_param("ss", $url, $platform);
            } else {
                $stmt = $conn->prepare("INSERT INTO social_media (platform, url) VALUES (?, ?)");
                $stmt->bind_param("ss", $platform, $url);
            }
            
            if ($stmt->execute()) {
                $message = "Social media updated successfully!";
            } else {
                $error = "Error updating social media: " . $conn->error;
            }
            $stmt->close();
            $check->close();
        }
    }
}

// Get contact info
$contactInfo = [];
$result = $conn->query("SELECT * FROM contact_info ORDER BY order_num ASC");
while ($row = $result->fetch_assoc()) {
    $contactInfo[$row['info_type']] = $row;
}

// Get social media
$socialMedia = [];
$result = $conn->query("SELECT * FROM social_media ORDER BY order_num ASC");
while ($row = $result->fetch_assoc()) {
    $socialMedia[$row['platform']] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Contact - Admin</title>
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
                <a href="index.php" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-admin-card text-admin-text transition-colors mb-2">
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
                <a href="contact.php" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-admin-accent text-white mb-2">
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
                <h2 class="text-2xl font-bold text-white">Manage Contact Information</h2>
                <p class="text-admin-text-light text-sm mt-1">Update your contact details and social media links</p>
            </header>

            <div class="p-8">
                <?php if ($message): ?>
                <div class="mb-6 p-4 bg-green-500/10 border border-green-500 text-green-400 rounded-lg">
                    <?php echo htmlspecialchars($message); ?>
                </div>
                <?php endif; ?>

                <?php if ($error): ?>
                <div class="mb-6 p-4 bg-red-500/10 border border-red-500 text-red-400 rounded-lg">
                    <?php echo htmlspecialchars($error); ?>
                </div>
                <?php endif; ?>

                <form method="POST" class="space-y-6">
                    <!-- Contact Info -->
                    <div class="bg-admin-card border border-admin-border rounded-xl p-6">
                        <h3 class="text-lg font-bold text-white mb-4">Contact Information</h3>
                        
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-admin-text mb-2">Email Label</label>
                                    <input type="text" name="contact_info[email][label]" value="<?php echo htmlspecialchars($contactInfo['email']['label'] ?? 'Email'); ?>" class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-2 text-white focus:outline-none focus:border-admin-accent">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-admin-text mb-2">Email Address</label>
                                    <input type="email" name="contact_info[email][value]" value="<?php echo htmlspecialchars($contactInfo['email']['value'] ?? ''); ?>" class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-2 text-white focus:outline-none focus:border-admin-accent">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-admin-text mb-2">Phone Label</label>
                                    <input type="text" name="contact_info[phone][label]" value="<?php echo htmlspecialchars($contactInfo['phone']['label'] ?? 'Phone'); ?>" class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-2 text-white focus:outline-none focus:border-admin-accent">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-admin-text mb-2">Phone Number</label>
                                    <input type="text" name="contact_info[phone][value]" value="<?php echo htmlspecialchars($contactInfo['phone']['value'] ?? ''); ?>" class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-2 text-white focus:outline-none focus:border-admin-accent">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-admin-text mb-2">Location Label</label>
                                    <input type="text" name="contact_info[location][label]" value="<?php echo htmlspecialchars($contactInfo['location']['label'] ?? 'Location'); ?>" class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-2 text-white focus:outline-none focus:border-admin-accent">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-admin-text mb-2">Location</label>
                                    <input type="text" name="contact_info[location][value]" value="<?php echo htmlspecialchars($contactInfo['location']['value'] ?? ''); ?>" class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-2 text-white focus:outline-none focus:border-admin-accent">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="bg-admin-card border border-admin-border rounded-xl p-6">
                        <h3 class="text-lg font-bold text-white mb-4">Social Media Links</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-admin-text mb-2">GitHub URL</label>
                                <input type="url" name="social_media[github][url]" value="<?php echo htmlspecialchars($socialMedia['github']['url'] ?? ''); ?>" class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-2 text-white focus:outline-none focus:border-admin-accent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-admin-text mb-2">LinkedIn URL</label>
                                <input type="url" name="social_media[linkedin][url]" value="<?php echo htmlspecialchars($socialMedia['linkedin']['url'] ?? ''); ?>" class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-2 text-white focus:outline-none focus:border-admin-accent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-admin-text mb-2">Twitter URL</label>
                                <input type="url" name="social_media[twitter][url]" value="<?php echo htmlspecialchars($socialMedia['twitter']['url'] ?? ''); ?>" class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-2 text-white focus:outline-none focus:border-admin-accent">
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="px-6 py-2 bg-admin-accent hover:bg-admin-accent-hover text-white rounded-lg transition-colors">
                            Save Changes
                        </button>
                        <a href="index.php" class="px-6 py-2 bg-admin-card border border-admin-border hover:border-admin-accent text-admin-text rounded-lg transition-colors">
                            Cancel
                        </a>
                    </div>
                </form>
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