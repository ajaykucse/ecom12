<!doctype html>
<html lang="en">
    <!--begin::Head-->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>AdminLTE v4 | Dashboard</title>

        <!--begin::Theme Init (prevents flash of incorrect theme on load, #6043)-->
        <script>
            (() => {
                "use strict";
                const root = document.documentElement;

                // Applications with their own theming opt out of AdminLTE's color mode
                // entirely, here as well as in the bundle.
                if (root.getAttribute("data-lte-color-mode") === "off") {
                    return;
                }

                const STORAGE_KEY = "lte-theme";
                let stored = null;
                try {
                    stored = localStorage.getItem(STORAGE_KEY);
                } catch {
                    // localStorage may be unavailable (private mode, sandboxed iframe).
                }
                // Mirror the precedence in color-mode.ts: the visitor's stored choice
                // wins, then a theme this page declared itself, then the OS preference.
                const authored = root.getAttribute("data-bs-theme");
                let resolved = "light";
                if (stored === "dark" || stored === "light") {
                    resolved = stored;
                } else if (authored === "dark" || authored === "light") {
                    resolved = authored;
                } else if (globalThis.matchMedia("(prefers-color-scheme: dark)").matches) {
                    resolved = "dark";
                }
                root.setAttribute("data-bs-theme", resolved);
                root.style.colorScheme = resolved;
                // Flag values computed here, so the bundle does not mistake them for a
                // theme the page declared and stop following the OS preference.
                if (resolved !== authored) {
                    root.setAttribute("data-lte-theme-resolved", "");
                }
            })();
        </script>
        <!--end::Theme Init-->

        <!--begin::Accessibility Meta Tags-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
        <meta name="color-scheme" content="light dark" />
        <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
        <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
        <!--end::Accessibility Meta Tags-->

        <!--begin::Primary Meta Tags-->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="title" content="AdminLTE v4 | Dashboard" />
        <meta name="author" content="ColorlibHQ" />
        <meta
            name="description"
            content="AdminLTE is a free Bootstrap 5 admin dashboard template with almost 50 example pages, built with vanilla JS and designed with accessibility in mind."
        />
        <meta
            name="keywords"
            content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard, accessible admin panel"
        />
        <!--end::Primary Meta Tags-->

        <!--begin::Accessibility Features-->
        <!-- Skip links will be dynamically added by accessibility.js -->
        <meta name="supported-color-schemes" content="light dark" />
        <link rel="preload" href="{{ asset('/admin/css/adminlte.css') }}" as="style" />
        <!--end::Accessibility Features-->
      @include('admin.layout.styles')
    </head>
    <!--end::Head-->
    <!--begin::Body-->
    <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
        <!--begin::App Wrapper-->
        <div class="app-wrapper">
            <!--begin::Header-->
            @include('admin.layout.header')
            <!--end::Header-->
            <!--begin::Sidebar-->
            @include('admin.layout.sidebar')
            <!--end::Sidebar-->
            <!--begin::App Main-->
            @yield('content')
            <!--end::App Main-->
            <!--begin::Footer-->
            @include('admin.layout.footer')
            <!--end::Footer-->
        </div>
        <!--end::App Wrapper-->
        <!--begin::Script-->
        @include('admin.layout.scripts')
        <!--end::Script-->
    </body>
    <!--end::Body-->
</html>
