Installation Steps
------------------

### Server Requirements

    * PHP Version - 5.2.7+ (preferably 5.3.5)
        Extensions
            GD Version - 2.x+
            PCRE Version - 7.x+
            cURL version - 7.x+
            json version - 1.x+
            PDO
            Freetype
            mbstring
            PHP ionCube Loader
        php.ini settings
            max_execution_time - 180 (not mandatory)
            max_input_time - 6000 (not mandatory)
            memory_limit - 128M (at least 32M)
            safe_mode - off
            open_basedir - No Value
            display_error = On
            magic_quotes_gpc = Off
    * MySQL Version - 5.x
    * Apache - 1+ (preferably 2+)
        Modules
            mod_rewrite
            mod_deflate (not mandatory, but highly recommended for better performance–gzip)
            mod_expires (not mandatory, but highly recommended for better performance–browser caching)
    Recommended Linux distributions: Centos / Ubuntu / RedHat

### Initial Configurations

* Extract Files

		Unzip the zip file

		Upload the unzipped files in server.

* Need write permission for following folders

Note: The above folders need to be writable (Have to chmod to 655 or 755 or 775 depending upon the server configuration. Note: 777 is highly discouraged).

    Make sure the permission as read,write and executable as recursively for the below directories

    app/Config
    app/media
    app/tmp
    app/webroot (Should not set permission recursively)
    app/webroot/js
    app/webroot/img
    app/webroot/css
    app/Console/Command/cron.sh
    app/Console/Command/CronShell.php
    core/lib/Cake/Console/cake
    core/vendors/securimage

* Change following item in app/config/config.php

$config['site']['domain'] = 'fpplatform'; // change to your domain name (only name like "yourdomain"). also you need to set this only when site routing url is set as subdomain.

* Updating site logo

There are few places where site logo are located. To change those logo, you need to replace your logo with exact name and resolution in the following mentioned directories.
		* app/webroot/img/logo        - logo.png            - 131 x 46
		* app/webroot                 - favicon.ico         - 16 x 16

### Configure Your Database

    The sql file 'fpplatform_with_empty_data.sql' is also attached, which is located in 'app/config/sql'. import the database through phpmyadmin or any other tool.
    After importing the sql database, do not truncate any data directly from the database. All the data in the imported database are required. Removing unwanted cities can be done through administrator end which will be explained later in the following steps.
    In app/config/database.php, we need to change host, login, password, database. Update that in 4 places (For setting up master/slave setup, get professional help and it's not thoroughly tested)

(
  'host' => 'localhost',
  'login' => 'dbuser',
  'password' => 'dbpassword',
  'database' => 'fpplatform'
)

### Configure Apache

If you can reset 'DocumentRoot'

Reset your Apache DocumentRoot to /public_html/app/webroot/ by following means:

    If you're on dedicated host, reset DocumentRoot in httpd.conf with /public_html/app/webroot/
    If you're on shared host, reset your virtual directory to point to /public_html/app/webroot/

Note: This requirement is not mandatory, but highly preferred to skip the following tweaks in htaccess files.
If you cannot reset 'DocumentRoot'

* Installing site directly in the root e.g., http://yourdomain.com/

Again, no need to tweak 'htaccess' files.
Installing site as a sub-folder e.g., http://yourdomain.com/myfolder

    app/.htaccess ensure the RewriteBase as below:

RewriteBase    /myfolder/app/

    app/webroot/.htaccess ensure the RewriteBase as below:

RewriteBase	/myfolder/

### Setting up cron

* Setup the cron with anyone of the following command,

		*/2 * * * * /home/public_html/app/Console/Command/cron.sh 1>> /home/public_html/app/tmp/error.log 2>> /home/public_html/app/tmp/error.log

Also you need to edit '/home/public_html/app/Console/Command/cron.sh' file to change the folder path of each command. Note: Please replace ”/home/public_html/” with your folder path.

(or)

php4 is enabled for shell command in some server, above command will not work. In that case, you can use anyone of the following commands,

* Command 1:

Check php installed path in server using ssh command. which php or which php5. It will give output like /usr/bin/php5.

	vi /home/public_html/core/lib/Cake/Console/cake
 
	exec php -q ${LIB}cake.php -working "${APP}" "$@"

In the above file, change the php path with your server php5 installed path,

	exec /usr/bin/php5 -q ${LIB}cake.php -working "${APP}" "$@"

(or)

* Command 2:

		*/2 * * * * wget http://yourdomain.com/cron/main
		0 0 * * * wget http://yourdomain.com/cron/daily

(or)

* Command 3:

		*/2 * * * * lynx http://yourdomain.com/cron/main
		0 0 * * * lynx http://yourdomain.com/cron/daily

(or)

* Command 4:

		*/2 * * * * curl http://yourdomain.com/cron/main
		0 0 * * * curl http://yourdomain.com/cron/daily

### Verify Your Configuration

* Running site for the first time

Now run the site with http://yourdomain.com/ or http://yourdomain.com/myfolder
After successful running of the site, login as admin using the below details in login form.

      username: admin
      password: agriya

To change administrator profile details, click 'My Account' in the top menu, then edit the profile information.
To change administrator password, click 'Change Password' in the top menu, then change the password.

