<h1>Hello user{{Auth::user()}}</h1>
<a href="" onclick="event.preventDefault(); document.getElementById('logout-form-front').submit();"
	class="dropdown-item">Sign out</a>
<form id="logout-form-front" action="/logout" method="POST" style="display: none;">
	{{ csrf_field() }}
</form>