// main.js

document.addEventListener('DOMContentLoaded', function() {
    // Sélectionne l'élément cliquable qui déclenche le menu (la zone "Mathis GUBIEN")
    const userInfo = document.querySelector('.user-info');
    // Sélectionne le menu déroulant lui-même
    const dropdownMenu = document.getElementById('userDropdown');

    // Vérifie que les éléments existent avant d'ajouter les écouteurs d'événements
    if (userInfo && dropdownMenu) {
        // Ajoute un écouteur d'événement au clic sur la zone utilisateur
        userInfo.addEventListener('click', function(event) {
            // Bascule la classe 'show' sur le menu déroulant
            // Si 'show' est présente, elle est retirée ; si elle est absente, elle est ajoutée.
            dropdownMenu.classList.toggle('show');

            // Empêche le clic de se propager au document (pour éviter de fermer immédiatement le menu)
            event.stopPropagation();
        });

        // Ajoute un écouteur d'événement au clic sur n'importe quelle partie du document
        document.addEventListener('click', function(event) {
            // Si le clic n'a PAS eu lieu à l'intérieur de 'userInfo'
            // ET si le 'dropdownMenu' est actuellement visible (a la classe 'show')
            if (!userInfo.contains(event.target) && dropdownMenu.classList.contains('show')) {
                // Alors, retire la classe 'show' pour masquer le menu
                dropdownMenu.classList.remove('show');
            }
        });
    }
});