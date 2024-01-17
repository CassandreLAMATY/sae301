const notif = document.querySelector('.notif');
const dropdown = document.querySelector('.notif-dropdown');
const deleteButton = document.querySelectorAll('.delete-button');

let timer;

dropdown.addEventListener('mouseenter', () => {
    clearTimeout(timer);
    dropdown.classList.add('dropdown-visible');
});

dropdown.addEventListener('mouseleave', () => {
    timer = setTimeout(() => {
        dropdown.style.transitionDelay = '1s';
        dropdown.classList.remove('dropdown-visible');
        setTimeout(() => {
            dropdown.style.transitionDelay = '0s';
        }, 1000);
    }, 1000);
});

deleteButton.forEach(button => {
    let deleteButtonContent = button.querySelector('i');
    let notificationId = button.dataset.id;

    button.addEventListener('click', () => {
        if( deleteButtonContent.classList.contains('fa-circle-check') ) {
            fetch(`/notifications/delete/${ notificationId }`, {
                method: 'DELETE'
            }).then(res => {
                if( !res.ok ) {
                    throw new Error('Quelque chose s\'est mal passé...');
                }
                button.parentElement.parentElement.remove();
            }).catch(error => {
                console.error('Erreur lors de l\'opération, action annulée :', error);
            });
        }

        if( deleteButtonContent.classList.contains('fa-trash-can') ) {
            deleteButtonContent.classList.remove('fa-trash-can');
            deleteButtonContent.classList.add('fa-circle-check');
        }
    });
});