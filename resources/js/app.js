import './bootstrap';
import Alpine from 'alpinejs';

import { closeModal } from './modal';
import { getVanDetails } from './modal';
import { checkDateAvailability } from './checkAvailability';
import { dateValidator } from './checkAvailability';


// window.flatpickr = flatpickr;
window.Alpine = Alpine;
window.closeModal = closeModal;
window.getVanDetails = getVanDetails;
window.checkDateAvailability = checkDateAvailability;
window.dateValidator = dateValidator;
Alpine.start();