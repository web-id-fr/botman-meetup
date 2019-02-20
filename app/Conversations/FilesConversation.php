<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;

class FilesConversation extends Conversation
{
    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->askForImages("Hello ! Peux-tu m'envoyer une image ?", function ($images) {

            foreach ($images as $image) {
                /** @var Image $image */
                $url = $image->getUrl();

                $this->bot->userStorage()->save([
                    'image' => $url,
                ]);

                $this->say("Tu m'as envoyé l'image $url");
            }

        }, function (Answer $answer) {

            if (empty($answer->getMessage()->getFiles())) {
                $this->say("Tu n'as envoyé aucun fichier !");
            } else {
                $this->say("Ce n'est pas une image !");
            }

        });
    }
}
