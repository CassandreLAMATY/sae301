const deleteButton = document.querySelectorAll('.delete-button');

deleteButton.forEach(button => {
    let deleteButtonContent = button.querySelector('i');
    let notificationId = button.dataset.id;

    button.addEventListener('click', () => {
        if( deleteButtonContent.classList.contains('fa-trash-can') ) {
            deleteButtonContent.classList.remove('fa-trash-can');
            deleteButtonContent.classList.add('fa-circle-check');
        }

        if( deleteButtonContent.classList.contains('fa-circle-check') ) {
            fetch(`/notifications/delete/${ notificationId }`, {
                method: 'DELETE'
            }).then(res => {
                if( !res.ok ) {
                    throw new Error('Quelque chose s\'est mal passé...');
                }
            }).catch(error => {
                console.error('Erreur lors de l\'opération, action annulée :', error);
            });
        }
    });
});