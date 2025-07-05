$(document).ready(function() {
    // Debug: Confirm dependencies
    console.log('jQuery loaded:', typeof $ !== 'undefined');
    console.log('SweetAlert loaded:', typeof Swal !== 'undefined');
    console.log('Select2 loaded:', typeof $.fn.select2 !== 'undefined');

    // Function to initialize select plugins and options container
    function initializeSelect($section) {
        const $select = $section.find('select[name="type"]');
        const $optionsContainer = $section.find('.options-container');
        const $optionsList = $section.find('.options-list');


        console.error('No select element found in section');
            return;
        }

        if ($select.hasClass('select2-hidden-accessible')) {
            $select.select2('destroy');
        }
        $select.siblings('.select2-container').remove();

        $select.css({ display: '', visibility: '' });

        try {
            $select.select2({
                placeholder: "@lang('dash.select_question_type')",
                allowClear: true
            });
            console.log('Select2 initialized for:', $select.attr('id'));
        } catch (error) {
            console.error('Error initializing Select2:', error);
        }

        function toggleOptionsContainer() {
            if ($select.val() === 'multiple_choice') {
                $optionsContainer.show();
            } else {
                $optionsContainer.hide();
            }
        }

        toggleOptionsContainer();
        $select.on('change', toggleOptionsContainer);

        // Initialize option delete buttons with event delegation
        $optionsList.off('click', '.btn_delete_option').on('click', '.btn_delete_option', function() {
            console.log('Delete option button clicked');
            const $optionItem = $(this).closest('.option-item');
            const $input = $optionItem.find('input[name="options[]"]');
            const optionCount = $optionsList.find('.option-item').length;
            console.log('Current option count:', optionCount);
            console.log('Input value:', $input.val());

            if (optionCount <= 2) {
                Swal.fire({
                    title: '@lang('dash.error')',
                    text: '@lang('dash.at_least_two_option_required')',
                    icon: 'error'
                });
                return;
            }

            if ($input.val().trim() !== '') {
                Swal.fire({
                    title: '@lang('dash.are_you_sure')',
                    text: '@lang('dash.delete_filled_option')',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '@lang('dash.yes_delete_it')',
                    cancelButtonText: '@lang('dash.cancel')'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $optionItem.remove();
                        console.log('Option removed, new count:', $optionsList.find('.option-item').length);
                        Swal.fire({
                            title: '@lang('dash.deleted')',
                            text: '@lang('dash.option_deleted_successfully')',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                });
            } else {
                $optionItem.remove();
                console.log('Option removed, new count:', $optionsList.find('.option-item').length);
            }
        });

        // Initialize add option button
        $section.off('click', '.btn_add_option').on('click', '.btn_add_option', function() {
            console.log('Add option button clicked');
            const $newOption = $optionsList.find('.option-item:first').clone();
            $newOption.find('input').val('');
            $optionsList.append($newOption);
            console.log('Option added, new count:', $optionsList.find('.option-item').length);
        });
    }

    // Initialize select plugin for modal on load
    initializeSelect($('.question-dev'));

    // Initialize SortableJS for each exam's question table
    $('table[id^="questions-table-"]').each(function() {
        const examId = $(this).attr('id').split('-')[2];
        const reorderRoute = "{{ route('exams.questions.reorder', ['exam' => ':examId']) }}".replace(':examId', examId);
        const $sortable = $(this).find('.sortable');

        console.log('Initializing Sortable for table:', $(this).attr('id'), 'Exam ID:', examId);

        new Sortable($sortable[0], {
            animation: 150,
            handle: 'tr',
            onEnd: function(evt) {
                const rows = $sortable.children('tr');
                console.log('Rows found:', rows.length);

                const order = rows.map(function() {
                    const questionId = $(this).attr('data-question-id');
                    return questionId ? parseInt(questionId) : null;
                }).get().filter(id => id !== null);

                console.log('Reorder triggered:', { examId, order, reorderRoute });

                if (order.length === 0) {
                    Swal.fire({
                        title: '@lang('dash.error')',
                        text: '@lang('dash.no_questions_to_reorder')',
                        icon: 'error'
                    });
                    return;
                }

                $.ajax({
                    url: reorderRoute,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        order: order
                    },
                    success: function(response) {
                        // Swal.fire({
                        //     title: '@lang('dash.success')',
                        //     text: '@lang('dash.reordered_successfully')',
                        //     icon: 'success',
                        //     timer: 1500,
                        //     showConfirmButton: false
                        // });
                        rows.each(function(index) {
                            $(this).find('td:first').html(
                                '@lang('dash.question') ' + (index + 1) + ': ' +
                                '<span class="text-gray-800">' + $(this).find('td:first .text-gray-800').text() + '</span>'
                            );
                        });
                    },
                    error: function(xhr) {
                        console.error('Reorder error:', xhr.status, xhr.responseJSON);
                        Swal.fire({
                            title: '@lang('dash.error')',
                            text: xhr.responseJSON?.message || '@lang('dash.reorder_failed')',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    });

    // Edit button click handler
    $(document).on('click', '.btn_edit_question', function() {
        console.log('Edit button clicked');
        const questionId = $(this).data('id');
        const examId = $(this).data('exam-id');
        const editRoute = $(this).data('edit-route');
        const updateRoute = $(this).data('update-route');

        $('#question_id').val(questionId);
        $('#edit_question_form').data('exam-id', examId);
        $('#edit_question_form').data('update-route', updateRoute);

        // Reset form fields
        $('#edit_question_form').find('textarea, input:not([type="hidden"]), select').val('');
        $('#edit_question_form').find('.options-list').empty();

        // Show loader
        $('#modal_loader').addClass('d-flex');

        // Wait for modal to be shown to ensure DOM is ready
        $('#edit_question_modal').one('shown.bs.modal', function() {
            console.log('Modal shown, attempting to populate');
            console.log('Form container HTML:', $('#edit_question_form').html());

            // Fetch question data
            $.ajax({
                url: editRoute,
                method: 'GET',
                success: function(response) {
                    console.log('Edit response:', response);
                    const question = response.question || {};

                    // Populate form fields
                    const textEn = question.text && typeof question.text === 'object' ? question.text.en : '';
                    const textAr = question.text && typeof question.text === 'object' ? question.text.ar : '';
                    console.log('Setting values:', { textEn, textAr, type: question.type, marks: question.marks, correct_answer: question.correct_answer });

                    $('#edit-text-en').val(textEn || '');
                    $('#edit-text-ar').val(textAr || '');
                    $('#edit-question-type').val(question.type || '').trigger('change.select2');
                    $('#edit-marks').val(question.marks || '');
                    $('#edit-correct-answer').val(question.correct_answer || '');

                    // Fallback to name selectors
                    if (!$('#edit-text-en').val()) {
                        $('textarea[name="text_en"]').val(textEn || '');
                    }
                    if (!$('#edit-text-ar').val()) {
                        $('textarea[name="text_ar"]').val(textAr || '');
                    }
                    if (!$('#edit-question-type').val()) {
                        $('select[name="type"]').val(question.type || '').trigger('change.select2');
                    }
                    if (!$('#edit-marks').val()) {
                        $('input[name="marks"]').val(question.marks || '');
                    }
                    if (!$('#edit-correct-answer').val()) {
                        $('input[name="correct_answer"]').val(question.correct_answer || '');
                    }

                    // Reinitialize Select2 and option handlers
                    initializeSelect($('.question-dev'));

                    // Populate options
                    const $optionsList = $('.options-list').empty();
                    if (question.type === 'multiple_choice' && question.options && Array.isArray(question.options) && question.options.length > 0) {
                        question.options.forEach(function(option) {
                            const $optionItem = $(`
                                <div class="option-item d-flex align-items-center gap-3 mb-3">
                                    <input type="text" name="options[]" class="form-control" value="${option || ''}" placeholder="@lang('dash.enter_option')" />
                                    <a href="javascript:;" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm btn_delete_option" title="@lang('dash.delete_option')">
                                        <i class="ki-outline ki-trash fs-2"></i>
                                    </a>
                                </div>
                            `);
                            $optionsList.append($optionItem);
                        });
                        $('.options-container').show();
                    } else {
                        for (let i = 0; i < 2; i++) {
                            const $optionItem = $(`
                                <div class="option-item d-flex align-items-center gap-3 mb-3">
                                    <input type="text" name="options[]" class="form-control" placeholder="@lang('dash.enter_option')" />
                                    <a href="javascript:;" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm btn_delete_option" title="@lang('dash.delete_option')">
                                        <i class="ki-outline ki-trash fs-2"></i>
                                    </a>
                                </div>
                            `);
                            $optionsList.append($optionItem);
                        }
                        $('.options-container').hide();
                    }

                    // Clear previous error messages
                    $('.fv-plugins-message-container').remove();

                    // Hide loader
                    $('#modal_loader').removeClass('d-flex').hide();
                },
                error: function(xhr) {
                    console.error('Edit AJAX error:', xhr.status, xhr.responseJSON);
                    Swal.fire({
                        title: '@lang('dash.error')',
                        text: xhr.responseJSON?.message || '@lang('dash.failed_to_load_question')',
                        icon: 'error'
                    });
                    $('#modal_loader').removeClass('d-flex').hide();
                }
            });
        }).modal('show');
    });

    // Submit edit form container
    $(document).on('click', '#edit_question_submit', function(e) {
        e.preventDefault();
        console.log('Submit button clicked');
        const $formContainer = $('#edit_question_form');
        const updateRoute = $formContainer.data('update-route');
        const examId = $formContainer.data('exam-id');

        // Collect form data
        const formData = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            _method: 'PATCH',
            text_en: $('textarea[name="text_en"]').val(),
            text_ar: $('textarea[name="text_ar"]').val(),
            type: $('select[name="type"]').val(),
            marks: $('input[name="marks"]').val(),
            correct_answer: $('input[name="correct_answer"]').val(),
        };

        // Collect options only for multiple_choice
        if (formData.type === 'multiple_choice') {
            formData.options = [];
            $('input[name="options[]"]').each(function() {
                const value = $(this).val();
                formData.options.push(value || '');
            });
            if (formData.options.filter(opt => opt.trim() !== '').length < 2) {
                Swal.fire({
                    title: '@lang('dash.error')',
                    text: '@lang('dash.at_least_two_option_required')',
                    icon: 'error'
                });
                return;
            }
        }

        $.ajax({
            url: updateRoute,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Cache-Control': 'no-cache, no-store, must-revalidate',
                'Pragma': 'no-cache',
                'Expires': '0'
            },
            data: formData,
            success: function(response) {
                const question = response.question || {};
                const lang = '{{ $lang }}';

                // Update table row
                const $row = $(`tr[data-question-id="${question.id}"]`);
                if ($row.length) {
                    const questionText = question.text && typeof question.text === 'object' && question.text[lang]
                        ? question.text[lang].substring(0, 30)
                        : '';
                    $row.find('td:eq(0)').html(
                        '@lang('dash.question') ' + (question.order || '') + ': ' +
                        '<span class="text-gray-800">' + questionText + '</span>'
                    );
                    $row.find('td:eq(1) .text-gray-800').text(question.type || 'N/A');
                } else {
                    console.warn('Row not found for question ID:', question.id);
                }

                Swal.fire({
                    title: '@lang('dash.success')',
                    text: '@lang('dash.question_updated_successfully')',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                });
                $('#edit_question_modal').modal('hide');
            },
            error: function(xhr) {
                console.error('Submit error:', xhr.status, xhr.responseJSON);
                if (xhr.status === 422) {
                    $('.fv-plugins-message-container').remove();
                    const errors = xhr.responseJSON.errors || {};
                    $.each(errors, function(key, value) {
                        const $field = $(`[name="${key}"], [name="${key}[]"]`);
                        if ($field.length) {
                            $field.closest('.fv-row').append(
                                `<div class="fv-plugins-message-container invalid-feedback">${value[0]}</div>`
                            );
                        } else {
                            console.warn(`Field ${key} not found for error: ${value[0]}`);
                        }
                    });
                } else {
                    Swal.fire({
                        title: '@lang('dash.error')',
                        text: xhr.responseJSON?.message || '@lang('dash.failed_to_update_question')',
                        icon: 'error'
                    });
                }
            }
        });
    });

    // Delete question button click handler
    $(document).on('click', '.btn_delete_question', function() {
        console.log('Delete question button clicked');
        const questionId = $(this).data('id');
        const deleteRoute = $(this).data('delete-route');
        const $row = $(this).closest('tr');

        console.log('Delete question params:', { questionId, deleteRoute });

        Swal.fire({
            title: '@lang('dash.are you sure?')',
            text: '@lang('dash.delete this question')',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '@lang('dash.yes, delete it')',
            cancelButtonText: '@lang('dash.cancel')'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: deleteRoute,
                    method: 'DELETE',
                    data: { selectedIds: [questionId] },
                    success: function(response) {
                        Swal.fire({
                            title: '@lang('dash.deleted')',
                            text: '@lang('dash.question_deleted_successfully')',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        $row.remove();
                    },
                    error: function(xhr) {
                        console.error('Delete question error:', xhr.status, xhr.responseJSON);
                        Swal.fire({
                            title: '@lang('dash.error')',
                            text: xhr.responseJSON?.message || '@lang('dash.delete_failed')',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    });

    // Delete exam card handler
    $(document).on('click', '.btn_delete_exam_card', function() {
        console.log('Delete exam button clicked');
        const deleteRoute = $(this).data('delete-route');
        const card = $(this).parent().parent().parent();

        Swal.fire({
            title: '@lang('dash.are you sure?')',
            text: '@lang('dash.delete this records')',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '@lang('dash.yes, delete it')',
            cancelButtonText: '@lang('dash.cancel')'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }<!-- Include SortableJS -->
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
                    <script>
                        $(document).ready(function() {
                            // Debug: Confirm dependencies
                            console.log('jQuery loaded:', typeof $ !== 'undefined');
                            console.log('SweetAlert loaded:', typeof Swal !== 'undefined');
                            console.log('Select2 loaded:', typeof $.fn.select2 !== 'undefined');
                
                            // Function to initialize select plugins and options container
                            function initializeSelect($section) {
                                const $select = $section.find('select[name="type"]');
                                const $optionsContainer = $section.find('.options-container');
                                const $optionsList = $section.find('.options-list');
                
                                if ($select.length === 0) {
                                    console.error('No select element found in section');
                                    return;
                                }
                
                                if ($select.hasClass('select2-hidden-accessible')) {
                                    $select.select2('destroy');
                                }
                                $select.siblings('.select2-container').remove();
                
                                $select.css({ display: '', visibility: '' });
                
                                try {
                                    $select.select2({
                                        placeholder: "@lang('dash.select_question_type')",
                                        allowClear: true
                                    });
                                    console.log('Select2 initialized for:', $select.attr('id'));
                                } catch (error) {
                                    console.error('Error initializing Select2:', error);
                                }
                
                                function toggleOptionsContainer() {
                                    if ($select.val() === 'multiple_choice') {
                                        $optionsContainer.show();
                                    } else {
                                        $optionsContainer.hide();
                                    }
                                }
                
                                toggleOptionsContainer();
                                $select.on('change', toggleOptionsContainer);
                
                                // Initialize option delete buttons with event delegation
                                $optionsList.off('click', '.btn_delete_option').on('click', '.btn_delete_option', function() {
                                    console.log('Delete option button clicked');
                                    const $optionItem = $(this).closest('.option-item');
                                    const $input = $optionItem.find('input[name="options[]"]');
                                    const optionCount = $optionsList.find('.option-item').length;
                                    console.log('Current option count:', optionCount);
                                    console.log('Input value:', $input.val());
                
                                    if (optionCount <= 2) {
                                        Swal.fire({
                                            title: '@lang('dash.error')',
                                            text: '@lang('dash.at_least_two_option_required')',
                                            icon: 'error'
                                        });
                                        return;
                                    }
                
                                    if ($input.val().trim() !== '') {
                                        Swal.fire({
                                            title: '@lang('dash.are_you_sure')',
                                            text: '@lang('dash.delete_filled_option')',
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#3085d6',
                                            cancelButtonColor: '#d33',
                                            confirmButtonText: '@lang('dash.yes_delete_it')',
                                            cancelButtonText: '@lang('dash.cancel')'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                $optionItem.remove();
                                                console.log('Option removed, new count:', $optionsList.find('.option-item').length);
                                                Swal.fire({
                                                    title: '@lang('dash.deleted')',
                                                    text: '@lang('dash.option_deleted_successfully')',
                                                    icon: 'success',
                                                    timer: 1500,
                                                    showConfirmButton: false
                                                });
                                            }
                                        });
                                    } else {
                                        $optionItem.remove();
                                        console.log('Option removed, new count:', $optionsList.find('.option-item').length);
                                    }
                                });
                
                                // Initialize add option button
                                $section.off('click', '.btn_add_option').on('click', '.btn_add_option', function() {
                                    console.log('Add option button clicked');
                                    const $newOption = $optionsList.find('.option-item:first').clone();
                                    $newOption.find('input').val('');
                                    $optionsList.append($newOption);
                                    console.log('Option added, new count:', $optionsList.find('.option-item').length);
                                });
                            }
                
                            // Initialize select plugin for modal on load
                            initializeSelect($('.question-dev'));
                
                            // Initialize SortableJS for each exam's question table
                            $('table[id^="questions-table-"]').each(function() {
                                const examId = $(this).attr('id').split('-')[2];
                                const reorderRoute = "{{ route('exams.questions.reorder', ['exam' => ':examId']) }}".replace(':examId', examId);
                                const $sortable = $(this).find('.sortable');
                
                                console.log('Initializing Sortable for table:', $(this).attr('id'), 'Exam ID:', examId);
                
                                new Sortable($sortable[0], {
                                    animation: 150,
                                    handle: 'tr',
                                    onEnd: function(evt) {
                                        const rows = $sortable.children('tr');
                                        console.log('Rows found:', rows.length);
                
                                        const order = rows.map(function() {
                                            const questionId = $(this).attr('data-question-id');
                                            return questionId ? parseInt(questionId) : null;
                                        }).get().filter(id => id !== null);
                
                                        console.log('Reorder triggered:', { examId, order, reorderRoute });
                
                                        if (order.length === 0) {
                                            Swal.fire({
                                                title: '@lang('dash.error')',
                                                text: '@lang('dash.no_questions_to_reorder')',
                                                icon: 'error'
                                            });
                                            return;
                                        }
                
                                        $.ajax({
                                            url: reorderRoute,
                                            method: 'POST',
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            },
                                            data: {
                                                order: order
                                            },
                                            success: function(response) {
                                                // Swal.fire({
                                                //     title: '@lang('dash.success')',
                                                //     text: '@lang('dash.reordered_successfully')',
                                                //     icon: 'success',
                                                //     timer: 1500,
                                                //     showConfirmButton: false
                                                // });
                                                rows.each(function(index) {
                                                    $(this).find('td:first').html(
                                                        '@lang('dash.question') ' + (index + 1) + ': ' +
                                                        '<span class="text-gray-800">' + $(this).find('td:first .text-gray-800').text() + '</span>'
                                                    );
                                                });
                                            },
                                            error: function(xhr) {
                                                console.error('Reorder error:', xhr.status, xhr.responseJSON);
                                                Swal.fire({
                                                    title: '@lang('dash.error')',
                                                    text: xhr.responseJSON?.message || '@lang('dash.reorder_failed')',
                                                    icon: 'error'
                                                });
                                            }
                                        });
                                    }
                                });
                            });
                
                            // Edit button click handler
                            $(document).on('click', '.btn_edit_question', function() {
                                console.log('Edit button clicked');
                                const questionId = $(this).data('id');
                                const examId = $(this).data('exam-id');
                                const editRoute = $(this).data('edit-route');
                                const updateRoute = $(this).data('update-route');
                
                                $('#question_id').val(questionId);
                                $('#edit_question_form').data('exam-id', examId);
                                $('#edit_question_form').data('update-route', updateRoute);
                
                                // Reset form fields
                                $('#edit_question_form').find('textarea, input:not([type="hidden"]), select').val('');
                                $('#edit_question_form').find('.options-list').empty();
                
                                // Show loader
                                $('#modal_loader').addClass('d-flex');
                
                                // Wait for modal to be shown to ensure DOM is ready
                                $('#edit_question_modal').one('shown.bs.modal', function() {
                                    console.log('Modal shown, attempting to populate');
                                    console.log('Form container HTML:', $('#edit_question_form').html());
                
                                    // Fetch question data
                                    $.ajax({
                                        url: editRoute,
                                        method: 'GET',
                                        success: function(response) {
                                            console.log('Edit response:', response);
                                            const question = response.question || {};
                
                                            // Populate form fields
                                            const textEn = question.text && typeof question.text === 'object' ? question.text.en : '';
                                            const textAr = question.text && typeof question.text === 'object' ? question.text.ar : '';
                                            console.log('Setting values:', { textEn, textAr, type: question.type, marks: question.marks, correct_answer: question.correct_answer });
                
                                            $('#edit-text-en').val(textEn || '');
                                            $('#edit-text-ar').val(textAr || '');
                                            $('#edit-question-type').val(question.type || '').trigger('change.select2');
                                            $('#edit-marks').val(question.marks || '');
                                            $('#edit-correct-answer').val(question.correct_answer || '');
                
                                            // Fallback to name selectors
                                            if (!$('#edit-text-en').val()) {
                                                $('textarea[name="text_en"]').val(textEn || '');
                                            }
                                            if (!$('#edit-text-ar').val()) {
                                                $('textarea[name="text_ar"]').val(textAr || '');
                                            }
                                            if (!$('#edit-question-type').val()) {
                                                $('select[name="type"]').val(question.type || '').trigger('change.select2');
                                            }
                                            if (!$('#edit-marks').val()) {
                                                $('input[name="marks"]').val(question.marks || '');
                                            }
                                            if (!$('#edit-correct-answer').val()) {
                                                $('input[name="correct_answer"]').val(question.correct_answer || '');
                                            }
                
                                            // Reinitialize Select2 and option handlers
                                            initializeSelect($('.question-dev'));
                
                                            // Populate options
                                            const $optionsList = $('.options-list').empty();
                                            if (question.type === 'multiple_choice' && question.options && Array.isArray(question.options) && question.options.length > 0) {
                                                question.options.forEach(function(option) {
                                                    const $optionItem = $(`
                                                        <div class="option-item d-flex align-items-center gap-3 mb-3">
                                                            <input type="text" name="options[]" class="form-control" value="${option || ''}" placeholder="@lang('dash.enter_option')" />
                                                            <a href="javascript:;" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm btn_delete_option" title="@lang('dash.delete_option')">
                                                                <i class="ki-outline ki-trash fs-2"></i>
                                                            </a>
                                                        </div>
                                                    `);
                                                    $optionsList.append($optionItem);
                                                });
                                                $('.options-container').show();
                                            } else {
                                                for (let i = 0; i < 2; i++) {
                                                    const $optionItem = $(`
                                                        <div class="option-item d-flex align-items-center gap-3 mb-3">
                                                            <input type="text" name="options[]" class="form-control" placeholder="@lang('dash.enter_option')" />
                                                            <a href="javascript:;" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm btn_delete_option" title="@lang('dash.delete_option')">
                                                                <i class="ki-outline ki-trash fs-2"></i>
                                                            </a>
                                                        </div>
                                                    `);
                                                    $optionsList.append($optionItem);
                                                }
                                                $('.options-container').hide();
                                            }
                
                                            // Clear previous error messages
                                            $('.fv-plugins-message-container').remove();
                
                                            // Hide loader
                                            $('#modal_loader').removeClass('d-flex').hide();
                                        },
                                        error: function(xhr) {
                                            console.error('Edit AJAX error:', xhr.status, xhr.responseJSON);
                                            Swal.fire({
                                                title: '@lang('dash.error')',
                                                text: xhr.responseJSON?.message || '@lang('dash.failed_to_load_question')',
                                                icon: 'error'
                                            });
                                            $('#modal_loader').removeClass('d-flex').hide();
                                        }
                                    });
                                }).modal('show');
                            });
                
                            // Submit edit form container
                            $(document).on('click', '#edit_question_submit', function(e) {
                                e.preventDefault();
                                console.log('Submit button clicked');
                                const $formContainer = $('#edit_question_form');
                                const updateRoute = $formContainer.data('update-route');
                                const examId = $formContainer.data('exam-id');
                
                                // Collect form data
                                const formData = {
                                    _token: $('meta[name="csrf-token"]').attr('content'),
                                    _method: 'PATCH',
                                    text_en: $('textarea[name="text_en"]').val(),
                                    text_ar: $('textarea[name="text_ar"]').val(),
                                    type: $('select[name="type"]').val(),
                                    marks: $('input[name="marks"]').val(),
                                    correct_answer: $('input[name="correct_answer"]').val(),
                                };
                
                                // Collect options only for multiple_choice
                                if (formData.type === 'multiple_choice') {
                                    formData.options = [];
                                    $('input[name="options[]"]').each(function() {
                                        const value = $(this).val();
                                        formData.options.push(value || '');
                                    });
                                    if (formData.options.filter(opt => opt.trim() !== '').length < 2) {
                                        Swal.fire({
                                            title: '@lang('dash.error')',
                                            text: '@lang('dash.at_least_two_option_required')',
                                            icon: 'error'
                                        });
                                        return;
                                    }
                                }
                
                                $.ajax({
                                    url: updateRoute,
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                        'Cache-Control': 'no-cache, no-store, must-revalidate',
                                        'Pragma': 'no-cache',
                                        'Expires': '0'
                                    },
                                    data: formData,
                                    success: function(response) {
                                        const question = response.question || {};
                                        const lang = '{{ $lang }}';
                
                                        // Update table row
                                        const $row = $(`tr[data-question-id="${question.id}"]`);
                                        if ($row.length) {
                                            const questionText = question.text && typeof question.text === 'object' && question.text[lang]
                                                ? question.text[lang].substring(0, 30)
                                                : '';
                                            $row.find('td:eq(0)').html(
                                                '@lang('dash.question') ' + (question.order || '') + ': ' +
                                                '<span class="text-gray-800">' + questionText + '</span>'
                                            );
                                            $row.find('td:eq(1) .text-gray-800').text(question.type || 'N/A');
                                        } else {
                                            console.warn('Row not found for question ID:', question.id);
                                        }
                
                                        Swal.fire({
                                            title: '@lang('dash.success')',
                                            text: '@lang('dash.question_updated_successfully')',
                                            icon: 'success',
                                            timer: 1500,
                                            showConfirmButton: false
                                        });
                                        $('#edit_question_modal').modal('hide');
                                    },
                                    error: function(xhr) {
                                        console.error('Submit error:', xhr.status, xhr.responseJSON);
                                        if (xhr.status === 422) {
                                            $('.fv-plugins-message-container').remove();
                                            const errors = xhr.responseJSON.errors || {};
                                            $.each(errors, function(key, value) {
                                                const $field = $(`[name="${key}"], [name="${key}[]"]`);
                                                if ($field.length) {
                                                    $field.closest('.fv-row').append(
                                                        `<div class="fv-plugins-message-container invalid-feedback">${value[0]}</div>`
                                                    );
                                                } else {
                                                    console.warn(`Field ${key} not found for error: ${value[0]}`);
                                                }
                                            });
                                        } else {
                                            Swal.fire({
                                                title: '@lang('dash.error')',
                                                text: xhr.responseJSON?.message || '@lang('dash.failed_to_update_question')',
                                                icon: 'error'
                                            });
                                        }
                                    }
                                });
                            });
                
                            // Delete question button click handler
                            $(document).on('click', '.btn_delete_question', function() {
                                console.log('Delete question button clicked');
                                const questionId = $(this).data('id');
                                const deleteRoute = $(this).data('delete-route');
                                const $row = $(this).closest('tr');
                
                                console.log('Delete question params:', { questionId, deleteRoute });
                
                                Swal.fire({
                                    title: '@lang('dash.are you sure?')',
                                    text: '@lang('dash.delete this question')',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: '@lang('dash.yes, delete it')',
                                    cancelButtonText: '@lang('dash.cancel')'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                        });
                
                                        $.ajax({
                                            url: deleteRoute,
                                            method: 'DELETE',
                                            data: { selectedIds: [questionId] },
                                            success: function(response) {
                                                Swal.fire({
                                                    title: '@lang('dash.deleted')',
                                                    text: '@lang('dash.question_deleted_successfully')',
                                                    icon: 'success',
                                                    timer: 1500,
                                                    showConfirmButton: false
                                                });
                                                $row.remove();
                                            },
                                            error: function(xhr) {
                                                console.error('Delete question error:', xhr.status, xhr.responseJSON);
                                                Swal.fire({
                                                    title: '@lang('dash.error')',
                                                    text: xhr.responseJSON?.message || '@lang('dash.delete_failed')',
                                                    icon: 'error'
                                                });
                                            }
                                        });
                                    }
                                });
                            });
                
                            // Delete exam card handler
                            $(document).on('click', '.btn_delete_exam_card', function() {
                                console.log('Delete exam button clicked');
                                const deleteRoute = $(this).data('delete-route');
                                const card = $(this).parent().parent().parent();
                
                                Swal.fire({
                                    title: '@lang('dash.are you sure?')',
                                    text: '@lang('dash.delete this records')',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: '@lang('dash.yes, delete it')',
                                    cancelButtonText: '@lang('dash.cancel')'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                        });
                
                                        $.ajax({
                                            url: deleteRoute,
                                            type: 'DELETE',
                                            success: function(response) {
                                                if (response.success) {
                                                    Swal.fire({
                                                        icon: 'success',
                                                        title: '@lang('dash.deleted')',
                                                        text: response.message,
                                                        showConfirmButton: false,
                                                        timer: 1500
                                                    });
                                                    card.remove();
                                                } else {
                                                    Swal.fire({
                                                        title: '@lang('dash.error')',
                                                        text: '@lang('dash.error_delete')',
                                                        icon: 'error'
                                                    });
                                                }
                                            },
                                            error: function(xhr) {
                                                console.error('Delete exam error:', xhr.status, xhr.responseJSON);
                                                Swal.fire({
                                                    title: '@lang('dash.error')',
                                                    text: xhr.responseJSON?.message || '@lang('dash.error_delete')',
                                                    icon: 'error'
                                                });
                                            }
                                        });
                                    }
                                });
                            });
                        });
                    </script>
                });

                $.ajax({
                    url: deleteRoute,
                    type: 'DELETE',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '@lang('dash.deleted')',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            });
                            card.remove();
                        } else {
                            Swal.fire({
                                title: '@lang('dash.error')',
                                text: '@lang('dash.error_delete')',
                                icon: 'error'
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error('Delete exam error:', xhr.status, xhr.responseJSON);
                        Swal.fire({
                            title: '@lang('dash.error')',
                            text: xhr.responseJSON?.message || '@lang('dash.error_delete')',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    });
});