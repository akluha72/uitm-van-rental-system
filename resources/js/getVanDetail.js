import Lightpick from 'lightpick';

const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
let unavailableDates = [];

// Function to fetch van details and open booking modal
export function getVanDetails(vanId) {
    fetch("/get-van-details", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
        },
        body: JSON.stringify({ vanId: vanId }),
    })
        .then(response => response.json())
        .then(data => {
            populateModal(data);
            getUnavailableDate(vanId); // Fetch unavailable dates
            openBookingModal();
        })
        .catch(error => console.log("Error:", error));
}

// Function to open modal
function openBookingModal() {
    document.getElementById('bookingModal').classList.remove('hidden');
}

// Function to close modal
export function closeModal() {
    console.log("closeModal Triggered");
    document.getElementById('bookingModal').classList.add('hidden');
}

// Function to populate modal with van details
function populateModal(data) {
    document.getElementById('modalTitle').innerText = `Book ${data.model}`;
    document.getElementById('modalModel').innerText = `Model: ${data.model}`;
    document.getElementById('modalCapacity').innerText = `Capacity: ${data.capacity} passengers`;
    document.getElementById('modalRate').innerText = `Rental Rate: RM${data.rental_rate} per day`;
    document.getElementById('modalLicense').innerText = `License Plate: ${data.license_plate}`;
    document.getElementById('vanId').value = data.id;
}

// Function to fetch unavailable dates and update the calendar
function getUnavailableDate(vanId) {
    fetch("/get-unavailable-dates", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
        },
        body: JSON.stringify({ vanId: vanId }),
    })
        .then(response => response.json())
        .then(data => {
            console.log("Raw Unavailable Dates:", data);
            unavailableDates = convertDateRangesToArray(data);
            console.log("Processed Unavailable Dates:", unavailableDates);
            initializeLightpick(vanId);
        })
        .catch(error => console.log("Error fetching unavailable dates:", error));
}

// Convert unavailable date ranges to individual dates
function convertDateRangesToArray(dateRanges) {
    let disabledDates = [];

    dateRanges.forEach(({ start_date, end_date }) => {
        let currentDate = new Date(start_date);
        let lastDate = new Date(end_date);

        while (currentDate <= lastDate) {
            disabledDates.push(formatDate(currentDate));
            currentDate.setDate(currentDate.getDate() + 1);
        }
    });

    return disabledDates;
}

// Format date as YYYY-MM-DD
function formatDate(date) {
    return date.toISOString().split('T')[0];
}

// Initialize Lightpick with disabled dates
let picker = null; // Global variable to store the Lightpick instance

function initializeLightpick(vanId) {
    const modalContainer = document.querySelector(".date-input-and-availability-message");

    if (!modalContainer) return;

    // ✅ Destroy existing Lightpick instance before creating a new one
    if (picker) {
        picker.destroy(); // Lightpick destroy method
        picker = null; // Reset the picker variable
    }

    // ✅ Create a new Lightpick instance
    picker = new Lightpick({
        field: document.getElementById('startDate'),
        secondField: document.getElementById('endDate'),
        singleDate: false,
        format: 'YYYY-MM-DD',
        numberOfMonths: 2,
        parentEl: modalContainer,
        disableDates: unavailableDates, // Ensure unavailable dates are updated
        onSelect: async function (start, end) {
            if (start && end) {
                console.log("vanID:", vanId);

                const startDate = start.format('YYYY-MM-DD');
                const endDate = end.format('YYYY-MM-DD');

                console.log("Selected Dates:", startDate, endDate);

                const totalCost = await calculateCost(vanId, startDate, endDate);
                updateCostBreakdown(totalCost);
            }
        }
    });
}


// Update cost breakdown in the UI
function updateCostBreakdown(totalCost) {
    if (isNaN(totalCost) || totalCost === undefined) {
        console.error("Invalid totalCost:", totalCost);
        totalCost = 0; // Default to 0 if invalid
    }

    const deposit = totalCost * 0.1;

    document.querySelector("#baseRentalFee").textContent = `RM ${totalCost.toFixed(2)}`;
    document.querySelector("#deposit").textContent = `RM ${deposit.toFixed(2)}`;
    document.querySelector("#total").textContent = `RM ${(totalCost + deposit).toFixed(2)}`;

    const totalAmount = document.getElementById('totalAmount');
    if (totalAmount) totalAmount.value = (totalCost + deposit).toFixed(2);
}


// Calculate rental cost
async function calculateCost(vanId, startDate, endDate) {
    console.log("vanID in calculateCost:", vanId);
    
    try {
        const pricePerDay = await fetchVanPrice(vanId);
        console.log("Price per day:", pricePerDay, typeof pricePerDay);

        if (isNaN(pricePerDay) || pricePerDay === undefined) {
            throw new Error("Invalid price per day received");
        }

        const start = new Date(startDate);
        const end = new Date(endDate);

        console.log("Start Date:", start, "End Date:", end);

        if (isNaN(start.getTime()) || isNaN(end.getTime())) {
            throw new Error("Invalid date format provided");
        }

        let diffDays = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
        diffDays = Math.max(diffDays, 1);

        console.log("Days Difference:", diffDays, typeof diffDays);

        const totalCost = diffDays * pricePerDay;
        console.log("Total Cost:", totalCost, typeof totalCost);

        return totalCost;
    } catch (error) {
        console.error("Error calculating cost:", error);
        return 0;
    }
}


// Fetch van rental price
async function fetchVanPrice(vanId) {
    console.log("Fetching price for vanId:", vanId);
    
    try {
        const response = await fetch(`/get-van-price/${vanId}`, {
            method: "GET",
            headers: { "Content-Type": "application/json" },
        });

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const data = await response.json();
        console.log("Fetched van price:", data.price);

        return parseFloat(data.price); // ✅ Ensure it's a number
    } catch (error) {
        console.error("Error fetching price:", error);
        return 0; 
    }
}

