document.addEventListener("DOMContentLoaded", function () {
    const texts = [
        "Selamat datang di SpeakUp!",
        "Selamat berbincang dan mengobrol bersama!",
        "Selamat berdiskusi bersama!",
        "Temukan komunitas dengan minat yang sama!",
        "Bergabunglah dan mulai diskusi baru!"
    ];
    
    let index = 0;
    let charIndex = 0;
    const speed = 100;
    const eraseSpeed = 50;
    const delayBetween = 2000;
    const animatedText = document.getElementById("animated-text");
    const notification = document.querySelector(".notif-popup");
    const notifIcon = document.getElementById("notifIcon");

    function typeEffect() {
        if (charIndex < texts[index].length) {
            animatedText.textContent += texts[index].charAt(charIndex);
            charIndex++;
            setTimeout(typeEffect, speed);
        } else {
            setTimeout(eraseEffect, delayBetween);
        }
    }

    function eraseEffect() {
        if (charIndex > 0) {
            animatedText.textContent = texts[index].substring(0, charIndex - 1);
            charIndex--;
            setTimeout(eraseEffect, eraseSpeed);
        } else {
            index = (index + 1) % texts.length;
            setTimeout(typeEffect, speed);
        }
    }

    typeEffect();

    // Menampilkan notifikasi saat ikon diklik
    notifIcon.addEventListener("click", function (event) {
        notification.style.display = "block";
        event.stopPropagation(); // Mencegah event click ke body langsung menutup notifikasi
    });

    // Menutup notifikasi saat klik di luar
    document.addEventListener("click", function (event) {
        if (!notification.contains(event.target) && event.target !== notifIcon) {
            notification.style.display = "none";
        }
    });
});