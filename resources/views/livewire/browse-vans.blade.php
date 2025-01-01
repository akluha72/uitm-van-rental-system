<div>
   
    

    <div class="a-day-picker">
        <input type="text" data-picker>
    </div>
</div>

<script>
    const initializeFlatpickr = () => {
        const startDateInput = document.getElementById('startDate');
        const endDateInput = document.getElementById('endDate');

        if (startDateInput && !startDateInput._flatpickr) {
            flatpickr(startDateInput, {
                dateFormat: "Y-m-d",
                minDate: "today",
            });
        }

        if (endDateInput && !endDateInput._flatpickr) {
            flatpickr(endDateInput, {
                dateFormat: "Y-m-d",
                minDate: "today",
            });
        }
    };
</script>


@script
    <script>
        // Initialize Flatpickr immediately on page load (if the modal is open by default)
        initializeFlatpickr();
    </script>
@endscript


@assets
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js" defer></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
@endassets

@script
    <script>
        new Pikaday({
            field: $wire.$el.querySelector('[data-picker]')
        });
    </script>
@endscript