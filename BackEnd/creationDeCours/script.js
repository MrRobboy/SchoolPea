document.addEventListener("DOMContentLoaded", function () {
    const courseForm = document.getElementById('courseForm');
    const previewTitle = document.getElementById('previewTitle');
    const previewDescription = document.getElementById('previewDescription');
    const previewInstructor = document.getElementById('previewInstructor');
    const previewDate = document.getElementById('previewDate');
    const previewImage = document.getElementById('previewImage');

    courseForm.addEventListener('input', function () {
        previewTitle.textContent = document.getElementById('courseTitle').value;
        previewDescription.textContent = document.getElementById('courseDescription').value;
        previewInstructor.textContent = document.getElementById('courseInstructor').value;
        previewDate.textContent = document.getElementById('courseDate').value;
    });

    document.getElementById('courseImage').addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                previewImage.src = e.target.result;
                previewImage.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });
});
