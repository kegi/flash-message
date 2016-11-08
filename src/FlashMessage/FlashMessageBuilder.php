<?php

declare(strict_types = 1);

namespace KeGi\FlashMessage;

use KeGi\FlashMessage\Exception\MissingVariableException;
use KeGi\FlashMessage\Exception\UnknownVariableException;

/**
 * The messages are stored as key/value
 * All changes should be handle here as a migration
 */
class FlashMessageBuilder
{
    /**
     * mandatory variables
     */
    const MANDATORY_VARIABLES
        = [
            FlashMessageInterface::FIELD_MESSAGE,
            FlashMessageInterface::FIELD_TYPE,
        ];

    /**
     * optionnal variables
     */
    const OPTIONNAL_VARIABLES
        = [
            FlashMessageInterface::FIELD_UUID,
        ];

    /**
     * @param array                      $data
     * @param FlashMessageInterface|null $flashMessage
     *
     * @return FlashMessageInterface
     * @throws MissingVariableException
     * @throws UnknownVariableException
     */
    public function build(
        array $data,
        FlashMessageInterface $flashMessage = null
    ) : FlashMessageInterface
    {

        if ($flashMessage === null) {
            $flashMessage = new FlashMessage();
        }

        /*mandatory fields*/

        foreach (self::MANDATORY_VARIABLES as $mandatoryField) {
            if (!isset($data[$mandatoryField])) {
                throw new MissingVariableException(sprintf(
                    'Missing mandatory variable "%1$s" in %2$s',
                    $mandatoryField,
                    __METHOD__
                ));
            }
        }

        /*handle unknown variables*/

        foreach (array_keys($data) as $variable) {
            if (!in_array($variable, self::MANDATORY_VARIABLES, true)
                && !in_array($variable, self::OPTIONNAL_VARIABLES, true)
            ) {
                throw new UnknownVariableException(sprintf(
                    'Unknown variable "%1$s" in %2$s',
                    $variable,
                    __METHOD__
                ));
            }
        }

        /*add mandatory fields*/

        $flashMessage
            ->setMessage($data[FlashMessageInterface::FIELD_MESSAGE])
            ->setType($data[FlashMessageInterface::FIELD_TYPE]);

        /*add optionnal fields*/

        if (isset($data[FlashMessageInterface::FIELD_UUID])) {
            $flashMessage->setUuid($data[FlashMessageInterface::FIELD_UUID]);
        }

        return $flashMessage;
    }
}
