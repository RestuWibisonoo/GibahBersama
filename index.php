<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpeakUp - Forum Diskusi Publik Modern</title>
    <meta name="description"
        content="Platform diskusi modern untuk developer, programmer, dan tech enthusiast. Berbagi ide, pengalaman, dan berkembang bersama komunitas coding Indonesia.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Custom CSS Variables */
        :root {
            --blur-opacity: 0.15;
            --glass-opacity: 0.2;
        }

        /* Font families */
        .font-mono {
            font-family: 'JetBrains Mono', 'Fira Code', 'Consolas', monospace;
        }

        .font-sans {
            font-family: 'Inter', system-ui, sans-serif;
        }

        /* Glassmorphism styles */
        .glassmorphism {
            background: rgba(255, 255, 255, var(--glass-opacity));
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .glassmorphism-light {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .glassmorphism-strong {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }

        /* Blur circle animations */
        .blur-circle {
            position: absolute;
            background: rgba(255, 255, 255, var(--blur-opacity));
            filter: blur(100px);
            border-radius: 50%;
            z-index: -1;
        }

        /* Custom animations */
        @keyframes float {
            0% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
            }

            100% {
                transform: translateY(0) rotate(360deg);
            }
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes blink {

            0%,
            50% {
                opacity: 1;
            }

            51%,
            100% {
                opacity: 0;
            }
        }

        .animate-float {
            animation: float 20s ease-in-out infinite;
        }

        .animate-float-delayed {
            animation: float 25s ease-in-out infinite 5s;
        }

        .animate-float-slow {
            animation: float 30s ease-in-out infinite 10s;
        }

        .animate-fade-up {
            animation: fadeUp 0.8s ease-out forwards;
        }

        .animate-slide-in {
            animation: slideIn 0.8s ease-out forwards;
        }

        .animate-blink {
            animation: blink 1s infinite;
        }

        .typing-cursor::after {
            content: '|';
            animation: blink 1s infinite;
            color: #06B6D4;
            font-weight: 300;
        }

        /* Scroll animations */
        .scroll-animate {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease-out;
        }

        .scroll-animate.animate {
            opacity: 1;
            transform: translateY(0);
        }

        /* Mobile optimizations */
        @media (max-width: 768px) {
            .glassmorphism {
                padding: 1.5rem;
            }

            .blur-circle {
                filter: blur(60px);
            }
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Custom gradient background */
        .gradient-bg {
            background: linear-gradient(135deg, #3B82F6 0%, #8B5CF6 100%);
            min-height: 100vh;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="relative min-h-screen overflow-x-hidden">
        <!-- Animated Background Blur Elements -->
        <div class="blur-circle w-64 h-64 top-10 left-10 animate-float"></div>
        <div class="blur-circle w-48 h-48 top-1/3 right-20 animate-float-delayed"></div>
        <div class="blur-circle w-32 h-32 bottom-20 left-1/4 animate-float-slow"></div>
        <div class="blur-circle w-56 h-56 bottom-10 right-10 animate-float"></div>
        <div class="blur-circle w-40 h-40 top-1/2 left-1/2 animate-float-delayed"></div>

        <div class="gradient-bg">
            <!-- Navbar -->
            <nav class="relative z-10 p-6">
                <div class="max-w-7xl mx-auto flex justify-between items-center">
                    <div class="flex items-center space-x-2">
                        <div
                            class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center glassmorphism-light">
                            <span class="text-white font-mono font-bold text-xl">&lt;/&gt;</span>
                        </div>
                        <span class="text-white font-bold text-2xl font-mono">SpeakUp</span>
                    </div>

                    <div class="hidden md:flex space-x-8">
                        <a href="#features" class="text-white hover:text-blue-200 transition-colors">Fitur</a>
                        <a href="#about" class="text-white hover:text-blue-200 transition-colors">Tentang</a>
                        <a href="#community" class="text-white hover:text-blue-200 transition-colors">Komunitas</a>
                    </div>
                    <button onclick="window.location.href='auth/login.php'"
                        class="glassmorphism-light px-6 py-2 text-white hover:bg-white hover:bg-opacity-30 transition-all duration-300">
                        Masuk
                    </button>
                    <button class="md:hidden text-white text-xl" onclick="toggleMobileMenu()">
                        ☰
                    </button>
                </div>

                <!-- Mobile menu -->
                <div id="mobileMenu" class="md:hidden glassmorphism mt-4 mx-6 hidden">
                    <div class="flex flex-col space-y-4 py-4">
                        <a href="#features" class="text-white hover:text-blue-200 transition-colors">Fitur</a>
                        <a href="#about" class="text-white hover:text-blue-200 transition-colors">Tentang</a>
                        <a href="#community" class="text-white hover:text-blue-200 transition-colors">Komunitas</a>
                    </div>
                </div>
            </nav>

            <!-- Hero Section -->
            <section class="relative z-10 flex flex-col justify-center items-center min-h-screen px-6 text-center">
                <div class="max-w-4xl mx-auto">

                    <!-- Main Illustration -->
                    <div class="mb-8 animate-fade-up">
                        <img src="assets/img/maincontent.png"
                            alt="Developers collaborating and discussing code"
                            class="rounded-xl shadow-2xl w-full max-w-md mx-auto glassmorphism p-4" />
                    </div>

                    <!-- Typing Animation Headline -->
                    <div class="mb-8">
                        <h1 class="text-4xl md:text-6xl font-bold text-white mb-4">
                            <span id="typingText" class="typing-cursor font-mono"></span>
                        </h1>
                        <p class="text-xl md:text-2xl text-blue-100 font-light">
                            Forum diskusi modern untuk developer Indonesia
                        </p>
                    </div>

                    <!-- CTA Section -->
                    <div class="glassmorphism p-8 max-w-2xl mx-auto mb-12">
                        <h2 class="text-2xl font-semibold text-white mb-4">
                            Bergabung dengan ribuan developer lainnya
                        </h2>
                        <p class="text-blue-100 mb-6">
                            Diskusikan kode, berbagi pengalaman, dan bangun koneksi dengan komunitas developer terbaik
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <button onclick="window.location.href='home/home.php'"
                                class="bg-white text-blue-600 px-8 py-4 rounded-xl font-semibold hover:bg-blue-50 transition-all duration-300 transform hover:scale-105">
                                🚀 Mulai Diskusi
                            </button>
                            <button
                                class="glassmorphism-light px-8 py-4 text-white hover:bg-white hover:bg-opacity-30 transition-all duration-300">
                                📖 Pelajari Lebih Lanjut
                            </button>
                        </div>
                    </div>

                </div>
            </section>

            <!-- Features Section -->
            <section id="features" class="relative z-10 py-20 px-6">
                <div class="max-w-6xl mx-auto">
                    <h2 class="text-4xl font-bold text-white text-center mb-16 scroll-animate">
                        Fitur <span class="font-mono text-blue-200">&lt;&gt;</span>
                    </h2>

                    <div class="grid md:grid-cols-3 gap-8">
                        <!-- Feature 1 -->
                        <div
                            class="glassmorphism p-8 text-center scroll-animate hover:bg-white hover:bg-opacity-30 transition-all duration-300">
                            <div
                                class="w-16 h-16 mx-auto mb-6 bg-blue-400 bg-opacity-30 rounded-full flex items-center justify-center">
                                <span class="text-3xl">💬</span>
                            </div>
                            <h3 class="text-xl font-semibold text-white mb-4 font-mono">Real-time Discussion</h3>
                            <p class="text-blue-100">
                                Diskusi langsung dengan banyak pengguna, berbagi ide, dan berbagai pengalaman secara langsung
                            </p>
                        </div>

                        <!-- Feature 2 -->
                        <div
                            class="glassmorphism p-8 text-center scroll-animate hover:bg-white hover:bg-opacity-30 transition-all duration-300">
                            <div
                                class="w-16 h-16 mx-auto mb-6 bg-purple-400 bg-opacity-30 rounded-full flex items-center justify-center">
                                <span class="text-3xl">🏆</span>
                            </div>
                            <h3 class="text-xl font-semibold text-white mb-4 font-mono">Reputation System</h3>
                            <p class="text-blue-100">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum ipsum possimus modi quo repellat, earum perferendis dicta, adipisci, vero quod sapiente eum laudantium ipsa maiores beatae minima fugiat distinctio iste.
                            </p>
                        </div>

                        <!-- Feature 3 -->
                        <div
                            class="glassmorphism p-8 text-center scroll-animate hover:bg-white hover:bg-opacity-30 transition-all duration-300">
                            <div
                                class="w-16 h-16 mx-auto mb-6 bg-green-400 bg-opacity-30 rounded-full flex items-center justify-center">
                                <span class="text-3xl">🌐</span>
                            </div>
                            <h3 class="text-xl font-semibold text-white mb-4 font-mono">Global Community</h3>
                            <p class="text-blue-100">
                                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Labore veniam rerum nostrum quos asperiores. Voluptatum reiciendis culpa, ipsum corrupti dolor excepturi expedita earum, consequatur inventore architecto commodi sunt nobis blanditiis!
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Community Stats Section -->
            <section id="community" class="relative z-10 py-20 px-6">
                <div class="max-w-4xl mx-auto glassmorphism p-12 text-center">
                    <h2 class="text-3xl font-bold text-white mb-12 scroll-animate">
                        <span class="font-mono">Sudah Terpercaya(</span>Segera Join<span class="font-mono">)</span>
                    </h2>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                        <div class="scroll-animate">
                            <div class="text-4xl font-bold text-blue-200 font-mono">10K+</div>
                            <div class="text-white mt-2">Active Users</div>
                        </div>
                        <div class="scroll-animate">
                            <div class="text-4xl font-bold text-purple-200 font-mono">50K+</div>
                            <div class="text-white mt-2">Discussions</div>
                        </div>
                        <div class="scroll-animate">
                            <div class="text-4xl font-bold text-blue-200 font-mono">100+</div>
                            <div class="text-white mt-2">Tech Topics</div>
                        </div>
                        <div class="scroll-animate">
                            <div class="text-4xl font-bold text-purple-200 font-mono">24/7</div>
                            <div class="text-white mt-2">Online Support</div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Footer -->
            <footer class="relative z-10 glassmorphism m-6 p-8">
                <div class="max-w-6xl mx-auto">
                    <div class="grid md:grid-cols-4 gap-8">
                        <div>
                            <div class="flex items-center space-x-2 mb-4">
                                <div class="w-8 h-8 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                                    <span class="text-white font-mono font-bold">&lt;/&gt;</span>
                                </div>
                                <span class="text-white font-bold text-xl font-mono">SpeakUp</span>
                            </div>
                            <p class="text-blue-100 text-sm">
                                Forum diskusi modern untuk developer Indonesia. Tempat berbagi, belajar, dan berkembang
                                bersama.
                            </p>
                        </div>

                        <div>
                            <h4 class="text-white font-semibold mb-4">Platform</h4>
                            <ul class="space-y-2 text-blue-100 text-sm">
                                <li><a href="#" class="hover:text-white transition-colors">Diskusi</a></li>
                                <li><a href="#" class="hover:text-white transition-colors">Q&A</a></li>
                                <li><a href="#" class="hover:text-white transition-colors">Code Review</a></li>
                                <li><a href="#" class="hover:text-white transition-colors">Showcase</a></li>
                            </ul>
                        </div>

                        <div>
                            <h4 class="text-white font-semibold mb-4">Community</h4>
                            <ul class="space-y-2 text-blue-100 text-sm">
                                <li><a href="#" class="hover:text-white transition-colors">Events</a></li>
                                <li><a href="#" class="hover:text-white transition-colors">Meetups</a></li>
                                <li><a href="#" class="hover:text-white transition-colors">Newsletter</a></li>
                                <li><a href="#" class="hover:text-white transition-colors">Blog</a></li>
                            </ul>
                        </div>

                        <div>
                            <h4 class="text-white font-semibold mb-4">Connect</h4>
                            <ul class="space-y-2 text-blue-100 text-sm">
                                <li><a href="#" class="hover:text-white transition-colors">Discord</a></li>
                                <li><a href="#" class="hover:text-white transition-colors">GitHub</a></li>
                                <li><a href="#" class="hover:text-white transition-colors">Twitter</a></li>
                                <li><a href="#" class="hover:text-white transition-colors">LinkedIn</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="border-t border-white border-opacity-20 mt-8 pt-8 text-center">
                        <p class="text-blue-100 text-sm font-mono">
                            © 2024 SpeakUp. Made with ❤️ for Indonesian developers.
                        </p>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script>
        // Typing animation
        const phrases = [
            "Ayo Diskusi Bersama",
            "Ayo Mulai Percakapan Anda Untuk Menambah Teman",
            "Ayo Ceritakan Pengalamanmu",
            "Ayo..."
        ];

        let currentPhrase = 0;
        let currentChar = 0;
        let isDeleting = false;
        const typingElement = document.getElementById('typingText');

        function typeText() {
            const text = phrases[currentPhrase];

            if (isDeleting) {
                typingElement.textContent = text.substring(0, currentChar - 1);
                currentChar--;
            } else {
                typingElement.textContent = text.substring(0, currentChar + 1);
                currentChar++;
            }

            let typeSpeed = isDeleting ? 50 : 100;

            if (!isDeleting && currentChar === text.length) {
                typeSpeed = 2000;
                isDeleting = true;
            } else if (isDeleting && currentChar === 0) {
                isDeleting = false;
                currentPhrase = (currentPhrase + 1) % phrases.length;
                typeSpeed = 500;
            }

            setTimeout(typeText, typeSpeed);
        }

        // Start typing animation
        typeText();

        // Mobile menu toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }

        // Scroll animations
        function handleScrollAnimations() {
            const elements = document.querySelectorAll('.scroll-animate');

            elements.forEach(element => {
                const elementTop = element.getBoundingClientRect().top;
                const elementVisible = 150;

                if (elementTop < window.innerHeight - elementVisible) {
                    element.classList.add('animate');
                }
            });
        }

        // Initialize scroll animations
        window.addEventListener('scroll', handleScrollAnimations);
        window.addEventListener('load', handleScrollAnimations);


        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                // Skip jika href hanya #
                if (href === '#') return;

                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>

</html>