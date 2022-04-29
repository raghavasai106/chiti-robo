<?php
use App\Http\Controllers\BotManController;
use BotMan\BotMan\Middleware\Dialogflow;

$botman = resolve('botman');

$botman->hears('Hi', function ($bot) {
    $bot->reply('Hello!');
});
$botman->hears('Hi(.*)|Hello(.*)', function ($bot) {
    $bot->reply('Hello!');
    $bot->reply('How are you?');

});
$botman->hears('Start conversation', BotManController::class.'@startConversation');
$botman->hears('Weather in {location}', function ($bot, $location) {
    $url = 'http://api.weatherstack.com/current?access_key=0cf5a6cd0a5b4b1b39490265337df1f8&query='.urlencode($location);
    $response = json_decode(file_get_contents($url));

    $bot->reply('The weather in '.$response->location->name.', '.$response->location->country.' is:');
    $bot->reply('Wind Speed: ' .$response->current->wind_speed);
    $bot->reply('Temperature: '.$response->current->temperature.' Celsius');
    $bot->reply('Humidity: ' .$response->current->humidity.'%');
    $bot->reply('Visibility: ' .$response->current->visibility.'miles');

});


//$botman->hears('Start conversation', BotManController::class.'@startConversation');
//$dialogflow = \BotMan\BotMan\Middleware\Dialogflow::create('')->listenForAction();
//$dialogflow = \BotMan\Middleware\DialogFlow\V2\DialogFlow::create('en');
//$botman->middleware->received($dialogflow);
//$botman->hears('(.*)', function ($bot) {
//    $extras = $bot->getMessage()->getExtras();
//    $bot->reply($extras['apiReply']);
//})->middleware($dialogflow);

