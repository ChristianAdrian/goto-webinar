<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Webinar;

class WebinarManage extends Component
{
    public $data;
    protected $listeners = [
        'getSelected'=>'getSelected'
    ];
    
    public function render()
    {
        return view('livewire.webinar-manage');
    }
    public function getSelected(){

    }

    public function add(){

    }
    public function save(){

        $data->save();

    }
}
