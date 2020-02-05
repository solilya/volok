<ul class="nav nav-tabs"  role="tablist">
<li class="nav-item">
<a 
@IF ($active=='main') 
class="nav-link active" 
@else
class="nav-link"
@endif role="tab" aria-controls="home" aria-selected="true" data-toggle="tab" href="{{ route('edit') }}" onclick="javascript:window.location='{{ route('edit') }}?id={{ $client->id }}'">Общая инфо</a></li>
<li class="nav-item">
<a 
@IF ($active=='helpers') 
class="nav-link active" 
@else
class="nav-link" 
@endif data-toggle="tab" href="{{ route('view_helpers') }}" role="tab" aria-controls="home" aria-selected="true" onclick="javascript:window.location='{{ route('view_helpers') }}?id={{ $client->id }}'">Доверенные лица</a></li>
<li class="nav-item"><a class="nav-link"  data-toggle="tab" href="#photo" role="tab" aria-controls="home" aria-selected="true" ></a></li>
</ul>