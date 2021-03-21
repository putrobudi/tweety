{{-- Couple ways to do this: 
  a. 1 form with toggle button (single endpoint, pragmatic way.)
  b. Two forms: Restful way ==> 
  @if (auth()
        ->user()
        ->following($user)) display unfollow form
  and the opposite. Two endpoints: POST Request and Delete Request. 
  c. Maybe this is a view component and you're submitting axios request or maybe you're using 
      Larevel Livewire. --}}
{{-- @if (auth()->user()->isNot($user)) --}} {{-- or user unless --}}
@unless (current_user()->is($user))
    <form method="POST" action="/profiles/{{ $user->name }}/follow" {{-- or you can do /follow and pass user as part of the request. --}}>
        @csrf
        <button type="submit" class="bg-blue-500 rounded-full shadow py-2 px-4 text-white text-xs">
            {{ current_user()->following($user)
        ? 'Unfollow Me'
        : 'Follow Me' }}
        </button>
    </form>
@endunless
