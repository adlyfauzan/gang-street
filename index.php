<?php
include 'config/database.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YANK MOB - Official Hub</title>
    <!-- Google Fonts Tebal & Modern -->
    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://googleapis.com/css2?family=Plus+Jakarta+Sans:wght@700;800&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <div class="main-layout">
        <!-- HEADER ATAS KLASIK POP -->
        <header class="top-header">
            <div class="header-left">≡ YANK MOB</div>
        </header>

        <div class="body-container">
            <!-- SIDEBAR NAVIGASI KIRI UTAMA -->
            <div class="sidebar">
                <?php include 'includes/sidebar.php'; ?>
            </div>

            <!-- AREA UTAMA PENAMPUNG KONTEN DINAMIS AJAX -->
            <div class="main-content">
                <div id="content-container" class="content-wrapper">
                    <!-- Seluruh halaman About, Members, dan Chat dimuat otomatis di dalam sini -->
                </div>
            </div>
            
        </div>
    </div>

    <!-- MASTER Interaktivitas Skrip Vanilla JavaScript -->
    <script src="assets/js/script.js"></script>
    
    <!-- AUTOMATED AUTO-LOAD TRIGGERS -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Memaksa AJAX memuat konten halaman 'about' pertama kali secara otomatis
            if (typeof loadContent === "function") {
                loadContent('about');
            }
        });
    </script>
</body>
</html>
