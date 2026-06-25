<?php
require_once '../config/database.php';
require_once 'check_auth.php';
$conn = getConnection();

$message = '';
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'add' || $_POST['action'] === 'edit') {
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $technologies = $_POST['technologies'] ?? '';
            $project_url = $_POST['project_url'] ?? '';
            $github_url = $_POST['github_url'] ?? '';
            $category = $_POST['category'] ?? '';
            $status = $_POST['status'] ?? 'draft';
            
            // Handle image upload
            $image = $_POST['existing_image'] ?? '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                $filename = $_FILES['image']['name'];
                $filetype = pathinfo($filename, PATHINFO_EXTENSION);
                
                if (in_array(strtolower($filetype), $allowed)) {
                    $newname = uniqid() . '.' . $filetype;
                    $uploadpath = UPLOAD_DIR . $newname;
                    
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadpath)) {
                        $image = $newname;
                    }
                }
            }
            
            if ($_POST['action'] === 'add') {
                $stmt = $conn->prepare("INSERT INTO projects (title, description, image, technologies, project_url, github_url, category, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssssss", $title, $description, $image, $technologies, $project_url, $github_url, $category, $status);
                
                if ($stmt->execute()) {
                    $message = "Project added successfully!";
                } else {
                    $error = "Error adding project: " . $conn->error;
                }
            } else {
                $id = $_POST['id'];
                $stmt = $conn->prepare("UPDATE projects SET title=?, description=?, image=?, technologies=?, project_url=?, github_url=?, category=?, status=? WHERE id=?");
                $stmt->bind_param("ssssssssi", $title, $description, $image, $technologies, $project_url, $github_url, $category, $status, $id);
                
                if ($stmt->execute()) {
                    $message = "Project updated successfully!";
                } else {
                    $error = "Error updating project: " . $conn->error;
                }
            }
            $stmt->close();
        }
    }
}

// Handle delete
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM projects WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $message = "Project deleted successfully!";
    } else {
        $error = "Error deleting project: " . $conn->error;
    }
    $stmt->close();
}

// Get project for editing
$editProject = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM projects WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $editProject = $result->fetch_assoc();
    $stmt->close();
}

