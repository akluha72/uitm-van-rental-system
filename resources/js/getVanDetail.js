const csrfToken = document.head.querySelector(
    'meta[name="csrf-token"]'
).content;

let unavailableDates = []; // Global array to store unavailable dates

export function getVanDetails(vanId) {
    fetch("/get-van-details", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
        },
        body: JSON.stringify({
            vanId: vanId,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            populateModal(data);
            getUnavailableDate(vanId); // Fetch unavailable dates and update the calendar
            openBookingModal();
        })
        .catch((error) => {
            console.log("Error:", error);
        });
}

function openBookingModal() {
    document.getElementById('bookingModal').classList.remove('hidden');
}

export function closeModal() {
    console.log("closeModal Triggered");
    document.getElementById('bookingModal').classList.add('hidden');
}

function populateModal(data) {
    console.log(data.id);
    document.getElementById('modalTitle').innerText = `Book ${data.model}`;
    document.getElementById('modalModel').innerText = `Model: ${data.model}`;
    document.getElementById('modalCapacity').innerText = `Capacity: ${data.capacity} passengers`;
    document.getElementById('modalRate').innerText = `Rental Rate: RM${data.rental_rate} per day`;
    document.getElementById('modalLicense').innerText = `License Plate: ${data.license_plate}`;
    document.getElementById('vanId').value = `${data.id}`;
}

// Fetch unavailable dates and store them globally
function getUnavailableDate(vanId) {
    fetch("/get-unavailable-dates", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
        },
        body: JSON.stringify({
            vanId: vanId,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            console.log("Unavailable Dates:", data);
            unavailableDates = data; // Store unavailable dates globally
            populateUnavailableDate(data); // Populate the unavailable dates list
            initializeLightpick(); // Re-initialize Lightpick with unavailable dates
        })
        .catch((error) => {
            console.log("Error fetching unavailable dates:", error);
        });
}

import Lightpick from 'lightpick';

function initializeLightpick() {
    const modalContainer = document.querySelector(".date-input-and-availability-message");

    if (!modalContainer) return;

    const picker = new Lightpick({
        field: document.getElementById('startDate'),
        secondField: document.getElementById('endDate'),
        singleDate: false,
        format: 'YYYY-MM-DD',
        numberOfMonths: 2,
        parentEl: modalContainer,
        disableDates: unavailableDates, // Disable unavailable dates dynamically
        onSelect: function (start, end) {
            if (start && end) {
                dateValidator(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
            }
        }
    });
}

function setupDateChangeListeners() {
    const startDateInput = document.querySelector("#startDate");
    const endDateInput = document.querySelector("#endDate");

    if (startDateInput && endDateInput) {
        startDateInput.addEventListener("change", () => dateValidator(startDateInput.value, endDateInput.value));
        endDateInput.addEventListener("change", () => dateValidator(startDateInput.value, endDateInput.value));
    }
}

function populateUnavailableDate(dates) {
    const container = document.querySelector(".unavailable-dates-list");
    container.innerHTML = ""; // Clear existing entries

    dates.forEach((booking) => {
        const listDiv = document.createElement("div");
        listDiv.classList.add("list", "flex", "flex-row");

        const startDateP = document.createElement("p");
        startDateP.classList.add("start-date", "text-sm");
        startDateP.textContent = booking.start_date;

        const separator = document.createElement("p");
        separator.textContent = "->";
        separator.classList.add("mx-4");

        const endDateP = document.createElement("p");
        endDateP.classList.add("end-date", "text-sm");
        endDateP.textContent = booking.end_date;

        listDiv.appendChild(startDateP);
        listDiv.appendChild(separator);
        listDiv.appendChild(endDateP);
        container.appendChild(listDiv);
    });
}
