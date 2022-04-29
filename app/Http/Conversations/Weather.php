<?php

namespace App\Http\Conversations;
use App\Http\Controllers\BotManController;
use BotMan\BotMan\Messages\Conversations\Conversation;
use Illuminate\Foundation\Inspiring;
use App\Conversations\ExampleConversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;


class Weather extends Conversation
{
    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
//    {
//        $question = Question::create("Huh - you woke me up. What do you need?")
//            ->fallback('Unable to ask question')
//            ->callbackId('ask_reason')
//            ->addButtons([
//                Button::create('India')->value('someth'),
//                Button::create('Give me a fancy quote')->value('quote'),
//            ]);
//
//        return $this->ask($question, function (Answer $answer) {
//            if ($answer->isInteractiveMessageReply()) {
//                if ($answer->getValue() === 'someth') {
//                    $locat= json_decode(file_get_contents('http://api.weatherstack.com/current?access_key=ecdbeb300cc6bd5b4ff98fdce0db9545&query=india'));
//                    $this->say($locat->location->localtime);
//                } else {
//                    $this->say(Inspiring::quote());
//                }
//            }
//        });
//    }
    {
        $this->ask('In which location you need weather', function (Answer $answer) {
            $this->bot->userStorage()->save([
                'locat' => $answer->getText(),
            ]);

            $url = 'http://api.weatherstack.com/current?access_key=ecdbeb300cc6bd5b4ff98fdce0db9545&query='.urlencode($answer);
            $response = json_decode(file_get_contents($url));
            $this->say('Temperature in: ' .$response->location->name. ", " .$response->location->country. " is " .$response->current->temperature. "°C");
//            $this->say('temperature: ' .$response->current->temperature. "°C");

        });

    }

}
