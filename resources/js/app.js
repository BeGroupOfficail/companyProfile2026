import './bootstrap';

const userId = "{{ auth()->user()->id }}"; // current authenticated user id, from blade or API

window.Echo.private(`user.${userId}`)
    .listen('.ImportFinished', (e) => {
        alert('Import finished successfully!');
        // Or use nicer UI notification, e.g. Toast or SweetAlert
    });