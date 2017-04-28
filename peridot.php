<?php

use Evenement\EventEmitterInterface;
use Peridot\Plugin\Watcher\WatcherPlugin;
use Peridot\Reporter\Emoji\EmojiReporterPlugin;

return function(EventEmitterInterface $emitter) {
	$watcher = new WatcherPlugin($emitter);
	$watcher->track(__DIR__ . '/src');
	$emoji = new EmojiReporterPlugin($emitter);
};
