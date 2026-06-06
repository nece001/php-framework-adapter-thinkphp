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
     * @var \think\console\Input
     */
    protected $input;

    /**
     * @var \think\console\Output
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
     * @param \think\console\Input $input
     * @param \think\console\Output $output
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
     * 处理命令
     *
     * @return void
     */
    abstract public function handle();

    /**
     * 获取命令行参数
     *
     * @param string $name
     * @return mixed
     */
    public function getArg($name)
    {
        return $this->input->getArgument($name);
    }

    /**
     * 获取命令行选项
     *
     * @param string $name
     * @return mixed
     */
    public function getOpt($name)
    {
        return $this->input->getOption($name);
    }

    /**
     * 询问用户
     *
     * @param string $question
     * @param mixed $default
     * @return mixed
     */
    public function showAsk($question, $default = null)
    {
        return $this->output->ask($this->input, $question, $default);
    }

    /**
     * 确认用户操作
     *
     * @param string $question
     * @param bool $default
     * @return bool
     */
    public function showConfirm($question, $default = false)
    {
        return $this->output->confirm($this->input, $question, $default);
    }

    /**
     * 选择用户操作
     *
     * @param string $question
     * @param array $choices
     * @param mixed $default
     * @param int|null $attempts
     * @param bool $multiple
     * @return mixed
     */
    public function showChoice($question, array $choices, $default = null, $attempts = null, $multiple = false)
    {
        return $this->output->choice($this->input, $question, $choices, $default);
    }

    /**
     * 输出空行
     *
     * @param int $count
     * @return void
     */
    public function showLine($count = 1)
    {
        $this->output->newLine($count);
    }

    /**
     * 输出信息消息
     *
     * @param string $message
     * @return void
     */
    public function showInfo($message)
    {
        $this->output->info($message);
    }

    /**
     * 输出注释消息
     *
     * @param string $message
     * @return void
     */
    public function showComment($message)
    {
        $this->output->comment($message);
    }

    /**
     * 输出问题消息
     *
     * @param string $question
     * @return void
     */
    public function showQuestion($question)
    {
        $this->output->question($question);
    }

    /**
     * 输出警告消息
     *
     * @param string $message
     * @return void
     */
    public function showWarn($message)
    {
        $this->output->warning($message);
    }

    /**
     * 输出错误消息
     *
     * @param string $message
     * @return void
     */
    public function showError($message)
    {
        $this->output->error($message);
    }

    /**
     * 添加命令行参数
     *
     * @param string $name 参数名称
     * @param int|null $mode 参数模式（ARGUMENT_REQUIRED/ARGUMENT_OPTIONAL/ARGUMENT_IS_ARRAY）
     * @param string $description 参数描述
     * @param mixed $default 默认值
     * @param array $suggestedValues 输入补全的值
     * @return $this
     */
    public function addArg(string $name, ?int $mode = null, string $description = '', $default = null, array $suggestedValues = []): ContractCommand
    {
        $this->addArgument($name, $mode, $description, $default);
        return $this;
    }

    /**
     * 添加命令行选项
     *
     * @param string $name 选项名称
     * @param string|null $shortcut 快捷方式
     * @param int|null $mode 选项模式（OPTION_VALUE_NONE/OPTION_VALUE_REQUIRED等）
     * @param string $description 选项描述
     * @param mixed $default 默认值
     * @param array $suggestedValues 输入补全的值
     * @return $this
     */
    public function addOpt(string $name, ?string $shortcut = null, ?int $mode = null, string $description = '', $default = null, array $suggestedValues = []): ContractCommand
    {
        // ThinkPHP不支持OPTION_VALUE_NEGATABLE(16)，需要过滤掉
        if ($mode !== null && ($mode & ContractCommand::OPTION_VALUE_NEGATABLE) !== 0) {
            // 移除OPTION_VALUE_NEGATABLE标志
            $mode = $mode & ~ContractCommand::OPTION_VALUE_NEGATABLE;
            // 如果移除后mode为0，则设为null（使用默认值）
            if ($mode === 0) {
                $mode = null;
            }
        }
        $this->addOption($name, $shortcut, $mode, $description, $default);
        return $this;
    }
}