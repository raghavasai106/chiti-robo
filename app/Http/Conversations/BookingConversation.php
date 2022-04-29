<?php

namespace App\Http\Conversations;


use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;

class BookingConversation extends Conversation
{
    public function confirmBooking()
    {
        $user = $this->bot->userStorage()->find();

        $message = '------------------------------------------------ '."\n";
        $message .= 'Name : '.$user->get('name')."\n";
        $message .= 'Email : '.$user->get('email')."\n";
        $message .= 'Mobile : '.$user->get('mobile')."\n";
        $message .= 'Service : '.$user->get('service')."\n";
        $message .= 'Date : '.$user->get('date')."\n";
        $message .= 'Time : '.$user->get('timeslot')."\n";
        $message .= '------------------------------------------------'."\n";

        $this->say('Great. Your booking has been confirmed. Here is your booking details. '."\n".$message);
    }

    public function run()
    {
        $this->confirmBooking();
    }
}
