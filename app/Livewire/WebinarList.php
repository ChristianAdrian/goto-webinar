<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Webinar;
use App\Models\Event;
use Form;
use Cache;
class WebinarList extends Component
{

    public $list;
    public $form;
    public $event_list;

    public $name;
    public $description;
    public $event_id;

    protected $rules = [
        'name'=>'required',
        'description'=>'required',
        'event_id'=>'required',
        
    ];
    public function render()
    {
        return view('livewire.webinar-list');
    }
    public function mount(){
        $this->getList();
        $this->event_list =  Event::get();
       
    }
    public function getList(){
        $this->list = Webinar::get();
    }

    public function save(){
       
        $this->validate();
        Webinar::insert(
            [   'name'=>$this->name,
                'description'=>$this->description,
                'event_id'=>$this->event_id,
                'created_at'  => date('Y-m-d H:i:s'),
            ]
        );
        $this->getList();
        $this->reset('name','description','event_id');
    }

}
