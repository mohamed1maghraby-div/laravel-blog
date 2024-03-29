<div class="wn__sidebar">
    <aside class="widget recent_widget">
        <ul>
            <li class="list-group-item">
                @if (auth()->user()->user_image)
                    <img src="{{ asset('assets/users/' . auth()->user()->user_image) }}" alt="{{ auth()->user()->name }}">
                @else
                <img src="{{ asset('user/assets/images/') }}" alt="{{ auth()->user()->name }}">
                @endif
            </li>
            <li class="list-group-item">
                <a href="{{ route('user.dashboard') }}">My Posts</a>
            </li>
            <li class="list-group-item">
                <a href="{{ route('user.post.create') }}">Create Post</a>
            </li>
            <li class="list-group-item">
                <a href="{{ route('user.comments') }}">Manage Comments</a>
            </li>
            <li class="list-group-item">
                <a href="{{ route('user.edit_info') }}">Update Information</a>
            </li>
            <li class="list-group-item">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            </li>
        </ul>
    </aside>
</div>