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

const seeButton = document.querySelectorAll('.see-button');

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

                const NnotifCards = dropdown.querySelectorAll('.new-notif');
                if (NnotifCards.length <= 0) {
                    if( tagNew ) {
                        tagNew.style.display = 'none';
                    }
                    noNotif.style.display = 'block';
                    notifDot.style.display = 'none';

                    if(separator) {
                        separator.style.display = 'none';
                    }

                    readNotif.classList.add('empty-notif-desactivated');
                    readNotif.classList.remove('empty-notif');
                }

                const OnotifCards = dropdown.querySelectorAll('.old-notif');
                if (OnotifCards.length <= 0) {
                    if(separator) {
                        separator.style.display = 'none';
                    }
                }

                if(NnotifCards.length <= 0 && OnotifCards.length <= 0) {
                    deleteAllButton.classList.add('delete-button-desactivated');
                    deleteAllButton.classList.remove('delete-all-button');
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
        const confirm = document.querySelector('.delete-confirm');
    
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
            notifDot.style.display = 'none';

            if( separator ) {
                separator.style.display = 'none';
                
                newNotif.forEach(card => {
                    separator.parentNode.insertBefore(card, separator.nextSibling);
                });
            }
    
            readNotif.classList.add('empty-notif-desactivated');
            readNotif.classList.remove('empty-notif');

            newNotif.forEach(card => {
                card.style.border = "none";
                card.style.boxShadow = "0 0 0 2px var(--secondary-gray--02)";
                card.querySelector('.see-button').classList.remove('see-button__active');
                card.classList.add('old-notif');
                card.classList.remove('new-notif');
            });
        })
        .catch(error => {
            console.error('Erreur lors de l\'opération, action annulée :', error);
        });
    });
}

if(seeButton) {
    seeButton.forEach(button => {
        button.addEventListener('click', () => {
            let eventId = button.getAttribute('card-id');
            const xhr = new XMLHttpRequest();
            xhr.open('GET', `/details?eventId=${eventId}`, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    document.getElementById('details').innerHTML = xhr.responseText;

                    let modal = document.getElementById('details');
                    modal.classList.add('details--openned');

                    let backBtn = document.getElementById('back');
                    if (backBtn) {
                        backBtn.addEventListener('click', function () {
                            modal.classList.remove('details--openned');
                        });
                    }

                    button.classList.remove('see-button__active');

                    let notifCard = button.parentElement.parentElement;
                    notifCard.style.border = "none";
                    notifCard.style.boxShadow = "0 0 0 2px var(--secondary-gray--02)";
                    notifCard.classList.add('old-notif');
                    notifCard.classList.remove('new-notif');

                    if( separator ) {                        
                        separator.parentNode.insertBefore(card, separator.nextSibling);
                    } else {
                        let separator = document.createElement('hr');
                        separator.classList.add('notif-separator');
                        newNotif.parentNode.insertBefore(separator, newNotif.nextSibling);
                    }

                    let NnotifCards = dropdown.querySelectorAll('.new-notif');

                    if (NnotifCards.length <= 0) {
                        tagNew.style.display = 'none';
                    }
                }
            }
            xhr.send();
        });
    });
}
