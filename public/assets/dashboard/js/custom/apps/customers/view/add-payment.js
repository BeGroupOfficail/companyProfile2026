"use strict";
var KTModalAddPayment = (function () {
    var modals = document.querySelectorAll(".custom_form"); // Select all modals

    return {
        init: function () {
            modals.forEach((modal) => {
                var modalInstance = new bootstrap.Modal(modal);
                var form = modal.querySelector(".btn_form");
                var submitBtn = form.querySelector(".btn_submit");
                var cancelBtn = form.querySelector(".btn_cancel");
                var closeBtn = modal.querySelector(".btn_close");

                var validation = FormValidation.formValidation(form, {
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: ".fv-row",
                            eleInvalidClass: "",
                            eleValidClass: "",
                        }),
                    },
                });

                $(form.querySelector('[name="status"]')).on(
                    "change",
                    function () {
                        validation.revalidateField("status");
                    }
                );

                if (cancelBtn) {
                    // Cancel button logic
                    cancelBtn.addEventListener("click", function (e) {
                        e.preventDefault();
                        Swal.fire({
                            text: "Are you sure you would like to cancel?",
                            icon: "warning",
                            showCancelButton: true,
                            buttonsStyling: false,
                            confirmButtonText: "Yes, cancel it!",
                            cancelButtonText: "No, return",
                            customClass: {
                                confirmButton: "btn btn-primary",
                                cancelButton: "btn btn-active-light",
                            },
                        }).then((result) => {
                            if (result.value) {
                                form.reset();
                                modalInstance.hide();
                            }
                        });
                    });
                }

                // Close button logic
                closeBtn.addEventListener("click", function (e) {
                    e.preventDefault();
                    Swal.fire({
                        text: "Are you sure you would like to cancel?",
                        icon: "warning",
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: "Yes, cancel it!",
                        cancelButtonText: "No, return",
                        customClass: {
                            confirmButton: "btn btn-primary",
                            cancelButton: "btn btn-active-light",
                        },
                    }).then((result) => {
                        if (result.value) {
                            form.reset();
                            modalInstance.hide();
                        }
                    });
                });
            });
        },
    };
})();

KTUtil.onDOMContentLoaded(function () {
    KTModalAddPayment.init();
});
