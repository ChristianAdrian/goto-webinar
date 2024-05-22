<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Webinar;
use App\Models\Event;
use Form;
use Cache;
use App\Http\Controllers\GoToWebinarController;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Faker\Generator as Faker;

class WebinarList extends Component
{
    use LivewireAlert;

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
        $this->list = Webinar::with('event')->latest()->get();
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
        $this->alert('info', 'New Webinar Added');

        $this->getList();
        $this->reset('name','description','event_id');
    }
    public function linkGotoWebinar(Webinar $data){
        $gotowebinar =    New GotoWebinarController;
        $webinar_key = $gotowebinar->createWebinar($data->name,$data->description);
        $data->gotowebinar_id = $webinar_key;
        $this->alert('info', 'Webinar Added to Goto Webinar');

        $data->save();
        $this->getList();
    }
    public function addUser(Webinar $data){
        $gotowebinar =New GotoWebinarController;
        $response = $gotowebinar->createUser($data->gotowebinar_id,fake()->unique()->name,fake()->unique()->name,fake()->unique()->safeEmail() );
        if(property_exists($response,'validationErrorCodes')) {
            foreach($response->validationErrorCodes as $error){
                $this->alert('warning',  $error->description);
            }
        }else{
            $this->alert('info',   $response->status . (property_exists($response,'description')? ( ' - '.$response->description):''));
            if(!property_exists($response,'description')){
                $data->gotowebinar_user_count++;
                $data->save();
            }
        }
        $this->getList();
    }
    public function addPanelList(Webinar $data){

        $gotowebinar =New GotoWebinarController;
        
        $response = $gotowebinar->createPanelList($data->gotowebinar_id,fake()->unique()->safeEmail() ,fake()->unique()->name);
        if(!is_array($response) && property_exists($response,'errorCode')) {
                $this->alert('warning',  $response->description);
        }else{
            
            foreach($response as $info){
                $this->alert('info',  $info->name .' added to panelist');          
            }
            $data->gotowebinar_panelist_count++;
            $data->save();
        }
        
        $this->getList();
    }



}
