document.addEventListener("DOMContentLoaded", () => {
    const MAIN_IMG = document.getElementById("main-img")
    const IMG_CYCLE = ["main-img.png", "main-img2.jpg", "main-img3.jpg"]
    CycleImage();
    function CycleImage() {
        let i = 0;
        MAIN_IMG.src = "images/" + IMG_CYCLE[i];
        setInterval(function() {
            MAIN_IMG.style.animation = 'none';
            MAIN_IMG.offsetHeight;
            MAIN_IMG.style.animation = null;
            i++;
            if(i === IMG_CYCLE.length) {
                i = 0;
            }
            MAIN_IMG.src = "images/" + IMG_CYCLE[i];
        }, 8000);
    }

    function ShowImage(n) {
        MAIN_IMG.src = "images/" + IMG_CYCLE[i];
    }

})