# AWS EC2 Instance Backups
This application will allow you to make backups (Full Images) of the instances that you want, all you need to do is setup this system and **add a tag in the instance that you want to backup with the name "backup"**.


## Requirements

1. Apache 2.4
2. PHP 5.6
3. OpenSSL
4. AWS API Credentials


## Installation

### #1 Clone this repository
```javascript
git clone https://github.com/minorsolis/ec2InstanceBackup.git
```

### #2 Composer update

```javascript
cd ec2InstanceBackup/app
composer update
```

### #3 Set your own application key

```javascript
cd ec2InstanceBackup/app
php artisan key:generate
```


