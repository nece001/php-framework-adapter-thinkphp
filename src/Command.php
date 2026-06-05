<?php

namespace Nece\Framework\Adapter;

use Nece\Framework\Adapter\Contract\Command as ContractCommand;
use think\console\Command as ConsoleCommand;

abstract class Command extends ConsoleCommand implements ContractCommand
{
    /**
     * 默认命令名称
     *
     * @var string
     */
    protected static $defaultName = '';

    /**
     * 默认命令描述
     *
     * @var string
     */
    protected static $defaultDescription = '';

    /**
     * @var InputInterface
     */
    protected $input;

    /**
     * @var OutputInterface
     */
    protected $output;

    public function __construct()
    {

        $this->setName(static::$defaultName)
            ->setDescription(static::$defaultDescription);
        parent::__construct();
    }

    /**
     * 执行命令
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute($input, $output): int
    {
        $this->input = $input;
        $this->output = $output;
        $this->handle();
        return 0;
    }

    /**
     * @inheritDoc
     */
    public function argument(string $name)
    {
        return $this->input->getArgument($name);
    }

    /**
     * @inheritDoc
     */
    public function option(string $name)
    {
        return $this->input->getOption($name);
    }

    /**
     * @inheritDoc
     */
    public function ask(string $question, $default = null)
    {
        $helper = $this->getHelper('question');
        $questionObj = new Question($question, $default);
        return $helper->ask($this->input, $this->output, $questionObj);
    }

    /**
     * @inheritDoc
     */
    public function confirm(string $question, bool $default = false): bool
    {
        $helper = $this->getHelper('question');
        $questionObj = new ConfirmationQuestion($question, $default);
        return $helper->ask($this->input, $this->output, $questionObj);
    }

    /**
     * @inheritDoc
     */
    public function choice(string $question, array $choices, $default = null)
    {
        $helper = $this->getHelper('question');
        $questionObj = new ChoiceQuestion($question, $choices, $default);
        return $helper->ask($this->input, $this->output, $questionObj);
    }

    /**
     * @inheritDoc
     */
    public function newLine(int $count = 1): void
    {
        for ($i = 0; $i < $count; $i++) {
            $this->output->writeln('');
        }
    }

    /**
     * @inheritDoc
     */
    public function writeln(string $message): void
    {
        $this->output->writeln($message);
    }

    /**
     * @inheritDoc
     */
    public function write(string $message): void
    {
        $this->output->write($message);
    }

    /**
     * @inheritDoc
     */
    public function info(string $message): void
    {
        $this->output->info($message);
    }

    /**
     * @inheritDoc
     */
    public function comment(string $message): void
    {
        $this->output->comment($message);
    }

    /**
     * @inheritDoc
     */
    public function question(string $question): void
    {
        $this->output->question($question);
    }

    /**
     * @inheritDoc
     */
    public function warn(string $message): void
    {
        $this->output->warn($message);
    }

    /**
     * @inheritDoc
     */
    public function error(string $message): void
    {
        $this->output->error($message);
    }

    /**
     * @inheritDoc
     */
    public function addArg(string $name, ?int $mode = null, string $description = '', $default = null, array $suggestedValues = []): self
    {
        parent::addArgument($name, $mode, $description, $default, $suggestedValues);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function addOpt(string $name, ?string $shortcut = null, ?int $mode = null, string $description = '', $default = null, array $suggestedValues = []): self
    {
        parent::addOption($name, $shortcut, $mode, $description, $default, $suggestedValues);
        return $this;
    }
}
