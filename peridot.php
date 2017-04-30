<?php

use Evenement\EventEmitterInterface;
use Peridot\Plugin\Watcher\WatcherPlugin;
use Peridot\Reporter\CodeCoverage\AbstractCodeCoverageReporter;
use Peridot\Reporter\CodeCoverageReporters;
use Peridot\Reporter\Emoji\EmojiReporter;
use Peridot\Reporter\Emoji\EmojiReporterPlugin;
use Spatie\Emoji\Emoji;

return function (EventEmitterInterface $emitter) {
    $watcher = new WatcherPlugin($emitter);
    $watcher->track(__DIR__ . '/src');

    (new EmojiReporterPlugin($emitter))->register();

    $emitter->on('emoji.start', function (EmojiReporter $reporter) {
        $reporter->setPassEmoji(Emoji::smilingCatFaceWithHeartShapedEyes());
        $reporter->setFailEmoji(Emoji::noEntry());
        $reporter->setPendingEmoji(Emoji::alienMonster());
    });

    (new CodeCoverageReporters($emitter))->register();

    $emitter->on('peridot.start', function (\Peridot\Console\Environment $environment) {
        $environment->getDefinition()->getArgument('path')->setDefault('specs');
    });

    $emitter->on('code-coverage.start', function (AbstractCodeCoverageReporter $reporter) {
        $reporter->addDirectoryToWhitelist(__DIR__ . '/src');
    });
};
