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
      const calendar = document.getElementById('calendar');
      const dataEvents = await fetch(calendar.dataset.url).
        then(response => response.json());
      console.log(dataEvents);
      getCalendar(dataEvents);

      let eventDiv = document.getElementsByClassName('fc-event-main');
      for (let i = 0; i < eventDiv.length; i++) {
        eventDiv[i].addEventListener('click', function() {
          let eventId = this.querySelector('.card_id').innerHTML;
          console.log(eventId);
          fetch('/details', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify({ eventId: eventId }),
          })
          .then(async (response) =>  {
            if (!response.ok) {
              throw new Error('Network response was not ok');
            }
            document.getElementById('details').innerHTML = await response.text();
          })
          .then(data => {
            console.log('Success:', data);
          })
          .catch(error => {
            console.error('Error:', error);
          });
        });
      }
    }
  },
);

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

export default getCalendar;

