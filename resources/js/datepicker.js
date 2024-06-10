import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';



function refreshDatePicker(enabledDates ){
    const datepickerElements = document.querySelectorAll('.datepicker');

    if(enabledDates.length > 0){
        datepickerElements.forEach(element => {
            if (!element.airDatepickerInstance) {

                const datepickerInstance = flatpickr(element,{
                    inline:true,
                    onChange: function () {
                        const selectedDate = {date :element.value } ;
                        Livewire.dispatch('selectedDate', selectedDate);
                    },
                    enable: enabledDates

                });
                element.airDatepickerInstance = datepickerInstance;
            }
        });
    }else{
        datepickerElements.forEach(element => {
            if (!element.airDatepickerInstance) {

                const datepickerInstance = flatpickr(element,{
                    inline:true,
                    onChange: function () {
                        const selectedDate = {date :element.value } ;
                        Livewire.dispatch('selectedDate', selectedDate);
                    },

                });
                element.airDatepickerInstance = datepickerInstance;
            }
        });

    }

    // alert(enabledDates);


    // creates multiple instances

}

document.addEventListener('livewire:init', () => {
    Livewire.on('enabledDatesUpdated', (event) => {
        console.log(event[0]);
        const enabledDates = event[0];
        refreshDatePicker(enabledDates);

    });
 });

document.addEventListener('DOMContentLoaded', function () {



    refreshDatePicker([]);

});




