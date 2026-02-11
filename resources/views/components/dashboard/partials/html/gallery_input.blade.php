@php use App\Helper\Path; @endphp
@props([
    'model' => null,
    'modelName' => 'projects',
    'title' => 'Project Gallery',
    'name' => 'images',
    'changeImageText' => null,
    'cancelImageText' => null,
    'removeImageText' => null,
])

<div class="card card-flush card-standard">
    <!--begin::Card header-->
    <div class="card-header">
        <!--begin::Card title-->
        <div class="card-title">
            <h2>@lang("dash.$title")</h2>
        </div>
        <!--end::Card title-->
    </div>
    <!--end::Card header-->

    <!--begin::Card body-->
    <div class="card-body pt-0">
        <!--begin::Description-->
        <div class="text-muted fs-7 mb-4">{{ __('dash.only') }} *.png, *.jpg, *.jpeg, *.webp {{ __('dash.image files are accepted') }}</div>
        <!--end::Description-->

        <!--begin::Input-->
        <div class="mb-4">
             <label class="btn btn-primary">
                <i class="ki-outline ki-plus fs-2"></i> {{ __('dash.Add Images') }}
                <input type="file" name="{{ $name }}[]" class="d-none" id="gallery_upload_{{ $name }}" multiple accept=".png, .jpg, .jpeg, .webp" />
            </label>
        </div>
        <!--end::Input-->

        <!--begin::Previews-->
        <div class="d-flex flex-wrap gap-4" id="gallery_preview_{{ $name }}">
            <!-- Existing Images -->
            @if($model && $model->images)
                @foreach($model->images as $image)
                    <div class="image-preview-item position-relative" data-id="{{ $image->id }}">
                        <div class="image-input-wrapper w-150px h-150px text-center justify-content-center d-flex align-items-center border" 
                             style="background-image: url('{{ asset("uploads/$modelName/" . $image->image) }}'); background-size: cover; background-position: center;">
                        </div>
                        <button type="button" class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow position-absolute top-0 end-0 m-2 remove-existing-image" 
                                data-id="{{ $image->id }}"
                                data-bs-toggle="tooltip" title="{{ __('dash.Remove image') }}">
                            <i class="ki-outline ki-cross fs-2"></i>
                        </button>
                    </div>
                @endforeach
            @endif
        </div>
        <!--end::Previews-->

        <!-- Container for deleted image IDs -->
        <div id="deleted_images_container_{{ $name }}"></div>
    </div>
    <!--end::Card body-->
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('gallery_upload_{{ $name }}');
        const previewContainer = document.getElementById('gallery_preview_{{ $name }}');
        const deletedContainer = document.getElementById('deleted_images_container_{{ $name }}');
        let dt = new DataTransfer(); // Used to manipulate the input files

        input.addEventListener('change', function() {
            // Append new files to DataTransfer
            for(let i = 0; i < this.files.length; i++){
                let file = this.files[i];
                dt.items.add(file);
                
                // Create preview
                let reader = new FileReader();
                reader.onload = function(e){
                    let div = document.createElement('div');
                    div.className = 'image-preview-item position-relative new-image-preview';
                    div.innerHTML = `
                        <div class="image-input-wrapper w-150px h-150px border" 
                             style="background-image: url('${e.target.result}'); background-size: cover; background-position: center;">
                        </div>
                        <button type="button" class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow position-absolute top-0 end-0 m-2 remove-new-image">
                            <i class="ki-outline ki-cross fs-2"></i>
                        </button>
                    `;
                    
                    // Add remove functionality for this new image
                    div.querySelector('.remove-new-image').addEventListener('click', function() {
                        div.remove();
                        // Remove from DataTransfer
                        // Note: Browsers generate files usage differently. To reliably remove, 
                        // we would need to rebuild the DataTransfer object excluding this file.
                        // However, matching by name/size is the closest simple heuristic.
                        refreshDataTransfer(file);
                    });

                    previewContainer.appendChild(div);
                }
                reader.readAsDataURL(file);
            }
            this.files = dt.files;
        });

        // Function to rebuild DataTransfer excluding a specific file
        function refreshDataTransfer(fileToRemove) {
            const newDt = new DataTransfer();
            for (let i = 0; i < dt.files.length; i++) {
                if (dt.files[i] !== fileToRemove) {
                    newDt.items.add(dt.files[i]);
                }
            }
            dt = newDt;
            input.files = dt.files;
        }

        // Handle existing image removal
        document.querySelectorAll('.remove-existing-image').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const parent = this.closest('.image-preview-item');
                
                // Add hidden input for deletion
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'delete_images[]';
                hiddenInput.value = id;
                deletedContainer.appendChild(hiddenInput);

                // Remove preview
                parent.remove();
            });
        });
    });
</script>
