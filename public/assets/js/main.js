const slideBtn = document.getElementById("slideBtn");
const slideContainer = document.getElementById("slideContainer");
const slideProgress = document.getElementById("slideProgress");
const homePage = document.getElementById("homePage");
const paymentMethodPage = document.getElementById("paymentMethodPage");
const container = document.querySelector(".container");

let isSlid = false;

function startSlide(event) {
    const maxMove = slideContainer.offsetWidth - slideBtn.offsetWidth;
    let startX = event.type.includes("touch") ? event.touches[0].clientX : event.clientX;

    function onMove(event) {
        let clientX = event.type.includes("touch") ? event.touches[0].clientX : event.clientX;
        let newX = clientX - startX;
        if (newX < 0) newX = 0;
        if (newX > maxMove) newX = maxMove;
        slideBtn.style.transform = `translateX(${newX}px)`;
        slideProgress.style.width = `${(newX / maxMove) * 100}%`;

        if (newX === maxMove) {
            isSlid = true;
            setTimeout(transitionToPaymentPage, 500);
        }
    }

    function onEnd() {
        document.removeEventListener("mousemove", onMove);
        document.removeEventListener("mouseup", onEnd);
        document.removeEventListener("touchmove", onMove);
        document.removeEventListener("touchend", onEnd);

        if (!isSlid) {
            slideBtn.style.transform = "translateX(0px)";
            slideProgress.style.width = "0%";
        }
    }

    document.addEventListener("mousemove", onMove);
    document.addEventListener("mouseup", onEnd);
    document.addEventListener("touchmove", onMove);
    document.addEventListener("touchend", onEnd);
}

function transitionToPaymentPage() {
    container.classList.add("fadeOutContent");
    setTimeout(() => {
        container.style.display = "none";
        paymentMethodPage.classList.add("fadeIn");
    }, 500);
}

slideBtn.addEventListener("mousedown", startSlide);
slideBtn.addEventListener("touchstart", startSlide);

function showVoucherPage() {
    let paymentPage = document.getElementById("paymentMethodPage");
    let voucherPage = document.getElementById("voucherPage");

    paymentPage.classList.add("fadeOutContent");
    paymentPage.classList.remove("fadeIn");
    setTimeout(() => {
        voucherPage.classList.add("fadeIn");
        setTimeout(() => {
            voucherPage.style.opacity = "1";
        }, 50);
    }, 500);
}

function hideVoucherPage() {
    let paymentPage = document.getElementById("paymentMethodPage");
    let voucherPage = document.getElementById("voucherPage");

    voucherPage.style.opacity = "0";
    setTimeout(() => {
        voucherPage.style.display = "none";
        paymentPage.style.display = "block";
        setTimeout(() => {
            paymentPage.style.opacity = "1";
        }, 50);
    }, 500);
}

document.getElementById("voucher-card").addEventListener("click", showVoucherPage);
document.getElementById("backButton").addEventListener("click", hideVoucherPage);

let claimButton = document.querySelector(".voucher-claim-btn");
let voucherPage = document.getElementById("voucherPage");
let templatePage = document.getElementById("templatePage");

claimButton.addEventListener("click", function () {
    // Add fade-out class to voucherPage
    voucherPage.classList.add("fadeOutContent");

    // Remove fadeIn class from voucherPage
    voucherPage.classList.remove("fadeIn");

    // Wait for fade-out animation to complete before switching visibility
    setTimeout(() => {
        voucherPage.style.display = "none";
        templatePage.style.display = "block";

        // Add fadeIn class to templatePage
        templatePage.classList.add("fadeIn");
    }, 500); // Adjust time to match transition duration
});

const slider = document.getElementById("slider");
const prev = document.querySelector(".prev");
const next = document.querySelector(".next");

const scrollAmount = slider.clientWidth / 3;

next.addEventListener("click", () => {
    slider.scrollBy({ left: scrollAmount, behavior: "smooth" });
});

prev.addEventListener("click", () => {
    slider.scrollBy({ left: -scrollAmount, behavior: "smooth" });
});

const slides = document.querySelectorAll(".slide");

slides.forEach(slide => {
    slide.addEventListener("click", () => {
        // Hapus border dari semua slide
        slides.forEach(s => s.style.border = "none");
        // Tambahkan border ke slide yang dipilih
        slide.style.border = "3px solid #fff";
    });
});

document.getElementById("cashless-card").addEventListener("click", function() {
    alert("Server Error: Midtrans tidak merespon");
});
