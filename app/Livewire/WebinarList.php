<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Webinar;
use App\Models\Event;
use Form;
use Cache;
use App\Http\Controllers\GoToWebinarController;
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
        $this->list = Webinar::with('event')->get();
    }
    public function remove($id){
        Webinar::where('id',$id)->delete($id);

        $this->getList();
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
    public function linkGotoWebinar(Webinar $data){

        $gotowebinar =    New GotoWebinarController;
        
        $webinar_key = $gotowebinar->createWebinar($data->name,$data->description);
       
        $data->gotowebinar_id = $webinar_key;
        $data->save();
        $this->getList();
    }
    public function addUser(Webinar $data){

        $gotowebinar =New GotoWebinarController;
        
        $webinar_key = $gotowebinar->createUser($data->gotowebinar_id,'first_name','last_name','cadriandomantay@gmail.com');
        $data->gotowebinar_user_count++;
        $data->save();
        $this->getList();
    }
    public function addPanelList(Webinar $data){

        $gotowebinar =New GotoWebinarController;
        
        $webinar_key = $gotowebinar->createPanelList($data->gotowebinar_id,'cadriandomantay@gmail.com','name');
        $this->getList();
    }



}
