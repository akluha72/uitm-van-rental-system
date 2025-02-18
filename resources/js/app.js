import './bootstrap';
import Alpine from 'alpinejs';
import $ from 'jquery'; // Import jQuery first
window.$ = window.jQuery = $; // Make jQuery available globally

import 'datatables.net'; // Import DataTables
import 'lightpick'; // Import Lightpick
import 'moment'; // Import Moment.js if needed
import moment from 'moment';
window.moment = moment;


import { closeModal } from './getVanDetail';
import { lightPickerInit } from './checkAvailability';
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
window.lightPickerInit = lightPickerInit;
Alpine.start();

// import { lightPickerInit } from './checkAvailability';





