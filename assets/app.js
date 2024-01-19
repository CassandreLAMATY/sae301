/**
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */

//import FullCalendar from './fullcalendar-6.1.10/dist/index.global.min.js';

////////////////////////////// CALENDAR //////////////////////////////
document.addEventListener('DOMContentLoaded', async function() {
  if (document.getElementById('main-list')) {
    const btnCalendar = document.querySelector('.btn-calendar');
    btnCalendar.addEventListener('click', function() {
      window.location.href = '/';
    });

    for (let i = 1; i <= 4; i++) {
      typeFilter(i);
    }
  }

  if (document.getElementById('calendar')) {
    const cookies = !!localStorage.getItem('cookies');

    if (!cookies) {
      const cookiesDiv = document.querySelector('.cookies');
      setTimeout(function() {
        cookiesDiv.style.display = 'flex';
        cookiesDiv.style.opacity = '1';
      }, 500);

      const btnCookies = document.querySelector('.btn-cookies');
      btnCookies.addEventListener('click', function() {
        localStorage.setItem('cookies', 'true');
        cookiesDiv.style.display = 'none';
        cookiesDiv.style.opacity = '0';
      });
    }

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
      innerDiv1.classList.add('btn-calendar');
      innerDiv1.classList.add('fc-button-active');

      const innerDiv2 = document.createElement('button');
      innerDiv2.innerHTML = '<i class="fa-solid fa-table-list"></i>';
      innerDiv2.classList.add('fc-button');
      innerDiv2.classList.add('fc-button-primary');
      innerDiv2.classList.add('btn-list');
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
      //retirer les évenements

      slideBtn.addEventListener('click', function() {
        for (let i = 1; i <= 4; i++) {
          const btnsTypes = document.querySelectorAll('.types button');
          const btnType = i - 1;
          const isPressed = localStorage.getItem('typeId[' + i + ']') !==
            null;
          btnsTypes[btnType].setAttribute('aria-pressed',
            isPressed ? 'false' : 'true');

          hideType(i, isPressed);
        }
      });

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
    divFilter.classList.add('filter-nav');

    divFilters.appendChild(divFilter);

    createFilter('types', 4);

    const btnTypes = document.querySelectorAll('.types button');
    btnTypes[0].innerHTML = 'Rendus';
    btnTypes[1].innerHTML = 'Examens';
    btnTypes[2].innerHTML = 'IUT';
    btnTypes[3].innerHTML = 'BDE';

    // FILTRER LES ÉVÉNEMENTS
    for (let i = 1; i <= 4; i++) {
      typeFilter(i);
    }

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

    //validatedFilter();

    //créer un input select
    const select = document.createElement('button');
    select.classList.add('fc-button');
    select.classList.add('fc-button-primary');

    select.innerHTML = 'Matières <i class="fa-solid fa-angle-down"></i>';

    subjectDiv.appendChild(select);

    const selectChoices = document.createElement('div');
    selectChoices.classList.add('subject-choices');

    subjectDiv.appendChild(selectChoices);

    selectChoices.innerHTML = dataSubject;

    getDetailsCard('event-card');
    getDetailsCard('item');

    const btnCalendar = document.querySelector('.btn-calendar');
    const btnList = document.querySelector('.btn-list');

    btnList.addEventListener('click', function() {
      window.location.href = '/list';
    });

    const btnWeek = document.querySelector('[title="Semaine"]');
    btnWeek.addEventListener('click', function() {
        if (btnWeek.getAttribute('aria-pressed') === 'true') {
          const hourList = document.querySelectorAll(
            '.fc-scrollgrid-section-body');
          hourList[1].style.display = 'none';
          const divider = document.querySelectorAll('.fc-scrollgrid-section');
          divider[2].style.display = 'none';
          const week = document.querySelectorAll('.fc-scroller-harness');
          week[1].style.height = '100%';
          const week2 = document.querySelectorAll('.fc-scroller');
          week2[1].style.height = '100%';
          const week3 = document.querySelector('.fc-daygrid-body');
          week3.style.height = '100%';
          const week4 = document.querySelector('.fc-scrollgrid-sync-table');
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
      eventDiv.classList.add('event-card');
      if(arg.event.extendedProps.validated == 0){
        eventDiv.classList.add('notvalidated');
      }

      eventDiv.innerHTML =
        arg.event.title + '<br>' +
        arg.event.extendedProps.subject.sbjName + '<br>' +
        arg.event.extendedProps.hour;

      eventDiv.setAttribute('card-id', arg.event.id );
      eventDiv.setAttribute('is-validated', arg.event.extendedProps.validated);
      eventDiv.setAttribute('type-id', arg.event.extendedProps.type.id );

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
      let eventId = this.getAttribute('card-id');
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
        console.log(document.getElementById('details'));

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

    filterBtn.setAttribute('aria-pressed', 'false');

    filterDiv.appendChild(filterBtn);
  }
}

function typeFilter(typeId) {

  const btnsTypes = document.querySelectorAll('.types button');
  const btnType = typeId - 1;

  const isPressed = localStorage.getItem('typeId[' + typeId + ']') !== null;

  btnsTypes[btnType].setAttribute('aria-pressed',
    isPressed ? 'false' : 'true');

  if (btnsTypes[btnType].getAttribute('aria-pressed') === 'true') {
    btnsTypes[btnType].classList.add('btn--active');
  } else {
    btnsTypes[btnType].classList.remove('btn--active');
  }

  hideType(typeId, isPressed);

  btnsTypes[btnType].addEventListener('click', function() {

    const isPressed = localStorage.getItem('typeId[' + typeId + ']') !== null;

    if (isPressed) {
      localStorage.removeItem('typeId[' + typeId + ']');
      this.setAttribute('aria-pressed', 'true');
      btnsTypes[btnType].classList.add('btn--active');
    } else {
      localStorage.setItem('typeId[' + typeId + ']', typeId);
      this.setAttribute('aria-pressed', 'false');
      btnsTypes[btnType].classList.remove('btn--active');
    }

    hideType(typeId, !isPressed);
  });
}

function hideType(typeId, isPressed) {
  const events = document.querySelectorAll('.fc-event-main');
  const eventsList = document.querySelectorAll('.item');

  if (isPressed) {
    events.forEach(event => {
      const eventCard = event.querySelector('.event-card')
      if (eventCard.getAttribute('type-id') == typeId) {
        event.parentNode.style.display = 'none';
      }
    });
    eventsList.forEach(eventList => {
      if (eventList.getAttribute('type-id') == typeId) {
        eventList.style.display = 'none';
      }
    });
  } else {
    events.forEach(event => {
      const eventCard = event.querySelector('.event-card')
      if (eventCard.getAttribute('type-id') == typeId) {
        event.parentNode.style.display = 'block';
      }
    });
    eventsList.forEach(eventList => {
      if (eventList.getAttribute('type-id') == typeId) {
        eventList.style.display = 'grid';
      }
    });
  }
}
