# AWS EC2 Instance Backups
This application will allow you to make backups (Full Images) of the instances that you want, all you need to do is setup this system and **add a tag in the instance that you want to backup with the name "backup"**.


## Requirements

1. Apache 2.4
2. PHP 5.6
3. OpenSSL
4. Composer
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

### #3 Copy the ec2InstanceBackup/app/.env.example to .env

```javascript
cd ec2InstanceBackup/app
cp -rp .env.example .env
```

### #4 Set your own application key

```javascript
cd ec2InstanceBackup/app
php artisan key:generate
```

### #5 Set your AWS Credentials

With an editor open the file **ec2InstanceBackup/app/.env** and the following credentials:
```javascript
AWS_ACCESS_KEY_ID=your_access_key_here
AWS_SECRET_ACCESS_KEY=your_secret_key_here
AWS_REGION=your_region_here (default: us-east-1)
```