// Get all projects
$projects = $conn->query("SELECT * FROM projects ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Projects - Admin</title>
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
                <a href="projects.php" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-admin-accent text-white mb-2">
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
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-white"><?php echo $editProject ? 'Edit Project' : 'Manage Projects'; ?></h2>
                        <p class="text-admin-text-light text-sm mt-1"><?php echo $editProject ? 'Update project information' : 'Add and manage your portfolio projects'; ?></p>
                    </div>
                    <?php if (!$editProject): ?>
                    <a href="projects.php?action=add" class="px-4 py-2 bg-admin-accent hover:bg-admin-accent-hover text-white rounded-lg transition-colors flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span class="hidden sm:inline">Add New Project</span>
                    </a>
                    <?php endif; ?>
                </div>
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

                <?php if ($editProject || isset($_GET['action']) && $_GET['action'] === 'add'): ?>
                <!-- Add/Edit Form -->
                <div class="bg-admin-card border border-admin-border rounded-xl p-6 mb-6">
                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="<?php echo $editProject ? 'edit' : 'add'; ?>">
                        <?php if ($editProject): ?>
                        <input type="hidden" name="id" value="<?php echo $editProject['id']; ?>">
                        <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($editProject['image']); ?>">
                        <?php endif; ?>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-admin-text mb-2">Project Title *</label>
                                <input type="text" name="title" required value="<?php echo $editProject ? htmlspecialchars($editProject['title']) : ''; ?>" class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-2 text-white focus:outline-none focus:border-admin-accent">
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-admin-text mb-2">Description</label>
                                <textarea name="description" rows="4" class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-2 text-white focus:outline-none focus:border-admin-accent"><?php echo $editProject ? htmlspecialchars($editProject['description']) : ''; ?></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-admin-text mb-2">Project Image</label>
                                <?php if ($editProject && $editProject['image']): ?>
                                <div class="mb-3">
                                    <img src="<?php echo strpos($editProject['image'], 'http') === 0 ? $editProject['image'] : '../uploads/' . $editProject['image']; ?>" alt="Current image" class="w-32 h-32 rounded-lg object-cover border border-admin-border">
                                </div>
                                <?php endif; ?>
                                <input type="file" name="image" accept="image/*" class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-2 text-white focus:outline-none focus:border-admin-accent">
                                <p class="text-xs text-admin-text-light mt-1">Leave empty to keep current image</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-admin-text mb-2">Technologies (comma separated)</label>
                                <input type="text" name="technologies" value="<?php echo $editProject ? htmlspecialchars($editProject['technologies']) : ''; ?>" placeholder="React, Node.js, MySQL" class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-2 text-white focus:outline-none focus:border-admin-accent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-admin-text mb-2">Project URL</label>
                                <input type="url" name="project_url" value="<?php echo $editProject ? htmlspecialchars($editProject['project_url']) : ''; ?>" class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-2 text-white focus:outline-none focus:border-admin-accent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-admin-text mb-2">GitHub URL</label>
                                <input type="url" name="github_url" value="<?php echo $editProject ? htmlspecialchars($editProject['github_url']) : ''; ?>" class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-2 text-white focus:outline-none focus:border-admin-accent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-admin-text mb-2">Category</label>
                                <input type="text" name="category" value="<?php echo $editProject ? htmlspecialchars($editProject['category']) : ''; ?>" class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-2 text-white focus:outline-none focus:border-admin-accent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-admin-text mb-2">Status</label>
                                <select name="status" class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-2 text-white focus:outline-none focus:border-admin-accent">
                                    <option value="draft" <?php echo $editProject && $editProject['status'] === 'draft' ? 'selected' : ''; ?>>Draft</option>
                                    <option value="published" <?php echo $editProject && $editProject['status'] === 'published' ? 'selected' : ''; ?>>Published</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex gap-3 mt-6">
                            <button type="submit" class="px-6 py-2 bg-admin-accent hover:bg-admin-accent-hover text-white rounded-lg transition-colors">
                                <?php echo $editProject ? 'Update Project' : 'Add Project'; ?>
                            </button>
                            <a href="projects.php" class="px-6 py-2 bg-admin-card border border-admin-border hover:border-admin-accent text-admin-text rounded-lg transition-colors">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
                <?php endif; ?>

                <!-- Projects List -->
                <div class="bg-admin-card border border-admin-border rounded-xl p-6">
                    <h3 class="text-lg font-bold text-white mb-4">All Projects</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-admin-border">
                                    <th class="text-left py-3 px-4 text-sm font-medium text-admin-text-light">Image</th>
                                    <th class="text-left py-3 px-4 text-sm font-medium text-admin-text-light">Title</th>
                                    <th class="text-left py-3 px-4 text-sm font-medium text-admin-text-light">Category</th>
                                    <th class="text-left py-3 px-4 text-sm font-medium text-admin-text-light">Status</th>
                                    <th class="text-left py-3 px-4 text-sm font-medium text-admin-text-light">Date</th>
                                    <th class="text-right py-3 px-4 text-sm font-medium text-admin-text-light">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($project = $projects->fetch_assoc()): ?>
                                <tr class="border-b border-admin-border hover:bg-admin-bg transition-colors">
                                    <td class="py-3 px-4">
                                        <img src="<?php echo $project['image'] ? strpos($project['image'], 'http') === 0 ? $project['image'] : '../uploads/' . $project['image'] : 'https://via.placeholder.com/50'; ?>" alt="<?php echo htmlspecialchars($project['title']); ?>" class="w-12 h-12 rounded-lg object-cover">
                                    </td>
                                    <td class="py-3 px-4">
                                        <div>
                                            <p class="text-white font-medium"><?php echo htmlspecialchars($project['title']); ?></p>
                                            <p class="text-admin-text-light text-xs mt-1"><?php echo htmlspecialchars($project['technologies']); ?></p>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-sm text-admin-text"><?php echo htmlspecialchars($project['category']); ?></td>
                                    <td class="py-3 px-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-medium <?php echo $project['status'] === 'published' ? 'bg-green-500/10 text-green-400' : 'bg-yellow-500/10 text-yellow-400'; ?>">
                                            <?php echo ucfirst($project['status']); ?>
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-sm text-admin-text-light"><?php echo date('M d, Y', strtotime($project['created_at'])); ?></td>
                                    <td class="py-3 px-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="projects.php?action=edit&id=<?php echo $project['id']; ?>" class="p-2 hover:bg-admin-border rounded-lg transition-colors">
                                                <svg class="w-4 h-4 text-admin-text" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                            <a href="projects.php?action=delete&id=<?php echo $project['id']; ?>" onclick="return confirm('Are you sure you want to delete this project?')" class="p-2 hover:bg-red-500/10 rounded-lg transition-colors">
                                                <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
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