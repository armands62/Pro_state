document.addEventListener("DOMContentLoaded", () => {
    let seconds = 50;
    let countdown = document.getElementById('countdown');
    let alertWindow = document.getElementById('session-alert');
    let expireWindow = document.getElementById('session-expire');
    let sessionCountdown;

    updateSession(1200, 120);
    function updateSession(totalTime = 1200, timeToAlert = 120) {
        seconds = timeToAlert;
        countdown.textContent = seconds;
        setTimeout(sessionAlert, (totalTime - timeToAlert) * 1000)
    }
    function updateCountdown() {
        countdown.textContent = seconds;
        seconds--;
        if(seconds < 0) {
            clearInterval(sessionCountdown);
            sessionEnd();
        }
    }
    function sessionAlert() {
        alertWindow.style.display = 'block';
        sessionCountdown = setInterval(updateCountdown, 1000);
    }
    function sessionEnd() {
        alertWindow.style.display = 'none';
        expireWindow.style.display = 'block';
    }
});
