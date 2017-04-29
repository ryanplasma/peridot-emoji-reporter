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
	public function __construct(EventEmitterInterface $emitter, EmojiConfiguration $configuration = null)
	{
		$this->emitter = $emitter;
	}

	/**
	 * @param InputInterface $input
	 * @param ReporterFactory $reporters
	 */
	public function onPeridotReporters(InputInterface $input, ReporterFactory $reporters)
	{
		$reporters->register('emoji', 'emoji matrix', 'Peridot\Reporter\Emoji\EmojiReporter');
	}

    /**
     * Register the reporters.
     *
     * @return $this
     */
    public function register()
    {
        $this->emitter->on('peridot.reporters', [$this, 'onPeridotReporters']);
        return $this;
    }
}
