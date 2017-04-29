# Peridot Emoji Reporter [![Build Status](https://travis-ci.org/ryanplasma/peridot-emoji-reporter.svg?branch=master)](https://travis-ci.org/ryanplasma/peridot-emoji-reporter)

Derived from [Peridot Dot Reporter](https://github.com/peridot-php/peridot-dot-reporter)

![Peridot emoji reporter](https://raw.github.com/ryanplasma/peridot-emoji-reporter/master/output.png "Peridot emoji reporter in action")

## Requirements:
* PHP 7+
* Terminal that supports emojis - i.e. iTerm2

## Usage

We recommend installing the reporter to your project via composer:

```
$ composer require --dev ryanplasma/peridot-emoji-reporter:~1.0
```

You can register the reporter via your [peridot.php](http://peridot-php.github.io/#plugins) file.

```php
<?php

use Evenement\EventEmitterInterface;
use Peridot\Reporter\Emoji\EmojiReporterPlugin;

return function(EventEmitterInterface $emitter) {
    $emoji = new EmojiReporterPlugin($emitter);
};
```

## Running reporter tests

You can run the reporter specs and also preview the reporter in action like so:

```
$ vendor/bin/peridot specs/ -r emoji
```

Todo:
* Allow emoji customization
