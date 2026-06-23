<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
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
  </style>
</head>

<body class="h-screen w-full overflow-hidden bg-white sm:bg-kp-gray-bg">
  <main class="relative bg-kp-gray-bg w-full h-full flex flex-col lg:flex-row overflow-hidden border-0">

    <!-- BEGIN: Side Navigation -->
    <nav class="w-full lg:w-20 h-auto lg:h-full flex flex-row lg:flex-col items-center justify-between lg:justify-start py-4 px-10 lg:py-6 lg:px-0 lg:gap-8 order-last lg:order-first bg-white lg:bg-transparent border-t lg:border-t-0 border-white/50 z-20 shrink-0">
      <div class="hidden lg:flex justify-center items-center">
        <svg class="w-8 h-8 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4">
          </path>
        </svg>
      </div>
      <div class="flex flex-row lg:flex-col gap-4 lg:gap-6 items-center bg-transparent lg:bg-white/50 rounded-full py-2 lg:py-3 px-2 w-full lg:w-auto justify-between lg:justify-center">
        <button id="side-about" class="p-3 bg-kp-orange text-white rounded-full shadow-lg shadow-kp-orange/30">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"></path>
          </svg>
        </button>
        <button id="side-projects" class="p-3 text-kp-text-light hover:text-kp-orange transition-colors">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z"></path>
          </svg>
        </button>
        <button id="side-contact" class="p-3 text-kp-text-light hover:text-kp-orange transition-colors">
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
    <div class="flex-1 flex flex-col p-4 lg:px-4 lg:py-10 overflow-y-auto lg:overflow-hidden no-scrollbar pb-6 lg:pb-10 w-full">
      <!-- BEGIN: Top Navigation Tabs -->
      <header class="flex items-center gap-2 lg:gap-6 mb-4 lg:mb-6 overflow-x-auto no-scrollbar pb-2 lg:pb-0 shrink-0">
        <button id="tab-about" class="flex items-center gap-2 px-6 py-2 bg-white rounded-full shadow-sm text-kp-text-dark font-bold whitespace-nowrap cursor-pointer">
          About Me 🙎🏻
        </button>
        <button id="tab-projects" class="flex items-center gap-2 px-6 py-2 rounded-full shadow-sm text-kp-text-light font-medium hover:text-kp-text-dark whitespace-nowrap transition-colors cursor-pointer">
          Projects 🚀
        </button>
        <button id="tab-contact" class="flex items-center gap-2 px-6 py-2 rounded-full shadow-sm text-kp-text-light font-medium hover:text-kp-text-dark whitespace-nowrap transition-colors cursor-pointer">
          Contact ✉️
        </button>
      </header>
      <!-- END: Top Navigation Tabs -->

      <!-- BEGIN: Content Grid -->
      <div class="flex-1 flex flex-col lg:grid lg:grid-cols-12 gap-6 lg:overflow-hidden min-h-0">

        <!-- About Section -->
        <div id="about-section" class="p-4 sm:p-6 bg-white rounded-3xl lg:col-span-8 flex flex-col gap-6 sm:gap-8 overflow-visible lg:overflow-y-auto no-scrollbar h-full min-h-0">
          <!-- BEGIN: Main Hero Card -->
          <section class="flex flex-col gap-6" data-purpose="main-exercise-card">
            <div class="relative w-full aspect-[16/7] md:aspect-video rounded-3xl overflow-hidden bg-blue-50">
              <img alt="Coding Workspace" class="w-full h-full object-cover opacity-90" src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=1000&q=80" />
              <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
              <!-- Card Header Overlay -->
              <div class="absolute bottom-6 left-6 right-6">
                <h2 class="text-2xl md:text-3xl font-black text-white mb-2">Restian Dwi Friwaldi</h2>
                <p class="text-sm md:text-lg font-medium text-white/90">Front-End Developer & Graphic Designer</p>
              </div>
            </div>
            <!-- Stats Bar / Skills -->
            <div class="flex flex-wrap items-center justify-between gap-4" data-purpose="stats-bar">
              <div class="flex items-center gap-3 bg-blue-50 px-4 py-3 rounded-2xl flex-1 min-w-[140px]">
                <div class="p-2 bg-blue-100 rounded-lg text-blue-600">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                  </svg>
                </div>
                <div>
                  <p class="text-xs font-bold text-kp-text-dark">HTML, CSS, JS</p>
                  <p class="text-[10px] text-kp-text-light uppercase tracking-wider">Frontend</p>
                </div>
              </div>
              <div class="flex items-center gap-3 bg-indigo-50 px-4 py-3 rounded-2xl flex-1 min-w-[140px]">
                <div class="p-2 bg-indigo-100 rounded-lg text-indigo-600">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                  </svg>
                </div>
                <div>
                  <p class="text-xs font-bold text-kp-text-dark">Tailwind CSS</p>
                  <p class="text-[10px] text-kp-text-light uppercase tracking-wider">Styling</p>
                </div>
              </div>
              <div class="flex items-center gap-3 bg-purple-50 px-4 py-3 rounded-2xl flex-1 min-w-[140px]">
                <div class="p-2 bg-purple-100 rounded-lg text-purple-600">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                  </svg>
                </div>
                <div>
                  <p class="text-xs font-bold text-kp-text-dark">PHP & MySQL</p>
                  <p class="text-[10px] text-kp-text-light uppercase tracking-wider">Backend</p>
                </div>
              </div>
              <div class="flex items-center gap-3 bg-pink-50 px-4 py-3 rounded-2xl flex-1 min-w-[140px]">
                <div class="p-2 bg-pink-100 rounded-lg text-pink-600">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                  </svg>
                </div>
                <div>
                  <p class="text-xs font-bold text-kp-text-dark">Flutter</p>
                  <p class="text-[10px] text-kp-text-light uppercase tracking-wider">Mobile App</p>
                </div>
              </div>
            </div>
          </section>
          <!-- END: Main Hero Card -->

          <!-- BEGIN: Description Section -->
          <section class="" data-purpose="exercise-description">
            <h3 class="text-xs font-bold text-kp-text-light uppercase tracking-widest mb-6">Overview</h3>
            <div class="flex flex-col gap-8">
              <div class="flex gap-4">
                <div class="w-8 h-8 rounded-full bg-kp-text-dark text-white flex items-center justify-center shrink-0 text-xs font-bold">👤</div>
                <div>
                  <h4 class="font-bold text-kp-text-dark mb-1">About Me</h4>
                  <p class="text-sm text-kp-text-light leading-relaxed">I am an enthusiastic web developer and graphic designer located in Serang, Banten, Indonesia. I am constantly exploring new programming languages and actively improving my skills in web and mobile development, UI/UX, and data science.</p>
                </div>
              </div>
              <div class="flex gap-4 border-l-2 border-gray-100 ml-4 pl-4 pb-4">
                <div class="flex flex-col gap-1">
                  <h4 class="font-bold text-kp-text-dark mb-1">Education & Certifications</h4>
                  <p class="text-sm text-kp-text-light leading-relaxed mb-2">🎓 Bachelor of Informatics – Yogyakarta Technology University</p>
                  <p class="text-sm text-kp-text-light leading-relaxed mb-2">🏆 Finalist LKS SMK 2020 - Cybersecurity</p>
                  <p class="text-sm text-kp-text-light leading-relaxed">📜 RapidMiner Data Engineering Professional & freeCodeCamp Responsive Web Design Certified.</p>
                </div>
              </div>
            </div>
          </section>
          <!-- END: Description Section -->
        </div>

        <!-- Projects Section (Hidden by default) -->
        <div id="projects-section" class="lg:col-span-8 flex flex-col gap-6 sm:gap-8 overflow-visible lg:overflow-y-auto no-scrollbar hidden min-h-0">
          <div class="">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-white rounded-3xl p-6 shadow-sm">
              <!-- Project 1 -->
              <div class="bg-white border border-gray-200 rounded-2xl p-4 hover:shadow-md hover:shadow-md transition-all">
                <img alt="Wonderland" class="w-full h-32 rounded-xl object-cover mb-3" src="https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?w=300&h=200&fit=crop" />
                <h4 class="font-bold text-kp-text-dark mb-2">Wonderland</h4>
                <p class="text-xs text-kp-text-light mb-3">A beautiful tourism website built with ReactJS and Tailwind CSS featuring modern UI/UX design.</p>
                <div class="flex gap-2 mb-3">
                  <span class="px-2 py-1 bg-blue-50 text-blue-600 text-[10px] rounded-full">ReactJS</span>
                  <span class="px-2 py-1 bg-teal-50 text-teal-600 text-[10px] rounded-full">Tailwind</span>
                </div>
                <a href="https://restiandf.my.id/pariwisata/" target="_blank" class="text-kp-orange text-xs font-medium hover:underline transition-all">View Project →</a>
              </div>

              <!-- Project 2 -->
              <div class="bg-white border border-gray-200 rounded-2xl p-4 hover:shadow-md hover:shadow-md transition-all">
                <img alt="Teras Online" class="w-full h-32 rounded-xl object-cover mb-3" src="https://images.unsplash.com/photo-1541534741688-6078c6bfb5c5?w=300&h=200&fit=crop" />
                <h4 class="font-bold text-kp-text-dark mb-2">Teras Online</h4>
                <p class="text-xs text-kp-text-light mb-3">E-commerce platform with secure payment integration and inventory management system.</p>
                <div class="flex gap-2 mb-3">
                  <span class="px-2 py-1 bg-purple-50 text-purple-600 text-[10px] rounded-full">PHP</span>
                  <span class="px-2 py-1 bg-indigo-50 text-indigo-600 text-[10px] rounded-full">MySQL</span>
                </div>
                <a href="https://ubeltech.rf.gd/Ecommerce/" target="_blank" class="text-kp-orange text-xs font-medium hover:underline transition-all">View Project →</a>
              </div>

              <!-- Project 3 -->
              <div class="bg-white border border-gray-200 rounded-2xl p-4 hover:shadow-md hover:shadow-md transition-all">
                <img alt="Weather Forecast" class="w-full h-32 rounded-xl object-cover mb-3" src="https://images.unsplash.com/photo-1581009146145-b5ef050c2e1e?w=300&h=200&fit=crop" />
                <h4 class="font-bold text-kp-text-dark mb-2">Weather Forecast</h4>
                <p class="text-xs text-kp-text-light mb-3">Real-time weather application with location-based forecasts using external APIs.</p>
                <div class="flex gap-2 mb-3">
                  <span class="px-2 py-1 bg-yellow-50 text-yellow-600 text-[10px] rounded-full">JavaScript</span>
                  <span class="px-2 py-1 bg-red-50 text-red-600 text-[10px] rounded-full">APIs</span>
                </div>
                <a href="https://prediksi-cuaca.vercel.app/" target="_blank" class="text-kp-orange text-xs font-medium hover:underline transition-all">View Project →</a>
              </div>

              <!-- Project 4 -->
              <div class="bg-white border border-gray-200 rounded-2xl p-4 hover:shadow-md hover:shadow-md transition-all">
                <img alt="AI Chatbot" class="w-full h-32 rounded-xl object-cover mb-3" src="https://images.unsplash.com/photo-1599058917212-d750089bc07e?w=300&h=200&fit=crop" />
                <h4 class="font-bold text-kp-text-dark mb-2">AI Chatbot</h4>
                <p class="text-xs text-kp-text-light mb-3">Intelligent chatbot powered by OpenRouter API with natural language processing capabilities.</p>
                <div class="flex gap-2 mb-3">
                  <span class="px-2 py-1 bg-gray-100 text-gray-600 text-[10px] rounded-full">OpenRouter</span>
                  <span class="px-2 py-1 bg-purple-50 text-purple-600 text-[10px] rounded-full">PHP</span>
                </div>
                <span class="text-gray-400 text-xs">Coming Soon</span>
              </div>

              <!-- Project 5 -->
              <div class="bg-white border border-gray-200 rounded-2xl p-4 hover:shadow-md hover:shadow-md transition-all">
                <img alt="Artisan Coffee" class="w-full h-32 rounded-xl object-cover mb-3" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=300&h=200&fit=crop" />
                <h4 class="font-bold text-kp-text-dark mb-2">Artisan Coffee</h4>
                <p class="text-xs text-kp-text-light mb-3">Modern coffee shop website with online ordering and reservation system.</p>
                <div class="flex gap-2 mb-3">
                  <span class="px-2 py-1 bg-orange-50 text-orange-600 text-[10px] rounded-full">HTML5</span>
                  <span class="px-2 py-1 bg-yellow-50 text-yellow-600 text-[10px] rounded-full">JavaScript</span>
                </div>
                <a href="https://coffe-lake.vercel.app/" target="_blank" class="text-kp-orange text-xs font-medium hover:underline transition-all">View Project →</a>
              </div>
            </div>
          </div>
        </div>

        <!-- Contact Section (Hidden by default) -->
        <div id="contact-section" class="lg:col-span-8 flex flex-col gap-6 sm:gap-8 overflow-visible lg:overflow-y-auto no-scrollbar hidden min-h-0">
          <div class="bg-white rounded-3xl p-6 shadow-sm">
            <h3 class="text-xl font-bold text-kp-text-dark mb-6">Get In Touch</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="space-y-4">
                <div class="flex items-start gap-3">
                  <div class="w-10 h-10 bg-kp-orange/10 rounded-full flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-kp-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                  </div>
                  <div>
                    <p class="text-xs text-kp-text-light mb-1">Email</p>
                    <a href="mailto:restiandf@gmail.com" class="text-sm text-kp-text-dark hover:text-kp-orange transition-colors">restiandf@gmail.com</a>
                  </div>
                </div>

                <div class="flex items-start gap-3">
                  <div class="w-10 h-10 bg-kp-orange/10 rounded-full flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-kp-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                  </div>
                  <div>
                    <p class="text-xs text-kp-text-light mb-1">Phone</p>
                    <a href="tel:+6281234567890" class="text-sm text-kp-text-dark hover:text-kp-orange">+62 812-3456-7890</a>
                  </div>
                </div>

                <div class="flex items-start gap-3">
                  <div class="w-10 h-10 bg-kp-orange/10 rounded-full flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-kp-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                  </div>
                  <div>
                    <p class="text-xs text-kp-text-light mb-1">Location</p>
                    <p class="text-sm text-kp-text-dark">Serang, Banten, Indonesia</p>
                  </div>
                </div>
              </div>

              <div>
                <h4 class="text-sm font-bold text-kp-text-dark mb-4">Send Message</h4>
                <form class="space-y-3" onsubmit="event.preventDefault(); alert('Message sent! (Demo only)');">
                  <input type="text" placeholder="Your Name" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-kp-orange text-sm" required />
                  <input type="email" placeholder="Your Email" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-kp-orange text-sm" required />
                  <textarea rows="4" placeholder="Your Message" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-kp-orange text-sm resize-none" required></textarea>
                  <button type="submit" class="w-full bg-kp-orange text-white px-4 py-2 rounded-xl hover:bg-orange-600 transition-colors text-sm font-medium">Send Message</button>
                </form>
              </div>
            </div>
          </div>
        </div>

        <!-- Right Column (4 Units) - Always visible -->
        <div class="lg:col-span-4 flex flex-col gap-6 sm:gap-8 overflow-visible lg:overflow-hidden bg-white rounded-3xl p-4 sm:p-6 shadow-sm h-full">
          <h3 class="text-[10px] font-bold text-kp-text-light uppercase tracking-widest mb-6">My Projects</h3>
          <div class="flex flex-col gap-3 sm:gap-4 overflow-visible lg:overflow-y-auto no-scrollbar pr-2 pb-4">

            <!-- Project 1 -->
            <div class="flex items-center gap-3 sm:gap-4 p-2 rounded-2xl hover:bg-gray-100 transition-colors">
              <img alt="Wonderland" class="w-16 h-12 sm:w-20 sm:h-14 rounded-xl object-cover shrink-0" src="https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?w=300&h=200&fit=crop" />
              <div class="flex-1">
                <h4 class="text-xs font-bold text-kp-text-dark">Wonderland</h4>
                <div class="flex gap-3 mt-1 flex-wrap">
                  <span class="text-[10px] text-kp-text-light flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-blue-400"></span> ReactJS</span>
                  <span class="text-[10px] text-kp-text-light flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-teal-400"></span> Tailwind</span>
                </div>
              </div>
              <a href="https://restiandf.my.id/pariwisata/" target="_blank" class="w-8 h-8 border-2 border-kp-orange text-kp-orange hover:bg-kp-orange hover:text-white rounded-full flex items-center justify-center transition-colors shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
              </a>
            </div>

            <!-- Project 2 -->
            <div class="flex items-center gap-3 sm:gap-4 p-2 rounded-2xl hover:bg-gray-100 transition-colors">
              <img alt="Teras Online" class="w-16 h-12 sm:w-20 sm:h-14 rounded-xl object-cover shrink-0" src="https://images.unsplash.com/photo-1541534741688-6078c6bfb5c5?w=300&h=200&fit=crop" />
              <div class="flex-1">
                <h4 class="text-xs font-bold text-kp-text-dark">Teras Online</h4>
                <div class="flex gap-3 mt-1 flex-wrap">
                  <span class="text-[10px] text-kp-text-light flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-purple-400"></span> PHP</span>
                  <span class="text-[10px] text-kp-text-light flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-indigo-400"></span> MySQL</span>
                </div>
              </div>
              <a href="https://ubeltech.rf.gd/Ecommerce/" target="_blank" class="w-8 h-8 border-2 border-kp-orange text-kp-orange hover:bg-kp-orange hover:text-white rounded-full flex items-center justify-center transition-colors shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
              </a>
            </div>

            <!-- Project 3 -->
            <div class="flex items-center gap-3 sm:gap-4 p-2 rounded-2xl hover:bg-gray-100 transition-colors">
              <img alt="Weather Forecast" class="w-16 h-12 sm:w-20 sm:h-14 rounded-xl object-cover shrink-0" src="https://images.unsplash.com/photo-1581009146145-b5ef050c2e1e?w=300&h=200&fit=crop" />
              <div class="flex-1">
                <h4 class="text-xs font-bold text-kp-text-dark">Weather Forecast</h4>
                <div class="flex gap-3 mt-1 flex-wrap">
                  <span class="text-[10px] text-kp-text-light flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-yellow-400"></span> JS</span>
                  <span class="text-[10px] text-kp-text-light flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-red-400"></span> APIs</span>
                </div>
              </div>
              <a href="https://prediksi-cuaca.vercel.app/" target="_blank" class="w-8 h-8 border-2 border-kp-orange text-kp-orange hover:bg-kp-orange hover:text-white rounded-full flex items-center justify-center transition-colors shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
              </a>
            </div>

            <!-- Project 4 -->
            <div class="flex items-center gap-3 sm:gap-4 p-2 rounded-2xl hover:bg-gray-100 transition-colors">
              <img alt="AI Chatbot" class="w-16 h-12 sm:w-20 sm:h-14 rounded-xl object-cover shrink-0" src="https://images.unsplash.com/photo-1599058917212-d750089bc07e?w=300&h=200&fit=crop" />
              <div class="flex-1">
                <h4 class="text-xs font-bold text-kp-text-dark">AI Chatbot</h4>
                <div class="flex gap-3 mt-1 flex-wrap">
                  <span class="text-[10px] text-kp-text-light flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-gray-600"></span> OpenRouter</span>
                  <span class="text-[10px] text-kp-text-light flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-purple-400"></span> PHP</span>
                </div>
              </div>
              <a href="#" class="w-8 h-8 border-2 border-gray-300 text-gray-300 rounded-full flex items-center justify-center cursor-not-allowed shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
              </a>
            </div>

            <!-- Project 5 -->
            <div class="flex items-center gap-3 sm:gap-4 p-2 rounded-2xl hover:bg-gray-100 transition-colors">
              <img alt="Artisan Coffee" class="w-16 h-12 sm:w-20 sm:h-14 rounded-xl object-cover shrink-0" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=300&h=200&fit=crop" />
              <div class="flex-1">
                <h4 class="text-xs font-bold text-kp-text-dark">Artisan Coffee</h4>
                <div class="flex gap-3 mt-1 flex-wrap">
                  <span class="text-[10px] text-kp-text-light flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-orange-400"></span> HTML5</span>
                  <span class="text-[10px] text-kp-text-light flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-yellow-400"></span> JS</span>
                </div>
              </div>
              <a href="https://coffe-lake.vercel.app/" target="_blank" class="w-8 h-8 border-2 border-kp-orange text-kp-orange hover:bg-kp-orange hover:text-white rounded-full flex items-center justify-center transition-colors shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
              </a>
            </div>
          </div>
          </aside>
          <!-- END: Exercise List -->

          <!-- BEGIN: User Stats/Contact Card -->
          <div class="bg-kp-accent-purple rounded-3xl p-6 shadow-sm flex flex-col gap-6" data-purpose="user-stats-card">
            <div class="flex justify-between items-start">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm text-lg">
                  ✉️
                </div>
                <div>
                  <h4 class="text-xs font-extrabold text-kp-text-dark uppercase tracking-wide">Get In Touch</h4>
                  <p class="text-[10px] text-kp-text-light">SERANG, BANTEN</p>
                </div>
              </div>
            </div>

            <div class="flex justify-between items-center mt-2">
              <div>
                <h5 class="text-[10px] font-bold text-kp-text-light uppercase tracking-widest mb-3">Connect With Me</h5>
                <div class="flex gap-3">
                  <a href="https://github.com/restiandf" target="_blank" class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-gray-700 hover:text-black transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                      <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path>
                    </svg>
                  </a>
                  <a href="https://linkedin.com/in/restiandf" target="_blank" class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-blue-600 hover:text-blue-800 transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                    </svg>
                  </a>
                  <a href="https://twitter.com/restiandf" target="_blank" class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-blue-400 hover:text-blue-600 transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                    </svg>
                  </a>
                </div>
              </div>
              <a href="mailto:restiandf@gmail.com" class="w-10 h-10 bg-kp-orange text-white rounded-xl flex items-center justify-center shadow-lg shadow-kp-orange/30 hover:bg-orange-600 transition-colors shrink-0 ml-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
              </a>
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
    // Navigation functionality
    const tabAbout = document.getElementById('tab-about');
    const tabProjects = document.getElementById('tab-projects');
    const tabContact = document.getElementById('tab-contact');
    const aboutSection = document.getElementById('about-section');
    const projectsSection = document.getElementById('projects-section');
    const contactSection = document.getElementById('contact-section');

    // Initially show only about section
    let currentSection = 'about';

    function showSection(section) {
      // Reset all top tabs
      [tabAbout, tabProjects, tabContact].forEach(tab => {
        tab.classList.remove('bg-white', 'shadow-sm', 'text-kp-text-dark', 'font-bold');
        tab.classList.add('text-kp-text-light', 'font-medium');
      });

      // Reset all side navigation buttons
      [sideAbout, sideProjects, sideContact].forEach(btn => {
        btn.classList.remove('bg-kp-orange', 'text-white', 'rounded-full', 'shadow-lg', 'shadow-kp-orange/30');
        btn.classList.add('text-kp-text-light');
      });

      // Hide all sections
      aboutSection.classList.add('hidden');
      projectsSection.classList.add('hidden');
      contactSection.classList.add('hidden');

      // Show selected section and activate tab
      if (section === 'about') {
        aboutSection.classList.remove('hidden');
        tabAbout.classList.add('bg-white', 'shadow-sm', 'text-kp-text-dark', 'font-bold');
        tabAbout.classList.remove('text-kp-text-light', 'font-medium');
        sideAbout.classList.add('bg-kp-orange', 'text-white', 'rounded-full', 'shadow-lg', 'shadow-kp-orange/30');
        sideAbout.classList.remove('text-kp-text-light');
      } else if (section === 'projects') {
        projectsSection.classList.remove('hidden');
        tabProjects.classList.add('bg-white', 'shadow-sm', 'text-kp-text-dark', 'font-bold');
        tabProjects.classList.remove('text-kp-text-light', 'font-medium');
        sideProjects.classList.add('bg-kp-orange', 'text-white', 'rounded-full', 'shadow-lg', 'shadow-kp-orange/30');
        sideProjects.classList.remove('text-kp-text-light');
      } else if (section === 'contact') {
        contactSection.classList.remove('hidden');
        tabContact.classList.add('bg-white', 'shadow-sm', 'text-kp-text-dark', 'font-bold');
        tabContact.classList.remove('text-kp-text-light', 'font-medium');
        sideContact.classList.add('bg-kp-orange', 'text-white', 'rounded-full', 'shadow-lg', 'shadow-kp-orange/30');
        sideContact.classList.remove('text-kp-text-light');
      }

      currentSection = section;
    }

    // Add click handlers to top navigation buttons
    tabAbout.addEventListener('click', () => showSection('about'));
    tabProjects.addEventListener('click', () => showSection('projects'));
    tabContact.addEventListener('click', () => showSection('contact'));

    // Add click handlers to side navigation buttons
    const sideAbout = document.getElementById('side-about');
    const sideProjects = document.getElementById('side-projects');
    const sideContact = document.getElementById('side-contact');

    sideAbout.addEventListener('click', () => showSection('about'));
    sideProjects.addEventListener('click', () => showSection('projects'));
    sideContact.addEventListener('click', () => showSection('contact'));

    // Initialize with about section active
    showSection('about');
  </script>
</body>

</html>