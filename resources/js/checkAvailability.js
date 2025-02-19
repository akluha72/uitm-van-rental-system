

export async function dateValidator(startDate, endDate) {
    const costBreakdownElement = document.querySelector(".cost-breakdown");
    const confirmBookingButton = document.querySelector("#confirmBookingButton");
    const vanId = document.querySelector("#vanId")?.value;

    if (!vanId || !startDate || !endDate) {
        console.error("Missing required parameters.");
        return;
    }

    console.log("Validating dates:", startDate, endDate);

    // Check availability
    const available = await checkDateAvailability(vanId, startDate, endDate);

    if (!available) {
        confirmBookingButton.disabled = true;
        costBreakdownElement.innerHTML = `<p class="text-red-500">The van is not available for the selected dates.</p>`;
    } else {
        confirmBookingButton.disabled = false;
        // Calculate total cost
        const totalCost = await calculateCost(vanId, startDate, endDate);
        console.log(totalCost);
        updateCostBreakdown(totalCost);
    }
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
        return data.success ? data.price : 0;
    } catch (error) {
        console.error("Error fetching price:", error);
        return 0;
    }
}

export async function calculateCost(vanId, startDate, endDate) {
    try {
        const pricePerDay = await fetchVanPrice(vanId);
        const start = new Date(startDate);
        const end = new Date(endDate);

        let diffDays = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
        diffDays = Math.max(diffDays, 1);

        return diffDays * pricePerDay;
    } catch (error) {
        console.error("Error calculating cost:", error);
        return 0;
    }
}

function updateCostBreakdown(totalCost) {
    const deposit = totalCost * 0.1;

    document.querySelector("#baseRentalFee").textContent = `RM ${totalCost.toFixed(2)}`;
    document.querySelector("#deposit").textContent = `RM ${deposit.toFixed(2)}`;
    document.querySelector("#total").textContent = `RM ${(totalCost + deposit).toFixed(2)}`;

    const totalAmount = document.getElementById('totalAmount');
    if (totalAmount) totalAmount.value = (totalCost + deposit).toFixed(2);
}
