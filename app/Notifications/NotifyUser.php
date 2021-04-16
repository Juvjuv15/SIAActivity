<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notifiable;

class NotifyUser extends Notification
{
    use Queueable;
    // use Notification;
    // protected $othercontent;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($content)
    {
        $this->content = $content;
        // $this->othercontent = $othercontent;        
    }

    // public static function other($othercontent)
    // {
    //     $this->othercontent = $othercontent;
    //     // $this->othercontent = $othercontent;        
    // }
    // public static function othercontent($othercontent)
    // {
    //     $other = new self();
    //     $other = $content($othercontent);
    // }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return 
        // [
            // 'content' => $this->content,
            $this->content;
            // $this->othercontent;
            

            // $this->othercontent;                          
        // ];
    }
}

