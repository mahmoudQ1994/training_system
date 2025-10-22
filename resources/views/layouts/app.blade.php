<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'نظام قاعات التدريب') }}</title>

    {{-- ✅ Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">

    {{-- ✅ Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Lightbox2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">

    <!-- GLightbox JS -->
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <style>
        /* ✅ تنسيق السايدبار */
        .sidebar {
            width: 260px;
            transition: all 0.3s ease-in-out;
            z-index: 1040;
            overflow-y: auto;
            background-color: #f8f9fa;
            position: fixed;
            top: 70px; /* تحت الهيدر */
            bottom: 40px; /* فوق الفوتر */
        }

        /* ✅ حركة الانزلاق */
        .sidebar-collapsed {
            margin-right: -260px;
        }

        /* ✅ تأثير hover */
        .sidebar .nav-link:hover {
            background-color: #e9f2ff;
            border-radius: 8px;
            color: #0d6efd !important;
            transition: 0.2s;
        }

        /* ✅ لتجنب تغطية المحتوى */
        #mainContent {
            margin-right: 260px;
            margin-top: 70px;
            margin-bottom: 40px;
            transition: margin-right 0.3s ease-in-out;
            flex-grow: 1;
            padding: 20px;
        }

        /* ✅ لما السايدبار يتقفل */
        #mainContent.expanded {
            margin-right: 0;
        }

        /* ✅ سكرول داخلي للسايدبار */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background: #bbb;
            border-radius: 4px;
        }
        
        .sidebar-overlay.active {
            opacity: 1;
        }

        /* ✅ انزلاق ناعم للسايدبار */
        @media (max-width: 992px) {
            .sidebar {
                margin-right: -260px;
            }
            .sidebar.active {
                margin-right: 0;
                box-shadow: -3px 0 10px rgba(0, 0, 0, 0.2);
            }
            #mainContent {
                margin-right: 0;
            }
        }
    </style>
</head>

<body class="bg-light">

    {{-- ✅ الهيدر الثابت --}}
    @include('layouts.navigation')

    <main class="d-flex">
        {{-- ✅ الشريط الجانبي --}}
        @include('layouts.sidebar')

        {{-- ✅ الخلفية المموهة --}}
        <div id="sidebarOverlay" class="sidebar-overlay d-none"></div>

        {{-- ✅ منطقة المحتوى --}}
        <div id="mainContent" class="flex-grow-1 p-3" style="margin-top: 0; !important; margin-bottom: 2rem; ">
            {{-- ✅ زر التبديل للسايدبار --}}
            @yield('content')
        </div>
    </main>

    {{-- ✅ الفوتر الثابت --}}
    <footer class="bg-white text-center text-muted py-2 border-top shadow-sm"
        style="position: fixed; bottom: 0; right: 0; width: 100%; z-index: 1050;">
        <small>© 2025 مديرية الشئون الصحية بسوهاج - نظام قاعات التدريب</small>
    </footer>

    {{-- ✅ سكريبتات Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ✅ شاشة التحميل -->
<div id="loader-overlay">
    <div class="loader">
        <div class="spinner-border text-primary" style="width: 4rem; height: 4rem;" role="status">
            <span class="visually-hidden">جاري التحميل...</span>
        </div>
    </div>
</div>

<style>
    /* شاشة التحميل */
    #loader-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        transition: opacity 0.5s ease;
    }
    #loader-overlay.fade-out {
        opacity: 0;
        visibility: hidden;
    }
</style>

<script>
    // ✅ إخفاء شاشة التحميل عند اكتمال تحميل الصفحة
    window.addEventListener('load', () => {
        const loader = document.getElementById('loader-overlay');
        loader.classList.add('fade-out');
        setTimeout(() => loader.style.display = 'none', 500);
    });
</script>


    {{-- ✅ سكريبت التحكم في السايدبار والتمويه --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebarMenu');
            const content = document.getElementById('mainContent');
            const toggleBtn = document.getElementById('toggleSidebarBtn');
            const overlay = document.getElementById('sidebarOverlay');

            // ✅ عند الضغط على الزر
            toggleBtn?.addEventListener('click', () => {
                if (window.innerWidth > 992) {
                    sidebar.classList.toggle('sidebar-collapsed');
                    content.classList.toggle('expanded');
                } else {
                    sidebar.classList.toggle('active');
                    overlay.classList.remove('d-none');
                    setTimeout(() => overlay.classList.add('active'), 10);
                }
            });

            // ✅ عند الضغط على الخلفية يغلق السايدبار
            overlay?.addEventListener('click', () => {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
                setTimeout(() => overlay.classList.add('d-none'), 300);
            });
        });

        const lightbox = GLightbox({
            selector: 'glightbox',
            touchNavigation: true,
            loop: true,
            zoomable: true,
            openEffect: 'fade',
            closeEffect: 'fade',
            slideEffect: 'slide'
        });


    </script>

    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>


</body>
</html>
