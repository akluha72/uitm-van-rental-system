export function dateValidator() {
    document.addEventListener("DOMContentLoaded", function () {
        const costBreakdownElement = document.querySelector(".cost-breakdown"); // The container for cost breakdown
        const confirmBookingButton = document.querySelector("#confirmBookingButton");

        document.querySelector("#startDate").addEventListener("change", handleDateChange);
        document.querySelector("#endDate").addEventListener("change", handleDateChange);

        async function handleDateChange() {
            const startDate = document.querySelector("#startDate").value;
            const endDate = document.querySelector("#endDate").value;
            const vanId = document.querySelector("#vanId").value;

            if (startDate && endDate) {
                // Check availability
                const available = await checkDateAvailability(vanId, startDate, endDate);

                if (!available) {
                    confirmBookingButton.disabled = true;
                    costBreakdownElement.innerHTML = `<p class="text-red-500">The van is not available for the selected dates.</p>`;
                } else {
                    // confirmBookingButton.disabled = false;

                    // Calculate total cost
                    const totalCost = await calculateCost(vanId, startDate, endDate);
                    updateCostBreakdown(totalCost);
                }
            }
        }
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
                end_date: endDate,
            }),
        });

        const data = await response.json();
        const availabilityMessageElement = document.querySelector(".availability-message");

        if (data.available) {
            availabilityMessageElement.textContent = "The van is available for the selected dates.";
            availabilityMessageElement.classList.remove("text-red-500");
            availabilityMessageElement.classList.add("text-green-500");
        } else {
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

export async function fetchVanPrice(vanId) {
    try {
        const response = await fetch(`/get-van-price/${vanId}`, {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
            },
        });

        const data = await response.json();

        if (data.success) {
            return data.price; // Assuming the backend returns the price in `data.price`
        } else {
            console.error("Failed to fetch price:", data.message);
            return 0;
        }
    } catch (error) {
        console.error("Error fetching price:", error);
        return 0;
    }
}

export async function calculateCost(vanId, startDate, endDate) {
    try {
        const pricePerDay = await fetchVanPrice(vanId);

        // Calculate number of days between start and end dates
        const start = new Date(startDate);
        const end = new Date(endDate);
        const diffTime = Math.abs(end - start);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); // Convert to days

        // Calculate total cost
        return diffDays * pricePerDay;
    } catch (error) {
        console.error("Error calculating cost:", error);
        return 0;
    }
}

function updateCostBreakdown(totalCost) {
    // Calculate 10% deposit
    const deposit = totalCost * 0.1;

    // Update the Base Rental Fee
    const baseRentalFeeElement = document.querySelector("#baseRentalFee");
    if (baseRentalFeeElement) {
        baseRentalFeeElement.textContent = `RM ${totalCost.toFixed(2)}`;
    }

    // Update the Deposit
    const depositElement = document.querySelector("#deposit");
    if (depositElement) {
        depositElement.textContent = `RM ${deposit.toFixed(2)}`;
    }

    // Update the Total
    const totalElement = document.querySelector("#total");
    if (totalElement) {
        totalElement.textContent = `RM ${(totalCost + deposit).toFixed(2)}`;
    }
}

