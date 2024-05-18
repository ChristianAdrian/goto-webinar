<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Redirect;
use Cache;
use App\Livewire\WebinarList;

class GoToWebinarController extends Controller
{
    //

    public function home(){
        
        if(cache('token')!=null){
            return Redirect::to('/list');
        }else{
            return $this->generateCode();
        }
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
            $time = 3600;
            $data_token = json_decode($response->body());
            Cache::put('token', $data_token, $seconds = 3600);
            return Redirect::to('/list');
        }
    }

}
