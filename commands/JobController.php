<?php


namespace meliorator\cron\commands;

use meliorator\cron\models\CronJob;
use meliorator\cron\Module;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Class JobController
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

        $module = Module::getInstance();

        $logFile = strtr('{yii}/{file}', [
            '{yii}' => $module->yiiFile,
            '{file}' => $job->logfile
        ]);

        Console::output('Process is finished, exit code: #' . $run->exit_code);
        Console::output($run->output);
        Console::output($logFile);

        if($job->logfile!="") {
            error_log($run->output, 3, $logFile);
        }

        if (!empty($run->error_output)) {
            if($job->logfile!="") {
                error_log($run->error_output, 3, $logFile);
            }
            Console::output($run->error_output);
        }
    }

}

