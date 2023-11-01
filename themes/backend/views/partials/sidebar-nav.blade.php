<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('admin.dashboard.index')}}" class="brand-link">

        <span class="brand-text font-weight-light" style="display: flex;">
            <img src="{{ asset('images/uim_apps.svg')}}" class="ml-2 mx-3" alt="">
            Khám chữa bệnh</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        {{-- <div class="os-resize-observer-host observed"><div class="os-resize-observer" style="left: 0px; right: auto;"></div></div>
        <div class="os-size-auto-observer observed" style="height: calc(100% + 1px); float: left;"><div class="os-resize-observer"></div></div>
        <div class="os-content-glue" style="margin: 0px -8px; width: 249px; height: 404px;"></div>
        <div class="os-padding">
            <div class="os-viewport os-viewport-native-scrollbars-invisible os-viewport-native-scrollbars-overlaid" style="overflow-y: scroll;">
                <div class="os-content" style="padding: 15px 8px; height: 100%; width: 100%;"> --}}
                    <nav class="mt-2">
                        {!! $sidebar !!}
                    </nav>
{{-- 
                </div>
            </div>
        </div>
        <div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden"><div class="os-scrollbar-track"><div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px, 0px);"></div></div></div>
        <div class="os-scrollbar os-scrollbar-vertical os-scrollbar-auto-hidden"><div class="os-scrollbar-track"><div class="os-scrollbar-handle" style="height: 29.8013%; transform: translate(0px, 0px);"></div></div></div>
        <div class="os-scrollbar-corner"></div> --}}
    </div>
</aside>
