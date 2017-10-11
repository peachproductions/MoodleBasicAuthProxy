# MoodleBasicAuthProxy

##### Dev Host requirements
* Docker Engine
* Docker Compose (`https://docs.docker.com/compose/install/#install-compose`)
* PHP + Composer (`https://getcomposer.org/doc/00-intro.md`)

##### Development setup
Run the setup.sh bash script `./setup.sh`.

##### Starting the docker Moodle container
From repo root directory: `docker-compose up`

Wait for this output before attempting to connect to moodle via browser 
(**be aware that this can take several minutes to complete**):
```
moodle_1   | mysql-c INFO  Found MySQL server listening at mariadb:3306
moodle_1   | mysql-c INFO  MySQL server listening and working at mariadb:3306
moodle_1   | moodle  INFO  Configuring Cron Jobs...
moodle_1   | moodle  INFO
moodle_1   | moodle  INFO  ########################################################################
moodle_1   | moodle  INFO   Installation parameters for moodle:
moodle_1   | moodle  INFO     Username: user
moodle_1   | moodle  INFO     Password: **********
moodle_1   | moodle  INFO     Email: user@example.com
moodle_1   | moodle  INFO   (Passwords are not shown for security reasons)
moodle_1   | moodle  INFO  ########################################################################
moodle_1   | moodle  INFO
moodle_1   | nami    INFO  moodle successfully initialized
moodle_1   | INFO  ==> Starting moodle... 
```
##### To connect to Moodle app in browser:
* https://localhost

##### Moodle Admin Login: 
Standard Docker Moodle Admin: user = 'user', password = 'bitnami'
     
##### Moodle Admin setup
* Login to site using Moodle Admin credentials `user, bitnami`
* Site administration > Plugins > Authentication > Manage authentication
* enable HTTP Basic Authentication Proxy
* Settings: URL = http://auth/response.php (docker auth service)
* Save changes

##### Turn on Moodle's Developer Debug mode
* Site administration > Development > Debugging > Developer mode

##### Some test HTTP basic auth server credentials (username:password):
There are 100 users setup in the .htpasswd file for authentication:
* Username: u0 ... u99
* Password: password

##### Tail Moodle error log:
```
docker-compose exec moodle bash
tail -f /tmp/php_errors.log
```

##### Accessing the Moodle Database
```
docker-compose exec moodle bash
mysql -h mariadb -u root
```

##### Installing the plugin
* copy the 'basicauthproxy' directory and its contents to the Moodle server's directory: `/path/to/moodle/auth`. 
It should sit at the same level as the other auth plugins, e.g. /email, /nologin, /oauth2, etc.
* cd into the basicauthproxy directory and run `composer install`
* restart Moodle - plugin should be visible in admin panel