{{-- Whenever you're in a blade loop you have access to $loop variable.
You can also use CSS nth child but for utility class like tailwind, this is a good way. --}}
<div class="flex p-4 {{ $loop->last ? '' : 'border-b border-b-gray-400' }}">
    {{-- You can do <aside> or just simple <div> --}}
    <div class="mr-2 flex-shrink-0"> {{-- flex-shrink so it's not affected by flex p-4 above so you can resize it. --}}
        <a href="{{ route('profile', $tweet->user) }}"> {{-- You don't need write $tweet->user->name
        because if you provide a model, Laravel will be smart enough to get the routeKeyName
        and then pass in only that attribute. --}}
            <img src="{{ $tweet->user->avatar }}" alt="" class="rounded-full mr-2" width="50" height="50">
        </a>
    </div>
    <div>

        <h5 class="font-bold mb-4">{{ $tweet->user->name }}</h5>
        <p class="text-sm mb-3">
            <a href="{{ route('profile', $tweet->user) }}">
                {{ $tweet->body }}
            </a>
        </p>

        <x-like-buttons :tweet="$tweet" />
    </div>
</div>
