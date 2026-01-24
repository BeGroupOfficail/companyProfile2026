@extends('website.layouts.main')

@section('title')
    <title>{{ $settings->site_name }} | @lang('home.portfolio')</title>
@endsection

@section('content')
@include('website.partials.pagesSections.breadcrumb', [
    'title' => __('home.portfolio'),
    'items' => [['label' => __('home.portfolio')]]
])

<!-- PDF Flipbook Section -->
<section class="flipbook-section py-12 bg-neutral-secondary-light">
    <div class="container mx-auto">
        <div class="flipbook-wrapper shadow-lg rounded-2xl overflow-hidden bg-white">

            <!-- Controls -->
            <div class="controls d-flex flex-wrap align-items-center justify-content-center gap-3 p-4 bg-neutral-secondary-medium">
                <button id="firstPage" class="btn-control disabled:opacity-50" title="@lang('home.First')" disabled>
                    <i class="fas fa-fast-backward"></i> @lang('home.First')
                </button>
                <button id="prevPage" class="btn-control disabled:opacity-50" title="@lang('home.Previous')" disabled>
                    <i class="fas fa-chevron-left"></i> @lang('home.Previous')
                </button>

                <span class="page-info text-sm font-medium mx-2">
                    @lang('home.Page') <span id="currentPage">0</span> / <span id="totalPages">0</span>
                </span>

                <button id="nextPage" class="btn-control disabled:opacity-50" title="@lang('home.Next')" disabled>
                    @lang('home.Next') <i class="fas fa-chevron-right"></i>
                </button>
                <button id="lastPage" class="btn-control disabled:opacity-50" title="@lang('home.Last')" disabled>
                    @lang('home.Last') <i class="fas fa-fast-forward"></i>
                </button>
            </div>

            <!-- Flipbook -->
            <div class="flipbook-container relative p-4" id="flipbookContainer">
                <div id="flipbook" class="relative min-h-[400px] flex justify-center items-center">
                    <div class="loading d-flex flex-col items-center justify-content-center text-gray-500">
                        <div class="loading-spinner w-12 h-12 border-4 border-t-brand rounded-full animate-spin mb-2"></div>
                        <span>@lang('home.Loading portfolio')...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/turn.js/3/turn.min.js"></script>

<script>
(function() {
    'use strict';

    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

    let pdfDoc = null;
    let currentZoom = 1.5;
    let totalPages = 0;
    let renderedPages = {};
    let flipbookInitialized = false;

    function enableButtons() {
        document.querySelectorAll('.controls button').forEach(btn => btn.disabled = false);
    }

    async function renderPage(pageNum, canvas) {
        if (renderedPages[pageNum]) return renderedPages[pageNum];
        try {
            const page = await pdfDoc.getPage(pageNum);
            const viewport = page.getViewport({ scale: currentZoom });
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            await page.render({ canvasContext: canvas.getContext('2d'), viewport }).promise;
            renderedPages[pageNum] = canvas;
            return canvas;
        } catch (error) {
            console.error('Error rendering page:', pageNum, error);
            return null;
        }
    }

    async function loadPDF(url) {
        $('#flipbook').html(`<div class="loading flex flex-col items-center justify-center text-gray-500">
            <div class="loading-spinner w-12 h-12 border-4 border-t-brand rounded-full animate-spin mb-2"></div>
            <span>@lang('home.Loading portfolio')...</span>
        </div>`);

        try {
            pdfDoc = await pdfjsLib.getDocument(url).promise;
            totalPages = pdfDoc.numPages;
            document.getElementById('totalPages').textContent = totalPages;
            document.getElementById('currentPage').textContent = 1;

            if (flipbookInitialized) $('#flipbook').turn('destroy');
            $('#flipbook').empty();
            renderedPages = {};

            for (let i = 1; i <= totalPages; i++) {
                const pageDiv = document.createElement('div');
                pageDiv.className = 'page';
                pageDiv.id = `page-${i}`;
                pageDiv.appendChild(document.createElement('canvas'));
                $('#flipbook')[0].appendChild(pageDiv);
            }

            setTimeout(async () => {
                $('#flipbook').turn({
                    width: $('#flipbook').parent().width(),
                    height: $('#flipbook').parent().height(),
                    autoCenter: true,
                    gradients: true,
                    duration: 800,
                    when: {
                        turning: (e, page) => {
                            document.getElementById('currentPage').textContent = page;
                            renderVisiblePages(page);
                        }
                    }
                });

                flipbookInitialized = true;
                await renderVisiblePages(1);
                enableButtons();
            }, 100);

        } catch (error) {
            console.error(error);
            $('#flipbook').html(`<div class="loading text-red-500">@lang('home.Error loading portfolio PDF')</div>`);
        }
    }

    async function renderVisiblePages(page) {
        const pages = [page];
        if (page < totalPages) pages.push(page + 1);
        if (page > 1) pages.push(page - 1);

        for (const p of pages) {
            const pageDiv = document.getElementById(`page-${p}`);
            if (pageDiv) await renderPage(p, pageDiv.querySelector('canvas'));
        }
    }

    $(document).ready(function() {
        const pdfUrl = "{{ WebsiteHelper::getAsset('images/TABA.pdf') }}";

        $('#prevPage').click(() => flipbookInitialized && $('#flipbook').turn('previous'));
        $('#nextPage').click(() => flipbookInitialized && $('#flipbook').turn('next'));
        $('#firstPage').click(() => flipbookInitialized && $('#flipbook').turn('page', 1));
        $('#lastPage').click(() => flipbookInitialized && $('#flipbook').turn('page', totalPages));

        $(window).resize(() => flipbookInitialized && $('#flipbook').turn('resize'));
        document.addEventListener('keydown', e => {
            if (!flipbookInitialized) return;
            if (e.key === 'ArrowLeft') $('#flipbook').turn('previous');
            if (e.key === 'ArrowRight') $('#flipbook').turn('next');
        });

        setTimeout(() => loadPDF(pdfUrl), 300);
    });

})();
</script>
@endpush
