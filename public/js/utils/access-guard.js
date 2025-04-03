document.addEventListener('DOMContentLoaded', () => {
    document.body.dataset.userType = window.USER_TYPE || 'guest';

    document.querySelectorAll('[data-check="student-only"]').forEach(link => {
        link.addEventListener('click', function (e) {
            const isStudent = document.body.dataset.userType === 'student';
            if (!isStudent) {
                e.preventDefault();
                alert('❌ Seuls les étudiants peuvent jouer aux quiz.');
            }
        });
    });
});
