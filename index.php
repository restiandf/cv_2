<?php
require_once 'config/database.php';
$conn = getConnection();

// Fetch projects
$projects = $conn->query("SELECT * FROM projects WHERE status = 'published' ORDER BY created_at DESC");

// Fetch about content
$aboutContent = [];
$result = $conn->query("SELECT * FROM about_content ORDER BY order_num ASC");
while ($row = $result->fetch_assoc()) {
    $aboutContent[$row['section_name']] = $row;
}

// Fetch skills grouped by category
$skills = [];
$result = $conn->query("SELECT * FROM skills ORDER BY category, order_num ASC");
while ($row = $result->fetch_assoc()) {
    $skills[$row['category']][] = $row;
}

// Fetch contact info
$contactInfo = [];
$result = $conn->query("SELECT * FROM contact_info ORDER BY order_num ASC");
while ($row = $result->fetch_assoc()) {
    $contactInfo[$row['info_type']] = $row;
}

// Fetch social media
$socialMedia = [];
$result = $conn->query("SELECT * FROM social_media ORDER BY order_num ASC");
while ($row = $result->fetch_assoc()) {
    $socialMedia[$row['platform']] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
 
<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0, viewport-fit=cover" name="viewport" />
  <title>Restian Dwi Friwaldi - Portfolio Dashboard</title>
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <!-- Google Fonts: Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            "kp-orange": "#FF5722",
            "kp-gray-bg": "#E8EBF3",
            "kp-card-bg": "#FFFFFF",
            "kp-text-dark": "#2D3436",
            "kp-text-light": "#9E9E9E",
            "kp-accent-purple": "#F3E5F5",
          },
          fontFamily: {
            sans: ["Poppins", "sans-serif"]
          },
        },
      },
    };
  </script>
  <style data-purpose="custom-layout-styles">
    body {
      background-color: #e8ebf3;
      font-family: "Poppins", sans-serif;
      margin: 0;
      padding: 0;
    }

    .no-scrollbar::-webkit-scrollbar {
      display: none;
    }

    .no-scrollbar {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }

    .tab-active {
      background-color: white;
      color: #2D3436;
      font-weight: 700;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .tab-inactive {
      color: #9E9E9E;
    }

    .nav-indicator {
      transition: left 0.3s ease, top 0.3s ease, width 0.3s ease, height 0.3s ease;
    }

    .side-nav-btn {
      color: #9E9E9E;
    }

    .side-nav-btn:hover {
      color: #FF5722;
    }

    .side-nav-btn.is-active,
    .side-nav-btn.is-active:hover {
      color: #ffffff;
    }

    .section-panel {
      opacity: 0;
      visibility: hidden;
      transform: translateY(10px);
      transition: opacity 0.35s ease, transform 0.35s ease, visibility 0.35s;
      pointer-events: none;
    }

    .section-panel.is-active {
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
      pointer-events: auto;
    }

    @media (max-width: 1023px) {
      .section-panel:not(.is-active) {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 0;
        overflow: hidden;
      }

      .section-panel.is-active {
        position: relative;
      }
    }

    @media (min-width: 1024px) {
      #section-container {
        min-height: 0;
      }

      .section-panel:not(.is-active) {
        position: absolute;
        inset: 0;
        overflow: hidden;
      }

      .section-panel.is-active {
        position: relative;
        height: 100%;
        overflow-y: auto;
      }
    }

    @supports (padding-bottom: env(safe-area-inset-bottom)) {
      .safe-bottom {
        padding-bottom: env(safe-area-inset-bottom);
      }
    }
  </style>
</head>

