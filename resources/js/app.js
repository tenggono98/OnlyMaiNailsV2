import './bootstrap';
import  'flowbite';
import flatpickr from "flatpickr";
import Swal from 'sweetalert2';
window.Swal = Swal;
import AOS from 'aos';
import 'aos/dist/aos.css';

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



// Phone number formatting
document.addEventListener('input', function(e) {
    if (e.target.classList.contains('phone-format')) {
        // Remove all non-digit characters
        let value = e.target.value.replace(/\D/g, '');

        // Limit to 10 digits maximum
        if (value.length > 10) {
            value = value.substring(0, 10);
        }

        e.target.value = value;
    }
});

// =====================
// Premium UX Interactions
// =====================
document.addEventListener('DOMContentLoaded', () => {
    // Check if we're on an admin page - if so, skip animations
    const isAdminPage = window.location.pathname.includes('/admin');
    
    // Initialize AOS only for user/guest pages
    if (!isAdminPage) {
        AOS.init({
            offset: 40,
            duration: 600,
            easing: 'ease-out-quart',
            once: true,
            mirror: false,
            disable: window.matchMedia('(prefers-reduced-motion: reduce)').matches,
        });

        // Ensure AOS re-initializes after Livewire DOM updates (prevents elements staying hidden)
        if (window.Livewire && window.AOS) {
            try {
                Livewire.hook('message.processed', () => AOS.refresh());
            } catch (e) {
                // no-op for Livewire v3 without this hook
            }
        }

        window.addEventListener('livewire:navigated', () => {
            if (window.AOS) {
                AOS.refreshHard();
            }
        });

        // Auto-apply AOS to direct children of content-flow (staggered)
        document.querySelectorAll('.content-flow').forEach((container) => {
            if (container.hasAttribute('data-aos-skip')) {
                return; // do not auto-apply in marked containers
            }
            Array.from(container.children).forEach((child, idx) => {
                if (!child.hasAttribute('data-aos')) {
                    child.setAttribute('data-aos', 'fade-up');
                    child.setAttribute('data-aos-delay', String(Math.min(idx * 60, 360)));
                }
            });
        });
    }

    // Sticky header subtle shadow on scroll
    const desktopNav = document.getElementById('nav-dekstop');
    const toggleShadow = () => {
        if (!desktopNav) return;
        if (window.scrollY > 2) {
            desktopNav.classList.add('shadow-md', 'backdrop-blur');
        } else {
            desktopNav.classList.remove('shadow-md', 'backdrop-blur');
        }
    };
    toggleShadow();
    window.addEventListener('scroll', toggleShadow, { passive: true });
});

// Auto-apply content reveal to children of content containers
// Removed: auto content-reveal and AOS animations
