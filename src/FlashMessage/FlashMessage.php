<?php

declare(strict_types = 1);

namespace KeGi\FlashMessage;

class FlashMessage implements FlashMessageInterface
{

    /**
     * @var string
     */
    private $uuid;

    /**
     * @var string
     */
    private $message;

    /**
     * @var string
     */
    private $type = self::TYPE_INFO;

    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            (new FlashMessageBuilder())->build($data, $this);
        }

        if (empty($this->uuid)) {
            $this->setUuid($this->generateUuid());
        }
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     *
     * @return $this
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function generateUuid() : string
    {
        return uniqid();
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     *
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray() : array
    {

        return [
            self::FIELD_UUID => $this->getUuid(),
            self::FIELD_TYPE => $this->getType(),
            self::FIELD_MESSAGE => $this->getMessage(),
        ];
    }

    /**
     * @return array
     */
    public function jsonSerialize() : array
    {
        return $this->toArray();
    }
}
