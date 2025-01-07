const csrfToken = document.head.querySelector(
    'meta[name="csrf-token"]'
).content;

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
            // Handle the response data (true or false)
            populateModal(data);
            getUnavailableDate(vanId);
            openBookingModal(); // Show the modal
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

// Function to populate the modal with data
function populateModal(data) {
    console.log(data.id);
    document.getElementById('modalTitle').innerText = `Book ${data.model}`;
    document.getElementById('modalModel').innerText = `Model: ${data.model}`;
    document.getElementById('modalCapacity').innerText = `Capacity: ${data.capacity} passengers`;
    document.getElementById('modalRate').innerText = `Rental Rate: RM${data.rental_rate} per day`;
    document.getElementById('modalLicense').innerText = `License Plate: ${data.license_plate}`;
    document.getElementById('vanId').value = `${data.id}`;
}


//to list out all the unavailable date intially. easier for the user to find a date. 
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
            console.log(data);
            // Handle the response data (true or false)
            populateUnavailableDate(data);
        })
        .catch((error) => {
            console.log("Error:", error);
        });
}

function populateUnavailableDate(dates) {
    // Get the container where the unavailable dates will be appended
    const container = document.querySelector(".unavailable-dates-list");

    // Clear any existing content (optional, to avoid duplicate entries)
    container.innerHTML = "";

    // Loop through each booking and create HTML elements for start and end dates
    dates.forEach((booking) => {
        // Create the list container
        const listDiv = document.createElement("div");
        listDiv.classList.add("list", "flex", "flex-row");

        // Create the start date element
        const startDateP = document.createElement("p");
        startDateP.classList.add("start-date" , "text-sm");
        startDateP.textContent = booking.start_date;

        // Create the separator
        const separator = document.createElement("p");
        separator.textContent = "->";
        separator.classList.add("mx-4");


        // Create the end date element
        const endDateP = document.createElement("p");
        endDateP.classList.add("end-date" , "text-sm");
        endDateP.textContent = booking.end_date;

        // Append the start date, separator, and end date to the list container
        listDiv.appendChild(startDateP);
        listDiv.appendChild(separator);
        listDiv.appendChild(endDateP);

        // Append the list container to the main container
        container.appendChild(listDiv);
    });
}