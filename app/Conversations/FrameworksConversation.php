<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class FrameworksConversation extends Conversation
{
    /**
     * @var array
     */
    protected $frameworks = [
        "Laravel",
        "Symfony",
        "CakePHP",
    ];

    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->askForFrameworkText();
    }

    /**
     *
     */
    protected function askForFrameworkText()
    {
        $this->ask("Hello ! Quel est ton Framework préféré ?", function (Answer $answer) {

            $answerText = $answer->getText();
            $this->say("Tu as répondu '$answerText', mais juste pour être sûr...");

            $this->askForFrameworkButtons();
        });
    }

    /**
     *
     */
    protected function askForFrameworkButtons()
    {
        // On crée la liste des boutons
        $buttons = collect($this->frameworks)
            ->map(function ($framework) {
                return Button::create($framework)->value($framework);
            })
            ->toArray();

        // On crée la question
        $question = Question::create('Quel est ton framework préféré ?')
            ->callbackId('favorite_framework')
            ->addButtons($buttons);

        // On pose la question & traite la réponse
        $this->ask($question, function (Answer $answer) use ($question) {

            if ($answer->isInteractiveMessageReply()) {

                if ('Laravel' === $answer->getValue()) {
                    $this->say("Tu as répondu Laravel. Excellent choix !");
                } else {
                    $this->say("Tu as répondu " . $answer->getValue() . ". J'ai dû mal entendre...");
                    $this->repeat($question);
                }

            } else {

                $this->say("Utilise les boutons s'il te plait !");
                $this->repeat($question);
            }

        });
    }
}
