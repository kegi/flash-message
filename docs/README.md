# Documentation
## Table of content

1. [Drivers](#drivers)
2. [Channel](#channel)
3. [Message object](#message-object)
4. [Exceptions](#exceptions)
5. [Add messages](#add-messages)
    * [Shortcut methods](#add-messages-shortcut-methods)
        * [Success](#add-messages-success)
        * [Info](#add-messages-info)
        * [Warning](#add-messages-warning)
        * [Error](#add-messages-error)
6. [Get messages](#get-messages)
    * [Specific channel](#get-messages-channel)
    * [All channels](#get-all-messages)
7. [Clear all messages](#clear-all-messages)

----

<a name="drivers"></a>
## Drivers
Currently, **SessionDriver** is the only available driver. Feel free to implement your own driver (*MUST implements DriverInterface*) and send me a pull request!

<a name="channel"></a>
## Channel

The previous example didn't specified a channel so it was saved in "general" (default) channel. You can use multiples channels to split your messages.

```php
<?php

$flashMessageController->success('Your profile was updated successfully !', true, 'account.messages');
```

The second parameter is for uniqueness (default : true). If the same message already exists on that channel, it will be ignored.
The second parameter is for uniqueness (default : true). If the same message already exists on that channel, it will be ignored.

<a name="message-object"></a>
## Message object

All messages implements **FlashMessageInterface** and offers those methods

```
$message->getUuid() : string;
$message->setUuid(string $uuid);

$message->getMessage() : string;
$message->setMessage(string $message);

$message->getType() : string;
$message->setType(string $type);
```

<a name="exceptions"></a>
## Exceptions
All exceptions from that library extends **FlashMessageException**.

<a name="add-messages"></a>
## Add messages

The following method allows you to add a message

```
addFlashMessage ( string $message, string $type [, bool $unique = true, string $channel = 'general'] ) : void
```
<a name="add-messages-shortcut-methods"></a>
### Shortcut methods :
<a name="add-messages-success"></a>
#### Success message

```
success ( string $message [, bool $unique = true, string $channel = 'general'] ) : void
```
<a name="add-messages-info"></a>
#### Info message

```
info ( string $message [, bool $unique = true, string $channel = 'general'] ) : void
```
<a name="add-messages-warning"></a>
#### Warning message

```
warning ( string $message [, bool $unique = true, string $channel = 'general'] ) : void
```
<a name="add-messages-error"></a>
#### Error message

```
error ( string $message [, bool $unique = true, string $channel = 'general'] ) : void
```
<a name="get-messages"></a>
## Get messages
<a name="get-messages-channel"></a>
### Messages of a specific channel

```
getMessages ( [string $channel = 'general', bool $clear = true] ) : FlashMessageInterface[]
```
This return an array of objects implementing **FlashMessageInterface**. By default, the messages are deleted when opened. To prevent this, you can set $clear to false.

<a name="get-all-messages"></a>
### Get all messages

```
getAllMessages ( [bool $clear = true] ) : array
```
This return an bi-dimensionnal array holdings each messages of each channels. By default, the messages are deleted when opened. To prevent this, you can set $clear to false.

<a name="clear-all-messages"></a>
## Clear all messages

```
clearAllMessages ( [string $channel = 'general'] ) : void
```

This will clear all messages. Optionnaly, you can specify a channel to clear only that channel. Otherwise, all channels will be cleared.
