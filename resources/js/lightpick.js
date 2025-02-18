import Lightpick from 'lightpick';

document.addEventListener("DOMContentLoaded", function () {
    const picker = new Lightpick({
        field: document.getElementById('datepicker'),
        singleDate: false, // Set to true for single date selection
        format: 'YYYY-MM-DD', // Adjust format if needed
        onSelect: function(start, end){
            console.log('Start Date: ' + start.format('YYYY-MM-DD'));
            console.log('End Date: ' + (end ? end.format('YYYY-MM-DD') : ''));
        }
    });
});
