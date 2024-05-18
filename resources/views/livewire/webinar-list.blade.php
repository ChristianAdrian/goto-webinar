<div>
    @if ($list)
        @foreach ($list as $item) 
        <div class="card">
            <h5>{{$item->name}}</h5>
            <p>{{$item->description}}</p>
        </div>

        @endforeach
    @endif
    
    
</div>
