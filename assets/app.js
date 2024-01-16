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
    console.log(dataSubject);

    const calendar = document.getElementById('calendar');
    const dataEvents = await fetch(calendar.dataset.url).
      then(response => response.json());

    getCalendar(dataEvents);

    const toolbarChunks = document.querySelectorAll('.fc-toolbar-chunk');

    if (toolbarChunks.length >= 3) {
      const thirdToolbarChunk = toolbarChunks[2];

      const newDivDisplay = document.createElement('div');
      newDivDisplay.classList.add('fc-button-group');

      // Create two inner div elements
      const innerDiv1 = document.createElement('button');
      innerDiv1.innerHTML = '<i class="fa-regular fa-calendar"></i>';
      innerDiv1.classList.add('fc-button');
      innerDiv1.classList.add('fc-button-primary');

      const innerDiv2 = document.createElement('button');
      innerDiv2.innerHTML = '<i class="fa-solid fa-table-list"></i>';
      innerDiv2.classList.add('fc-button');
      innerDiv2.classList.add('fc-button-primary');

      newDivDisplay.appendChild(innerDiv1);
      newDivDisplay.appendChild(innerDiv2);

      thirdToolbarChunk.appendChild(newDivDisplay);
    }

    // Créer la div pour les filtres
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
    btnTypes[1].innerHTML = 'Partiels';
    btnTypes[2].innerHTML = 'IUT';
    btnTypes[3].innerHTML = 'BDE';

    createFilter('statusHomework', 1);

    const btnstatusHomework = document.querySelectorAll('.statusHomework button');
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

    getDetailsCard('fc-event-main');
    getDetailsCard('item');
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
        '<p class="card_id">' + arg.event.id + '</p>';

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
      let eventId = this.querySelector('.card_id').innerHTML;
      console.log(eventId);
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

    filterDiv.appendChild(filterBtn);
  }
}

