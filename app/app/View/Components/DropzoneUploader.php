<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DropzoneUploader extends Component
{
    public $uploadUrl;
    public $removeUrl;
    public $type;
    public $elementId;
    public $maxFilesize;
    public $acceptedFiles;

    public function __construct(
        string $uploadUrl,
        string $removeUrl,
        string $type,
        string $elementId = 'kt_dropzone',
        float $maxFilesize = 3, // in MB
        string $acceptedFiles = '.jpeg,.jpg,.png,.gif,.webp'
    ) {
        $this->uploadUrl = $uploadUrl;
        $this->removeUrl = $removeUrl;
        $this->type = $type;
        $this->elementId = $elementId;
        $this->maxFilesize = $maxFilesize;
        $this->acceptedFiles = $acceptedFiles;
    }

    public function render()
    {
        return view('components.dashboard.partials.html.dropzone-uploader');
    }
}
