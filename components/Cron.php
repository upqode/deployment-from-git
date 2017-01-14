<?php

namespace app\components;

use app\models\Backups;
use app\models\Commits;
use app\models\Logs;
use app\models\Repositories;
use app\models\Settings;

class Cron
{
    const ACTION_REMOVE_OLD_LOGS = 'remove-old-logs';
    const ACTION_REMOVE_OLD_BACKUPS = 'remove-old-backups';
    const ACTION_AUTO_UPDATE_REPOSITORIES = 'auto-update-repositories';

    /**
     * Get cron action and run it
     *
     * @param string $action
     */
    public static function run($action)
    {
        switch ($action) {
            case self::ACTION_REMOVE_OLD_LOGS:
                self::removeOldLogs();
                break;

            case self::ACTION_REMOVE_OLD_BACKUPS:
                self::removeOldBackups();
                break;

            case self::ACTION_AUTO_UPDATE_REPOSITORIES:
                self::autoUpdateRepositories();
                break;

            default:
                die();
        }
    }

    /**
     * Remove old logs (default 10 days ago)
     * Run once a day
     *
     * command: 0 0 * * * php /path/to/my/project/yii cron -a=remove-old-logs
     * or: 0 0 * * * wget -O - -q -t 1 http://your-site.com/cron?action=remove-old-logs&key=1234
     */
    public static function removeOldLogs()
    {
        $option = Settings::getSettingValue(Settings::SETTING_REMOVE_LOGS_AFTER_DAYS, 10);
        $old_time = strtotime("-{$option} days");
        $count = Logs::deleteAll(['<=', 'time', $old_time]);

        if ($count) {
            Logs::setLog(501, [':count' => $count, ':type' => 'logs']);
        }
    }

    /**
     * Remove old backups (default 10 days ago)
     * Run once a day
     *
     * command: 0 0 * * * php /path/to/my/project/yii cron -a=remove-old-backups
     * or: 0 0 * * * wget -O - -q -t 1 http://your-site.com/cron?action=remove-old-backups&key=1234
     */
    public static function removeOldBackups()
    {
        $option = Settings::getSettingValue(Settings::SETTING_REMOVE_BACKUPS_AFTER_DAYS, 10);
        $old_time = strtotime("-{$option} days");
        $count = Backups::deleteAll(['<=', 'time', $old_time]);

        if ($count) {
            Logs::setLog(501, [':count' => $count, ':type' => 'backups']);
        }
    }

    /**
     * Auto update repositories if need (only for repositories in which the enabled auto update)
     * Possible run several times a day
     *
     * command: 0 0 * * * php /path/to/my/project/yii cron -a=auto-update-repositories
     * or: 0 0 * * * wget -O - -q -t 1 http://your-site.com/cron?action=auto-update-repositories&key=1234
     */
    public static function autoUpdateRepositories()
    {
        $repositories = Repositories::findAll(['has_auto_update' => true]);

        foreach ($repositories as $repository) {
            $last_commit_sha = $repository->getLastCommitSha();

            if ($last_commit_sha && $repository->hasNewVersion($last_commit_sha)) {
                $install_commit = Deployment::installCommit($repository, 'master');

                if (true === $install_commit) {
                    Logs::setLog(502, [':repository' => $repository->remote_path]);
                    Commits::saveInstalledCommitInfo($repository->id, $last_commit_sha);
                }
            }
        }
    }

}