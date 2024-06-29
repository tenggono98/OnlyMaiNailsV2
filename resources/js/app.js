import './bootstrap';
import  'flowbite';
import flatpickr from "flatpickr";
import Swal from 'sweetalert2';
window.Swal = Swal;

// Listen for Livewire initialization
document.addEventListener('livewire:init', () => {
    Livewire.on('closeModal', (event) => {
        window.FlowbiteInstances.getInstance('Modal', event[0].id) ?.hide();
    });

    Livewire.on('googleRedirect', (event) => {
    //    Get event array name "Link" and redirect to open new tab
    if (event[0].link) {
        // Open the link in a new tab
        window.open(event[0].link, '_blank');
    } else if (event[0].error) {
        // Handle any errors
        alert(event[0].error);
    } else {
        // Handle unexpected cases
        alert('An unknown error occurred.');
    }
    });
});







