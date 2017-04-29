<?php
use Evenement\EventEmitter;
use Peridot\Configuration;
use Peridot\Reporter\Emoji\EmojiReporterPlugin;
use Peridot\Reporter\ReporterFactory;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

describe('DotReporterPlugin', function() {
	beforeEach(function() {
		$this->emitter = new EventEmitter();
		$this->plugin = new EmojiReporterPlugin($this->emitter);
		$this->plugin->register();
	});

	context('when peridot.reporters event is emitted', function() {
		beforeEach(function() {
			$config = new Configuration();
			$output = new BufferedOutput();
			$this->factory = new ReporterFactory($config, $output, $this->emitter);
		});

		it('should register the emoji reporter', function() {
			$input = new ArrayInput([]);
			$this->emitter->emit('peridot.reporters', [$input, $this->factory]);
			$reporters = $this->factory->getReporters();
			assert(array_key_exists('emoji', $reporters), 'emoji reporter should have been registered');
		});
	});
});
