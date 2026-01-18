<script src="{{ Path::dashboardPath('plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ Path::dashboardPath('js/scripts.bundle.js') }}"></script>
<script src="{{ Path::dashboardPath('js/custom/apps/ecommerce/sales/save-order.js') }}"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
<script src="{{ Path::dashboardPath('js/custom/apps/customers/view/add-payment.js') }}"></script>
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
<!--<script src="https://cdn.datatables.net/fixedheader/3.4.0/js/dataTables.fixedHeader.min.js"></script>-->
<!--<script src="https://cdn.datatables.net/fixedheader/3.4.0/js/fixedHeader.dataTables.js"></script>-->
<script src="{{ Path::dashboardPath('js/custom/apps/ecommerce/sales/save-order.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<x-dashboard.partials.toastr-notifications />
<x-dashboard.partials.delete-btn />
<x-dashboard.partials.change-status />


<script>
    $(document).ready(function() {

        // pushing the notifications to the user
        // import Echo from 'laravel-echo';

        // window.Echo.private(`imports.${userId}`)
        //     .listen('.import.started', () => {
        //         alert('Import started...');
        //     })
        //     .listen('.import.finished', () => {
        //         alert('Import finished!');
        //     });


        // For every table with the 'select-all-records' class, apply the select/deselect functionality
        $('table.select-all-records').each(function() {
            var table = $(this); // Get the current table

            // Select/deselect all checkboxes in the DataTable when the header checkbox is clicked
            table.on('click', 'thead .select-all-records-checkbox', function() {
                var isChecked = this.checked;

                // Select or deselect all checkboxes in the rows of the current table
                table.find('tbody input[name="checkbox"]').each(function() {
                    this.checked = isChecked;
                });

                // Toggle visibility of action buttons based on checkbox selection
                toggleActionButtons();
            });

            // If any checkbox in the rows is clicked, make sure the "select-all" checkbox reflects the state
            table.on('click', 'tbody input[name="checkbox"]', function() {
                var allChecked = table.find('tbody input[name="checkbox"]').length === table
                    .find('tbody input[name="checkbox"]:checked').length;
                table.find('thead .select-all-records-checkbox')[0].checked = allChecked;

                // Toggle visibility of action buttons based on checkbox selection
                toggleActionButtons();
            });

            // Reapply select-all checkbox functionality after every draw event (pagination, sorting, etc.)
            table.on('draw', function() {
                var allChecked = table.find('tbody input[name="checkbox"]').length === table
                    .find('tbody input[name="checkbox"]:checked').length;
                table.find('thead .select-all-records-checkbox')[0].checked = allChecked;

                // Toggle visibility of action buttons based on checkbox selection
                toggleActionButtons();
            });

            // Function to show or hide action buttons based on checkbox selection
            function toggleActionButtons() {
                if (table.find('tbody input[name="checkbox"]:checked').length > 0) {
                    // Show action buttons when at least one checkbox is checked
                    $('#delete-all-btn').show();
                    $('#change-status-btn').show();
                } else {
                    // Hide action buttons when no checkboxes are checked
                    $('#delete-all-btn').hide();
                    $('#change-status-btn').hide();
                }
            }
        });
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.2.0/tinymce.min.js"></script>

<script>
    ///////// HTML editor ////////////////
    const useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const isSmallScreen = window.matchMedia('(max-width: 1023.5px)').matches;
    tinymce.init({
        selector: 'textarea.area1',
        plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
        editimage_cors_hosts: ['picsum.photos'],
        menubar: 'file edit view insert format tools table help',
        toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
        toolbar_sticky: true,
        toolbar_sticky_offset: isSmallScreen ? 102 : 108,
        autosave_ask_before_unload: true,
        autosave_interval: '30s',
        autosave_prefix: '{path}{query}-{id}-',
        autosave_restore_when_empty: false,
        relative_urls : false,
        remove_script_host : false,
        autosave_retention: '2m',
        image_advtab: true,
        link_list: [
            { title: 'My page 1', value: 'https://www.tiny.cloud' },
            { title: 'My page 2', value: 'http://www.moxiecode.com' }
        ],
        image_list: [
            { title: 'My page 1', value: 'https://www.tiny.cloud' },
            { title: 'My page 2', value: 'http://www.moxiecode.com' }
        ],
        image_class_list: [
            { title: 'None', value: '' },
            { title: 'Some class', value: 'class-name' }
        ],
        importcss_append: true,
        file_picker_callback: (callback, value, meta) => {
            /* Provide file and text for the link dialog */
            if (meta.filetype === 'file') {
                callback('https://www.google.com/logos/google.jpg', { text: 'My text' });
            }

            /* Provide image and alt text for the image dialog */
            if (meta.filetype === 'image') {
                callback('https://www.google.com/logos/google.jpg', { alt: 'My alt text' });
            }

            /* Provide alternative source and posted for the media dialog */
            if (meta.filetype === 'media') {
                callback('movie.mp4', { source2: 'alt.ogg', poster: 'https://www.google.com/logos/google.jpg' });
            }
        },
        templates: [
            { title: 'New Table', description: 'creates a new table', content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>' },
            { title: 'Starting my story', description: 'A cure for writers block', content: 'Once upon a time...' },
            { title: 'New list with dates', description: 'New List with dates', content: '<div class="mceTmpl"><span class="cdate">cdate</span><br><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>' }
        ],
        template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
        template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
        height: 600,
        image_caption: true,
        quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
        noneditable_class: 'mceNonEditable',
        toolbar_mode: 'sliding',
        contextmenu: 'link image table',
        skin: useDarkMode ? 'oxide-dark' : 'oxide',
        content_css: useDarkMode ? 'dark' : 'default',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
    });
</script>

<script>
    // Run when the page is fully loaded
    document.addEventListener("DOMContentLoaded", function() {
        // Create the page loading element dynamically
        const loadingEl = document.createElement("div");
        document.body.append(loadingEl);
        loadingEl.classList.add("page-loader");
        loadingEl.innerHTML = `
        <span class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </span>
    `;

        // Show page loading
        KTApp.showPageLoading();

        // Hide after 3 seconds
        setTimeout(function() {
            KTApp.hidePageLoading();
            loadingEl.remove();
        }, 3000);
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('kt_app_sidebar');
    const mainContent = document.getElementById('kt_app_main');
    const sidebarHover = document.querySelector('.app-sidebar-menu') || sidebar; // fallback

    // Try to find an existing pin toggle button; if missing, create one
    let toggleBtn = document.getElementById('kt_app_sidebar_toggle');
    toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('app-sidebar-minimized');
            mainContent.classList.toggle('app-main-expanded');

            // Update icon
            if (sidebar.classList.contains('app-sidebar-minimized')) {
                toggleIcon.classList.remove('ki-arrow-left');
                toggleIcon.classList.add('ki-arrow-right');
                localStorage.setItem('sidebarMinimized', 'true');
            } else {
                toggleIcon.classList.remove('ki-arrow-right');
                toggleIcon.classList.add('ki-arrow-left');
                localStorage.setItem('sidebarMinimized', 'false');
            }
        });
    if (!toggleBtn) {
        toggleBtn = document.createElement('button');
        toggleBtn.id = 'kt_app_sidebar_toggle';
        toggleBtn.type = 'button';
        toggleBtn.className = 'kt-sidebar-pin-btn';
        // Add an icon element inside the button
        const icon = document.createElement('span');
        icon.className = 'toggle-icon ki-arrow-left'; // default icon classes (adjust to your icon font)
        toggleBtn.appendChild(icon);

        // Append the button to the sidebar (adjust position as needed)
        // Prefer appending to a header area inside sidebar if you have one, otherwise append to sidebar.
        const insertTarget = sidebar.querySelector('.kt-sidebar-header') || sidebar;
        insertTarget.appendChild(toggleBtn);
    }

    // Ensure we have a toggleIcon reference
    let toggleIcon = toggleBtn.querySelector('.toggle-icon');
    if (!toggleIcon) {
        toggleIcon = document.createElement('span');
        toggleIcon.className = 'toggle-icon ki-arrow-left';
        toggleBtn.appendChild(toggleIcon);
    }

    // load saved states
    let isPinned = localStorage.getItem('sidebarPinned') === 'true';
    let isMinimized = localStorage.getItem('sidebarMinimized') === 'true';

    // utility to update DOM classes and localStorage
    function applyState({ pinned = isPinned, minimized = isMinimized } = {}) {
        isPinned = pinned;
        isMinimized = minimized;

        // pinned => always open
        if (isPinned) {
            sidebar.classList.remove('app-sidebar-minimized');
            mainContent.classList.remove('app-main-expanded');
            toggleIcon.classList.remove('ki-arrow-right');
            toggleIcon.classList.add('ki-arrow-left');
        } else {
            // honor minimized flag
            if (isMinimized) {
                sidebar.classList.add('app-sidebar-minimized');
                mainContent.classList.add('app-main-expanded');
                toggleIcon.classList.remove('ki-arrow-left');
                toggleIcon.classList.add('ki-arrow-right');
            } else {
                sidebar.classList.remove('app-sidebar-minimized');
                mainContent.classList.remove('app-main-expanded');
                toggleIcon.classList.remove('ki-arrow-right');
                toggleIcon.classList.add('ki-arrow-left');
            }
        }

        // visual for pin button
        if (isPinned) {
            toggleBtn.classList.add('pinned');
            toggleBtn.setAttribute('aria-pressed', 'true');
        } else {
            toggleBtn.classList.remove('pinned');
            toggleBtn.setAttribute('aria-pressed', 'false');
        }

        localStorage.setItem('sidebarPinned', isPinned ? 'true' : 'false');
        localStorage.setItem('sidebarMinimized', isMinimized ? 'true' : 'false');
    }

    // initial apply
    applyState({ pinned: isPinned, minimized: isMinimized });

    // click -> toggle pin (pin/unpin)
    toggleBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        isPinned = !isPinned;

        if (isPinned) {
            // when pinned, ensure sidebar is open
            isMinimized = false;
        } else {
            // when unpinned, you might want it to return to minimized by default.
            // keep the previously saved minimized value or default to true
            isMinimized = (localStorage.getItem('sidebarMinimized') === 'true');
        }

        applyState({ pinned: isPinned, minimized: isMinimized });
    });

    // Hover behavior only when NOT pinned
    sidebarHover.addEventListener('mouseenter', function () {
        if (!isPinned) {
            // expand on hover
            isMinimized = false;
            applyState({ pinned: isPinned, minimized: isMinimized });
        }
    });

    sidebarHover.addEventListener('mouseleave', function () {
        if (!isPinned) {
            // collapse on leave (minimize)
            isMinimized = true;
            applyState({ pinned: isPinned, minimized: isMinimized });
        }
    });

    // Optional: allow clicking outside to auto-close when unpinned (common UX)
    document.addEventListener('click', function (ev) {
        if (isPinned) return; // ignore when pinned
        // if click outside sidebar, minimize
        if (!sidebar.contains(ev.target)) {
            isMinimized = true;
            applyState({ pinned: isPinned, minimized: isMinimized });
        }
    });
        // Handle responsive behavior
        function handleResize() {
            if (window.innerWidth < 992) { // lg breakpoint
                sidebar.classList.remove('app-sidebar-minimized');
                mainContent.classList.remove('app-main-expanded');
                toggleIcon.classList.remove('ki-arrow-right');
                toggleIcon.classList.add('ki-arrow-left');
            } else {
                // Restore saved state on larger screens
                if (localStorage.getItem('sidebarMinimized') === 'true') {
                    sidebar.classList.add('app-sidebar-minimized');
                    mainContent.classList.add('app-main-expanded');
                    toggleIcon.classList.remove('ki-arrow-left');
                    toggleIcon.classList.add('ki-arrow-right');
                }
            }
        }

        // Initial call
        handleResize();

        // Listen for resize events
        window.addEventListener('resize', handleResize);
    });
</script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.js'></script>
<script>

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth'
        });
        calendar.render();
    });

    $(document).on('focusin', function(e) {
                if ($(e.target).closest('.select2-container').length) {
                    e.stopImmediatePropagation();
                }
            });

            // Initialize Select2s inside any modal
            $(document).on('shown.bs.modal', '.modal', function () {
                var $modal = $(this);
                $modal.find('select[data-control="select2"]').each(function () {
                    var $select = $(this);
                    if ($select.data('select2')) $select.select2('destroy');
                    $select.select2({
                        dropdownParent: $modal,
                        width: '100%'
                    });
                });
            });


</script>
