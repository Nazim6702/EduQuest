const goodMessages = [
    "Bravo !",
    "Excellente réponse !",
    "Quel génie",
    "Je te tire mon chapeau",
    "Digne des plus grands"
];

const badMessages = [
    "Ouch... mauvaise réponse",
    "Paaas tout à fait ça...",
    "Essaie encore !",
    "Tu feras mieux à la prochaine",
    "Lâche pas les cours !"
];

const timeoutMessages = [
    "Le temps file... ⏳",
    "Trop tard",
    "Soit plus rapide la prochaine fois 🏃‍♂️",
    "Il faut cliquer sur le bouton hein",
    "Ça passe vite !"
];

const feedbackEl = document.getElementById('feedback-message');
let messages = [];

if (feedbackEl?.dataset.result === "true") {
    messages = goodMessages;
} else if (feedbackEl?.dataset.result === "false") {
    messages = badMessages;
} else {
    messages = timeoutMessages;
}

const randomMessage = messages[Math.floor(Math.random() * messages.length)];
if (feedbackEl) feedbackEl.innerText = randomMessage;
