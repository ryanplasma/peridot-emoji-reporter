# Peridot Emoji Reporter [![Build Status](https://travis-ci.org/ryanplasma/peridot-emoji-reporter.svg?branch=master)](https://travis-ci.org/ryanplasma/peridot-emoji-reporter) [![codecov](https://codecov.io/gh/ryanplasma/peridot-emoji-reporter/branch/master/graph/badge.svg)](https://codecov.io/gh/ryanplasma/peridot-emoji-reporter)


Derived from [Peridot Dot Reporter](https://github.com/peridot-php/peridot-dot-reporter)

![Peridot emoji reporter](https://raw.github.com/ryanplasma/peridot-emoji-reporter/master/output.png "Peridot emoji reporter in action")

## Requirements:
* PHP 7+
* Terminal that supports emojis - i.e. iTerm2

## Usage

I recommend installing the reporter to your project via composer:

```
$ composer require --dev ryanplasma/peridot-emoji-reporter:~1.0
```

You can register the reporter via your [peridot.php](http://peridot-php.github.io/#plugins) file.

```php
<?php

use Evenement\EventEmitterInterface;
use Peridot\Reporter\Emoji\EmojiReporter;
use Peridot\Reporter\Emoji\EmojiReporterPlugin;
use Spatie\Emoji\Emoji;

return function(EventEmitterInterface $emitter) {
	(new EmojiReporterPlugin($emitter))->register();

    $emitter->on('emoji.start', function (EmojiReporter $reporter) {
        // The next 3 lines are optional - use them to change the default emojis
        $reporter->setPassEmoji(Emoji::smilingCatFaceWithHeartShapedEyes());
        $reporter->setFailEmoji(Emoji::noEntry());
        $reporter->setPendingEmoji(Emoji::alienMonster());
    });
};
```

Default Emojis are:
 * :pizza: for passing tests
 * :poop: for failing tests
 * :hear_no_evil: for pending tests
 
See above example for how to customize what emojis are used.

## Running reporter tests

You can run the reporter specs and also preview the reporter in action like so:

```
$ vendor/bin/peridot specs/ -r emoji
```
