/**
 * Carga de dependencias JS del proyecto: Vue, FullCalendar, etc.
 */
import '@fullcalendar/daygrid/main.css'; // CSS compatible con la versión 5.11.3

import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';

import Vue from 'vue'; // Importa Vue correctamente

// Si usas algún componente Vue (descomenta si es necesario)
// import ExampleComponent from './components/ExampleComponent.vue';

document.addEventListener('DOMContentLoaded', function () {
  const calendarEl = document.getElementById('calendar');

  if (calendarEl) {
    const calendar = new Calendar(calendarEl, {
      plugins: [dayGridPlugin, interactionPlugin],
      initialView: 'dayGridMonth',
      selectable: true,
      editable: true,
      events: '/work-schedule/events', // Ruta del controlador Laravel
      dateClick: function (info) {
        alert('Fecha seleccionada: ' + info.dateStr);
        // Aquí puedes abrir un modal
      },
    });

    calendar.render();
  }
});

// Inicialización de Vue si se usa en tu proyecto
const app = new Vue({
  el: '#app',
  // components: {
  //   ExampleComponent,
  // },
});
