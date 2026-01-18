@extends('website.layouts.main')

@section('title')
    <title>{{$settings->site_name}} | @lang('home.portfolio')</title>
@endsection

@section('content')
    @include('website.partials.pagesSections.breadcrumb', [
        'title' => __('home.portfolio'),
        'items' => [
            ['label' => __('home.portfolio')]
        ]
    ])

    <!-- PDF Flipbook Section -->
    <section class="flipbook-section">
        <div class="container">
            <div class="flipbook-wrapper">
                <div class="controls">
                    <button id="firstPage" title="First Page" disabled>
                        <i class="fas fa-fast-backward"></i> @lang('home.First')
                    </button>
                    <button id="prevPage" title="Previous Page" disabled>
                        <i class="fas fa-chevron-left"></i> @lang('home.Previous')
                    </button>

                    <span class="page-info">
                        Page <span id="currentPage">0</span> of <span id="totalPages">0</span>
                    </span>

                    <button id="nextPage" title="Next Page" disabled>
                        @lang('home.Next') <i class="fas fa-chevron-right"></i>
                    </button>
                    <button id="lastPage" title="Last Page" disabled>
                        @lang('home.Last') <i class="fas fa-fast-forward"></i>
                    </button>
                </div>

                <div class="flipbook-container" id="flipbookContainer">
                    <div id="flipbook">
                        <div class="loading">
                            <div class="loading-spinner"></div>
                            <div>@lang('home.Loading portfolio')...</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <!-- PDF.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>

    <!-- Turn.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/turn.js/3/turn.min.js"></script>

    <script>
        (function() {
            'use strict';

            // Set PDF.js worker
            pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

            let pdfDoc = null;
            let currentZoom = 1.5;
            let totalPages = 0;
            let renderedPages = {};
            let flipbookInitialized = false;

            // Enable/disable buttons
            function enableButtons() {
                document.querySelectorAll('.controls button').forEach(btn => {
                    btn.disabled = false;
                });
            }

            // Render a PDF page to canvas
            async function renderPage(pageNum, canvas) {
                if (renderedPages[pageNum]) {
                    return renderedPages[pageNum];
                }

                try {
                    const page = await pdfDoc.getPage(pageNum);
                    const viewport = page.getViewport({ scale: currentZoom });

                    canvas.height = viewport.height;
                    canvas.width = viewport.width;

                    const context = canvas.getContext('2d');
                    const renderContext = {
                        canvasContext: context,
                        viewport: viewport
                    };

                    await page.render(renderContext).promise;
                    renderedPages[pageNum] = canvas;
                    return canvas;
                } catch (error) {
                    console.error('Error rendering page:', pageNum, error);
                    return null;
                }
            }

            // Load PDF
            async function loadPDF(url) {
                console.log('Loading PDF from:', url);

                try {
                    // Show loading state
                    document.getElementById('flipbook').innerHTML = `
                        <div class="loading">
                            <div class="loading-spinner"></div>
                            <div>Loading portfolio...</div>
                        </div>
                    `;

                    pdfDoc = await pdfjsLib.getDocument(url).promise;
                    totalPages = pdfDoc.numPages;

                    console.log('PDF loaded successfully. Total pages:', totalPages);

                    document.getElementById('totalPages').textContent = totalPages;
                    document.getElementById('currentPage').textContent = '1';

                    // Destroy previous flipbook if exists
                    if (flipbookInitialized) {
                        $('#flipbook').turn('destroy');
                    }

                    $('#flipbook').empty();
                    renderedPages = {};

                    // Add pages to flipbook
                    for (let i = 1; i <= totalPages; i++) {
                        const pageDiv = document.createElement('div');
                        pageDiv.className = 'page';
                        pageDiv.id = `page-${i}`;

                        const canvas = document.createElement('canvas');
                        pageDiv.appendChild(canvas);

                        document.getElementById('flipbook').appendChild(pageDiv);
                    }

                    // Small delay to ensure DOM is ready
                    setTimeout(async function() {
                        try {
                            // Initialize turn.js
                            $('#flipbook').turn({
                                width: $('#flipbook').parent().width(),
                                height: $('#flipbook').parent().height(),
                                autoCenter: true,
                                acceleration: true,
                                gradients: true,
                                elevation: 50,
                                duration: 1000,
                                when: {
                                    turning: function(event, page, view) {
                                        document.getElementById('currentPage').textContent = page;
                                        renderVisiblePages(page);
                                    },
                                    turned: function(event, page, view) {
                                        document.getElementById('currentPage').textContent = page;
                                    }
                                }
                            });

                            flipbookInitialized = true;
                            console.log('Flipbook initialized');

                            // Render first pages
                            await renderVisiblePages(1);

                            // Enable buttons
                            enableButtons();

                        } catch (error) {
                            console.error('Error initializing flipbook:', error);
                            $('#flipbook').html('<div class="loading" style="color: #f5576c;">Error initializing flipbook. Please refresh the page.</div>');
                        }
                    }, 100);

                } catch (error) {
                    console.error('Error loading PDF:', error);
                    $('#flipbook').html(`
                        <div class="loading" style="color: #f5576c;">
                            <p>Error loading portfolio PDF.</p>
                            <p style="font-size: 14px; margin-top: 10px;">Error: ${error.message}</p>
                            <p style="font-size: 14px;">Please check the PDF file path.</p>
                        </div>
                    `);
                }
            }

            // Render visible pages
            async function renderVisiblePages(page) {
                const pagesToRender = [page];
                if (page < totalPages) pagesToRender.push(page + 1);
                if (page > 1) pagesToRender.push(page - 1);

                for (const pageNum of pagesToRender) {
                    if (!renderedPages[pageNum]) {
                        const pageDiv = document.getElementById(`page-${pageNum}`);
                        if (pageDiv) {
                            const canvas = pageDiv.querySelector('canvas');
                            await renderPage(pageNum, canvas);
                        }
                    }
                }
            }

            // Initialize when DOM is ready
            $(document).ready(function() {
                console.log('Document ready, initializing PDF viewer...');

                // Navigation controls
                document.getElementById('prevPage').addEventListener('click', function() {
                    if (flipbookInitialized) {
                        $('#flipbook').turn('previous');
                    }
                });

                document.getElementById('nextPage').addEventListener('click', function() {
                    if (flipbookInitialized) {
                        $('#flipbook').turn('next');
                    }
                });

                document.getElementById('firstPage').addEventListener('click', function() {
                    if (flipbookInitialized) {
                        $('#flipbook').turn('page', 1);
                    }
                });

                document.getElementById('lastPage').addEventListener('click', function() {
                    if (flipbookInitialized) {
                        $('#flipbook').turn('page', totalPages);
                    }
                });

                // Keyboard navigation
                document.addEventListener('keydown', function(e) {
                    if (!pdfDoc || !flipbookInitialized) return;

                    if (e.key === 'ArrowLeft') {
                        $('#flipbook').turn('previous');
                    } else if (e.key === 'ArrowRight') {
                        $('#flipbook').turn('next');
                    }
                });

                // Responsive resize
                $(window).on('resize', function() {
                    if (flipbookInitialized && $('#flipbook').turn('is')) {
                        $('#flipbook').turn('resize');
                    }
                });

                // Load PDF on page load
                const pdfUrl = "{{ WebsiteHelper::getAsset('images/TABA.pdf') }}";

                // Add delay to ensure all resources are loaded
                setTimeout(function() {
                    loadPDF(pdfUrl);
                }, 500);
            });

        })();
    </script>
@endpush
