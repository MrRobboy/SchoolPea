document.addEventListener("DOMContentLoaded", function() {
    const courseForm = document.getElementById('courseForm');
    const courseImage = document.getElementById('courseImage');
    const imagePreview = document.getElementById('imagePreview');

    // Prévisualisation de l'image
    courseImage.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            imagePreview.src = '';
            imagePreview.style.display = 'none';
        }
    });

    // Validation du formulaire
    courseForm.addEventListener('submit', function(event) {
        const nom = document.getElementById('nom').value;
        const niveau = document.getElementById('niveau').value;
        const prix = document.getElementById('prix').value;

        if (!nom) {
            alert('Le nom du cours est requis.');
            event.preventDefault();
            return;
        }

        if (!niveau) {
            alert('Le niveau du cours est requis.');
            event.preventDefault();
            return;
        }

        if (prix < 0) {
            alert('Le prix du cours doit être un nombre positif.');
            event.preventDefault();
            return;
        }
    });
});
