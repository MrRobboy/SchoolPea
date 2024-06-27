function searchCourses() {
    var input, filter, courseList, courses, h3, i, txtValue;
    input = document.getElementById('search');
    filter = input.value.toUpperCase();
    courseList = document.getElementById('course_list');
    courses = courseList.getElementsByClassName('course_item');

    for (i = 0; i < courses.length; i++) {
        h3 = courses[i].getElementsByTagName('h3')[0];
        txtValue = h3.textContent || h3.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            courses[i].style.display = "";
        } else {
            courses[i].style.display = "none";
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('ajouter_section').addEventListener('click', function() {
        var sectionIndex = document.querySelectorAll('.section').length;
        var newSection = document.createElement('div');
        newSection.classList.add('section');
        newSection.innerHTML = `
            <label for="titre_section">Titre de la section :</label>
            <input type="text" name="section[${sectionIndex}][titre]" required><br>
            
            <div class="titres">
                <h4>Titres</h4>
                <div class="titre">
                    <label for="titre">Titre :</label>
                    <input type="text" name="section[${sectionIndex}][titre][0][titre]" required><br>
                    
                    <div class="paragraphes">
                        <h5>Paragraphes</h5>
                        <label for="paragraphe">Paragraphe :</label>
                        <textarea name="section[${sectionIndex}][titre][0][paragraphe][]" required></textarea><br>
                    </div>
                    <button type="button" class="ajouter_paragraphe">Ajouter un paragraphe</button>
                </div>
                <button type="button" class="ajouter_titre">Ajouter un titre</button>
            </div>
        `;
        document.getElementById('sections').appendChild(newSection);
    });
    
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('ajouter_titre')) {
            var section = e.target.closest('.section');
            var titreIndex = section.querySelectorAll('.titre').length;
            var newTitre = document.createElement('div');
            newTitre.classList.add('titre');
            newTitre.innerHTML = `
                <label for="titre">Titre :</label>
                <input type="text" name="section[${sectionIndex}][titre][${titreIndex}][titre]" required><br>
                
                <div class="paragraphes">
                    <h5>Paragraphes</h5>
                    <label for="paragraphe">Paragraphe :</label>
                    <textarea name="section[${sectionIndex}][titre][${titreIndex}][paragraphe][]" required></textarea><br>
                </div>
                <button type="button" class="ajouter_paragraphe">Ajouter un paragraphe</button>
            `;
            section.querySelector('.titres').appendChild(newTitre);
        } else if (e.target.classList.contains('ajouter_paragraphe')) {
            var titre = e.target.closest('.titre');
            var paragrapheIndex = titre.querySelectorAll('.paragraphes textarea').length;
            var newParagraphe = document.createElement('div');
            newParagraphe.innerHTML = `
                <label for="paragraphe">Paragraphe :</label>
                <textarea name="section[${sectionIndex}][titre][${titreIndex}][paragraphe][]" required></textarea><br>
            `;
            titre.querySelector('.paragraphes').appendChild(newParagraphe);
        }
    });
});
