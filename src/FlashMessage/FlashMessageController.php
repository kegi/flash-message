<?php

declare(strict_types = 1);

namespace KeGi\PromisesTracker\Core\FlashMessage;

use KeGi\FlashMessage\Driver\DriverInterface;

class FlashMessageController
{
    /**
     * default channel to store messages
     */
    const DEFAULT_CHANEL = 'general';

    /**
     * @var DriverInterface
     */
    private $driver;

    /**
     * @param DriverInterface $driver
     */
    public function __construct(DriverInterface $driver)
    {
        $this->setDriver($driver);
    }

    /**
     * @return DriverInterface
     */
    public function getDriver(): DriverInterface
    {
        return $this->driver;
    }

    /**
     * @param DriverInterface $driver
     *
     * @return $this
     */
    public function setDriver(DriverInterface $driver)
    {
        $this->driver = $driver;

        return $this;
    }

    /**
     * @param string $message
     * @param string $type
     * @param bool   $unique
     * @param string $channel
     */
    public function addFlashMessage(
        string $message,
        string $type,
        bool $unique = true,
        string $channel = self::DEFAULT_CHANEL
    ) {

        $flashMessage = new FlashMessage([
            FlashMessageInterface::FIELD_MESSAGE => $message,
            FlashMessageInterface::FIELD_TYPE => $type,
        ]);

        /*if unique is required and messages exists, ignore it*/

        if ($unique
            && $this->getDriver()->channelHasMessage($flashMessage, $channel)
        ) {
            return;
        }

        $this->getDriver()->insert(
            $flashMessage,
            $channel
        );
    }

    /**
     * add a success message
     *
     * @param string $message
     * @param bool   $unique
     * @param string $channel
     */
    public function success(
        string $message,
        bool $unique = true,
        string $channel = self::DEFAULT_CHANEL
    ) {
        $this->addFlashMessage(
            $message,
            FlashMessageInterface::TYPE_SUCCESS,
            $unique,
            $channel
        );
    }

    /**
     * add an info message
     *
     * @param string $message
     * @param bool   $unique
     * @param string $channel
     */
    public function info(
        string $message,
        bool $unique = true,
        string $channel = self::DEFAULT_CHANEL
    ) {
        $this->addFlashMessage(
            $message,
            FlashMessageInterface::TYPE_INFO,
            $unique,
            $channel
        );
    }

    /**
     * add a warning message
     *
     * @param string $message
     * @param bool   $unique
     * @param string $channel
     */
    public function warning(
        string $message,
        bool $unique = true,
        string $channel = self::DEFAULT_CHANEL
    ) {
        $this->addFlashMessage(
            $message,
            FlashMessageInterface::TYPE_WARNING,
            $unique,
            $channel
        );
    }

    /**
     * add an error message
     *
     * @param string $message
     * @param bool   $unique
     * @param string $channel
     */
    public function error(
        string $message,
        bool $unique = true,
        string $channel = self::DEFAULT_CHANEL
    ) {
        $this->addFlashMessage(
            $message,
            FlashMessageInterface::TYPE_ERROR,
            $unique,
            $channel
        );
    }

    /**
     * get all messages of a channel
     *
     * @param string $channel
     * @param bool   $clear
     *
     * @return array
     */
    public function getMessages(
        string $channel = self::DEFAULT_CHANEL,
        bool $clear = true
    ) : array
    {
        $messages = $this->getDriver()->getByChannel($channel);

        if ($clear) {
            $this->getDriver()->clearAll($channel);
        }

        return $messages;
    }

    /**
     * get all messages for each channels
     *
     * @param bool $clear
     *
     * @return array
     */
    public function getAllMessages(
        bool $clear = true
    ) : array
    {

        $messages = $this->getDriver()->getAll();

        if ($clear) {
            $this->getDriver()->clearAll();
        }

        return $messages;
    }

    /**
     * clear all messages
     * if a channel is specified, only that channel will be cleared
     *
     * @param string|null $channel
     */
    public function clearAllMessages(
        string $channel = null
    ) {
        $this->getDriver()->clearAll($channel);
    }
}
