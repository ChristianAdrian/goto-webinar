<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Redirect;
use Cache;
use App\Livewire\WebinarList;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class GoToWebinarController extends Controller 
{
  
    public function home(){
        return Redirect::to('/list');
    }
    public function generateCode(){
        $url = ' https://authentication.logmeininc.com/oauth/authorize?client_id='.env('GOTO_WEBINAR_CLIENT_ID').'&response_type=code&redirect_uri='.url('/getToken'); 
        return Redirect::away($url);
    }
    public function generateToken(Request $request){
        $data =  $request->all();
        if(array_key_exists('code',$data)){
            $url = 'https://authentication.logmeininc.com/oauth/token?grant_type=authorization_code&redirect_uri='.url('/getToken').'&code='.$data['code'];
            
            $response = Http::withBasicAuth(env('GOTO_WEBINAR_CLIENT_ID'), env('GOTO_WEBINAR_SECRET'))->withHeaders([
                'Authorization: Basic N2UyZTRkYjEtMGFiNC00Y2VmLTg5OTUtZmUwNGJjMTBiNWFiOnludmRITTc5UVk4cGllRkN6WG94cG4xdg==',
            ])->post($url);
            $time = 3000;
            $data_token = json_decode($response->body());
            Cache::put('token', $data_token, $seconds = 3000);


            return Redirect::to('/list');
        }
    }
    public function getWebinarList(){
        $url = 'https://api.getgo.com/G2W/rest/v2/organizers/'.env('GOTO_WEBINAR_ACCOUNT_KEY').'/webinars';
        $token = get_object_vars(Cache::get('token'));
        $auth = 'Bearer '.$token['access_token'];
        $response = Http::
        withToken($token['access_token'])
        ->get($url,[
                'fromTime' => '2024-05-13T10:00:00Z',
                'toTime' => '2024-05-18T22:30:00Z', 
                'page'=>0,
                'size'=>10,     
        ]);
    }
   
    public function createWebinar($name = null,$description = null){
        
        $url = 'https://api.getgo.com/G2W/rest/v2/organizers/'.env('GOTO_WEBINAR_ACCOUNT_KEY').'/webinars';
        $token = get_object_vars(Cache::get('token'));
        $auth = 'Bearer '.$token['access_token'];
        $body = '{
            "subject": "'.$name.'",
            "description": "'.$description.'",
            "times": [
              {
                "startTime": "2024-08-25T14:15:22Z",
                "endTime": "2024-08-25T15:15:22Z"
              }
            ],
            "emailSettings": {
              "confirmationEmail": {
                "enabled": true
              },
              "reminderEmail": {
                "enabled": true
              },
              "absenteeFollowUpEmail": {
                "enabled": true
              },
              "attendeeFollowUpEmail": {
                "enabled": true,
                "includeCertificate": true
              }
            }
          }';
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization'=>$auth,
        ])
        ->withBody($body)->post($url);
            $result = json_decode($response->body());
            return $result->webinarKey;
    }
    public function createPanelList($webinar_id = null,$email = null,$name = null){
        $url = 'https://api.getgo.com/G2W/rest/v2/organizers/'.env('GOTO_WEBINAR_ACCOUNT_KEY').'/webinars/'.$webinar_id.'/panelists';
        $token = get_object_vars(Cache::get('token'));
        $auth = 'Bearer '.$token['access_token'];
        $body = '[
            {
              "email": "'.$email.'",
              "name": "'.$name.'"
            }
          ]';
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization'=>$auth,
        ])
        ->withBody($body)->post($url);
            $result = json_decode($response->body());
            return $result;
    }
    public function createUser($webinar_id = null,$first_name = null,$last_name = null,$email= null){
        $url = 'https://api.getgo.com/G2W/rest/v2/organizers/'.env('GOTO_WEBINAR_ACCOUNT_KEY').'/webinars/'.$webinar_id.'/registrants';
        $token = get_object_vars(Cache::get('token'));
        $auth = 'Bearer '.$token['access_token'];
        $body = '{
            "firstName": "'.$first_name.'",
            "lastName": "'.$last_name.'",
            "email": "'.$email.'",
            "source": "external",
            "responses": [
              {
                "questionKey": 0,
                "responseText": "string",
                "answerKey": 0
              }
            ]
          }';
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization'=>$auth,
        ])
        ->withBody($body)->post($url);
            $result = json_decode($response->body());
            return $result;
    }


}
