const notif = document.querySelector('.notif');
const notifDot = document.querySelector('.notif-dot');
const dropdown = document.querySelector('.notif-dropdown');
const notifCards = document.querySelectorAll('.notif-card');
const newNotif = document.querySelectorAll('.new-notif');
const separator = document.querySelector('.notif-separator');
const deleteButton = document.querySelectorAll('.delete-button');
const tagNew = document.querySelector('.tag.new');
const hr = document.querySelector('.notif-separator');
const noNotif = document.querySelector('.notif-message');
const readNotif = document.querySelector('.empty-notif');

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
                    hr.style.display = 'none';
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
        }
    });
});

readNotif.addEventListener('click', () => {
    fetch('/notifications/markAllAsRead', {
        method: 'POST',
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Quelque chose s\'est mal passé...');
        }
        tagNew.style.display = 'none';
        hr.style.display = 'none';
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
    })
    .catch(error => {
        console.error('Erreur lors de l\'opération, action annulée :', error);
    });
});