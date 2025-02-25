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

        #capture-button {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            width: 70px;
            height: 70px;
            background-color: white;
            border-radius: 50%;
            border: 5px solid rgba(255, 255, 255, 0.5);
            cursor: pointer;
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

        #next-button {
            display: none;
            position: fixed;
            bottom: 70px;
            left: 50%;
            transform: translateX(-50%);
            background: black;
            color: white;
            padding: 15px 30px;
            font-size: 20px;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div id="camera-container">
        <video id="video" autoplay></video>
        <button id="capture-button"></button>
        <div id="countdown"></div>
        <button id="next-button">Lanjutkan ke Preview</button>
    </div>

    <script>
        const video = document.getElementById('video');
        const captureButton = document.getElementById('capture-button');
        const countdownElement = document.getElementById('countdown');
        const nextButton = document.getElementById('next-button');

        let mediaRecorder;
        let recordedChunks = [];

        navigator.mediaDevices.getUserMedia({ video: true })
            .then((stream) => {
                video.srcObject = stream;
                mediaRecorder = new MediaRecorder(stream);
                mediaRecorder.ondataavailable = (event) => {
                    recordedChunks.push(event.data);
                };
                mediaRecorder.onstop = () => {
                    const videoBlob = new Blob(recordedChunks, { type: 'video/webm' });
                    const formData = new FormData();
                    formData.append('video', videoBlob, 'capture.webm');
                    
                    fetch('/upload-video', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            nextButton.style.display = 'block';
                            nextButton.addEventListener('click', () => {
                                window.location.href = '/preview';
                            });
                        } else {
                            alert('Upload failed, please try again.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
                    
                    recordedChunks = [];
                };
            })
            .catch((err) => {
                console.error("Error accessing camera: ", err);
                alert("Permission to access the camera was denied.");
            });

        function startCountdown(callback) {
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

        captureButton.addEventListener('click', () => {
            startCountdown(() => {
                mediaRecorder.start();
                setTimeout(() => {
                    mediaRecorder.stop();
                }, 5000); // Record for 5 seconds
            });
        });
    </script>
</body>
</html>
