<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function read_message(){
       foreach ( auth()->user()->unreadNotifications as $notifcation){
           $notifcation->markAsRead();
       }
    }

    public function notifications(){

        return view('CP.notifications');
        
     }
    
}
