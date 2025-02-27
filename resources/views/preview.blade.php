<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview & Download</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            background: #2F2F2F;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
        }

        .frame-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100vh;
            position: fixed;
        }

        .frame-image {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        #done-button {
            position: fixed;
            right: 30px;
            top: 30px;
            font-size: 28px;
            color: #fff;
            padding: 15px 30px;
            background: #02548B;
            color: #fff;
            border-radius: 255px;
            border: 0px;
            text-decoration: none;
        }

        .print-icon {
            position: fixed;
            right: 30px;
            bottom: 45px;
            width: 106px;
            height: 106px;
        }

        .photos-card {
            position: fixed;
            bottom: 21px;
            left: 21px;
            width: 178px;
            height: 178px;
            border: 1px solid #848484;
            background: rgba(165, 165, 165, 0.2); 
            font-size: 28px;
            font-weight: 500;
            color: #fff;
            
            /* Untuk pusatkan teks */
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .gif-card {
            position: fixed;
            bottom: 213px;
            left: 21px;
            width: 178px;
            height: 178px;
            border: 1px solid #848484;
            background: rgba(165, 165, 165, 0.2); 
            font-size: 28px;
            font-weight: 500;
            color: #fff;
            
            /* Untuk pusatkan teks */
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .live-card {
            position: fixed;
            bottom: 405px;
            left: 21px;
            width: 178px;
            height: 178px;
            border: 1px solid #848484;
            background: rgba(165, 165, 165, 0.2); 
            font-size: 28px;
            font-weight: 500;
            color: #fff;
            
            /* Untuk pusatkan teks */
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .qr-icon {
            width: 178px;
            height: 178px;
            position: fixed;
            bottom: 597px;
            left: 21px;
        }

        .scan-title {
            color: #fff;
            position: fixed;
            top: 100px;
            left: 210px;
            font-weight: 500;
        }

        .images {
            position: fixed;
            left: -100px;
            top: -100px;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .image1 {
            position: fixed;
            top: 10px;
            left: 390px;
            height: 230px;
            width: 230px;
        }

        .image2 {
            position: fixed;
            top: 10px;
            left: 660px;
            height: 230px;
            width: 230px;
        }

        .image3 {
            position: fixed;
            top: 240px;
            left: 390px;
            height: 230px;
            width: 230px;
        }

        .image4 {
            position: fixed;
            top: 240px;
            left: 660px;
            height: 230px;
            width: 230px;
        }

        .image5 {
            position: fixed;
            top: 470px;
            left: 390px;
            height: 230px;
            width: 230px;
        }

        .image6 {
            position: fixed;
            top: 470px;
            left: 660px;
            height: 230px;
            width: 230px;
        }

        #photos-image {
            position: fixed;
            bottom: 21px;
            left: 21px;
            width: 178px;
            height: 178px;
            background-image: url("{{ $capturedImages[0] }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            border: 1px solid #fff;
            z-index: -1000;
        }

        #live-image {
            position: fixed;
            bottom: 405px;
            left: 21px;
            width: 178px;
            height: 178px;
            background-image: url("{{ $capturedImages[0] }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            border: 1px solid #fff;
            z-index: -1000;
        }

        #gif-image {
            position: fixed;
            bottom: 213px;
            left: 21px;
            width: 178px;
            height: 178px;
            background-image: url("{{ $capturedImages[0] }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            border: 1px solid #fff;
            z-index: -1000;
        }

        #gif-images {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translateX(-50%) translateY(-50%);
            width: 500px;
            height: auto;
        }

        #gif-area {
            display: none;
        }

        #live-area {
            display: none;
        }

        .video {
            position: fixed;
            left: -100px;
            top: -100px;
            width: 230px;
            height: 230px;
            overflow: hidden;
        }

        .video video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .video1 {
            top: 10px;
            left: 390px;
        }

        .video2 {
            top: 10px;
            left: 660px;
        }

        .video3 {
            top: 240px;
            left: 390px;
        }

        .video4 {
            top: 240px;
            left: 660px;
        }

        .video5 {
            top: 470px;
            left: 390px;
        }

        .video6 {
            top: 470px;
            left: 660px;
        }


    </style>
</head>
<body>
    
    <div class="frame-area">
        @php
            $noImage = 0;
        @endphp

        @foreach($capturedImages as $image)
            @php
                $noImage = $noImage + 1;
            @endphp
            <div class="images image{{$noImage}}" style="background-image: url('{{ $image }}');"></div>
        @endforeach

        @foreach($capturedImages as $image)
            @php
                $noImage = $noImage + 1;
            @endphp
            <div class="images image{{$noImage}}" style="background-image: url('{{ $image }}');"></div>
        @endforeach


    </div>

    <div id="live-area">
        @php
            $no = 0;
            $noImage = 0;
        @endphp

        @foreach($capturedVideos as $video)
            @php
                $no = $no + 1;
            @endphp
            <div class="video video{{$no}}">
                <video autoplay loop muted>
                    <source src="{{ $video }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        @endforeach



        @foreach($capturedVideos as $video)
            @php
                $no = $no + 1;
            @endphp
            <div class="video video{{$no}}">
                <video autoplay loop muted>
                    <source src="{{ $video }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        @endforeach
    </div>
        

    <div class="frame-container">
        <img src="/assets/img/frame1.png" class="frame-image">
    </div>

    <section id="gif-area">
        <img src="" id="gif-images">
    </section>

    <a href="/" id="done-button">Done</a>

    <img src="/assets/img/print-icon.png" class="print-icon">

    <img src="/assets/img/qr-code.png" class="qr-icon">

    <p class="scan-title"><i class="fas fa-arrow-left"></i> Scan to Download</p>



    <div class="live-card">
        <div id="live-image"></div>
        Live Mode
    </div>

    <div class="gif-card">
        <div id="gif-image"></div>
        <img src="/assets/img/gif-icon.png" height="60px">
    </div>

    <div class="photos-card">
        <div id="photos-image"></div>
        Photos
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let images = [
                "{{ $capturedImages[0] }}",
                "{{ $capturedImages[1] }}",
                "{{ $capturedImages[2] }}"
            ];
            
            let index = 0;
            let gifElement = document.getElementById("gif-image");

            setInterval(() => {
                gifElement.style.backgroundImage = `url('${images[index]}')`;
                index = (index + 1) % images.length; // Loop kembali ke awal setelah mencapai gambar terakhir
            }, 500);
        });

        document.addEventListener("DOMContentLoaded", function () {
            let images = [
                "{{ $capturedImages[0] }}",
                "{{ $capturedImages[1] }}",
                "{{ $capturedImages[2] }}"
            ];
            
            let index = 0;
            let gifElement = document.getElementById("gif-image");
            let gifElement2 = document.getElementById("gif-images");

            setInterval(() => {
                gifElement.style.backgroundImage = `url('${images[index]}')`;
                gifElement2.src = images[index];
                index = (index + 1) % images.length; // Loop kembali ke awal setelah mencapai gambar terakhir
            }, 500);

            // Handle click events to toggle visibility
            const gifCard = document.querySelector(".gif-card");
            const photosCard = document.querySelector(".photos-card");
            const liveCard = document.querySelector(".live-card");
            const frameArea = document.querySelector(".frame-area");
            const frameContainer = document.querySelector(".frame-container");
            const gifArea = document.getElementById("gif-area");
            const liveArea = document.getElementById("live-area");

            gifCard.addEventListener("click", function () {
                frameArea.style.display = "none";
                liveArea.style.display = "none";
                frameContainer.style.display = "none";
                gifArea.style.display = "block";
            });

            photosCard.addEventListener("click", function () {
                gifArea.style.display = "none";
                liveArea.style.display = "none";
                frameArea.style.display = "block";
                frameContainer.style.display = "flex";
            });

            liveCard.addEventListener("click", function () {
                gifArea.style.display = "none";
                frameArea.style.display = "none";
                liveArea.style.display = "block";
                frameContainer.style.display = "flex";
            });
        });

    </script>
</body>
</html>