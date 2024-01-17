/**
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */

//import FullCalendar from './fullcalendar-6.1.10/dist/index.global.min.js';
import './styles/app.css';

////////////////////////////// CALENDAR //////////////////////////////

document.addEventListener('DOMContentLoaded', async function() {
  if (document.getElementById('calendar')) {
    const dataSubject = await fetch('/subjects/data').
      then(response => response.json());

    const calendar = document.getElementById('calendar');
    const dataEvents = await fetch(calendar.dataset.url).
      then(response => response.json());

    getCalendar(dataEvents);

    const toolbarChunks = document.querySelectorAll('.fc-toolbar-chunk');

    if (toolbarChunks.length >= 3) {
      const firstToolbarChunk = toolbarChunks[0];
      const thirdToolbarChunk = toolbarChunks[2];

      const firstButtonGroup = firstToolbarChunk.querySelector(
        '.fc-button-group');

      const newDivDisplay = document.createElement('div');
      newDivDisplay.classList.add('fc-button-group');

      // Create two inner div elements
      const innerDiv1 = document.createElement('button');
      innerDiv1.innerHTML = '<i class="fa-regular fa-calendar"></i>';
      innerDiv1.classList.add('fc-button');
      innerDiv1.classList.add('fc-button-primary');
      innerDiv1.classList.add('calendar-view');

      const innerDiv2 = document.createElement('button');
      innerDiv2.innerHTML = '<i class="fa-solid fa-table-list"></i>';
      innerDiv2.classList.add('fc-button');
      innerDiv2.classList.add('fc-button-primary');
      innerDiv2.classList.add('list-view');

      newDivDisplay.appendChild(innerDiv1);
      newDivDisplay.appendChild(innerDiv2);

      firstToolbarChunk.appendChild(newDivDisplay);

      // METTRE LE BOUTON SLIDE MONTH À DROITE DU CALENDRIER ET A GAUCHE DE LA DIV
      if (firstButtonGroup) {
        firstToolbarChunk.removeChild(firstButtonGroup);

        thirdToolbarChunk.appendChild(firstButtonGroup);
      }

      let slideBtn = thirdToolbarChunk.querySelector('.fc-button-group');
      thirdToolbarChunk.removeChild(slideBtn);
      thirdToolbarChunk.appendChild(slideBtn);
       slideBtn = thirdToolbarChunk.querySelector('.fc-button-group');

      slideBtn.addEventListener('click', function() {
        const typeId = localStorage.getItem('typeId');
        console.log(typeId);
        hideElement(typeId, true);
      })

      // METTRE LE BOUTON TODAY À DROITE
      const todayBtn = firstToolbarChunk.querySelector('.fc-today-button');
      firstToolbarChunk.removeChild(todayBtn);
      firstToolbarChunk.appendChild(todayBtn);
    }

    // CRÉER LA DIV DE FILTRES
    const divFilters = document.createElement('div');
    divFilters.classList.add('filter');
    divFilters.classList.add('fc-header-toolbar');
    divFilters.classList.add('fc-toolbar');
    divFilters.classList.add('fc-toolbar-ltr');

    const secondChild = calendar.children[1];

    calendar.insertBefore(divFilters, secondChild);

    // Créer les boutons de filtres
    const divFilter = document.createElement('div');
    divFilter.classList.add('fc-toolbar-chunk');

    divFilters.appendChild(divFilter);

    createFilter('types', 4);

    const btnTypes = document.querySelectorAll('.types button');
    btnTypes[0].innerHTML = 'Rendus';
    btnTypes[1].innerHTML = 'Examens';
    btnTypes[2].innerHTML = 'IUT';
    btnTypes[3].innerHTML = 'BDE';

    createFilter('statusHomework', 1);

    const btnstatusHomework = document.querySelectorAll(
      '.statusHomework button');
    btnstatusHomework[0].innerHTML = '<i class="fa-regular fa-square-check"></i> Rendu';

    createFilter('statusEvent', 1);

    const btnstatusEvent = document.querySelectorAll('.statusEvent button');
    btnstatusEvent[0].innerHTML = '<i class="fa-regular fa-square-check"></i> Validés';

    const subjectDiv = document.createElement('div');
    subjectDiv.classList.add('fc-button-group');
    subjectDiv.classList.add('subject');

    divFilter.appendChild(subjectDiv);

    //créer un input select
    const select = document.createElement('select');
    select.classList.add('fc-button');
    select.classList.add('fc-button-primary');

    select.innerHTML = dataSubject;

    subjectDiv.appendChild(select);

    // FILTRER LES ÉVÉNEMENTS
    for (let i = 1; i <= 4; i++) {
      typeFilter(i);
    }

    getDetailsCard('fc-event-main');
    getDetailsCard('item');

    getGlobalView();

    const btnWeek = document.querySelector('[title="Semaine"]');
    btnWeek.addEventListener('click', function() {
        if (btnWeek.getAttribute('aria-pressed') === 'true') {
          const hourList = document.querySelectorAll('.fc-scrollgrid-section-body');
          hourList[1].style.display = 'none';
          const divider = document.querySelectorAll('.fc-scrollgrid-section');
          divider[2].style.display = 'none';
          const week= document.querySelectorAll('.fc-scroller-harness');
          week[1].style.height = '100%';
          const week2= document.querySelectorAll('.fc-scroller');
          week2[1].style.height = '100%';
          const week3= document.querySelector('.fc-daygrid-body');
          week3.style.height = '100%';
          const week4= document.querySelector('.fc-scrollgrid-sync-table');
          week4.style.height = '100%';
        }
      },
    );
  }
});

