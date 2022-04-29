<?php

namespace App\Http\Conversations;

use App\Conversations\ExampleConversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

class SelectSomethingConversation extends Conversation
{
    public function askSomething()
    {
        $question = Question::create('What are you looking for?')
//            ->callbackId('select_something')
            ->addButtons([
                Button::create('Make an Appointment')->value('Appointment'),
                Button::create('Query')->value('query'),
                Button::create('Pass the time')->value('example'),
                Button::create('Weather Information')->value('weather')
            ]);

        $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                switch ($answer->getValue()) {
                    case "Appointment":
                        $this->bot->startConversation(new OnboardingConversation());
                        break;
                    case "query":
                        $this->bot->startConversation(new MoreDetails());
                        break;
                    case "example":
                        $this->bot->startConversation(new ExampleConversation());
                        break;
                    case "weather":
                        $this->bot->startConversation(new Weather());
                        break;

                }
            }
        });

//        $this->bot->startConversation(new OnboardingConversation());
//        $this->say('oakuyda');
//        $this->askNextStep();
////        $this->bot->startConversation(new OnboardingConversation());
//    }
//    // ...inside the conversation object...
//    public function askNextStep()
//    {
//        $this->ask('Shall we proceed? Say YES or NO', [
//            [
//                'pattern' => 'yes|yep',
//                'callback' => function () {
//                    $this->say('Okay - we\'ll keep going');
//                }
//            ],
//            [
//                'pattern' => 'nah|no|nope',
//                'callback' => function () {
//                    $this->say('PANIC!! Stop the engines NOW!');
//                }
//            ]
//        ]);
//
//    }

//        $this->submitThat();
////        $this->bot->startConversation(new OnboardingConversation());
//    }
//    public function submitThat()
//    {
//        $this->bot->startConversation(new OnboardingConversation()); // Trigger the next conversation
//
//    }
    }

    public function run()
    {
        $this->askSomething();

    }
}