<body class="min-h-screen lg:h-screen w-full overflow-x-hidden lg:overflow-hidden bg-white sm:bg-kp-gray-bg">
  <main class="relative bg-kp-gray-bg w-full min-h-screen lg:h-full flex flex-col lg:flex-row overflow-x-hidden lg:overflow-hidden border-0">

    <!-- BEGIN: Side Navigation -->
    <nav class="fixed bottom-0 left-0 right-0 lg:static w-full lg:w-20 h-auto lg:h-full flex flex-row lg:flex-col items-center justify-center lg:justify-start py-3 px-6 sm:px-10 lg:py-6 lg:px-0 lg:gap-8 order-last lg:order-first bg-white lg:bg-transparent border-t lg:border-t-0 border-gray-100 lg:border-white/50 z-30 shrink-0 safe-bottom">
      <div class="hidden lg:flex justify-center items-center">
        <svg class="w-8 h-8 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4">
          </path>
        </svg>
      </div>
      <div id="side-nav-group" class="relative flex flex-row lg:flex-col gap-2 sm:gap-4 lg:gap-6 items-center bg-gray-50 lg:bg-white/50 rounded-full py-2 lg:py-3 px-4 sm:px-6 lg:px-2 w-auto max-w-xs sm:max-w-none lg:w-auto justify-center lg:justify-center">
        <div id="side-indicator" class="nav-indicator absolute bg-kp-orange rounded-full shadow-lg shadow-kp-orange/30 pointer-events-none z-0"></div>
        <button id="side-about" class="side-nav-btn is-active relative z-10 p-3 min-w-[44px] min-h-[44px] flex items-center justify-center rounded-full transition-all duration-300 ease-out">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"></path>
          </svg>
        </button>
        <button id="side-projects" class="side-nav-btn relative z-10 p-3 min-w-[44px] min-h-[44px] flex items-center justify-center rounded-full transition-all duration-300 ease-out">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z"></path>
          </svg>
        </button>
        <button id="side-contact" class="side-nav-btn relative z-10 p-3 min-w-[44px] min-h-[44px] flex items-center justify-center rounded-full transition-all duration-300 ease-out">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"></path>
          </svg>
        </button>
      </div>
      <div class="hidden lg:block lg:mt-auto lg:mb-4">
        <img alt="Profile" class="w-10 h-10 rounded-full border-2 border-white shadow-sm object-cover" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=200&h=200&fit=crop" />
      </div>
    </nav>
    <!-- END: Side Navigation -->

    <!-- BEGIN: Main Workspace -->
    <div id="main-workspace" class="flex-1 flex flex-col p-3 sm:p-4 lg:px-4 lg:py-10 overflow-y-auto lg:overflow-hidden no-scrollbar pb-24 lg:pb-10 w-full min-h-0">
      <!-- BEGIN: Top Navigation Tabs -->
      <header id="tab-header" class="relative inline-flex items-center gap-1 sm:gap-1.5 bg-gray-100/80 rounded-full p-1 mb-3 sm:mb-4 lg:mb-6 overflow-x-auto no-scrollbar shrink-0 max-w-full">
        <div id="tab-indicator" class="nav-indicator absolute top-1 bottom-1 bg-white rounded-full shadow-sm pointer-events-none z-0"></div>
        <button id="tab-about" class="relative z-10 flex items-center gap-1.5 px-4 sm:px-6 py-2 text-sm sm:text-base rounded-full text-kp-text-dark font-bold whitespace-nowrap cursor-pointer shrink-0 transition-colors duration-300">
          About Me 🙎🏻
        </button>
        <button id="tab-projects" class="relative z-10 flex items-center gap-1.5 px-4 sm:px-6 py-2 text-sm sm:text-base rounded-full text-kp-text-light font-medium hover:text-kp-text-dark whitespace-nowrap transition-colors duration-300 cursor-pointer shrink-0">
          Projects 🚀
        </button>
        <button id="tab-contact" class="relative z-10 flex items-center gap-1.5 px-4 sm:px-6 py-2 text-sm sm:text-base rounded-full text-kp-text-light font-medium hover:text-kp-text-dark whitespace-nowrap transition-colors duration-300 cursor-pointer shrink-0">
          Contact ✉️
        </button>
      </header>
      <!-- END: Top Navigation Tabs -->

      <!-- BEGIN: Content Grid -->
      <div class="flex-1 flex flex-col lg:grid lg:grid-cols-12 gap-4 sm:gap-6 lg:overflow-hidden min-h-0">

        <div id="section-container" class="lg:col-span-8 relative min-h-0 lg:h-full">

          <!-- About Section -->
          <div id="about-section" class="section-panel is-active p-4 sm:p-6 bg-white rounded-2xl sm:rounded-3xl flex flex-col gap-4 sm:gap-6 lg:gap-8 no-scrollbar h-full min-h-0">
            <!-- BEGIN: Main Hero Card -->
            <section class="flex flex-col gap-6" data-purpose="main-exercise-card">
              <div class="relative w-full aspect-[4/3] sm:aspect-[16/9] md:aspect-video rounded-2xl sm:rounded-3xl overflow-hidden bg-blue-50">
                <img alt="Coding Workspace" class="w-full h-full object-cover opacity-90" src="<?php echo isset($aboutContent['hero_image']) && $aboutContent['hero_image']['image'] ? (strpos($aboutContent['hero_image']['image'], 'http') === 0 ? $aboutContent['hero_image']['image'] : 'uploads/' . $aboutContent['hero_image']['image']) : 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=1000&q=80'; ?>" />
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                <!-- Card Header Overlay -->
                <div class="absolute bottom-4 left-4 right-4 sm:bottom-6 sm:left-6 sm:right-6">
                  <h2 class="text-xl sm:text-2xl md:text-3xl font-black text-white mb-1 sm:mb-2 leading-tight"><?php echo htmlspecialchars($aboutContent['hero_title']['content'] ?? 'Restian Dwi Friwaldi'); ?></h2>
                  <p class="text-xs sm:text-sm md:text-lg font-medium text-white/90"><?php echo htmlspecialchars($aboutContent['hero_subtitle']['content'] ?? 'Front-End Developer & Graphic Designer'); ?></p>
                </div>
              </div>
              <!-- Stats Bar / Skills -->
              <div class="grid grid-cols-2 sm:flex sm:flex-wrap items-stretch sm:items-center sm:justify-between gap-2 sm:gap-4" data-purpose="stats-bar">
                <?php 
                $skillColors = [
                    'Frontend' => ['bg' => 'bg-blue-50', 'icon' => 'bg-blue-100', 'text' => 'text-blue-600'],
                    'Backend' => ['bg' => 'bg-purple-50', 'icon' => 'bg-purple-100', 'text' => 'text-purple-600'],
                    'Database' => ['bg' => 'bg-indigo-50', 'icon' => 'bg-indigo-100', 'text' => 'text-indigo-600'],
                    'Tools' => ['bg' => 'bg-pink-50', 'icon' => 'bg-pink-100', 'text' => 'text-pink-600']
                ];
                $counter = 0;
                foreach ($skills as $category => $categorySkills): 
                    $colors = $skillColors[$category] ?? ['bg' => 'bg-gray-50', 'icon' => 'bg-gray-100', 'text' => 'text-gray-600'];
                    if ($counter >= 4) break;
                ?>
                <div class="flex items-center gap-2 sm:gap-3 <?php echo $colors['bg']; ?> px-3 sm:px-4 py-2.5 sm:py-3 rounded-xl sm:rounded-2xl sm:flex-1 sm:min-w-[140px]">
                  <div class="p-2 <?php echo $colors['icon']; ?> rounded-lg <?php echo $colors['text']; ?>">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                    </svg>
                  </div>
                  <div>
                    <p class="text-xs font-bold text-kp-text-dark"><?php echo htmlspecialchars($category); ?></p>
                    <p class="text-[10px] text-kp-text-light uppercase tracking-wider"><?php echo count($categorySkills); ?> Skills</p>
                  </div>
                </div>
                <?php $counter++; endforeach; ?>
              </div>
            </section>
            <!-- END: Main Hero Card -->

            <!-- BEGIN: Description Section -->
            <section class="" data-purpose="exercise-description">
              <h3 class="text-xs font-bold text-kp-text-light uppercase tracking-widest mb-4 sm:mb-6">Overview</h3>
              <div class="flex flex-col gap-5 sm:gap-8">
                <div class="flex gap-3 sm:gap-4">
                  <div class="w-8 h-8 rounded-full bg-kp-text-dark text-white flex items-center justify-center shrink-0 text-xs font-bold">👤</div>
                  <div>
                    <h4 class="font-bold text-kp-text-dark mb-1">About Me</h4>
                    <p class="text-sm text-kp-text-light leading-relaxed"><?php echo htmlspecialchars($aboutContent['hero_description']['content'] ?? ''); ?></p>
                  </div>
                </div>
                <div class="flex gap-3 sm:gap-4 border-l-2 border-gray-100 ml-3 sm:ml-4 pl-3 sm:pl-4 pb-2 sm:pb-4">
                  <div class="flex flex-col gap-1">
                    <h4 class="font-bold text-kp-text-dark mb-1">Education & Certifications</h4>
                    <p class="text-sm text-kp-text-light leading-relaxed mb-2"><?php echo htmlspecialchars($aboutContent['education']['content'] ?? ''); ?></p>
                    <p class="text-sm text-kp-text-light leading-relaxed mb-2"><?php echo htmlspecialchars($aboutContent['certification_1']['content'] ?? ''); ?></p>
                    <p class="text-sm text-kp-text-light leading-relaxed"><?php echo htmlspecialchars($aboutContent['certification_2']['content'] ?? ''); ?></p>
                  </div>
                </div>
              </div>
            </section>
            <!-- END: Description Section -->
          </div>

          <!-- Projects Section -->
          <div id="projects-section" class="section-panel flex flex-col gap-6 sm:gap-8 no-scrollbar min-h-0 bg-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 shadow-sm">
            <div class="">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
                <?php while ($project = $projects->fetch_assoc()): ?>
                <div class="bg-white border border-gray-200 rounded-2xl p-4 hover:shadow-md hover:shadow-md transition-all">
                  <img alt="<?php echo htmlspecialchars($project['title']); ?>" class="w-full h-32 rounded-xl object-cover mb-3" src="<?php echo $project['image'] ? (strpos($project['image'], 'http') === 0 ? $project['image'] : 'uploads/' . $project['image']) : 'https://via.placeholder.com/300x200'; ?>" />
                  <h4 class="font-bold text-kp-text-dark mb-2"><?php echo htmlspecialchars($project['title']); ?></h4>
                  <p class="text-xs text-kp-text-light mb-3"><?php echo htmlspecialchars($project['description']); ?></p>
                  <div class="flex gap-2 mb-3">
                    <?php 
                    $techs = explode(',', $project['technologies']);
                    foreach ($techs as $tech): 
                    ?>
                    <span class="px-2 py-1 bg-blue-50 text-blue-600 text-[10px] rounded-full"><?php echo htmlspecialchars(trim($tech)); ?></span>
                    <?php endforeach; ?>
                  </div>
                  <?php if ($project['project_url']): ?>
                  <a href="<?php echo htmlspecialchars($project['project_url']); ?>" target="_blank" class="text-kp-orange text-xs font-medium hover:underline transition-all">View Project →</a>
                  <?php else: ?>
                  <span class="text-gray-400 text-xs">Coming Soon</span>
                  <?php endif; ?>
                </div>
                <?php endwhile; ?>
              </div>
            </div>
          </div>

          <!-- Contact Section -->
          <div id="contact-section" class="section-panel flex flex-col gap-6 sm:gap-8 no-scrollbar min-h-0">
            <div class="bg-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 shadow-sm">
              <h3 class="text-lg sm:text-xl font-bold text-kp-text-dark mb-4 sm:mb-6">Get In Touch</h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                  <?php if (isset($contactInfo['email'])): ?>
                  <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-kp-orange/10 rounded-full flex items-center justify-center shrink-0">
                      <svg class="w-5 h-5 text-kp-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                      </svg>
                    </div>
                    <div>
                      <p class="text-xs text-kp-text-light mb-1"><?php echo htmlspecialchars($contactInfo['email']['label'] ?? 'Email'); ?></p>
                      <a href="mailto:<?php echo htmlspecialchars($contactInfo['email']['value']); ?>" class="text-sm text-kp-text-dark hover:text-kp-orange transition-colors"><?php echo htmlspecialchars($contactInfo['email']['value']); ?></a>
                    </div>
                  </div>
                  <?php endif; ?>

                  <?php if (isset($contactInfo['phone'])): ?>
                  <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-kp-orange/10 rounded-full flex items-center justify-center shrink-0">
                      <svg class="w-5 h-5 text-kp-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                      </svg>
                    </div>
                    <div>
                      <p class="text-xs text-kp-text-light mb-1"><?php echo htmlspecialchars($contactInfo['phone']['label'] ?? 'Phone'); ?></p>
                      <a href="tel:<?php echo htmlspecialchars($contactInfo['phone']['value']); ?>" class="text-sm text-kp-text-dark hover:text-kp-orange"><?php echo htmlspecialchars($contactInfo['phone']['value']); ?></a>
                    </div>
                  </div>
                  <?php endif; ?>

                  <?php if (isset($contactInfo['location'])): ?>
                  <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-kp-orange/10 rounded-full flex items-center justify-center shrink-0">
                      <svg class="w-5 h-5 text-kp-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                      </svg>
                    </div>
                    <div>
                      <p class="text-xs text-kp-text-light mb-1"><?php echo htmlspecialchars($contactInfo['location']['label'] ?? 'Location'); ?></p>
                      <p class="text-sm text-kp-text-dark"><?php echo htmlspecialchars($contactInfo['location']['value']); ?></p>
                    </div>
                  </div>
                  <?php endif; ?>
                </div>

                <div>
                  <h4 class="text-sm font-bold text-kp-text-dark mb-4">Send Message</h4>
                  <form class="space-y-3" onsubmit="event.preventDefault(); alert('Message sent! (Demo only)');">
                    <input type="text" placeholder="Your Name" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-kp-orange text-base sm:text-sm" required />
                    <input type="email" placeholder="Your Email" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-kp-orange text-base sm:text-sm" required />
                    <textarea rows="4" placeholder="Your Message" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-kp-orange text-base sm:text-sm resize-none" required></textarea>
                    <button type="submit" class="w-full bg-kp-orange text-white px-4 py-3 rounded-xl hover:bg-orange-600 transition-colors text-sm font-medium">Send Message</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Right Column (4 Units) - Desktop only -->
        <div id="sidebar-column" class="hidden lg:flex lg:col-span-4 flex-col gap-6 sm:gap-8 overflow-visible lg:overflow-hidden bg-white rounded-3xl p-4 sm:p-6 shadow-sm h-full">
          <h3 class="text-[10px] font-bold text-kp-text-light uppercase tracking-widest mb-6">My Projects</h3>
          <div class="flex flex-col gap-3 sm:gap-4 overflow-visible lg:overflow-y-auto no-scrollbar pr-2 pb-4">
            <?php 
            $projects->data_seek(0);
            while ($project = $projects->fetch_assoc()): 
            ?>
            <div class="flex items-center gap-3 sm:gap-4 p-2 rounded-2xl hover:bg-gray-100 transition-colors">
              <img alt="<?php echo htmlspecialchars($project['title']); ?>" class="w-16 h-12 sm:w-20 sm:h-14 rounded-xl object-cover shrink-0" src="<?php echo $project['image'] ? (strpos($project['image'], 'http') === 0 ? $project['image'] : 'uploads/' . $project['image']) : 'https://via.placeholder.com/300x200'; ?>" />
              <div class="flex-1">
                <h4 class="text-xs font-bold text-kp-text-dark"><?php echo htmlspecialchars($project['title']); ?></h4>
                <div class="flex gap-3 mt-1 flex-wrap">
                  <?php 
                  $techs = explode(',', $project['technologies']);
                  foreach (array_slice($techs, 0, 2) as $tech): 
                  ?>
                  <span class="text-[10px] text-kp-text-light flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-blue-400"></span> <?php echo htmlspecialchars(trim($tech)); ?></span>
                  <?php endforeach; ?>
                </div>
              </div>
              <?php if ($project['project_url']): ?>
              <a href="<?php echo htmlspecialchars($project['project_url']); ?>" target="_blank" class="w-8 h-8 border-2 border-kp-orange text-kp-orange hover:bg-kp-orange hover:text-white rounded-full flex items-center justify-center transition-colors shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
              </a>
              <?php else: ?>
              <span class="w-8 h-8 border-2 border-gray-300 text-gray-300 rounded-full flex items-center justify-center cursor-not-allowed shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
              </span>
              <?php endif; ?>
            </div>
            <?php endwhile; ?>
          </div>
          <!-- END: Exercise List -->

          <!-- BEGIN: User Stats/Contact Card -->
          <div class="bg-kp-accent-purple rounded-2xl sm:rounded-3xl p-4 sm:p-6 shadow-sm flex flex-col gap-4 sm:gap-6" data-purpose="user-stats-card">
            <div class="flex justify-between items-start">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm text-lg">
                  ✉️
                </div>
                <div>
                  <h4 class="text-xs font-extrabold text-kp-text-dark uppercase tracking-wide">Get In Touch</h4>
                  <p class="text-[10px] text-kp-text-light"><?php echo htmlspecialchars($contactInfo['location']['value'] ?? 'SERANG, BANTEN'); ?></p>
                </div>
              </div>
            </div>

            <div class="flex justify-between items-center mt-2">
              <div>
                <h5 class="text-[10px] font-bold text-kp-text-light uppercase tracking-widest mb-3">Connect With Me</h5>
                <div class="flex gap-3">
                  <?php if (isset($socialMedia['github'])): ?>
                  <a href="<?php echo htmlspecialchars($socialMedia['github']['url']); ?>" target="_blank" class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-gray-700 hover:text-black transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                      <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path>
                    </svg>
                  </a>
                  <?php endif; ?>
                  <?php if (isset($socialMedia['linkedin'])): ?>
                  <a href="<?php echo htmlspecialchars($socialMedia['linkedin']['url']); ?>" target="_blank" class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-blue-600 hover:text-blue-800 transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                    </svg>
                  </a>
                  <?php endif; ?>
                  <?php if (isset($socialMedia['twitter'])): ?>
                  <a href="<?php echo htmlspecialchars($socialMedia['twitter']['url']); ?>" target="_blank" class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-blue-400 hover:text-blue-600 transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                    </svg>
                  </a>
                  <?php endif; ?>
                </div>
              </div>
              <?php if (isset($contactInfo['email'])): ?>
              <a href="mailto:<?php echo htmlspecialchars($contactInfo['email']['value']); ?>" class="w-10 h-10 bg-kp-orange text-white rounded-xl flex items-center justify-center shadow-lg shadow-kp-orange/30 hover:bg-orange-600 transition-colors shrink-0 ml-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
              </a>
              <?php endif; ?>
            </div>
          </div>
          <!-- END: User Stats/Social Card -->
        </div>
      </div>
      <!-- END: Content Grid -->
    </div>
    <!-- END: Main Workspace -->
  </main>

  <script>
    const tabAbout = document.getElementById('tab-about');
    const tabProjects = document.getElementById('tab-projects');
    const tabContact = document.getElementById('tab-contact');
    const tabHeader = document.getElementById('tab-header');
    const tabIndicator = document.getElementById('tab-indicator');
    const sideAbout = document.getElementById('side-about');
    const sideProjects = document.getElementById('side-projects');
    const sideContact = document.getElementById('side-contact');
    const sideNavGroup = document.getElementById('side-nav-group');
    const sideIndicator = document.getElementById('side-indicator');
    const aboutSection = document.getElementById('about-section');
    const projectsSection = document.getElementById('projects-section');
    const contactSection = document.getElementById('contact-section');
    const mainWorkspace = document.getElementById('main-workspace');

    const tabs = [tabAbout, tabProjects, tabContact];
    const sideBtns = [sideAbout, sideProjects, sideContact];
    const sections = [aboutSection, projectsSection, contactSection];

    let currentSection = 'about';

    function moveIndicator(indicator, container, activeBtn) {
      if (!indicator || !container || !activeBtn) return;
      const containerRect = container.getBoundingClientRect();
      const btnRect = activeBtn.getBoundingClientRect();
      indicator.style.width = `${btnRect.width}px`;
      indicator.style.height = `${btnRect.height}px`;
      indicator.style.left = `${btnRect.left - containerRect.left}px`;
      indicator.style.top = `${btnRect.top - containerRect.top}px`;
    }

    function updateIndicators(activeTab, activeSide) {
      requestAnimationFrame(() => {
        moveIndicator(tabIndicator, tabHeader, activeTab);
        moveIndicator(sideIndicator, sideNavGroup, activeSide);
      });
    }

    function setActiveTab(activeTab) {
      tabs.forEach(tab => {
        tab.classList.remove('text-kp-text-dark', 'font-bold');
        tab.classList.add('text-kp-text-light', 'font-medium');
      });
      activeTab.classList.remove('text-kp-text-light', 'font-medium');
      activeTab.classList.add('text-kp-text-dark', 'font-bold');
    }

    function setActiveSide(activeSide) {
      sideBtns.forEach(btn => btn.classList.remove('is-active'));
      activeSide.classList.add('is-active');
    }

    function showSection(section) {
      sections.forEach(s => s.classList.remove('is-active'));

      let activeTab, activeSide, activeSection;

      if (section === 'about') {
        activeTab = tabAbout;
        activeSide = sideAbout;
        activeSection = aboutSection;
      } else if (section === 'projects') {
        activeTab = tabProjects;
        activeSide = sideProjects;
        activeSection = projectsSection;
      } else {
        activeTab = tabContact;
        activeSide = sideContact;
        activeSection = contactSection;
      }

      activeSection.classList.add('is-active');
      setActiveTab(activeTab);
      setActiveSide(activeSide);
      updateIndicators(activeTab, activeSide);

      currentSection = section;

      if (mainWorkspace && window.innerWidth < 1024) {
        mainWorkspace.scrollTo({
          top: 0,
          behavior: 'smooth'
        });
      }
    }

    tabAbout.addEventListener('click', () => showSection('about'));
    tabProjects.addEventListener('click', () => showSection('projects'));
    tabContact.addEventListener('click', () => showSection('contact'));

    sideAbout.addEventListener('click', () => showSection('about'));
    sideProjects.addEventListener('click', () => showSection('projects'));
    sideContact.addEventListener('click', () => showSection('contact'));

    window.addEventListener('resize', () => {
      const activeTab = tabs.find(t => t.classList.contains('font-bold'));
      const activeSide = sideBtns.find(b => b.classList.contains('is-active'));
      if (activeTab && activeSide) updateIndicators(activeTab, activeSide);
    });

    window.addEventListener('load', () => {
      const activeTab = tabs.find(t => t.classList.contains('font-bold'));
      const activeSide = sideBtns.find(b => b.classList.contains('is-active'));
      if (activeTab && activeSide) updateIndicators(activeTab, activeSide);
    });

    showSection('about');
  </script>
</body>

</html>