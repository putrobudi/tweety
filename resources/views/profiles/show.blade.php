<x-app>
    <header class="mb-6 relative">
        <div class="relative">
            <img src="/images/default-profile-banner.jpg" alt="" class="mb-2 rounded-lg">

            <img src="{{ $user->avatar }}" 
                alt="" 
                class="rounded-full mr-2 absolute bottom-0 transform -translate-x-1/2 translate-y-1/2"
                style="left: 50%"
                width="150"
                {{-- style="width: 150px; left: calc(50% - 75px); top: 292px;" 
                using translate will be more reponsive. --}}>
        </div>

        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="font-bold text-2xl mb-0">{{ $user->name }}</h2>
                <p class="text-sm">Joined {{ $user->created_at->diffForHumans() }}</p>
            </div>

            <div class="flex">
                {{-- if you want to simplify auth()->user() to e.g current_user() then you can make a global helper function.
                    Just make a helper function in App directory. Notice this is similar but different
                    to custom Model method. --}}
               {{--  @if (auth()->user()->is($user)) --}} {{-- later you can use @can('edit-profile') if you implement authorization.--}}
               {{-- with policy defined, when you want to give authorization e.g to administrator 
                 or manager, then you'd just have to make changes in the policy. And then
                 you'd just have to write @can('edit', $user) here. --}}
               {{-- @if (current_user()->is($user)) --}}
               @can('edit', $user)
                    <a href="{{ $user->path('edit') }}" class="rounded-full border border-gray-300 py-2 px-4 text-black text-xs mr-2">Edit
                        Profile</a>
                @endcan

                {{-- if you don't use :, it will be interpreted as a string. --}}
                {{-- <x-follow-button :user="$user"></x-follow-button> --}}
                <x-follow-button :user="$user"></x-follow-button>
            </div>
        </div>
        <p class="text-sm">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum voluptas nesciunt autem a sapiente
            repellat,
            minima illum soluta odit facilis asperiores eos iste voluptate quod neque sed. Maiores nemo vero et
            praesentium
            voluptas reiciendis, accusamus repellat quam fugiat amet itaque, saepe doloribus ea eaque sint? Eveniet
            doloremque pariatur quisquam error.
        </p>

    </header>

    {{-- tweets has to be known for _timeline --}}
    @include('_timeline', [
    'tweets' => $user->tweets
    ])
</x-app>
