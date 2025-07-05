"use strict";

var KTModalNewTarget = (function () {
    var submitButton, cancelButton, validator, modalForm, modalElement, modal;

    return {
        init: function () {
            modalElement = document.querySelector("#kt_modal_new_target");
            if (!modalElement) return;

            modal = new bootstrap.Modal(modalElement);
            modalForm = document.querySelector("#kt_modal_new_target_form");
            submitButton = document.getElementById(
                "kt_modal_new_target_submit"
            );
            cancelButton = document.getElementById(
                "kt_modal_new_target_cancel"
            );

            // Initialize Tagify
            new Tagify(modalForm.querySelector('[name="tags"]'), {
                whitelist: ["Important", "Urgent", "High", "Medium", "Low"],
                maxTags: 5,
                dropdown: { maxItems: 10, enabled: 0, closeOnSelect: false },
            }).on("change", function () {
                validator.revalidateField("tags");
            });

            // Handle team assign change event
            var teamAssignInput = modalForm.querySelector(
                '[name="team_assign"]'
            );
            if (teamAssignInput) {
                teamAssignInput.addEventListener("change", function () {
                    validator.revalidateField("team_assign");
                });
            }

            // Form validation
            validator = FormValidation.formValidation(modalForm, {
                fields: {
                    target_title: {
                        validators: {
                            notEmpty: { message: "Target title is required" },
                        },
                    },
                    target_assign: {
                        validators: {
                            notEmpty: { message: "Target assign is required" },
                        },
                    },
                    target_due_date: {
                        validators: {
                            notEmpty: {
                                message: "Target due date is required",
                            },
                        },
                    },
                    target_tags: {
                        validators: {
                            notEmpty: { message: "Target tags are required" },
                        },
                    },
                    "targets_notifications[]": {
                        validators: {
                            notEmpty: {
                                message:
                                    "Please select at least one communication method",
                            },
                        },
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: ".fv-row",
                        eleInvalidClass: "",
                        eleValidClass: "",
                    }),
                },
            });

            // Submit button handler
            submitButton.addEventListener("click", function (e) {
                e.preventDefault();

                if (!validator) return;

                validator.validate().then(function (status) {
                    console.log("validated!");

                    if (status === "Valid") {
                        submitButton.setAttribute("data-kt-indicator", "on");
                        submitButton.disabled = true;

                        setTimeout(function () {
                            submitButton.removeAttribute("data-kt-indicator");
                            submitButton.disabled = false;

                            Swal.fire({
                                text: "Form has been successfully submitted!",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary",
                                },
                            }).then(function (result) {
                                if (result.isConfirmed) {
                                    modal.hide();
                                }
                            });
                        }, 2000);
                    } else {
                        Swal.fire({
                            text: "Sorry, looks like there are some errors detected, please try again.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary",
                            },
                        });
                    }
                });
            });

            // Cancel button handler
            cancelButton.addEventListener("click", function (e) {
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
                }).then(function (result) {
                    if (result.value) {
                        modalForm.reset();
                        modal.hide();
                    } else if (result.dismiss === "cancel") {
                        Swal.fire({
                            text: "Your form has not been cancelled!",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary",
                            },
                        });
                    }
                });
            });
        },
    };
})();

// Init when DOM is ready
KTUtil.onDOMContentLoaded(function () {
    KTModalNewTarget.init();
});
