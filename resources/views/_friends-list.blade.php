<div class="bg-blue-50 border border-gray-300 rounded-lg py-4 px-6">
    <h3 class="font-bold text-xl mb-4">Following</h3> {{-- if you find yourself doing the css class all
    the time, then it's recommended to extract a component. --}}
    <ul>
        {{-- @foreach (range(1, 8) as $item) --}}
        @forelse (current_user()->follows as $user)
            <li class="{{ $loop->last ? '' : 'mb-4' }}">
                <div> {{-- move the flex to anchor tag because anchor tag is only 1 element --}}
                    <a href="{{ route('profile', $user) }}" class="flex items-center text-sm">
                        <img src="{{ $user->avatar }}" alt="" class="rounded-full mr-2" width="40" height="40">
                        {{ $user->name }}
                    </a>
                </div>
            </li>
        @empty
            <li>No friends yet!</li>
        @endforelse
    </ul>
</div>
