let sectionCount = 1;

function addSection() {
    sectionCount++;
    const sectionsDiv = document.getElementById('sections');
    const sectionHTML = `
        <div class="form-group">
            <h3>Section ${sectionCount}</h3>
            <label for="sectionTitle${sectionCount}">Titre :</label>
            <input type="text" id="sectionTitle${sectionCount}" name="sectionTitle[]" required>
            <label for="sectionContent${sectionCount}">Contenu :</label>
            <textarea id="sectionContent${sectionCount}" name="sectionContent[]" rows="4" required></textarea>
        </div>
    `;
    sectionsDiv.insertAdjacentHTML('beforeend', sectionHTML);
}

document.getElementById('courseForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const formData = new FormData(event.target);

    const courseName = formData.get('nom');
    const courseLevel = formData.get('niveau');
    const coursePrice = formData.get('prix');
    const courseCreator = formData.get('createur');
    const sectionTitles = formData.getAll('sectionTitle[]');
    const sectionContents = formData.getAll('sectionContent[]');

    let courseContent = '<h2>Sommaire</h2><ul>';
    sectionTitles.forEach((title, index) => {
        courseContent += `<li><a href="#section${index + 1}">${title}</a></li>`;
    });
    courseContent += '</ul>';

    sectionTitles.forEach((title, index) => {
        courseContent += `<h2 id="section${index + 1}">${title}</h2>`;
        courseContent += `<p>${sectionContents[index]}</p>`;
    });

    const coursePreview = document.getElementById('coursePreview');
    coursePreview.innerHTML = `
        <h1>${courseName}</h1>
        <p><strong>Niveau :</strong> ${courseLevel}</p>
        <p><strong>Prix :</strong> ${coursePrice}€</p>
        <p><strong>Créateur :</strong> ${courseCreator}</p>
        ${courseContent}
    `;

    const reader = new FileReader();
    reader.onload = function(event) {
        coursePreview.innerHTML += `<img src="${event.target.result}" alt="Image du cours" style="max-width: 100%;">`;
    }
    reader.readAsDataURL(formData.get('courseImage'));

    // Ensuite, soumettre le formulaire réellement pour sauvegarder les données
    setTimeout(() => {
        event.target.submit
                event.target.submit();
    }, 1000); // Attendre 1 seconde pour que la prévisualisation se mette à jour
});

