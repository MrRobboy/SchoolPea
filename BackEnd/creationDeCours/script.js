document.addEventListener('DOMContentLoaded', function() {
    const previewFields = document.querySelectorAll('.preview-field');

    previewFields.forEach(field => {
        field.addEventListener('input', updatePreview);
    });

    const addButton = document.querySelector('button[type="button"]');
    if (addButton) {
        addButton.addEventListener('click', addSection);
    }

    const previewButton = document.querySelector('button[type="submit"]');
    if (previewButton) {
        previewButton.addEventListener('click', updatePreview);
    }
});

function updatePreview() {
    const previewContainer = document.getElementById('previewContent');
    previewContainer.innerHTML = '';

    // Récupérer les valeurs des champs du formulaire
    const courseName = document.getElementById('courseName').value;
    const courseLevel = document.getElementById('courseLevel').value;
    const coursePrice = document.getElementById('coursePrice').value;
    const courseCreator = document.getElementById('courseCreator').value;

    // Récupérer le contenu des sections
    const sections = document.querySelectorAll('.sections .form-group');
    const sectionsContent = [];

    sections.forEach((section, index) => {
        const sectionTitle = section.querySelector(`#sectionTitle${index + 1}`).value;
        const sectionContent = section.querySelector(`#sectionContent${index + 1}`).value;
        
        sectionsContent.push(`<div><strong>Section ${index + 1} - ${sectionTitle}</strong><br>${sectionContent}</div>`);
    });

    // Générer le HTML de la prévisualisation
    const previewHTML = `
        <h3>${courseName}</h3>
        <p><strong>Niveau:</strong> ${courseLevel}</p>
        <p><strong>Prix:</strong> ${coursePrice}</p>
        <p><strong>Créateur:</strong> ${courseCreator}</p>
        <div>${sectionsContent.join('<br>')}</div>
    `;

    // Afficher la prévisualisation
    previewContainer.innerHTML = previewHTML;
}

function addSection() {
    const sectionsContainer = document.getElementById('sections');
    const sectionIndex = sectionsContainer.querySelectorAll('.form-group').length + 1;

    // Créer le HTML pour une nouvelle section
    const sectionHTML = `
        <div class="form-group">
            <h3>Section ${sectionIndex}</h3>
            <label for="sectionTitle${sectionIndex}">Titre :</label>
            <input type="text" id="sectionTitle${sectionIndex}" name="sectionTitle[]" class="preview-field" required>
            <label for="sectionContent${sectionIndex}">Contenu :</label>
            <textarea id="sectionContent${sectionIndex}" name="sectionContent[]" rows="4" class="preview-field" required></textarea>
        </div>
    `;

    // Ajouter la nouvelle section à la fin de sectionsContainer
    sectionsContainer.insertAdjacentHTML('beforeend', sectionHTML);
}
