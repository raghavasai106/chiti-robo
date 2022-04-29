<?php

namespace App\Http\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;

class MoreDetails extends Conversation
{
    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->ask('How can I help you?', function(Answer $answer) {
            $this->query = $answer->getText();

            $this->say('Your query has been forwarded, we will contact you soon.');
        });
    }
}
