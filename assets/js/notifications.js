const notif = document.querySelector('.notif');
const notifDot = document.querySelector('.notif-dot');
const userCard = document.querySelector('.userCard');

const dropdown = document.querySelector('.notif-dropdown');
const notifCards = document.querySelectorAll('.notif-card');
const newNotif = document.querySelectorAll('.new-notif');

const separator = document.querySelector('.notif-separator');

const deleteAllButton = document.querySelector('.delete-all-button');
const deleteButton = document.querySelectorAll('.delete-button');

const tagNew = document.querySelector('.tag.new');
const noNotif = document.querySelector('.notif-message');
const readNotif = document.querySelector('.empty-notif');

userCard.addEventListener('mouseenter', () => {
    dropdown.style.opacity = '0';
    dropdown.style.pointerEvents = 'none';
});

notif.addEventListener('mouseenter', () => {
    dropdown.style.opacity = '1';
    dropdown.style.pointerEvents = 'unset';
});

notif.addEventListener('mouseleave', () => {
    dropdown.style.transitionDelay = '0s';
    dropdown.style.opacity = '0';
    dropdown.style.pointerEvents = 'none';
});

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

                const DnotifCards = dropdown.querySelectorAll('.notif-card');
                if (DnotifCards.length <= 0) {
                    tagNew.style.display = 'none';
                    separator.style.display = 'none';
                    noNotif.style.display = 'block';
                    notifDot.style.display = 'none';
                }
            }).catch(error => {
                console.error('Erreur lors de l\'opération, action annulée :', error);
            });
        }

        if( deleteButtonContent.classList.contains('fa-trash-can') ) {
            deleteButtonContent.classList.remove('fa-trash-can');
            deleteButtonContent.classList.add('fa-circle-check');

            const confirm = button.parentElement.querySelector('.delete-confirm')
            confirm.style.display = 'block';
        }
    });
});

if(deleteAllButton) {
    deleteAllButton.addEventListener('click', () => {
        let deleteButtonContent = deleteAllButton.querySelector('i');
        const confirm = deleteAllButton.parentElement.querySelector('.delete-confirm');
    
        if( deleteButtonContent.classList.contains('fa-circle-check') ) {
            fetch('/notifications/deleteAll', {
                method: 'DELETE'
            }).then(res => {
                if( !res.ok ) {
                    throw new Error('Quelque chose s\'est mal passé...');
                }
                notifCards.forEach(card => {
                    card.remove();
                });
                tagNew.style.display = 'none';
                noNotif.style.display = 'block';
                notifDot.style.display = 'none';
                confirm.style.display = 'none';
                if(separator) {
                    separator.style.display = 'none';
                }
    
                deleteButtonContent.classList.remove('fa-circle-check');
                deleteButtonContent.classList.add('fa-trash-can');
    
                deleteAllButton.classList.add('delete-button-desactivated');
                deleteAllButton.classList.remove('delete-all-button');
                
                readNotif.classList.add('empty-notif-desactivated');
                readNotif.classList.remove('empty-notif');
            }).catch(error => {
                console.error('Erreur lors de l\'opération, action annulée :', error);
            });
        }
    
        if( deleteButtonContent.classList.contains('fa-trash-can') ) {
            deleteButtonContent.classList.remove('fa-trash-can');
            deleteButtonContent.classList.add('fa-circle-check');
    
            confirm.style.display = 'block';
        }
    });
}

if ( readNotif ) {
    readNotif.addEventListener('click', () => {
        fetch('/notifications/markAllAsRead', {
            method: 'POST',
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Quelque chose s\'est mal passé...');
            }
            tagNew.style.display = 'none';
            separator.style.display = 'none';
            notifDot.style.display = 'none';
            console.log(newNotif);
            newNotif.forEach(card => {
                separator.parentNode.insertBefore(card, separator.nextSibling);
    
                card.classList.remove('new-notif');
                card.classList.add('old-notif');
                card.style.border = "none";
                card.style.boxShadow = "0 0 0 2px var(--secondary-gray--02)";
                card.querySelector('.see-button').classList.remove('see-button__active');
            });
    
            readNotif.classList.add('empty-notif-desactivated');
            readNotif.classList.remove('empty-notif');
        })
        .catch(error => {
            console.error('Erreur lors de l\'opération, action annulée :', error);
        });
    });
}