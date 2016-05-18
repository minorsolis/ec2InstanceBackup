# AWS EC2 Instance Backups
This application will allow you to make backups (Full Images) of your AWS EC2 Instances. Just set this up and **add a tag in the instance with the name "backup"** and that's it.


## Requirements

1. Apache 2.4
2. PHP 5.6
3. OpenSSL
4. Composer
4. AWS API Credentials

## Notes
- This application was created using Laravel 5.1. If you want to extende it please go to (https://laravel.com/docs/5.1) for more info.
- The ec2InstanceBackup/general/httpd folder is something that you can delete. It's there only if you want to setup this in multiple AWS instances with autoscaling groups.


## Installation

#### #1 Clone this repository
```javascript
git clone https://github.com/minorsolis/ec2InstanceBackup.git
```

#### #2 Composer update

```javascript
cd ec2InstanceBackup/app
composer update
```

#### #3 Copy the ec2InstanceBackup/app/.env.example to .env

```javascript
cd ec2InstanceBackup/app
cp -rp .env.example .env
```

#### #4 Set your own application key

```javascript
cd ec2InstanceBackup/app
php artisan key:generate
```

#### #5 Set your AWS Credentials

With an editor open the file **ec2InstanceBackup/app/.env** and the following credentials:
```javascript
AWS_ACCESS_KEY_ID=your_access_key_here
AWS_SECRET_ACCESS_KEY=your_secret_key_here
AWS_REGION=your_region_here (default: us-east-1)
```

## How to Use It?

You have the API's available from your browser:

##### 1. /ec2InstanceBackup/app/public/?function=createImage

```
This api will create one full backup (Full Image) everyday for each instance that has the tag (backup=true).
```

##### 2. /ec2InstanceBackup/app/public/?function=deregisterImage

```
This api will delete the backups when they are more than X days (default: 7 days).
```

## More configuration options

```javascript
{open the file} =  ec2InstanceBackup/app/config/api.php
```

```javascript
'awsImageDateFrom' 	=> '20160101' (avoid deleting your custom images)
'awsImageDay'   	=> 7 		  (days that you want to keep the backup) 
'awsInstanceTag'   	=> 'backup'   (the tag searched in the instance)
```


