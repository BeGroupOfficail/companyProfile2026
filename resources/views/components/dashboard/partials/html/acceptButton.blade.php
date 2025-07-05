<a href="{{ $accept_url }}" title="@lang('dash.accept')"
    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" id="btn_accept">
    <i class="ki-outline ki-check-square text-gray-900 fs-2tx"></i>
</a>


<script>
    $('#btn_accept').on('click', function(e) {
        e.preventDefault();
        var $btn = $(this);
        Swal.fire({
            title: '@lang('dash.are_you_sure')',
            text: '{{ trans('dash.confirm_accept') }}',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: '@lang('dash.yes')',
            cancelButtonText: '@lang('dash.no')'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ $accept_url }}",
                    type: "GET",
                    success: function(response) {
                        Swal.fire({
                            title: '@lang('dash.success')',
                            text: '{{ trans('home.request_accepted') }}',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        $btn.closest('tr').fadeOut(300, function() {
                            $(this).remove();
                        });
                    },
                    error: function() {
                        Swal.fire({
                            title: '@lang('dash.error')',
                            text: '{{ trans('dash.error') }}',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    });
</script>
