{{-- refence blade component --}}
{{-- @component('master') --}}
<x-master> {{-- Laravel 7 and above x-componentName --}}
    {{-- anything within this tag will be slotted in {{ $slot }}, the master component. --}}
    <section class="px-8">
        <main class="container mx-auto">
            <div class="lg:flex lg:justify-between">
                @if (auth()->check()) {{-- using this method, it throws a feeling that it'd break 
                    the moment you'd add more flecibility. So let's use blade components. Does the video refers 
                    to auth()->check() or just the overall component? I don't know.. --}}
                    <div class="lg:w-32">
                        @include('_sidebar-links')
                    </div>
                @endif
                <div class="lg:flex-1 lg:mx-10" style="max-width: 700px">
                    {{ $slot }}
                </div>
                @if (auth()->check())
                    <div class="lg:w-1/6">
                        @include('_friends-list')
                    </div>
                @endif
            </div>
        </main>
    </section>
</x-master>
