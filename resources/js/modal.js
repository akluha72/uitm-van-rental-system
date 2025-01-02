const csrfToken = document.head.querySelector(
    'meta[name="csrf-token"]'
).content;



export function closeModal() {
    console.log("closeModal Triggered");
    document.getElementById('bookingModal').classList.add('hidden');
}


export function getVanDetails(vanId) {
    fetch("/booking-form", {
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
            openBookingModal(); // Show the modal
        })
        .catch((error) => {
            console.log("Error:", error);
        });
}

function openBookingModal(){
    document.getElementById('bookingModal').classList.remove('hidden');
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