<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=1280, height=800, initial-scale=1.0">
    <title>Kaama Photos</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* Modal Style */
        .modal {
            display: none; /* Modal tidak ditampilkan secara default */
            position: fixed;
            z-index: 1; /* Posisikan modal di atas elemen lain */
            left: 0;
            top: 0;
            width: 100%; /* Lebar penuh */
            height: 100%; /* Tinggi penuh */
            background-color: rgba(0, 0, 0, 0.4); /* Latar belakang transparan gelap */
            overflow: auto; /* Scroll jika perlu */
            padding-top: 60px; /* Jarak dari atas */
        }

        .modal-content {
            background-color: #fff;
            margin: 5% auto; /* Posisikan modal di tengah */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Lebar modal 80% */
            max-width: 400px; /* Lebar maksimum modal */
            border-radius: 10px;
        }

        .close-btn {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            position: absolute;
            top: 10px;
            right: 20px;
        }

        .close-btn:hover,
        .close-btn:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-size: 16px;
        }

        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .submit-btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .submit-btn:hover {
            background-color: #45a049;
        }

        .submit-btn:focus {
            outline: none;
        }


    </style>
</head>
<body>
    <!-- <video class="background-video" autoplay loop muted>
        <source src="/assets/video/bg-gradient.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video> -->
    
    <section id="homePage">
        <div class="container">
            <div class="logo" id="logo"></div>
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
            <button id="voucherBackButton" class="back-btn" onclick="hideVoucherPage()">&larr;</button>
            <h2 class="voucher-title">Tukar Voucher</h2>
            <div class="voucher-box">
                <input type="text" class="voucher-input" placeholder="Masukkan Kode Voucher">
                <button class="voucher-claim-btn">Klaim Voucher</button>
            </div>
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

    <section id="cashlessPage" style="display: none;">
        <button id="backButtonCashless" class="back-btn">&larr;</button>
        <img src="/assets/img/cashless-title.png" height="53px" width="auto" id="cashless-title">
        <h1 class="cashless-subtitle">Pembayaran dicek secara otomatis</h1>

        <div id="snap-container"></div>
    </section>

    <!-- Modal Form -->
    <div id="eventModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close-btn" id="closeModal">&times;</span>
            <h2>Pilih Event</h2>
            <form id="eventForm">
                <label for="event-select">Pilih Event</label>
                <select id="event-select" name="event">
                    <option value="analogy">Analogy</option>
                    <option value="grand-city">Grand City</option>
                    <option value="the-wheat">The Wheat</option>
                </select>
                <button type="submit" class="submit-btn">Submit</button>
            </form>
        </div>
    </div>

    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-LxvW3HQoTRQ8rfC3"></script>
    <script src="/assets/js/main.js"></script>

    <script>
        // Modal functionality
        let clickCount = 0;
        const logo = document.getElementById('logo');
        const modal = document.getElementById('eventModal');
        const closeModal = document.getElementById('closeModal');

        // Event listener for logo clicks
        logo.addEventListener('click', () => {
            clickCount++;
            if (clickCount === 10) {
                modal.style.display = 'block';
                clickCount = 0; // Reset click count
            }
        });

        // Close modal when the user clicks on <span> (x)
        closeModal.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        // Close modal when user clicks outside of the modal
        window.addEventListener('click', (event) => {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });

        // Handle form submission (for example, log the selected event)
        document.getElementById('eventForm').addEventListener('submit', (e) => {
            e.preventDefault();
            const selectedEvent = document.getElementById('event-select').value;
            console.log('Selected Event:', selectedEvent);
            modal.style.display = 'none'; // Close modal after form submission
        });
    </script>
</body>
</html>
