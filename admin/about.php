<?php
require_once '../config/database.php';
require_once 'check_auth.php';
$conn = getConnection();

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['content'] as $section_name => $content) {
        $content = $content ?? '';
        $image = '';
        
        // Handle image upload for hero section
        if ($section_name === 'hero_image' && isset($_FILES['hero_image_file'])) {
            if (isset($_FILES['hero_image_file']) && $_FILES['hero_image_file']['error'] === 0) {
                $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                $filename = $_FILES['hero_image_file']['name'];
                $filetype = pathinfo($filename, PATHINFO_EXTENSION);
                
                if (in_array(strtolower($filetype), $allowed)) {
                    $newname = uniqid() . '.' . $filetype;
                    $uploadpath = UPLOAD_DIR . $newname;
                    
                    if (move_uploaded_file($_FILES['hero_image_file']['tmp_name'], $uploadpath)) {
                        $image = $newname;
                    }
                }
            }
        }
        
        // Check if section exists
        $check = $conn->prepare("SELECT id FROM about_content WHERE section_name = ?");
        $check->bind_param("s", $section_name);
        $check->execute();
        $result = $check->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($image) {
                $stmt = $conn->prepare("UPDATE about_content SET content = ?, image = ? WHERE section_name = ?");
                $stmt->bind_param("sss", $content, $image, $section_name);
            } else {
                $stmt = $conn->prepare("UPDATE about_content SET content = ? WHERE section_name = ?");
                $stmt->bind_param("ss", $content, $section_name);
            }
        } else {
            if ($image) {
                $stmt = $conn->prepare("INSERT INTO about_content (section_name, content, image) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $section_name, $content, $image);
            } else {
                $stmt = $conn->prepare("INSERT INTO about_content (section_name, content) VALUES (?, ?)");
                $stmt->bind_param("ss", $section_name, $content);
            }
        }
        
        if ($stmt->execute()) {
            $message = "About section updated successfully!";
        } else {
            $error = "Error updating content: " . $conn->error;
        }
        $stmt->close();
        $check->close();
    }
}

// Get all about content
$aboutContent = [];
$result = $conn->query("SELECT * FROM about_content ORDER BY order_num ASC");
while ($row = $result->fetch_assoc()) {
    $aboutContent[$row['section_name']] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage About - Admin</title>
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
                <a href="about.php" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-admin-accent text-white mb-2">
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
                <h2 class="text-2xl font-bold text-white">Manage About Section</h2>
                <p class="text-admin-text-light text-sm mt-1">Update your about me content</p>
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

                <form method="POST" enctype="multipart/form-data" class="space-y-6">
                    <!-- Hero Section -->
                    <div class="bg-admin-card border border-admin-border rounded-xl p-6">
                        <h3 class="text-lg font-bold text-white mb-4">Hero Section</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-admin-text mb-2">Hero Title</label>
                                <input type="text" name="content[hero_title]" value="<?php echo htmlspecialchars($aboutContent['hero_title']['content'] ?? ''); ?>" class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-2 text-white focus:outline-none focus:border-admin-accent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-admin-text mb-2">Hero Subtitle</label>
                                <input type="text" name="content[hero_subtitle]" value="<?php echo htmlspecialchars($aboutContent['hero_subtitle']['content'] ?? ''); ?>" class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-2 text-white focus:outline-none focus:border-admin-accent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-admin-text mb-2">Hero Description</label>
                                <textarea name="content[hero_description]" rows="4" class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-2 text-white focus:outline-none focus:border-admin-accent"><?php echo htmlspecialchars($aboutContent['hero_description']['content'] ?? ''); ?></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-admin-text mb-2">Hero Background Image</label>
                                <?php if (isset($aboutContent['hero_image']) && $aboutContent['hero_image']['image']): ?>
                                <div class="mb-3">
                                    <img src="<?php echo strpos($aboutContent['hero_image']['image'], 'http') === 0 ? $aboutContent['hero_image']['image'] : '../uploads/' . $aboutContent['hero_image']['image']; ?>" alt="Hero image" class="w-48 h-32 rounded-lg object-cover border border-admin-border">
                                </div>
                                <?php endif; ?>
                                <input type="file" name="hero_image_file" accept="image/*" class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-2 text-white focus:outline-none focus:border-admin-accent">
                                <input type="hidden" name="content[hero_image]" value="<?php echo htmlspecialchars($aboutContent['hero_image']['content'] ?? ''); ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Education & Certifications -->
                    <div class="bg-admin-card border border-admin-border rounded-xl p-6">
                        <h3 class="text-lg font-bold text-white mb-4">Education & Certifications</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-admin-text mb-2">Education</label>
                                <input type="text" name="content[education]" value="<?php echo htmlspecialchars($aboutContent['education']['content'] ?? ''); ?>" class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-2 text-white focus:outline-none focus:border-admin-accent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-admin-text mb-2">Certification 1</label>
                                <input type="text" name="content[certification_1]" value="<?php echo htmlspecialchars($aboutContent['certification_1']['content'] ?? ''); ?>" class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-2 text-white focus:outline-none focus:border-admin-accent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-admin-text mb-2">Certification 2</label>
                                <input type="text" name="content[certification_2]" value="<?php echo htmlspecialchars($aboutContent['certification_2']['content'] ?? ''); ?>" class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-2 text-white focus:outline-none focus:border-admin-accent">
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