<?php


namespace meliorator\cron\commands;

use meliorator\cron\models\CronJob;
use meliorator\cron\Module;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Class JobController
 *
 * @package meliorator\cron\commands
 */
class JobController extends Controller
{

    /**
     * @param $id
     */
    public function actionRun($id)
    {
        $job = CronJob::findOne($id);
        $run = $job->run();

        $logFile = '';
        if($job->logfile != "") {
            $module = Module::getInstance();

            $logFile = strtr('{base}/{offset}', [
                '{base}' => dirname($module->yiiFile),
                '{offset}' => $job->logfile,
            ]);
        }

        Console::output('Process is finished, exit code: #' . $run->exit_code);
        Console::output($run->output);
        Console::output($logFile);

        $this->writeLogFile($logFile, $run->output);

        if (!empty($run->error_output)) {
            $this->writeLogFile($logFile, $run->error_output);
            Console::output($run->error_output);
        }
    }

    private function writeLogFile(string $logFile, string $message)
    {
        if($logFile != '') {
            if (!file_exists($logFile)) {
                touch($logFile);
            }

            if (is_writeable($logFile)) {
                error_log($message, 3, $logFile);
            }
        }
    }
}

