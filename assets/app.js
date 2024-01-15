/**
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */

//import FullCalendar from './fullcalendar-6.1.10/dist/index.global.min.js';
import './styles/app.css'

////////////////////////////// CALENDAR //////////////////////////////

document.addEventListener('DOMContentLoaded', async function() {
  if (document.getElementById('calendar')) {
    const calendar = document.getElementById('calendar')
    const dataEvents = await fetch(calendar.dataset.url).then(response => response.json());
    console.log(dataEvents);
    getCalendar(dataEvents);
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
      right: 'timeGridWeek,dayGridMonth'
    },
    firstDay: 1,
    businessHours: {
      // Jours ouvrés (lundi à vendredi)
      daysOfWeek: [1, 2, 3, 4, 5],
      startTime: '08:00', // Heure de début de la journée
      endTime: '18:00'   // Heure de fin de la journée
    },
    durationSlot: false,
    allDaySlot: true,

    views: {
      listWeek: {
        buttonText: 'List'
      }
      },

    eventColor: '#F0F4F8',
    eventBorderColor: '#E5E9ED',
    eventTextColor: '#424242',
    events: dataEvents,

    eventContent: function(arg) {
      return {
        html:
            arg.event.title + '<br>' +
            arg.event.extendedProps.subject.sbjName + '<br>' +
            arg.event.extendedProps.hour + '<br>' +
            arg.event.extendedProps.type.typName
      };
    }
  });
  calendar.render();
}


export default getCalendar;
