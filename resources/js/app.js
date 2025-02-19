import './bootstrap';
import Alpine from 'alpinejs';
import $ from 'jquery';
window.$ = window.jQuery = $;

import 'datatables.net';
import 'lightpick';
import 'moment';
import moment from 'moment';
window.moment = moment;


import { closeModal } from './getVanDetail';
import { getVanDetails } from './getVanDetail';
// import { checkDateAvailability } from './checkAvailability';
// import { dateValidator } from './checkAvailability';
import { pdfPreview } from './pdfPreview';

window.Alpine = Alpine;
window.closeModal = closeModal;
window.getVanDetails = getVanDetails;
// window.checkDateAvailability = checkDateAvailability;
// window.dateValidator = dateValidator;
window.pdfPreview = pdfPreview;

Alpine.start();
pdfPreview();




