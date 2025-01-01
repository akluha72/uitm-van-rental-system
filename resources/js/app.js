import './bootstrap';
import Alpine from 'alpinejs';

import { closeModal } from './modal';
import { getVanDetails } from './modal';


// window.flatpickr = flatpickr;
window.Alpine = Alpine;
window.closeModal = closeModal;
window.getVanDetails = getVanDetails;

Alpine.start();