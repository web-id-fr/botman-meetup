<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;

class StoragesConversation extends Conversation
{
    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->ask("Hello inconnu, comment t'appelles-tu ?", function (Answer $answer) {

            $name = $answer->getText();
            $this->say("Tu t'appelles $name, c'est génial ! Laisse-moi écrire ça dans les différents storages...");

            $this->bot->userStorage()->save(compact('name'));
            $this->bot->channelStorage()->save(compact('name'));
            $this->bot->driverStorage()->save(compact('name'));

        });
    }
}
