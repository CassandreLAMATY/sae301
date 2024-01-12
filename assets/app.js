import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

////////////////////////////// CALENDAR//////////////////////////////
document.addEventListener('DOMContentLoaded', async function() {
  if (document.getElementById('calendar')) {
    const calendar = document.getElementById('calendar')
    const dataEvents = await fetch(calendar.dataset.url).then(response => response.json());
    console.log(dataEvents);
    getCalendar(dataEvents);
  }
});

function getCalendar(dataEvents) {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
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
      durationSlot: false,
      allDaySlot: true,
      slotMinTime: '00:00:00', // Plage horaire minimale (début)
      slotMaxTime: '00:00:00',
      events: dataEvents,
      views: {
        listWeek: {
          buttonText: 'List',
        },
      },
    });
    calendar.render();
}

export default getCalendar;
