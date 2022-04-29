<?php
use App\Http\Controllers\BotManController;

$botman = resolve('botman');

$botman->hears('Hello', function($bot) {
    $bot->startConversation(new \App\Http\Conversations\SelectSomethingConversation());
});
$botman->hears('Appointment', function ($bot){
    $bot->startConversation(new \App\Http\Conversations\OnboardingConversation());
});

$botman->hears('Start conversation', BotManController::class.'@startConversation');
$dialogflow = \BotMan\BotMan\Middleware\Dialogflow::create('')->listenForAction();
$dialogflow = \BotMan\Middleware\DialogFlow\V2\DialogFlow::create('en');
$botman->middleware->received($dialogflow);
$botman->hears('(.*)', function ($bot) {
    $extras = $bot->getMessage()->getExtras();
    $bot->reply($extras['apiReply']);
})->middleware($dialogflow);

//$botman->hears('intent-action-name', function (BotMan\BotMan $bot) {
//    // The incoming message matched the "my_api_action" on Dialogflow
//    // Retrieve Dialogflow information:
//    $extras = $bot->getMessage()->getExtras();
//
//    $apiReply = $extras['apiReply'];
//    $apiAction = $extras['apiAction'];
//    $apiIntent = $extras['apiIntent'];
//})->middleware($dialogflow);