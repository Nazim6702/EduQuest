document.addEventListener('DOMContentLoaded', () => {
    const validateButton = document.getElementById('validate-quiz-info');
    const quizSection = document.getElementById('question-builder');
    const addQuestionButton = document.getElementById('add-question');
    const questionsContainer = document.getElementById('questions-container');

    validateButton.addEventListener('click', () => {
        quizSection.style.display = 'block';
        validateButton.disabled = true;
    });

    addQuestionButton.addEventListener('click', () => {
        const currentIndex = questionsContainer.children.length;

        const questionDiv = document.createElement('div');
        questionDiv.classList.add('question-block');
        questionDiv.dataset.index = currentIndex;

        questionDiv.innerHTML = `
            <h3>Question #${currentIndex + 1}</h3>
            <input type="hidden" name="questions[${currentIndex}][debug]" value="q${currentIndex}" />

            <label>Texte :</label>
            <input type="text" name="questions[${currentIndex}][texte]" required />

            <label>Durée (s) :</label>
            <input type="number" name="questions[${currentIndex}][duration]" required />

            <label>Type :</label>
            <select name="questions[${currentIndex}][type]" class="question-type-select">
                <option value="">-- Choisir un type --</option>
                <option value="Open">Open</option>
                <option value="True/False">True/False</option>
                <option value="QCM">QCM</option>
            </select>

            <div class="answers-container"></div>

            <button type="button" class="remove-question" style="margin-top:10px; background:#c00; color:#fff;">
                Supprimer cette question
            </button>
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
                    <textarea name="questions[${currentIndex}][answers][0][texte]" required></textarea>
                    <input type="hidden" name="questions[${currentIndex}][answers][0][isCorrect]" value="true" />
                `;
            } else if (selectedType === 'True/False') {
                answersContainer.innerHTML = `
                    <label>La bonne réponse est :</label>
                    <select name="questions[${currentIndex}][correct]" id="question-${currentIndex}-correct" required>
                        <option value="true">Vrai</option>
                        <option value="false">Faux</option>
                    </select>

                    <input type="hidden" name="questions[${currentIndex}][answers][0][texte]" value="True" />
                    <input type="hidden" name="questions[${currentIndex}][answers][1][texte]" value="False" />

                    <input type="hidden" name="questions[${currentIndex}][answers][0][isCorrect]" id="q${currentIndex}-true-is-correct" value="false" />
                    <input type="hidden" name="questions[${currentIndex}][answers][1][isCorrect]" id="q${currentIndex}-false-is-correct" value="false" />
                `;
                const correctSelect = document.getElementById(`question-${currentIndex}-correct`);
                const trueInput = document.getElementById(`q${currentIndex}-true-is-correct`);
                const falseInput = document.getElementById(`q${currentIndex}-false-is-correct`);

                correctSelect.addEventListener('change', () => {
                    const value = correctSelect.value;
                    trueInput.value = (value === 'true').toString();
                    falseInput.value = (value === 'false').toString();
                });

                correctSelect.dispatchEvent(new Event('change'));
            } else if (selectedType === 'QCM') {
                let html = '';
                for (let i = 0; i < 4; i++) {
                    html += `
                    <div>
                        <label>Choix ${i + 1} :</label>
                        <input type="text" name="questions[${currentIndex}][answers][${i}][texte]" required />
                        <input type="radio" name="questions[${currentIndex}][answers][correctIndex]" value="${i}" required /> Bonne réponse ?
                        <input type="hidden" name="questions[${currentIndex}][answers][${i}][isCorrect]" value="false" />
                    </div>
                    `;
                }
                answersContainer.innerHTML = html;

                const radios = answersContainer.querySelectorAll(`input[type="radio"][name="questions[${currentIndex}][answers][correctIndex]"]`);
                radios.forEach(radio => {
                    radio.addEventListener('change', () => {
                        for (let i = 0; i < 4; i++) {
                            const hidden = answersContainer.querySelector(`input[name="questions[${currentIndex}][answers][${i}][isCorrect]"]`);
                            if (hidden) hidden.value = (i.toString() === radio.value).toString();
                        }
                    });
                });
            }
        });

        questionDiv.querySelector('.remove-question').addEventListener('click', () => {
            questionsContainer.removeChild(questionDiv);
        });
    });


    document.querySelector('form').addEventListener('submit', function (e) {
        const questionBlocks = document.querySelectorAll('.question-block');
        if (questionBlocks.length === 0) {
            e.preventDefault();
            alert("❌ Vous devez ajouter au moins une question pour créer le quiz.");
            return;
        }

        let hasValidQuestion = false;
        questionBlocks.forEach(q => {
            const texteInput = q.querySelector('input[name*="[texte]"]');
            const durationInput = q.querySelector('input[name*="[duration]"]');
            const typeSelect = q.querySelector('select[name*="[type]"]');

            if (
                texteInput && texteInput.value.trim() !== '' &&
                durationInput && durationInput.value.trim() !== '' &&
                typeSelect && typeSelect.value !== ''
            ) {
                hasValidQuestion = true;
            }
        });

        if (!hasValidQuestion) {
            e.preventDefault();
            alert("❌ Veuillez remplir au moins une question avant de valider.");
        }
    });
});
