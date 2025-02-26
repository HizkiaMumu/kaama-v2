<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photobox - Camera</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body, html {
            width: 100%;
            height: 100%;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            background: black;
        }

        #camera-container {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100vw;
            height: 100vh;
            overflow: hidden;
        }

        video {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        #tap-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 36px;
            font-weight: bold;
            color: white;
            -webkit-text-stroke: 1px black;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% { transform: translate(-50%, -50%) scale(1); }
            50% { transform: translate(-50%, -50%) scale(1.1); }
            100% { transform: translate(-50%, -50%) scale(1); }
        }

        .captured-images {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            flex-direction: row;
            gap: 10px;
        }

        .captured-images img {
            width: 100px;
            height: auto;
            border-radius: 10px;
            border: 2px solid white;
        }

        #countdown {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 120px;
            font-weight: bold;
            color: white;
            -webkit-text-stroke: 2px black;
            opacity: 0;
        }

        #flash {
            position: absolute;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: white;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.1s ease-out;
            z-index: 10000 !important;
        }
        
        #next-button {
            background: white;
            color: black;
            padding: 15px 30px;
            font-size: 26px;
            border: none;
            border-radius: 255px;
            cursor: pointer;
            font-weight: 600;
            bottom: 210px;
            position: fixed;
            left: 50%;
            transform: translateX(-50%);
            text-decoration: none;
            display: none;
        }

        #preview-image{
            position: fixed;
            height: 100%;
            width: auto;
            top: 0px;
            left: 50%;
            transform: translateX(-50%);
        }

        #preview-container {
            display: none;
        }
    </style>
</head>
<body>
    <div id="camera-container">
        <video id="video" autoplay></video>
        <div id="tap-text">Tap to Start 👆 </div>
        <div class="captured-images" id="captured-images"></div>
        <div id="countdown"></div>
        <div id="flash"></div>

        <div id="preview-container">
            <img src="" id="preview-image">
        </div>
        
        <button id="next-button">Print & Download Hasil</button>
    </div>

    <script>
        const video = document.getElementById('video');
        const captureButton = document.getElementById('tap-text');
        const capturedImagesContainer = document.getElementById('captured-images');
        const countdownElement = document.getElementById('countdown');
        const flashElement = document.getElementById('flash');
        const nextButton = document.getElementById('next-button');
        const previewContainer = document.getElementById('preview-container');
        const previewImage = document.getElementById('preview-image');

        let capturedImages = [];

        navigator.mediaDevices.getUserMedia({ video: true })
            .then((stream) => {
                video.srcObject = stream;
            })
            .catch((err) => {
                console.error("Error accessing camera: ", err);
                alert("Permission to access the camera was denied.");
            });

        function captureImage(callback) {
            flashElement.style.opacity = '1';
            setTimeout(() => {
                flashElement.style.opacity = '0';
            }, 100);

            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            const imageData = canvas.toDataURL('image/png');
            
            const img = document.createElement('img');
            img.src = imageData;
            capturedImagesContainer.appendChild(img);

            capturedImages.push(imageData);
            
            // Show preview
            previewImage.src = imageData;
            previewContainer.style.display = 'block';
            
            setTimeout(() => {
                previewContainer.style.display = 'none';
                callback();
            }, 3000); // Show preview for 3 seconds
        }

        function startCountdown(callback) {
            captureButton.style.opacity = '0';
            let timer = 3;
            countdownElement.style.display = 'block';
            countdownElement.style.opacity = '1';
            countdownElement.innerText = timer;

            const countdownInterval = setInterval(() => {
                timer--;
                if (timer > 0) {
                    countdownElement.innerText = timer;
                } else {
                    clearInterval(countdownInterval);
                    countdownElement.style.opacity = '0';
                    setTimeout(() => {
                        countdownElement.style.display = 'none';
                    }, 500);
                    callback();
                }
            }, 1000);
        }

        function takeMultiplePhotos(times) {
            let count = 0;
            function takePhoto() {
                if (count < times) {
                    startCountdown(() => {
                        captureImage(() => {
                            count++;
                            if (count < times) {
                                setTimeout(takePhoto, 500); // Delay before next capture
                            } else {
                                captureButton.style.display = 'none';
                                nextButton.style.display = 'block';
                            }
                        });
                    });
                }
            }
            takePhoto();
        }

        captureButton.addEventListener('click', () => {
            takeMultiplePhotos(3);
        });

        nextButton.addEventListener('click', (event) => {
            event.preventDefault(); 

            fetch('/upload-images', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ images: capturedImages })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = '/preview';
                } else {
                    alert('Upload failed, please try again.');
                }
            })
            .catch(error => console.error('Error:', error));
        });

    </script>
</body>
</html>
