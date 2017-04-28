<?php
use Evenement\EventEmitter;
use Peridot\Configuration;
use Peridot\Core\Test;
use Peridot\Reporter\Emoji\EmojiReporter;
use Spatie\Emoji\Emoji;
use Symfony\Component\Console\Output\BufferedOutput;

describe('EmojiReporter', function() {
	beforeEach(function() {
		$this->configuration = new Configuration();
		$this->output = new BufferedOutput();
		$this->emitter = new EventEmitter();
		$this->reporter = new EmojiReporter($this->configuration, $this->output, $this->emitter);
	});

	context('when test.passed is emitted', function() {
		it('should add a slice of pizza to the output', function() {
			$test = new Test("passing test", function() {});
			$this->emitter->emit('test.passed', [$test]);
			$output = $this->output->fetch();
			assert(strpos($output, Emoji::sliceOfPizza()) !== false, "output should have slice of pizza");
		});
	});

	context('when test.failed is emitted', function() {
		it('should add a F to the output', function() {
			$test = new Test("failing test", function() {});
			$this->emitter->emit('test.failed', [$test, new \Exception("error")]);
			$output = $this->output->fetch();
			assert(strpos($output, Emoji::pileOfPoo()) !== false, "output should have F");
		});
	});

	context('when test.pending is emitted', function() {
		it('should add a P to the output', function() {
			$test = new Test("pending test");
			$this->emitter->emit('test.pending', [$test]);
			$output = $this->output->fetch();
			assert(strpos($output, Emoji::hearNoEvilMonkey()) !== false, "output should have P");
		});
	});

	context('when the current entry reaches the column', function() {
		beforeEach(function() {
			$this->reporter->setMaxColumns(3);
		});

		it('should print a new line', function() {
			$i = 0;
			while($i < 8) {
				$this->emitter->emit('test.pending', [new Test("pending")]);
				$i++;
			}
			$output = $this->output->fetch();
			$expected = str_repeat(Emoji::hearNoEvilMonkey() . ' ', 3) . PHP_EOL .
			            str_repeat(Emoji::hearNoEvilMonkey() . ' ', 3) . PHP_EOL .
			            str_repeat(Emoji::hearNoEvilMonkey() . ' ', 2);
			assert($expected == $output, "expected $expected, got $output");
		});

		it('should not print a new line for last element', function() {
			$i = 0;
			while($i < 6) {
				$this->emitter->emit('test.pending', [new Test("pending")]);
				$i++;
			}
			$output = $this->output->fetch();
			$expected = str_repeat(Emoji::hearNoEvilMonkey() . ' ', 3) . PHP_EOL .
			            str_repeat(Emoji::hearNoEvilMonkey() . ' ', 3);
			assert($expected == $output, "expected $expected, got $output");
		});
	});
});
