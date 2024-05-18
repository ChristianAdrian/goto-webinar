<div class="container">
    <div class="card p-5">
        <form wire:submit="save">
            <div class="row">
                <div class="col">
                    <label for="name">Event Name</label>
    
                    <input class="form-control" id='name'name='name' type="text"wire:model="name">
                    @error('name') <span class="error">{{ $message }}</span> @enderror 
    
                </div>
                <div class="col">
                    <label for="name">Description</label>
                    <input class="form-control" id='description'name='description' type="text" wire:model="description">
                    @error('description') <span class="error">{{ $message }}</span> @enderror 
                </div>
                <div class="col">
                    <label for="name">Event</label>
    
                    <select class="form-control" name="event_id" id="event_id" wire:model='event_id'>
                        <option value="">Nothing Selected</option>
                        @foreach ($event_list as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                    @error('event_id') <span class="error">{{ $message }}</span> @enderror 
    
                </div>
                <div class="col">
                    <button  class=' btn btn-success btn-sm w-100'type='submit'>save</button>

                </div>
            </div>
        </form>
    </div>
    
    @if ($list)
        @foreach ($list as $item) 
        <div class="card p-3">
            <h5>Webinar Name: <b>{{$item->name}}</b></h5>
            <p>Event: <b>{{$item->event->name}}</b></p>
            <i>{{$item->description}}</i>
            <div class="row">
                <div class="col">
                    <button class="btn btn-sm btn-danger w-100" wire:click='remove({{$item->id}})'> Remove</button>
                </div>
                <div class="col">
                    <button class="btn btn-sm btn-dark w-100"> Add GoTo Webinar</button>
                </div>
            </div>

        </div>
        @endforeach
    @endif
    
    
</div>
