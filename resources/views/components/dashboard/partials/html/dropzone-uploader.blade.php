<div class="dropzone upload_images dz-clickable" id="{{ $elementId }}">
    <div class="dz-message needsclick">
        <i class="ki-outline ki-file-up text-primary fs-3x"></i>
        <div class="ms-4">
            <h3 class="fs-5 fw-bold text-gray-900 mb-1">@lang('dash.Drop files here or click to upload.')</h3>
        </div>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            const token = "{{ csrf_token() }}";
            const uploadUrl = "{{ $uploadUrl }}";
            const removeUrl = "{{ $removeUrl }}";
            const type = "{{ $type }}";

            new Dropzone("#{{ $elementId }}", {
                url: uploadUrl,
                paramName: "file",
                addRemoveLinks: true,
                acceptedFiles: "{{ $acceptedFiles }}",
                maxFilesize: {{ $maxFilesize }}, // MB
                headers: {
                    'X-CSRF-TOKEN': token
                },
                init: function() {
                    const dz = this;

                    dz.on("sending", function(file, xhr, formData) {
                        formData.append("_token", token);
                        formData.append("type", type);
                    });

                    dz.on("removedfile", function(file) {
                        if (file.manuallyRemoved) return;

                        const fileName = file.name || (file.upload && file.upload.filename);
                        const fileData = {
                            _token: token,
                            type: type,
                            name: fileName,
                            request: 'delete'
                        };

                        // Show loading state
                        const removeButton = file.previewElement.querySelector(".dz-remove");
                        if (removeButton) {
                            removeButton.disabled = true;
                            removeButton.textContent = "Removing...";
                        }

                        fetch(removeUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(fileData)
                        })
                            .then(response => {
                                if (!response.ok) throw new Error('Delete failed');
                                return response.json();
                            })
                            .then(data => {
                                console.log('File removed:', data);
                                file.manuallyRemoved = true;
                                dz.removeFile(file);
                            })
                            .catch(error => {
                                console.error('Deletion failed:', error);
                                if (removeButton) {
                                    removeButton.disabled = false;
                                    removeButton.textContent = "Remove";
                                }
                                const errorElement = file.previewElement.querySelector(".dz-error-message");
                                if (errorElement) {
                                    errorElement.textContent = "Failed to delete. Try again.";
                                    errorElement.style.display = "block";
                                }
                            });
                    });

                    dz.on("error", function(file, errorMessage) {
                        console.error("Upload error:", errorMessage);
                        if (errorMessage.includes("CSRF")) {
                            alert("Session expired. Please refresh the page.");
                        }
                    });
                }
            });
        });
    </script>
@endpush
