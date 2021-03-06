# AWS EC2 Instance Backups
This application will allow you to make backups (Full Images) of your AWS EC2 Instances. Just set this up and **add a tag in the instance with the name "backup"** and that's it.


## Requirements

1. Apache 2.4
2. PHP 5.6
3. OpenSSL
4. Composer
4. AWS API Credentials

## Notes
- This application was created using Laravel 5.1. If you want to extend it please go to (https://laravel.com/docs/5.1) for more info.
- The ec2InstanceBackup/general/httpd folder is something that you can delete. It's there only if you want to setup this in multiple AWS instances with autoscaling groups.


## Installation

#### #1 Clone this repository
```javascript
git clone https://github.com/minorsolis/ec2InstanceBackup.git

Go inside of the main folder:
cd ec2InstanceBackup/

```

#### #2 Composer update

```javascript
cd app
composer update
```

#### #3 Copy the app/.env.example to .env

```javascript
cd app
cp -rp .env.example .env
```

#### #4 Set the permissions for Laravel Cache and Logs

```javascript
chmod -R 777 app/storage
chmod -R 777 app/bootstrap/cache
```

#### #5 Set your own application key

```javascript
cd app
php artisan key:generate
```

#### #6 Set your AWS Credentials

With an editor open the file **app/.env** and the following credentials:
```javascript
AWS_ACCESS_KEY_ID=your_access_key_here
AWS_SECRET_ACCESS_KEY=your_secret_key_here
AWS_REGION=your_region_here (default: us-east-1)
```

## How to Use It?

You have the API's available from your browser:

##### 1. /app/public/?function=createImage

```
This api will create one full backup (Full Image) everyday for each instance that has the tag with the name "backup".
```

##### 2. /app/public/?function=deregisterImage

```
This api will delete the backups (deregister the Image) when it's more than X days old (default: 7 days).
```

## More configuration options

```javascript
{open the file} =  app/config/api.php
```

```javascript
'awsImageDateFrom' 	=> '20160101' (avoid deleting your custom images)
'awsImageDay'   	=> 7 		  (days that you want to keep the backup) 
'awsInstanceTag'   	=> 'backup'   (the tag searched in the instance)
```

## Optional: Cron Job Setup

If you want this to run automatically, there's a cron job setup already provided. You will need to edit the $url and $path of your installation.

- 1. Edit this file: **general/cron/every1Day.sh**. You can setup this file in your crontab as required or (if you're lazy, go to the step #2).
```
url="http://{edit_here_url_to_the_app_public_folder}/"
```

- 2. Edit the path of your local server in this file: **general/cron/set/setCron.sh**
```
0 1 * * * {edit_here_path_to_your_installation}/general/cron/every1Day.sh
```
- 2.1 After your edit the file just run:
```
crontab setCron.sh
```

## Everybody Loves Screenshots

### Here's the backup tag
![alt tag](https://raw.githubusercontent.com/minorsolis/ec2InstanceBackup/master/general/documentation/1.jpg)

### Here's how the images will be created.
![alt tag](https://raw.githubusercontent.com/minorsolis/ec2InstanceBackup/master/general/documentation/2.jpg)



## Questions?
```
	Send me an email to minorsolis(at)gmail.com
```
