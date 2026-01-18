import Echo from "laravel-echo";
import Reverb from "laravel-reverb";

import toastr from "toastr";
import "toastr/build/toastr.min.css";


console.log('code loaded: echo.js');
window.Echo.channel("sms-status")
    .listen(".SmsSending", (e) => {
        console.log(e);
        toastr.success(`Sending SMS to ${e.phone}...`);
    })
    .listen(".SmsSent", (e) => {
        toastr.success(`SMS sent to ${e.phone}`);
    })
    .listen(".SmsFailed", (e) => {
        toastr.success(`Failed to send SMS to ${e.phone}`);
    });
