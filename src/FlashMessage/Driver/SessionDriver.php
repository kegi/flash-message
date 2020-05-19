<?php

declare(strict_types = 1);

namespace KeGi\FlashMessage\Driver;

use KeGi\FlashMessage\FlashMessage;
use KeGi\FlashMessage\FlashMessageInterface;

class SessionDriver implements DriverInterface
{
    /**
     * name of session item holding flash messages
     */
    const DEFAULT_SESSION_VAR = 'flashmessages';

    /**
     * name of keys holding each message
     */
    const TYPE_KEY = 'type';
    const MESSAGE_KEY = 'message';

    /**
     * @var string
     */
    private $sessionVar = self::DEFAULT_SESSION_VAR;

    /**
     * @return string
     */
    public function getSessionVar(): string
    {
        return $this->sessionVar;
    }

    /**
     * @param string $sessionVar
     *
     * @return $this
     */
    public function setSessionVar(string $sessionVar)
    {
        $this->sessionVar = $sessionVar;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function insert(FlashMessageInterface $flashMessage, string $channel)
    {
        if (!isset($_SESSION[$this->getSessionVar()])) {
            $_SESSION[$this->getSessionVar()] = [];
        }

        if (!isset($_SESSION[$this->getSessionVar()][$channel])) {
            $_SESSION[$this->getSessionVar()][$channel] = [];
        }

        $_SESSION[$this->getSessionVar()][$channel][$flashMessage->getUuid()]
            = $flashMessage->toArray();
    }

    /**
     * @inheritdoc
     */
    public function getAll() : array
    {
        return $this->fetchMessages();
    }

    /**
     * @inheritdoc
     */
    public function getByChannel(string $channel) : array
    {
        return $this->fetchMessages($channel)[$channel] ?? [];
    }

    /**
     * @inheritdoc
     */
    public function channelHasMessage(
        FlashMessageInterface $flashMessage,
        string $channel
    ) : bool
    {

        $messageData = $flashMessage->toArray();
        unset($messageData[FlashMessageInterface::FIELD_UUID]);
        ksort($messageData);

        foreach ($this->getByChannel($channel) as $channelMessage) {

            /** @var FlashMessageInterface $channelMessage */

            $channelMessageData = $channelMessage->toArray();
            unset($channelMessageData[FlashMessageInterface::FIELD_UUID]);
            ksort($channelMessageData);

            if ($messageData === $channelMessageData) {
                return true;
            }
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function clearAll($channel = null)
    {

        if (!isset($_SESSION)
            || !isset($_SESSION[$this->getSessionVar()])
        ) {
            return;
        }

        if ($channel === null) {
            unset($_SESSION[$this->getSessionVar()]);
        } else {

            if (isset($_SESSION[$this->getSessionVar()][$channel])) {
                unset($_SESSION[$this->getSessionVar()][$channel]);
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function clearByUuid(string $uuid)
    {
        if (!isset($_SESSION) || !isset($_SESSION[$this->getSessionVar()])) {
            return;
        }

        /*for each channels*/

        foreach (
            $_SESSION[$this->getSessionVar()] as $channel =>
            $channelMessages
        ) {

            /*for each messages in channel*/

            foreach ($channelMessages as $messageUuid => $messageData) {

                if ($messageUuid === $uuid) {
                    unset($_SESSION[$this->getSessionVar()][$channel][$messageUuid]);
                }
            }
        }
    }

    /**
     * @inheritdoc
     */
    private function fetchMessages($byChannel = null) : array
    {
        $messages = [];

        if (!isset($_SESSION)
            || !isset($_SESSION[$this->getSessionVar()])
        ) {
            return $messages;
        }

        /*for each channels*/

        foreach (
            $_SESSION[$this->getSessionVar()] as $channel =>
            $channelMessages
        ) {

            if ($byChannel !== null && $channel !== $byChannel) {
                continue;
            }

            if (empty($channelMessages)) {
                continue;
            }

            if (!isset($messages[$channel])) {
                $messages[$channel] = [];
            }

            /*for each messages in channel*/

            foreach ($channelMessages as $messageUuid => $messageData) {

                if (!is_array($messageData)) {
                    continue;
                }

                $messages[$channel][$messageUuid]
                    = new FlashMessage($messageData);
            }
        }

        return $messages;
    }
}
