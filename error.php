<?php
// Get the HTTP status code from various sources
$status_code = 404; // Default to 404

// Try to get the actual HTTP status code
if (isset($_SERVER['REDIRECT_STATUS'])) {
    $status_code = (int)$_SERVER['REDIRECT_STATUS'];
} elseif (isset($_GET['error'])) {
    $status_code = (int)$_GET['error'];
} elseif (function_exists('http_response_code')) {
    $current_code = http_response_code();
    if ($current_code && $current_code >= 400) {
        $status_code = $current_code;
    }
}

// Define error messages and titles
$error_messages = [
    400 => [
        'title' => 'Bad Request',
        'message' => 'Permintaan yang Anda kirim tidak valid atau tidak dapat diproses.',
        'animation_texts' => [
            'Oops...',
            'Permintaan tidak valid...',
            'Silakan periksa data yang Anda kirim.',
            'Mari kembali ke beranda.'
        ]
    ],
    401 => [
        'title' => 'Unauthorized',
        'message' => 'Anda perlu login untuk mengakses halaman ini.',
        'animation_texts' => [
            'Oops...',
            'Akses tidak diizinkan...',
            'Silakan login terlebih dahulu.',
            'Mari kembali ke beranda.'
        ]
    ],
    403 => [
        'title' => 'Forbidden',
        'message' => 'Anda tidak memiliki izin untuk mengakses halaman ini.',
        'animation_texts' => [
            'Oops...',
            'Akses ditolak...',
            'Halaman ini tidak dapat diakses.',
            'Mari kembali ke beranda.'
        ]
    ],
    404 => [
        'title' => 'Not Found',
        'message' => 'Halaman yang Anda cari tidak ditemukan atau telah dipindahkan.',
        'animation_texts' => [
            'Oops...',
            'Sepertinya terjadi kesalahan...',
            'Halaman tidak ditemukan.',
            'Silakan kembali ke beranda.'
        ]
    ],
    500 => [
        'title' => 'Server Error',
        'message' => 'Terjadi kesalahan pada server. Tim kami sedang menangani masalah ini.',
        'animation_texts' => [
            'Oops...',
            'Terjadi kesalahan server...',
            'Tim kami sedang memperbaikinya.',
            'Silakan kembali ke beranda.'
        ]
    ]
];

// Get current error info or default to 404
$current_error = $error_messages[$status_code] ?? $error_messages[404];
$animation_texts = json_encode($current_error['animation_texts']);

// Set appropriate HTTP status code
http_response_code($status_code);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error <?php echo $status_code; ?> - SpeakUp</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .glassmorphism {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            color: white;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .blur-circle {
            position: absolute;
            background: rgba(255, 255, 255, 0.15);
            filter: blur(100px);
            border-radius: 50%;
            animation: float 20s ease-in-out infinite;
            z-index: -1;
        }
        
        .blur-circle:nth-child(1) {
            width: 200px;
            height: 200px;
            top: 10%;
            left: 15%;
            animation-delay: 0s;
        }
        
        .blur-circle:nth-child(2) {
            width: 150px;
            height: 150px;
            top: 60%;
            right: 20%;
            animation-delay: -7s;
        }
        
        .blur-circle:nth-child(3) {
            width: 180px;
            height: 180px;
            bottom: 20%;
            left: 25%;
            animation-delay: -14s;
        }
        
        .blur-circle:nth-child(4) {
            width: 120px;
            height: 120px;
            top: 30%;
            right: 10%;
            animation-delay: -3s;
        }
        
        .blur-circle:nth-child(5) {
            width: 160px;
            height: 160px;
            bottom: 40%;
            right: 35%;
            animation-delay: -10s;
        }
        
        @keyframes float {
            0% { 
                transform: translateY(0) rotate(0deg) scale(1); 
                opacity: 0.7;
            }
            33% { 
                transform: translateY(-20px) rotate(120deg) scale(1.1); 
                opacity: 0.5;
            }
            66% { 
                transform: translateY(10px) rotate(240deg) scale(0.9); 
                opacity: 0.8;
            }
            100% { 
                transform: translateY(0) rotate(360deg) scale(1); 
                opacity: 0.7;
            }
        }
        
        .typing-animation {
            border-right: 2px solid rgba(255, 255, 255, 0.7);
            animation: blink 1s infinite;
            min-height: 1.5em;
            display: inline-block;
        }
        
        @keyframes blink {
            0%, 50% { border-color: rgba(255, 255, 255, 0.7); }
            51%, 100% { border-color: transparent; }
        }
        
        .fade-in {
            animation: fadeIn 0.8s ease-out;
        }
        
        .slide-up {
            animation: slideUp 1s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideUp {
            from { 
                opacity: 0; 
                transform: translateY(30px); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0); 
            }
        }
        
        .btn-hover {
            transition: all 0.3s ease;
            transform: translateY(0);
        }
        
        .btn-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }
        
        .error-code {
            font-size: 8rem;
            font-weight: 700;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.6));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            line-height: 1;
        }
        
        @media (max-width: 768px) {
            .error-code {
                font-size: 5rem;
            }
            
            .glassmorphism {
                padding: 1.5rem;
                margin: 1rem;
            }
        }
        
        @media (max-width: 480px) {
            .error-code {
                font-size: 4rem;
            }
            
            .glassmorphism {
                padding: 1rem;
                margin: 0.5rem;
            }
        }
    </style>
