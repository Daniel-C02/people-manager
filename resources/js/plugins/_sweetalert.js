import Swal from "sweetalert2";

// ------------------------------------------------------------------------------------

/*
 * Export a method to send out an alert from anywhere inside our javascript
 */
export function fireSweetalert(icon, title, html) {
    Swal.fire({
        title: title,
        icon: icon,
        html: html,
        showCloseButton: true,
        showCancelButton: false,
        showConfirmButton: false,
        focusConfirm: false,
    });
}
