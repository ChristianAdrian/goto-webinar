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
            <h5>Event Name: <b>{{$item->name}}</b></h5>
            <p>{{$item->description}}</p>
            <button>GoTo Webinar</button>
        </div>
        @endforeach
    @endif
    
    
</div>
