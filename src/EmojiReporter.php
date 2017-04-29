<?php
namespace Peridot\Reporter\Emoji;

use Peridot\Reporter\AbstractBaseReporter;
use Spatie\Emoji\Emoji;

/**
 * The EmojiReporter displays test results as an emoji matrix, using a slice of pizza
 * for passed tests, a pile of poo for failed tests, and hear-no-evil monkey for pending tests.
 *
 * @package Peridot\Reporter\Emoji
 */
class EmojiReporter extends AbstractBaseReporter
{
    /**
     * @var int
     */
    protected $maxColumns = 67;

    /**
     * @var int
     */
    protected $column = 0;

    /**
     * @var string
     */
    private $passEmoji;

    /**
     * @var string
     */
    private $failEmoji;

    /**
     * @var string
     */
    private $pendingEmoji;

    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function init()
    {
        $this->eventEmitter->on('test.passed', [$this, 'onTestPassed']);
        $this->eventEmitter->on('test.failed', [$this, 'onTestFailed']);
        $this->eventEmitter->on('test.pending', [$this, 'onTestPending']);
        $this->eventEmitter->on('runner.start', [$this, 'onRunnerStart']);
        $this->eventEmitter->on('runner.end', [$this, 'onRunnerEnd']);
    }

    /**
     * @return void
     */
    public function onTestPassed()
    {
        $this->write('success', $this->getPassEmoji());
    }

    /**
     * @return void
     */
    public function onTestFailed()
    {
        $this->write('error', $this->getFailEmoji());
    }

    /**
     * @return void
     */
    public function onTestPending()
    {
        $this->write('pending', $this->getPendingEmoji());
    }

    /**
     * @return void
     */
    public function onRunnerStart()
    {
        $this->eventEmitter->emit('emoji.start', [$this]);
    }

    /**
     * @return void
     */
    public function onRunnerEnd()
    {
        $this->output->writeln("");
        $this->footer();
    }

    /**
     * @param $key
     * @param $text
     */
    protected function write($key, $text)
    {
        if ($this->column == $this->getMaxColumns()) {
            $this->output->writeln("");
            $this->column = 0;
        }
        $this->output->write($this->color($key, $text . ' '));
        $this->column++;
    }

    /**
     * @param int $columns
     */
    public function setMaxColumns($columns)
    {
        $this->maxColumns = $columns;
    }

    /**
     * @return int
     */
    public function getMaxColumns()
    {
        return $this->maxColumns;
    }

    /**
     * @return string
     */
    public function getPassEmoji(): string
    {
        if (!$this->passEmoji) {
            return Emoji::sliceOfPizza();
        } else {
            return $this->passEmoji;
        }
    }

    /**
     * @param string $passEmoji
     */
    public function setPassEmoji(string $passEmoji)
    {
        $this->passEmoji = $passEmoji;
    }

    /**
     * @return string
     */
    public function getFailEmoji(): string
    {
        if (!$this->failEmoji) {
            return Emoji::pileOfPoo();
        } else {
            return $this->failEmoji;
        }
    }

    /**
     * @param string $failEmoji
     */
    public function setFailEmoji(string $failEmoji)
    {
        $this->failEmoji = $failEmoji;
    }

    /**
     * @return string
     */
    public function getPendingEmoji(): string
    {
        if (!$this->pendingEmoji) {
            return Emoji::hearNoEvilMonkey();
        } else {
            return $this->pendingEmoji;
        }
    }

    /**
     * @param string $pendingEmoji
     */
    public function setPendingEmoji(string $pendingEmoji)
    {
        $this->pendingEmoji = $pendingEmoji;
    }
}
