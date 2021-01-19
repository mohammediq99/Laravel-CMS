<div class="wn__sidebar"> 
	<aside class="widget recent_widget">
			<ul>
				<li class="list-group-item">
                <img src="{{ get_gravatar(auth()->user()->email,80) }}" alt="{{ auth()->user()->name}}">
                </li>
 				<li class="list-group-item"><a href="{{ route('frontend.dashboard') }}">My posts</a></li>
				<li class="list-group-item"><a href="{{ route('users.post.create') }}">Create Post</a></li>
                <li class="list-group-item"><a href="{{ route('frontend.dashboard') }}">Manage Comments</a></li>
				<li class="list-group-item"><a href="{{ route('frontend.dashboard') }}">update Information</a></li>
				<li class="list-group-item"><a href="" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a><form action="{{ route('frontend.logout') }}" method="POST" style="display:none;" id="logout-form"> @csrf </form></li>
			</ul>
	</aside>
</div> 