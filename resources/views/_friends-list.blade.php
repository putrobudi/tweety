<h3 class="font-bold text-xl mb-4">Following</h3>
<ul>
    {{-- @foreach (range(1, 8) as $item) --}}
    @forelse (current_user()->follows as $user)
        <li class="mb-4">
            <div> {{-- move the flex to anchor tag because anchor tag is only 1 element --}}
                <a href="{{ route('profile', $user) }}" class="flex items-center text-sm">
                    <img 
                        src="{{ $user->avatar }}" 
                        alt="" 
                        class="rounded-full mr-2"
                        width="40"
                        height="40">
                    {{ $user->name }}
                </a>
            </div>
        </li>
    @empty
        <li>No friends yet!</li>
    @endforelse
</ul>
