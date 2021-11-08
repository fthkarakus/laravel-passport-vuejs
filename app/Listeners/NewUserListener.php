<?php

namespace App\Listeners;

use App\Events\NewUser;
use App\Mail\SendMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class NewUserListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewUser  $event
     * @return void
     */
    public function handle(NewUser $event)
    {
        $details = [
            'title' => 'Turk Ai - Öğrenci Bilgi Sistemi',
            'link'  => 'http://127.0.0.1/login',
            'body' => '<p>Sayın '. $event->user->name.',<br> Turk Ai - Öğrenci Bilgi Sistemine Hoşgeldiniz.</p><p>Kayıt esnasında belirlemiş olduğunuz kullanıcı bilgileri ile aşağıdaki linke tıklayarak giriş yapabilirsiniz.</p>'
        ];

        Mail::to($event->user->email)->send(new SendMail($details));
    }
}
