function formatTime(seconds) {
    const m = Math.floor(seconds / 60).toString().padStart(2, '0');
    const s = (seconds % 60).toString().padStart(2, '0');
    return `${m}:${s}`;
}

let timeLeft = window.quizTimeLeft || 30;
let countdown = document.getElementById('countdown');
if (countdown) countdown.innerText = timeLeft;

let timer = setInterval(() => {
    timeLeft--;
    if (countdown) countdown.innerText = timeLeft;
    if (timeLeft <= 0) {
        clearInterval(timer);
        document.querySelector('form')?.submit();
    }
}, 1000);

let globalTimeLeft = window.globalRemaining || 0;
let globalCountdown = document.getElementById('global-countdown');
if (globalCountdown) globalCountdown.innerText = formatTime(globalTimeLeft);

let globalTimer = setInterval(() => {
    globalTimeLeft--;
    if (globalCountdown) globalCountdown.innerText = formatTime(globalTimeLeft);
    if (globalTimeLeft <= 0) {
        clearInterval(globalTimer);
        alert("Temps global écoulé !");
        window.location.href = window.quizResultsUrl || "/";
    }
}, 1000);
