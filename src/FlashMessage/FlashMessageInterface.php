<?php

declare(strict_types = 1);

namespace KeGi\FlashMessage;

use JsonSerializable;

interface FlashMessageInterface extends JsonSerializable
{
    /**
     * possibles values for message type
     */
    const TYPE_SUCCESS = 'success';
    const TYPE_INFO = 'info';
    const TYPE_WARNING = 'warning';
    const TYPE_ERROR = 'error';

    /**
     * name of the fields when imported / exported
     */
    const FIELD_UUID = 'uuid';
    const FIELD_MESSAGE = 'message';
    const FIELD_TYPE = 'type';

    /**
     * @return string
     */
    public function getUuid() : string;

    /**
     * @param string $uuid
     *
     * @return $this
     */
    public function setUuid($uuid);

    /**
     * @return string
     */
    public function getMessage() : string;

    /**
     * @param string $message
     *
     * @return $this
     */
    public function setMessage($message);

    /**
     * @return string
     */
    public function getType();

    /**
     * @param string $type
     *
     * @return $this
     */
    public function setType($type);

    /**
     * @return array
     */
    public function toArray() : array;
}
