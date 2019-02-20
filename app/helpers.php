<?php

if (!function_exists('step_bases')) {
    /**
     * Détermine si on est sur l'étape "Bases"
     *
     * @return bool
     */
    function step_bases(): bool
    {
        return str_is('*bases*', request()->header('Referer'));
    }
}

if (!function_exists('step_conversations')) {
    /**
     * Détermine si on est sur l'étape "Conversations"
     *
     * @return bool
     */
    function step_conversations(): bool
    {
        return str_is('*conversations*', request()->header('Referer'));
    }
}

if (!function_exists('step_bases')) {
    /**
     * Détermine si on est sur l'étape "Bases"
     *
     * @return bool
     */
    function step_bases(): bool
    {
        return str_is('*bases*', request()->header('Referer'));
    }
}

if (!function_exists('step_bases')) {
    /**
     * Détermine si on est sur l'étape "Bases"
     *
     * @return bool
     */
    function step_bases(): bool
    {
        return str_is('*bases*', request()->header('Referer'));
    }
}