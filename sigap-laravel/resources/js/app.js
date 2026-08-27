import './bootstrap';
import Swal from 'sweetalert2';

window.Swal = Swal;

window.confirmAction = (message, confirmText = 'Ya, lanjutkan') => {
    return Swal.fire({
        title: 'Konfirmasi',
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: confirmText,
        cancelButtonText: 'Batal',
        confirmButtonColor: '#A5552E',
        cancelButtonColor: '#3D3226',
        background: '#FFFCF6',
        color: '#3D3226',
        customClass: { popup: 'rounded-xl' },
    }).then((result) => result.isConfirmed);
};

document.addEventListener('livewire:init', () => {
    Livewire.on('toast', ({ message, type }) => {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: type ?? 'success',
            title: message,
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    });
});
