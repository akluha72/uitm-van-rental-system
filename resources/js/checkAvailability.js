export function dateValidator() {
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelector("#startDate").addEventListener("change", async function () {
            const startDate = document.querySelector("#startDate").value;
            const endDate = document.querySelector("#endDate").value;
            const vanId = document.querySelector("#vanId").value; // Ensure this exists

            if (startDate && endDate) {
                const available = await checkDateAvailability(vanId, startDate, endDate);

                if (!available) {
                    document.querySelector("#confirmBookingButton").disabled = true;
                } else {
                    document.querySelector("#confirmBookingButton").disabled = false;
                }
            }
        });

        document.querySelector("#endDate").addEventListener("change", async function () {
            const startDate = document.querySelector("#startDate").value;
            const endDate = document.querySelector("#endDate").value;
            const vanId = document.querySelector("#vanId").value; // Ensure this exists

            if (startDate && endDate) {
                const available = await checkDateAvailability(vanId, startDate, endDate);

                if (!available) {
                    document.querySelector("#confirmBookingButton").disabled = true;
                } else {
                    document.querySelector("#confirmBookingButton").disabled = false;
                }
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
