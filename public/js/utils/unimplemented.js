document.querySelectorAll('a.coming-soon').forEach(link => {
    link.addEventListener('click', (e) => {
        e.preventDefault();
        alert("🚧 Cette fonctionnalité sera bientôt disponible !");
    });
});
