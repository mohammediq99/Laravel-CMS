<div class="wn__sidebar"> 
	<aside class="widget recent_widget">
			<ul>
				<li class="list-group-item">
                <img src="{{ asset('assets/users/'.auth()->user()->user_image) }}" alt="{{ auth()->user()->name}}">
                </li>
 				<li class="list-group-item"><a href="{{ route('frontend.dashboard') }}">My posts</a></li>
				<li class="list-group-item"><a href="{{ route('users.post.create') }}">Create Post</a></li>
                <li class="list-group-item"><a href="{{ route('users.comments') }}">Manage Comments</a></li>
				<li class="list-group-item"><a href="{{ route('users.edit_info') }}">update Information</a></li>
				<li class="list-group-item"><a href="" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a><form action="{{ route('frontend.logout') }}" method="POST" style="display:none;" id="logout-form"> @csrf </form></li>
			</ul>
	</aside>
</div> 