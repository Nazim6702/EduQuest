// public/js/create_quiz.js

document.addEventListener('DOMContentLoaded', () => {
    const validateButton = document.getElementById('validate-quiz-info');
    const quizSection = document.getElementById('question-builder');
    const addQuestionButton = document.getElementById('add-question');
    const questionsContainer = document.getElementById('questions-container');

    let questionIndex = 0;

    validateButton.addEventListener('click', () => {
        quizSection.style.display = 'block';
        validateButton.disabled = true;
    });

    addQuestionButton.addEventListener('click', () => {
        const questionDiv = document.createElement('div');
        questionDiv.classList.add('question-block');
        questionDiv.dataset.index = questionIndex;

        questionDiv.innerHTML = `
            <h3>Question #${questionIndex + 1}</h3>
            <label>Texte :</label>
            <input type="text" name="questions[${questionIndex}][texte]" required />

            <label>Durée (s) :</label>
            <input type="number" name="questions[${questionIndex}][duration]" required />

            <label>Type :</label>
            <select name="questions[${questionIndex}][type]" class="question-type-select">
                <option value="">-- Choisir un type --</option>
                <option value="Open">Ouverte</option>
                <option value="TRUE_FALSE">Vrai / Faux</option>
                <option value="QCM">QCM</option>
            </select>

            <div class="answers-container"></div>
        `;

        questionsContainer.appendChild(questionDiv);

        const typeSelect = questionDiv.querySelector('.question-type-select');
        const answersContainer = questionDiv.querySelector('.answers-container');

        typeSelect.addEventListener('change', () => {
            answersContainer.innerHTML = '';
            const selectedType = typeSelect.value;

            if (selectedType === 'Open') {
                answersContainer.innerHTML = `
                    <label>Réponse ouverte :</label>
                    <textarea name="questions[${questionIndex}][answers][0][texte]" required></textarea>
                    <input type="hidden" name="questions[${questionIndex}][answers][0][isCorrect]" value="true" />
                `;
            } else if (selectedType === 'TRUE_FALSE') {
                answersContainer.innerHTML = `
                    <label>La bonne réponse est :</label>
                    <select name="questions[${questionIndex}][correct]">
                        <option value="true">Vrai</option>
                        <option value="false">Faux</option>
                    </select>
                    <input type="hidden" name="questions[${questionIndex}][answers][0][texte]" value="True" />
                    <input type="hidden" name="questions[${questionIndex}][answers][1][texte]" value="False" />
                `;
            } else if (selectedType === 'QCM') {
                for (let i = 0; i < 4; i++) {
                    answersContainer.innerHTML += `
                        <div>
                            <label>Choix ${i + 1} :</label>
                            <input type="text" name="questions[${questionIndex}][answers][${i}][texte]" required />
                            <input type="radio" name="questions[${questionIndex}][correct]" value="${i}" required /> Bonne réponse ?
                        </div>
                    `;
                }
            }
        });

        questionIndex++;
    });
});