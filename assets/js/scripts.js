document.addEventListener('DOMContentLoaded', function () {
    // Référence aux éléments du DOM
    const fileInput = document.getElementById('files');
    const imagePreview = document.querySelector('article img');
    const form = document.querySelector('form');

    const buttonHidden = document.querySelector('#button-hidden');
    const hidden = document.querySelectorAll('.hidden');

    buttonHidden.addEventListener('click', (e) => {
        hidden.forEach(element => {
            element.classList.toggle('hidden');
        });
    });

    // Fonction pour prévisualiser l'image avant l'envoi
    function previewImage(file) {
        if (file) {
            // Vérifier si le fichier est une image
            if (!file.type.match('image/jpeg') && !file.type.match('image/jpg') && !file.type.match('image/png')) {
                alert('Veuillez sélectionner uniquement des images au format JPG, JPEG ou PNG.');
                fileInput.value = '';
                return;
            }
            // Vérifier la taille du fichier (1Mo = 1 000 000 octets)
            if (file.size > 1000000) {
                alert('La taille de l\'image ne doit pas dépasser 1Mo.');
                fileInput.value = '';
                return;
            }
            // Créer un objet URL pour l'aperçu
            const reader = new FileReader();
            reader.onload = function (e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    }
    // Écouteur d'événement pour le changement de fichier
    fileInput.addEventListener('change', function () {
        const file = this.files[0];
        previewImage(file);
    });
    // Ajout de la fonctionnalité de glisser-déposer
    const dropArea = document.querySelector('article');
    // Empêcher le comportement par défaut du navigateur
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
    });
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    // Ajouter une classe lors du survol
    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, highlight, false);
    });
    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, unhighlight, false);
    });
    function highlight() {
        dropArea.classList.add('highlight');
    }
    function unhighlight() {
        dropArea.classList.remove('highlight');
    }
    // Gérer le dépôt de fichier
    dropArea.addEventListener('drop', handleDrop, false);
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const file = dt.files[0];
        fileInput.files = dt.files; // Mettre à jour l'input file
        previewImage(file);
    }
    // Gérer le bouton de fermeture
    const closeButton = document.querySelector('.close-button');
    if (closeButton) {
        closeButton.addEventListener('click', function () {
            imagePreview.src = '';
            fileInput.value = '';
        });
    }
});