</head>
<body class="flex justify-center items-center min-h-screen bg-gradient-to-r from-blue-500 to-purple-500 overflow-hidden relative">
    <!-- Animated background blur circles -->
    <div class="blur-circle"></div>
    <div class="blur-circle"></div>
    <div class="blur-circle"></div>
    <div class="blur-circle"></div>
    <div class="blur-circle"></div>
    
    <!-- Main error container -->
    <div class="glassmorphism max-w-md w-full mx-4 fade-in">
        <!-- Error code -->
        <div class="error-code mb-6"><?php echo $status_code; ?></div>
        
        <!-- Error title -->
        <h1 class="text-3xl md:text-4xl font-bold mb-4 slide-up">
            <?php echo $current_error['title']; ?>
        </h1>
        
        <!-- Typing animation container -->
        <div class="mb-6 slide-up" style="animation-delay: 0.3s;">
            <p class="text-lg md:text-xl font-medium typing-animation" id="typingText"></p>
        </div>
        
        <!-- Error description -->
        <div class="mb-8 slide-up" style="animation-delay: 0.6s;">
            <p class="text-sm md:text-base opacity-90 leading-relaxed">
                <?php echo $current_error['message']; ?>
            </p>
        </div>
        
        <!-- Back to home button -->
        <div class="slide-up" style="animation-delay: 0.9s;">
            <a href="/speakup/index.php" 
               class="inline-block bg-white bg-opacity-20 hover:bg-opacity-30 
                      text-white font-semibold py-3 px-8 rounded-lg 
                      transition-all duration-300 backdrop-blur-sm 
                      border border-white border-opacity-30 btn-hover">
                <svg class="inline-block w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Beranda
            </a>
        </div>
        
        <!-- SpeakUp branding -->
        <div class="mt-8 slide-up" style="animation-delay: 1.2s;">
            <p class="text-xs opacity-60">SpeakUp Forum Diskusi</p>
        </div>
    </div>

    <script>
        // Typing animation script
        const animationTexts = <?php echo $animation_texts; ?>;
        const typingElement = document.getElementById('typingText');
        let currentTextIndex = 0;
        let currentCharIndex = 0;
        let isDeleting = false;
        let typingSpeed = 100;
        let pauseTime = 2000;

        function typeAnimation() {
            const currentText = animationTexts[currentTextIndex];
            
            if (isDeleting) {
                typingElement.textContent = currentText.substring(0, currentCharIndex - 1);
                currentCharIndex--;
                typingSpeed = 50;
            } else {
                typingElement.textContent = currentText.substring(0, currentCharIndex + 1);
                currentCharIndex++;
                typingSpeed = 100;
            }

            if (!isDeleting && currentCharIndex === currentText.length) {
                // Pause at end of text
                setTimeout(() => {
                    isDeleting = true;
                    typeAnimation();
                }, pauseTime);
                return;
            } else if (isDeleting && currentCharIndex === 0) {
                isDeleting = false;
                currentTextIndex = (currentTextIndex + 1) % animationTexts.length;
                setTimeout(typeAnimation, 500);
                return;
            }

            setTimeout(typeAnimation, typingSpeed);
        }

        // Start typing animation after page load
        window.addEventListener('load', () => {
            setTimeout(() => {
                typeAnimation();
            }, 1000);
        });

        // Add smooth scrolling and fade effects for mobile
        if (window.innerWidth <= 768) {
            document.body.style.minHeight = '100vh';
            document.body.style.overflow = 'auto';
            
            // Add intersection observer for scroll animations
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, {
                threshold: 0.1
            });

            // Observe elements for scroll animations
            document.querySelectorAll('.slide-up').forEach(el => {
                observer.observe(el);
            });
        }

        // Preload optimization
        window.addEventListener('load', () => {
            // Remove any loading states
            document.body.classList.add('loaded');
        });

        // Add keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                const homeButton = document.querySelector('a[href="/speakup/index.php"]');
                if (homeButton) {
                    homeButton.click();
                }
            }
        });
    </script>
</body>
</html>
