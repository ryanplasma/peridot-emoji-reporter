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
		it('should add a slice of pizza to the output if no pass emoji is set', function() {
			$test = new Test("passing test", function() {});
			$this->emitter->emit('test.passed', [$test]);
			$output = $this->output->fetch();
			assert(strpos($output, Emoji::sliceOfPizza()) !== false, "output should have slice of pizza");
		});

        it('should add the selected emoji to the output if the pass emoji is set', function() {
            $test = new Test("passing test", function() {});
            $this->reporter->setPassEmoji(Emoji::alienMonster());
            $this->emitter->emit('test.passed', [$test]);
            $output = $this->output->fetch();
            assert(strpos($output, Emoji::alienMonster()) !== false, "output should have an alien monster");
        });
	});

	context('when test.failed is emitted', function() {
		it('should add a pile of poo to the output is no fail emoji is set', function() {
			$test = new Test("failing test", function() {});
			$this->emitter->emit('test.failed', [$test, new \Exception("error")]);
			$output = $this->output->fetch();
			assert(strpos($output, Emoji::pileOfPoo()) !== false, "output should have pile of poo");
		});

        it('should add the selected emoji to the output if the fail emoji is set', function() {
            $test = new Test("failing test", function() {});
            $this->reporter->setFailEmoji(Emoji::alienMonster());
            $this->emitter->emit('test.failed', [$test, new \Exception("error")]);
            $output = $this->output->fetch();
            assert(strpos($output, Emoji::alienMonster()) !== false, "output should have an alien monster");
        });
	});

	context('when test.pending is emitted', function() {
		it('should add a hear-no-evil monkey to the output if no pending emoji is set', function() {
			$test = new Test("pending test");
			$this->emitter->emit('test.pending', [$test]);
			$output = $this->output->fetch();
			assert(strpos($output, Emoji::hearNoEvilMonkey()) !== false, "output should have hear-no-evil monkey");
		});

        it('should add the selected emoji to the output if the fail emoji is set', function() {
            $test = new Test("pending test");
            $this->reporter->setPendingEmoji(Emoji::alienMonster());
            $this->emitter->emit('test.pending', [$test]);
            $output = $this->output->fetch();
            assert(strpos($output, Emoji::alienMonster()) !== false, "output should have an alien monster");
        });
	});

    context('when runner.start is emitted', function() {
        it('should emit the emoji.start event', function() {
            $emitted = false;
            $this->emitter->on('emoji.start', function() use (&$emitted) {
                $emitted = true;
            });
            $test = new Test("passing test");
            $this->emitter->emit('runner.start', [$test]);
            assert($emitted, 'start event should have been emitted');
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
