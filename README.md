# Flash messages handler
A very simple flash message handler written in PHP. (**PHP 7.0+**)

## Features:
- Based on **driver system** to write/read messages
- **Multiple channels** (optionnal)
- By default, **duplicated message within the same channel are ignored**
- Be default, **messages are deleted when opened**
- **Lightweight** and **no dependencies**

## Installation:
With composer :
```
composer require kegi/flash-message
```

## A very simple example :

```php
<?php

/*instantiate*/

$flashMessageController = new FlashMessageController(
    new SessionDriver()
);

/*add a message*/

$flashMessageController->success('Yay !');

/*get messages*/

var_dump($flashMessageController->getMessages());

```

## Documentation
[Documentation](/docs/README.md).

## Contribution
Feel free to contact me or send pull requests !
**or send your own driver !**
