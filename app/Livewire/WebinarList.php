<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Webinar;
use Cache;
class WebinarList extends Component
{

    public $list;
    public $form;


    protected $rules = [
        'form.name'=>'required',
        'form.description'=>'required',
        'form.event_id'=>'required',
        
    ];
    public function render()
    {
        return view('livewire.webinar-list');
    }
    public function mount(){
        $this->getList();
    }
    public function getList(){
        $this->list = Webinar::get();
    }

    public function add(){
        $this->validate();
        
    }


}