function getCalendar(dataEvents) {
  let calendarEl = document.getElementById('calendar');
  let calendar = new FullCalendar.Calendar(calendarEl, {
    locale: 'fr',
    initialView: 'dayGridMonth',
    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'timeGridWeek,dayGridMonth',
    },
    firstDay: 1,
    businessHours: {
      // Jours ouvrés (lundi à vendredi)
      daysOfWeek: [1, 2, 3, 4, 5],
      startTime: '08:00', // Heure de début de la journée
      endTime: '18:00',   // Heure de fin de la journée
    },
    allDaySlot: true,

    views: {
      listWeek: {
        buttonText: 'List',
      },
    },
    eventColor: 'transparent',
    eventBorderColor: '#E5E9ED',
    eventTextColor: '#424242',
    events: dataEvents,

    eventContent: function(arg) {
      const eventDiv = document.createElement('div');
      eventDiv.innerHTML =
        arg.event.title + '<br>' +
        arg.event.extendedProps.subject.sbjName + '<br>' +
        arg.event.extendedProps.hour + '<br> ' +
        '<p class="card-id">' + arg.event.id + '</p>' +
        '<p class="type-id">' + arg.event.extendedProps.type.id + '</p>';

      eventDiv.style.borderLeft = '5px solid ' +
        arg.event.extendedProps.type.typColor;
      eventDiv.style.backgroundColor = arg.event.extendedProps.type.typColor +
        '20';
      eventDiv.style.borderRadius = '3px';
      eventDiv.style.padding = '5px';
      eventDiv.style.textOverflow = 'ellipsis';
      eventDiv.style.overflow = 'hidden';
      eventDiv.style.cursor = 'pointer';
      return {domNodes: [eventDiv]};
    },
  });
  calendar.render();
}

function getDetailsCard(className) {
  let eventDiv = document.getElementsByClassName(className);
  for (let i = 0; i < eventDiv.length; i++) {
    eventDiv[i].addEventListener('click', function() {
      let eventId = this.querySelector('.card-id').innerHTML;
      fetch('/details', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({eventId: eventId}),
      }).then(async (response) => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        document.getElementById('details').innerHTML = await response.text();

        let modal = document.getElementById('details');
        modal.style.transform = 'translateX(-100%)';
        modal.style.transition = 'transform 0.5s ease-in-out';

        let backBtn = document.getElementById('back');
        if (backBtn) {
          backBtn.addEventListener('click', function() {
            modal.style.transform = 'translateX(0)';
          });
        }

      }).then(data => {
        console.log('Success:', data);
      }).catch(error => {
        console.error('Error:', error);
      });

    });
  }
}

function createFilter(className, nbFiltersOptions) {

  const filterDiv = document.createElement('div');
  filterDiv.classList.add('fc-button-group');
  filterDiv.classList.add(className);

  const divFilter = document.querySelector('.filter .fc-toolbar-chunk');
  divFilter.appendChild(filterDiv);

  for (let i = 0; i < nbFiltersOptions; i++) {
    const filterBtn = document.createElement('button');
    filterBtn.classList.add('fc-button');
    filterBtn.classList.add('fc-button-primary');

    filterBtn.setAttribute('aria-pressed', 'true');

    filterDiv.appendChild(filterBtn);
  }
}

function typeFilter(typeId) {
  const btnsTypes = document.querySelectorAll('.types button');
  const btnType = typeId - 1;

  //localStorage.getItem('typeId')

  btnsTypes[btnType].addEventListener('click', function() {
    console.log(btnType);
    localStorage.setItem('typeId', typeId);
    const isPressed = this.getAttribute('aria-pressed') === 'true'

    if (!isPressed) {
      this.setAttribute('aria-pressed', 'true');
    } else {
      this.setAttribute('aria-pressed', 'false');
    }

    hideElement(typeId, isPressed);
  });
}

function hideElement(typeId, isPressed) {
  const events = document.querySelectorAll('.fc-event-main');
  const eventsList = document.querySelectorAll('.item');
  if (isPressed) {
    events.forEach(event => {
      if (event.querySelector('.type-id').innerHTML == typeId) {
        event.parentNode.style.display = 'none';
      }
    });
    eventsList.forEach(eventList => {
      if (eventList.querySelector('.type-id').innerHTML == typeId) {
        eventList.style.display = 'none';
      }
    });
  } else {
    events.forEach(event => {
      if (event.querySelector('.type-id').innerHTML == typeId) {
        event.parentNode.style.display = 'block';
      }
    });
    eventsList.forEach(eventList => {
      if (eventList.querySelector('.type-id').innerHTML == typeId) {
        eventList.style.display = 'grid';
      }
    });
  }
}

function getGlobalView() {
  const listView = document.querySelector('.list-view');
  listView.addEventListener('click', async function() {
    try {
      const response = await fetch('/home-list');
      const htmlContent = await response.text();

      document.querySelector('main').innerHTML = htmlContent;
    } catch (error) {
      console.error('Erreur lors de la récupération du contenu détaillé :',
        error);
    }
  });
}
