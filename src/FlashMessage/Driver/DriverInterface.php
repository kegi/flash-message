<?php

declare(strict_types = 1);

namespace KeGi\FlashMessage\Driver;

use KeGi\FlashMessage\FlashMessageInterface;

interface DriverInterface
{

    /**
     * @param FlashMessageInterface $flashMessage
     * @param string                $channel
     *
     * @return mixed
     */
    public function insert(
        FlashMessageInterface $flashMessage,
        string $channel
    );

    /**
     * @return array
     */
    public function getAll() : array;

    /**
     * @param string $channel
     *
     * @return array
     */
    public function getByChannel(string $channel) : array;

    /**
     * @param FlashMessageInterface $flashMessage
     * @param string                $channel
     *
     * @return bool
     */
    public function channelHasMessage(
        FlashMessageInterface $flashMessage,
        string $channel
    ) : bool;

    /**
     * @param string|null $channel
     *
     * @return mixed
     */
    public function clearAll($channel = null);

    /**
     * @param string $uuid
     *
     * @return mixed
     */
    public function clearByUuid(string $uuid);
}
