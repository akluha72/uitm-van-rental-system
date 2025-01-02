export function dateValidator() {
    document.addEventListener("DOMContentLoaded", function () {
        const startDateInput = document.getElementById("startDate");
        const endDateInput = document.getElementById("endDate");
        const unavailableDates = ["2025-01-02", "2025-01-03"]; // Example unavailable dates

        // Function to check if a date is unavailable
        function isDateUnavailable(date) {
            return unavailableDates.includes(date);
        }

        // Start date validation
        startDateInput.addEventListener("change", function () {
            const selectedDate = startDateInput.value;
            if (isDateUnavailable(selectedDate)) {
                alert("The selected start date is unavailable.");
                startDateInput.value = ""; // Reset invalid selection
            }
        });

        // End date validation
        endDateInput.addEventListener("change", function () {
            const selectedDate = endDateInput.value;
            if (isDateUnavailable(selectedDate)) {
                alert("The selected end date is unavailable.");
                endDateInput.value = ""; // Reset invalid selection
            }
        });
    });
}



export async function checkDateAvailability(vanId, startDate, endDate) {
    try {
        const response = await fetch("/check-availability", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            },
            body: JSON.stringify({ van_id: vanId, start_date: startDate, end_date: endDate }),
        });

        const data = await response.json();

        if (data.available) {
            alert("The van is available for the selected dates.");
        } else {
            alert(data.message);
        }

        return data.available;
    } catch (error) {
        console.error("Error checking availability:", error);
        alert("An error occurred while checking availability. Please try again.");
        return false;
    }
}
