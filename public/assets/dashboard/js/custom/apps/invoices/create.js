"use strict";

var KTAppInvoicesCreate = (function () {
    var formElement, formatter;

    // Calculate totals
    var calculateTotals = function () {
        var items = formElement.querySelectorAll(
            '[data-kt-element="items"] [data-kt-element="item"]'
        );

        var total = 0;

        items.forEach(function (item) {
            var quantityInput = item.querySelector(
                '[data-kt-element="quantity"]'
            );
            var priceInput = item.querySelector('[data-kt-element="price"]');

            var price = formatter.from(priceInput.value) || 0;
            price = price < 0 ? 0 : price;

            var quantity = parseInt(quantityInput.value) || 1;
            quantity = quantity < 0 ? 1 : quantity;

            priceInput.value = formatter.to(price);
            quantityInput.value = quantity;

            item.querySelector('[data-kt-element="total"]').innerText =
                formatter.to(price * quantity);
            total += price * quantity;
        });

        formElement.querySelector('[data-kt-element="sub-total"]').innerText =
            formatter.to(total);
        formElement.querySelector('[data-kt-element="grand-total"]').innerText =
            formatter.to(total);
    };

    // Handle empty state if no items
    var handleEmptyState = function () {
        var itemCount = formElement.querySelectorAll(
            '[data-kt-element="items"] [data-kt-element="item"]'
        ).length;

        if (itemCount === 0) {
            var emptyRow = formElement
                .querySelector('[data-kt-element="empty-template"] tr')
                .cloneNode(true);

            formElement
                .querySelector('[data-kt-element="items"] tbody')
                .appendChild(emptyRow);
        } else {
            var emptyElement = formElement.querySelector(
                '[data-kt-element="items"] [data-kt-element="empty"]'
            );
            if (emptyElement) {
                emptyElement.remove();
            }
        }
    };

    // Setup flatpickr on all inputs with data-kt-flatpickr="true"
    var setupFlatpickr = function () {
        var dateInputs = formElement.querySelectorAll(
            '[data-kt-flatpickr="true"]'
        );

        dateInputs.forEach(function (input) {
            flatpickr(input, {
                enableTime: false,
                dateFormat: "d, M Y",
            });
        });
    };

    // Init
    return {
        init: function (form) {
            // Support init with a selector or a direct element
            if (typeof form === "string") {
                formElement = document.querySelector(form);
            } else {
                formElement = form;
            }

            if (!formElement) {
                console.error("KTAppInvoicesCreate: Form not found!");
                return;
            }

            // Setup formatter
            formatter = wNumb({ decimals: 2, thousand: "," });

            // Add item
            var addItemButton = formElement.querySelector(
                '[data-kt-element="items"] [data-kt-element="add-item"]'
            );

            if (addItemButton) {
                addItemButton.addEventListener("click", function (e) {
                    e.preventDefault();

                    var newItem = formElement
                        .querySelector('[data-kt-element="item-template"] tr')
                        .cloneNode(true);

                    formElement
                        .querySelector('[data-kt-element="items"] tbody')
                        .appendChild(newItem);

                    handleEmptyState();
                    calculateTotals();
                });
            }

            // Remove item
            KTUtil.on(
                formElement,
                '[data-kt-element="items"] [data-kt-element="remove-item"]',
                "click",
                function (e) {
                    e.preventDefault();

                    var item = this.closest('[data-kt-element="item"]');
                    if (item) item.remove();

                    handleEmptyState();
                    calculateTotals();
                }
            );

            // Update totals when quantity or price changes
            KTUtil.on(
                formElement,
                '[data-kt-element="items"] [data-kt-element="quantity"], [data-kt-element="items"] [data-kt-element="price"]',
                "change",
                function () {
                    calculateTotals();
                }
            );

            // Initialize
            setupFlatpickr();
            calculateTotals();
        },
    };
})();
