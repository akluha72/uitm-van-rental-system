import './bootstrap';

import Alpine from 'alpinejs';

import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.css";

import { closeModal } from './modal';
import { getVanDetails } from './modal';

// window.flatpickr = flatpickr;
window.Alpine = Alpine;
window.closeModal = closeModal;
window.getVanDetails = getVanDetails;

Alpine.start();
