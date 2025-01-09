export function dateValidator() {
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelector("#startDate").addEventListener("change", async function () {
            const startDate = document.querySelector("#startDate").value;
            const endDate = document.querySelector("#endDate").value;
            const vanId = document.querySelector("#vanId").value; 

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
            const vanId = document.querySelector("#vanId").value;

            if (endDate && startDate) {
                const available = await checkDateAvailability(vanId, endDate, startDate);

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
            body: JSON.stringify({
                van_id: vanId,
                start_date: startDate,
                end_date: endDate
            }),
        });

        const data = await response.json();
        console.log(data);

        const availabilityMessageElement = document.querySelector(".availability-message");

        if (data.available == true) {
            // Display available message
            availabilityMessageElement.textContent = "The van is available for the selected dates.";
            availabilityMessageElement.classList.remove("text-red-500");
            availabilityMessageElement.classList.add("text-green-500");
        } else {
            // Display not available message
            availabilityMessageElement.textContent = data.message || "The van is not available for the selected dates.";
            availabilityMessageElement.classList.remove("text-green-500");
            availabilityMessageElement.classList.add("text-red-500");
        }

        return data.available;
    } catch (error) {
        console.error("Error checking availability:", error);

        const availabilityMessageElement = document.querySelector(".availability-message");
        availabilityMessageElement.textContent = "An error occurred while checking availability. Please try again.";
        availabilityMessageElement.classList.remove("text-green-500");
        availabilityMessageElement.classList.add("text-red-500");

        return false;
    }
}
