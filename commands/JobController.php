<?php


namespace sharkom\cron\commands;

use sharkom\cron\models\CronJob;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Class JobController
 * @package sharkom\cron\commands
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

        Console::output('Process is finished, exit code: #' . $run->exit_code);
        Console::output($run->output);
        Console::output($job->logfile);

        if($job->logfile!="") {
            error_log($run->output, 3, $job->logfile);
        }

        if (!empty($run->error_output)) {
            if($job->logfile!="") {
                error_log($run->error_output, 3, $job->logfile);
            }
            Console::output($run->error_output);
        }
    }

}

