import {fireSweetalert} from "../plugins/_sweetalert.js";

export const init = () => {
    /*
     * Listens for the Livewire "$this->dispatch('close-modals');"
     * event to close all open modals on a page
     */
    Livewire.on('close-modals', () => {
        // Hide ALL Bootstrap modals
        document.querySelectorAll('.modal.show').forEach(modalEl => {
            const modalInstance = bootstrap.Modal.getInstance(modalEl)
                ?? new bootstrap.Modal(modalEl);
            modalInstance.hide();
        });
    });

    /*
     * Listens for the Livewire "$this->dispatch('dispatch-sweetalert');"
     * event to display sweetalert with the required data values
     */
    Livewire.on('dispatch-sweetalert', (event) => {

        const eventTitle = event[0].title;
        const eventIcon = event[0].icon;
        const eventMessage = event[0].message;

        fireSweetalert(
            eventIcon, // icon
            eventTitle, // title
            eventMessage // html
        );
    });
    window.dispatchEvent(new Event('livewire-sweetalert-registered'));
}
