<?php
namespace Peridot\Reporter\Emoji;

use Evenement\EventEmitterInterface;
use Peridot\Reporter\ReporterFactory;
use Symfony\Component\Console\Input\InputInterface;

/**
 * This plugin registers the EmojiReporter with Peridot
 * @package Peridot\Reporter\Emoji
 */
class EmojiReporterPlugin
{
	/**
	 * @var EventEmitterInterface
	 */
	protected $emitter;

	/**
	 * @param EventEmitterInterface $emitter
	 */
	public function __construct(EventEmitterInterface $emitter)
	{
		$this->emitter = $emitter;
		$this->emitter->on('peridot.reporters', [$this, 'onPeridotReporters']);
	}

	/**
	 * @param InputInterface $input
	 * @param ReporterFactory $reporters
	 */
	public function onPeridotReporters(InputInterface $input, ReporterFactory $reporters)
	{
		$reporters->register('emoji', 'emoji matrix', 'Peridot\Reporter\Emoji\EmojiReporter');
	}
}
