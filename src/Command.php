<?php

namespace Nece\Framework\Adapter;

use Nece\Framework\Adapter\Contract\ICommand;
use think\console\Command as ConsoleCommand;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;

abstract class Command extends ConsoleCommand implements ICommand
{
    /**
     * 命令的名称和签名（兼容laravel命令签名）
     * mail:send
     * {user : The ID of the user}
     * {--Q|queue=value : Whether the job should be queued}
     *
     * @var string
     */
    protected $signature = '';

    /**
     * 命令的描述
     *
     * @var string
     */
    protected $description = '';


    /**
     * 配置命令
     *
     * @author nece001@163.com
     * @create 2025-10-11 23:24:51
     *
     * @return void
     */
    protected function configure()
    {
        $this->setDescription($this->description);

        $patt = '/([^{}\s]+|{[^{}]+})/';
        if (preg_match_all($patt, $this->signature, $matches)) {
            foreach ($matches[1] as $str) {
                if (0 === strpos($str, '{')) {
                    $str = trim($str, '{}');

                    if (0 === strpos($str, '--')) {
                        // 分析选项
                        $str = substr($str, 2);
                        $name = '';
                        $shot = '';
                        $require = false;
                        $default = null;
                        $description = '';

                        if (false !== strpos($str, ':')) {
                            $parts = explode(':', $str);
                            $str = trim($parts[0]);
                            $description = trim($parts[1] ?? '');
                        }

                        if (false !== strpos($str, '|')) {
                            $parts = explode('|', $str);
                            $shot = $parts[0];
                            $str = $parts[1] ?? '';
                        }

                        if (false !== strpos($str, '=')) {
                            $parts = explode('=', $str);
                            $name = $parts[0];
                            $require = true;
                            $default = $parts[1] ?? '';
                        } else {
                            $name = $str;
                        }

                        $this->addOption($name, $shot, $require ? Option::VALUE_REQUIRED : Option::VALUE_OPTIONAL, $description, $default);
                    } else {

                        // 分析参数
                        $parts = explode(':', $str);
                        $this->addArgument(trim($parts[0]), Argument::REQUIRED, trim($parts[1] ?? ''));
                    }
                } else {
                    // 分析命令名称
                    $this->setName($str);
                }
            }
        }
    }

    /**
     * 执行命令
     *
     * @author nece001@163.com
     * @create 2025-10-11 23:24:33
     *
     * @param Input $input
     * @param Output $output
     * @return void
     */
    public function execute(Input $input, Output $output)
    {
        $this->handle();
    }

    /**
     * 处理命令
     *
     * @author nece001@163.com
     * @create 2025-10-11 23:24:42
     *
     * @return void
     */
    abstract public function handle();

    /**
     * 获取命令行参数
     *
     * @author nece001@163.com
     * @create 2025-10-11 22:54:35
     *
     * @param string $name
     * @return mixed
     */
    protected function argument(string $name)
    {
        return $this->input->getArgument($name);
    }

    /**
     * 获取命令行选项
     *
     * @author nece001@163.com
     * @create 2025-10-11 22:54:46
     *
     * @param string $name
     * @return mixed
     */
    protected function option(string $name)
    {
        return $this->input->getOption($name);
    }

    /**
     * 询问用户
     *
     * @author nece001@163.com
     * @create 2025-10-11 22:54:53
     *
     * @param string $question
     * @param string $default
     * @return mixed
     */
    protected function ask(string $question, $default = null)
    {
        return $this->output->ask($this->input, $question, $default);
    }

    /**
     * 确认用户操作
     *
     * @author nece001@163.com
     * @create 2025-10-11 22:55:04
     *
     * @param string $question
     * @param boolean $default
     * @return boolean
     */
    protected function confirm(string $question, bool $default = false)
    {
        return $this->output->confirm($this->input, $question, $default);
    }

    /**
     * 选择用户操作
     *
     * @author nece001@163.com
     * @create 2025-10-11 22:55:19
     *
     * @param string $question
     * @param array $choices
     * @param string $default
     * @return mixed
     */
    protected function choice(string $question, array $choices, $default = null)
    {
        return $this->output->choice($this->input, $question, $choices, $default);
    }

    /**
     * 输出空行
     *
     * @author nece001@163.com
     * @create 2025-10-11 22:55:34
     *
     * @param integer $count
     * @return void
     */
    protected function newLine(int $count = 1)
    {
        $this->output->newLine($count);
    }

    /**
     * 输出消息
     *
     * @author nece001@163.com
     * @create 2025-10-11 22:55:40
     *
     * @param string $message
     * @return void
     */
    protected function writeln(string $message)
    {
        $this->output->writeln($message);
    }

    /**
     * 输出消息
     *
     * @author nece001@163.com
     * @create 2025-10-11 22:55:46
     *
     * @param string $message
     * @return void
     */
    protected function write(string $message)
    {
        $this->output->write($message);
    }

    /**
     * 输出信息消息
     *
     * @author nece001@163.com
     * @create 2025-10-11 22:55:52
     *
     * @param string $message
     * @return void
     */
    protected function info(string $message)
    {
        $this->output->info($message);
    }

    /**
     * 输出注释消息
     *
     * @author nece001@163.com
     * @create 2025-10-11 22:55:58
     *
     * @param string $message
     * @return void
     */
    protected function comment(string $message)
    {
        $this->output->comment($message);
    }

    /**
     * 输出问题消息
     *
     * @author nece001@163.com
     * @create 2025-10-11 22:56:04
     *
     * @param string $question
     * @return mixed
     */
    protected function question(string $question)
    {
        return $this->output->question($question);
    }

    /**
     * 输出警告消息
     *
     * @author nece001@163.com
     * @create 2025-10-11 22:56:10
     *
     * @param string $message
     * @return void
     */
    protected function warn(string $message)
    {
        $this->output->warning($message);
    }

    /**
     * 输出错误消息
     *
     * @author nece001@163.com
     * @create 2025-10-11 22:56:16
     *
     * @param string $message
     * @return void
     */
    protected function error(string $message)
    {
        $this->output->error($message);
    }
}
