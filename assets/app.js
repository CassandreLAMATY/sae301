import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.

import { Calendar } from './vendor/@fullcalendar/core/index.js';
import dayGridPlugin from './vendor/@fullcalendar/daygrid/index.js';
import timeGridPlugin from './vendor/@fullcalendar/timegrid/index.js';
import listPlugin from './vendor/@fullcalendar/list/index.js';
*/
import './styles/app.css'

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉')

document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
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
    slotMinTime: '00:00:00', // Plage horaire minimale (début)
    slotMaxTime: '00:00:00',
    events: [
      {
        title: 'Événement 1',
        start: '2024-01-10',
        end: '2024-01-12'
      },
      {
        title: 'Événement 2',
        start: '2024-01-15',
        end: '2024-01-17'
      }
    ],
    views: {
      listWeek: {
        buttonText: 'List'
      }
    }
  });
  calendar.render();
});
