Yii2 Cron job Manager
=====================
Create Cron jobs from browser, and look that run logs

Forked from sharkom/yii2-cron with some modifications


Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist meliorator/yii2-cron "*"
```

or add

```
"meliorator/yii2-cron": "*"
```

to the require section of your `composer.json` file.


### Migration

Run the following command in Terminal for database migration:

```
yii migrate/up --migrationPath=@meliorator/cron/migrations
```

Or use the [namespaced migration](http://www.yiiframework.com/doc-2.0/guide-db-migrations.html#namespaced-migrations) (requires at least Yii 2.0.10):

```php
// Add namespace to console config:
'controllerMap' => [
    'migrate' => [
        'class' => 'yii\console\controllers\MigrateController',
        'migrationPath' => [
            '@meliorator/cron/migrations',
        ],
    ],
],
```

Then run:
```
yii migrate/up
```

### Web Application Config

Turning on the Cron Job Manager Module in the web application:

Simple example:

```php
'modules' => [
    'cron' => [
        'class' => 'meliorator\cron\Module',
    ],
],
```

### Console Application Config

Turning on the Cron Job Manager Module in the console application:

Simple example:

```php
'modules' => [
    'cron' => [
        'class' => 'meliorator\cron\Module',
    ],
],
```

### Schedule Config

Set the server schedule to run the following command

On Linux:

Add to the crontab with the user who you want to run the script (possibly not root) with the `crontab -e` command or by editing the `/etc/crontab` file

```bash
* * * * * <your-application-folder>/yii cron/cron/run 2>&1
```

On Windows:

Open the task scheduler and create a new task
