<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=1280, height=800, initial-scale=1.0">
    <title>Kaama Photos</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <video class="background-video" autoplay loop muted>
        <source src="/assets/video/bg-gradient.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    
    <section id="homePage">
        <div class="container">
            <div class="logo"></div>
            <div class="slide-btn-container" id="slideContainer">
                <div class="slide-progress" id="slideProgress"></div>
                <p>Slide to Start</p>
                <div class="slide-btn" id="slideBtn"><span>&#8594;</span></div>
            </div>
        </div>
    </section>

    <section id="paymentMethodPage">

        <div id="cashless-card">
            <div class="icon-area">
                <img src="/assets/img/cashless-icon.png" id="cashless-icon">
            </div>
            <p class="payment-text">Cashless</p>
            <img src="/assets/img/arrow-right-icon.png" class="payment-arrow-icon">
        </div>

        <div id="voucher-card">
            <div class="icon-area">
                <img src="/assets/img/voucher-icon.png" id="voucher-icon">
            </div>
            <p class="payment-text">Use Voucher</p>
            <img src="/assets/img/arrow-right-icon.png" class="payment-arrow-icon">
        </div>

    </section>

    <section id="voucherPage" style="display: none; opacity: 0; transition: opacity 0.5s ease;">
        <div class="voucher-container">
            <button id="backButton" class="back-btn">&larr;</button>
            <h2 class="voucher-title">Tukar Voucher</h2>
            <div class="voucher-box">
                <!-- <p class="voucher-instruction">Masukkan kode voucher pada kolom di bawah ini</p> -->
                <input type="text" class="voucher-input" placeholder="Masukkan Kode Voucher">
                <button class="voucher-claim-btn">Klaim Voucher</button>
            </div>
            <!-- <div class="timer-box">
                <img src="/assets/img/timer-icon.png" class="timer-icon">
                <span id="voucherTimer">02:01</span>
            </div> -->
        </div>
    </section>

    <section id="templatePage" style="display: none; opacity: 0; transition: opacity 0.5s ease;">
        <button id="backButtonTemplate" class="back-btn">&larr;</button>
        <h2 class="frame-title">Pilih Frame</h2>

        <div class="slider-container">
            <button class="nav-btn prev">&#9665;</button>
            <div class="slider" id="slider">
                <div class="slide">
                    <img src="/assets/img/frame1.png" width="100%" height="auto">
                </div>
                <div class="slide">
                    <img src="/assets/img/frame1.png" width="100%" height="auto">
                </div>
                <div class="slide">
                    <img src="/assets/img/frame1.png" width="100%" height="auto">
                </div>
                <div class="slide">
                    <img src="/assets/img/frame1.png" width="100%" height="auto">
                </div>
                <div class="slide">
                    <img src="/assets/img/frame1.png" width="100%" height="auto">
                </div>
                <div class="slide">
                    <img src="/assets/img/frame1.png" width="100%" height="auto">
                </div>
            </div>
            <button class="nav-btn next">&#9655;</button>
        </div>

        <a href="/cam" id="select-frame-button">Click to Start</a>
    </section>

    
    <script src="/assets/js/main.js"></script>
</body>
</html>
