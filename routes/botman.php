<?php

use App\Conversations\FilesConversation;
use App\Conversations\FrameworksConversation;
use App\Conversations\StoragesConversation;
use App\Http\Middleware\BotmanMatchingMiddleware;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

/** @var Botman $botman */
$botman = resolve('botman');


/*
 |--------------------------------------------------------------------------
 | 1. BASES
 |--------------------------------------------------------------------------
 |
 */
if (str_is('*bases*', request()->header('Referer'))) {

    /*
     |--------------------------------------------------------------------------
     | 1.1 Réagir à un message selon un pattern
     |--------------------------------------------------------------------------
     |
     */
    $botman->hears('.*(bonjour|coucou|hello|salut).*', function (Botman $bot) {
        $bot->reply("Bonjour  !");
    });

    /*
     |--------------------------------------------------------------------------
     | 1.2 Accéder aux informations de l'user
     |--------------------------------------------------------------------------
     |
     */
    $botman->hears('.*id.*', function (Botman $bot) {
        $bot->reply("Ton ID est le #" . $bot->getUser()->getId());
    });

    /*
     |--------------------------------------------------------------------------
     | 1.3 Lire des informations dans le message
     |--------------------------------------------------------------------------
     |
     */
    $botman->hears(".*je m'appelle ([a-zA-Z ]+).*", function (Botman $bot, $name) {
        $bot->reply("Enchanté $name !");
    });

    /*
     |--------------------------------------------------------------------------
     | 1.4 Action par défaut
     |--------------------------------------------------------------------------
     |
     */
    $botman->fallback(function (BotMan $bot) {
        $bot->reply("Je n'ai pas compris !");
    });

}













































/*
 |--------------------------------------------------------------------------
 | 2. CONVERSATIONS
 |--------------------------------------------------------------------------
 |
 */
if (str_is('*conversations*', request()->header('Referer'))) {

    /*
     |--------------------------------------------------------------------------
     | 2.1 Démarrer une conversation
     |--------------------------------------------------------------------------
     |
     */
    $botman->hears('hello', function (BotMan $bot) {
        $bot->startConversation(new FrameworksConversation);
    });

    /*
     |--------------------------------------------------------------------------
     | 2.2 Mettre fin à la conversation
     |--------------------------------------------------------------------------
     |
     */
    $botman->hears('stop', function (BotMan $bot) {
        $bot->reply('Fin de la conversation');
    })->stopsConversation();

}













































/*
 |--------------------------------------------------------------------------
 | 3. STORAGES
 |--------------------------------------------------------------------------
 |
 */
if (str_is('*storages*', request()->header('Referer'))) {

    /*
     |--------------------------------------------------------------------------
     | 3.1 Sauvegarder une information dans les storages
     |--------------------------------------------------------------------------
     |
     | BotMan propose plusieurs types de storage, à 3 niveaux différents :
     |
     |    1. userStorage()      => les infos sont stockées pour l'user actuel
     |    2. channelStorage()   => les infos sont stockées pour le canal actuel
     |    3. driverStorage()    => les infos sont dispos à tous les users
     |
     */
    $botman->hears('hello', function (Botman $bot) {
        $bot->startConversation(new StoragesConversation);
    });

    /*
     |--------------------------------------------------------------------------
     | 3.2 Lire les informations sauvées dans les storages
     |--------------------------------------------------------------------------
     |
     */
    $botman->hears('{storage}', function (BotMan $bot, $storage) {
        if (method_exists($bot, $storage)) {
            $name = $bot->$storage()->get('name');

            if (empty($name)) {
                $bot->reply("Oups, ton nom a déjà disparu du $storage...");
            } else {
                $bot->reply("Tu t'appelles $name !");
            }
        }
    });

}













































/*
 |--------------------------------------------------------------------------
 | 4. FILES
 |--------------------------------------------------------------------------
 |
 */
if (str_is('*files*', request()->header('Referer'))) {

    /*
     |--------------------------------------------------------------------------
     | 4.1 Demander à l'user d'uploader des fichiers
     |--------------------------------------------------------------------------
     |
     */
    $botman->hears('hello', function (BotMan $bot) {
        $bot->startConversation(new FilesConversation);
    });

    /*
     |--------------------------------------------------------------------------
     | 4.2 Traiter des fichiers uploadés spontanément
     |--------------------------------------------------------------------------
     |
     */
    $botman->receivesImages(function (BotMan $bot, $images) {
        foreach ($images as $image) {
            /** @var Image $image */
            $url = $image->getUrl();

            $bot->userStorage()->save([
                'image' => $url,
            ]);

            $bot->reply("Tu m'as envoyé l'image $url");
        }
    });

    /*
     |--------------------------------------------------------------------------
     | 4.3 Envoyer des fichiers
     |--------------------------------------------------------------------------
     |
     */
    $botman->hears('image', function (BotMan $bot) {
        $url = $bot->userStorage()->get('image');

        $message = OutgoingMessage::create("Voilà l'image que tu m'as envoyée  juste avant :")
            ->withAttachment(Image::url($url));

        $bot->reply($message);
    });

}












































/*
 |--------------------------------------------------------------------------
 | 5. MIDDLEWARES
 |--------------------------------------------------------------------------
 |
 */
if (str_is('*middlewares*', request()->header('Referer'))) {

    /*
     |--------------------------------------------------------------------------
     | 5.1 Appliquer des middlewares maison
     |--------------------------------------------------------------------------
     |
     */
    $botman->middleware->matching(new BotmanMatchingMiddleware());

    /*
     |--------------------------------------------------------------------------
     | 5.2 Exécuter une action à tous les messages...
     |--------------------------------------------------------------------------
     |
     */
    $botman->hears('.*', function (BotMan $bot) {
        $bot->reply("Tu as trouvé le mot de passe, félicitations !");
    });

    /*
     |--------------------------------------------------------------------------
     | 5.3 Fallback qui ne devrait jamais être exécutée...
     |--------------------------------------------------------------------------
     |
     */
    $botman->fallback(function (BotMan $bot) {
        $bot->reply("Le mot de passe est 'toto'");
    });

}
