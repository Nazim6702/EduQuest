// Script js qui va générer des gifs aléatoires et des citataions aléatoire
// utile pour la page undone.html.twig, but : amadouer l'utilisateur pour qu'il pardonne le fait qu'on ai pas fini le site

const gifs = [
    "https://media.giphy.com/media/v1.Y2lkPTc5MGI3NjExYzhmbzRtdTNwNW5rYXZlN3E4bmx5NWx0YzUybWI1azljb2ZrZzQzOCZlcD12MV9naWZzX3NlYXJjaCZjdD1n/jpbnoe3UIa8TU8LM13/giphy.gif",
    "https://media.giphy.com/media/v1.Y2lkPTc5MGI3NjExZHRyaGV0YnlkYWcyaDdjZmJkcGltZm1tdmxqYjYxYjhkbDBpNXAzMiZlcD12MV9naWZzX3NlYXJjaCZjdD1n/3o7aD2saalBwwftBIY/giphy.gif",
    "https://media.giphy.com/media/v1.Y2lkPTc5MGI3NjExdDBjZ2s5bDk1OWFvYWk2eHM4am15OGxlbnFxOTc4d3Y5NW52NzUwcyZlcD12MV9naWZzX3NlYXJjaCZjdD1n/U3qYN8S0j3bpK/giphy.gif",
    "https://media.giphy.com/media/v1.Y2lkPTc5MGI3NjExdWRpbWlwbXRuNmlyeXllc3N0bXlpM2RtNm5nc2dyMHprM2d6ZWM1MCZlcD12MV9naWZzX3NlYXJjaCZjdD1n/QHE5gWI0QjqF2/giphy.gif",
    "https://media.giphy.com/media/v1.Y2lkPTc5MGI3NjExbGRiZmxmcXA2bTAyN2h4bzdwaHB1bDg2cnhobGl2eWJyaThudTRmYSZlcD12MV9naWZzX3NlYXJjaCZjdD1n/l0MYt5jPR6QX5pnqM/giphy.gif"
];

const quotes = [
    "« Même les meilleurs sites prennent le temps de grandir. » 🌱",
    "« Patience, jeune Padawan. Le contenu arrive. » ⚔️",
    "« Rome ne s’est pas codée en un jour. » 🏛️",
    "« Ce n’est pas un bug, c’est une surprise ! » 🐞",
    "« Qui code lentement, code sûrement. » 🐢"
];

const randomGif = gifs[Math.floor(Math.random() * gifs.length)];
const randomQuote = quotes[Math.floor(Math.random() * quotes.length)];

document.getElementById('wip-gif').src = randomGif;
document.getElementById('quote').innerText = randomQuote;