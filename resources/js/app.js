import './bootstrap';
import Alpine from 'alpinejs';
import $ from 'jquery'; // Import jQuery first
window.$ = window.jQuery = $; // Make jQuery available globally

import 'datatables.net'; // Import DataTables
import 'lightpick'; // Import Lightpick
import 'moment'; // Import Moment.js if needed


import { closeModal } from './getVanDetail';
import { getVanDetails } from './getVanDetail';
import { checkDateAvailability } from './checkAvailability';
import { dateValidator } from './checkAvailability';
import { pdfPreview } from './pdfPreview';


// window.flatpickr = flatpickr;
window.Alpine = Alpine;
window.closeModal = closeModal;
window.getVanDetails = getVanDetails;
window.checkDateAvailability = checkDateAvailability;
window.dateValidator = dateValidator;
window.pdfPreview = pdfPreview;
Alpine.start();

import Lightpick from 'lightpick';
import moment from 'moment';
window.moment = moment;


document.addEventListener("DOMContentLoaded", function () {
    const modalContainer = document.querySelector(".date-input-and-availability-message");
    const picker = new Lightpick({
        field: document.getElementById('startDate'),
        secondField: document.getElementById('endDate'),
        singleDate: false, // Change to true for a single date picker
        format: 'YYYY-MM-DD', // Set date format
        numberOfMonths: 2,
        parentEl: modalContainer, // Ensure Lightpick is inside the modal
        onSelect: function(start, end) {
            console.log('Selected Start Date:', start ? start.format('YYYY-MM-DD') : '');
            console.log('Selected End Date:', end ? end.format('YYYY-MM-DD') : '');
        }
    });
});
