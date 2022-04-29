<?php
//
//namespace App\Conversations;
//
//use BotMan\BotMan\Messages\Conversations\Conversation;
//use BotMan\BotMan\Messages\Incoming\Answer;
//
//class OnboardingConversation extends Conversation
//{
//    protected $firstname;
//
//    protected $email;
//
//    public function askFirstname()
//    {
//        $this->ask('Hello! What is your firstname?', function(Answer $answer) {
//            // Save result
//            $this->firstname = $answer->getText();
//
//            $this->say('Nice to meet you '.$this->firstname);
//            $this->askEmail();
//        });
//    }
//
//    public function askEmail()
//    {
//        $this->ask('One more thing - what is your email?', function(Answer $answer) {
//            // Save result
//            $this->email = $answer->getText();
//
//            $this->say('Great - that is all we need, '.$this->firstname);
////            $this->bot->startConversation(new FavouriteLunchConversation());
//        });
//    }
//
//
//    public function run()
//    {
//        // This will be called immediately
//        $this->askFirstname();
//    }
//}


namespace App\Http\Conversations;


use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use Illuminate\Support\Facades\Validator;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Conversations\Conversation;

class OnboardingConversation extends Conversation
{
    protected $name;

    public function askName()
    {
        $this->ask('What is your name?', function (Answer $answer) {
            $this->bot->userStorage()->save([
                'name' => $answer->getText(),
            ]);

            $this->say('Nice to meet you ' . $answer->getText());
            $this->askEmail();
        });
    }

    public function askEmail()
    {
        $this->ask('What is your email?', function (Answer $answer) {

            $validator = Validator::make(['email' => $answer->getText()], [
                'email' => 'email',
            ]);

            if ($validator->fails()) {
                return $this->repeat('That doesn\'t look like a valid email. Please enter a valid email.');
            }

            $this->bot->userStorage()->save([
                'email' => $answer->getText(),
            ]);

            $this->askMobile();
        });
    }

    public function askMobile()
    {
        $this->ask('Great. What is your mobile?', function (Answer $answer) {
            $this->bot->userStorage()->save([
                'mobile' => $answer->getText(),
            ]);

            $this->say('Great!');
            $this->bot->startConversation(new \App\Http\Conversations\SelectServiceConversation());
        });
    }

    public function run()
    {
        $this->askName();
    }
}