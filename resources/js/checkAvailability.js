// export async function fetchVanPrice(vanId) {
//     try {
//         const response = await fetch(`/get-van-price/${vanId}`, {
//             method: "GET",
//             headers: {
//                 "Content-Type": "application/json",
//             },
//         });

//         const data = await response.json();
//         return data.success ? data.price : 0;
//     } catch (error) {
//         console.error("Error fetching price:", error);
//         return 0;
//     }
// }

// export async function calculateCost(vanId, startDate, endDate) {
//     try {
//         const pricePerDay = await fetchVanPrice(vanId);
//         const start = new Date(startDate);
//         const end = new Date(endDate);

//         let diffDays = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
//         diffDays = Math.max(diffDays, 1);

//         return diffDays * pricePerDay;
//     } catch (error) {
//         console.error("Error calculating cost:", error);
//         return 0;
//     }
// }

// function updateCostBreakdown(totalCost) {
//     const deposit = totalCost * 0.1;

//     document.querySelector("#baseRentalFee").textContent = `RM ${totalCost.toFixed(2)}`;
//     document.querySelector("#deposit").textContent = `RM ${deposit.toFixed(2)}`;
//     document.querySelector("#total").textContent = `RM ${(totalCost + deposit).toFixed(2)}`;

//     const totalAmount = document.getElementById('totalAmount');
//     if (totalAmount) totalAmount.value = (totalCost + deposit).toFixed(2);
// }
