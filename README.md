#MoodleBasicAuthProxy

##Development testing

#####Start docker Moodle container. From repo root directory:
* docker-compose up

Wait for this output before attempting to connect to moodle via browser 
(**be aware that this can take several minutes to complete**):
```
moodle_1   | mysql-c INFO  Found MySQL server listening at mariadb:3306
moodle_1   | mysql-c INFO  MySQL server listening and working at mariadb:3306
moodle_1   | moodle  INFO
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
#####To connect to Moodle app in browser:
* https://localhost

#####Moodle Admin Login: 
```
user = user
password = bitnami
```
     
#####Moodle Admin setup
* Login to site using Moodle Admin credentials `user, bitnami`
* Site administration > Plugins > Authentication > Manage authentication
* disable all authentication plugins
* enable HTTP Basic Authentication Proxy
* Settings: Host = http://auth/auth/index.html
* Save changes


#####Authentication server credentials (username:password):
```
jeff:letm31n
test:test
user1:password
```

#####Tail Moodle error log:
* docker-compose exec moodle bash
* tail -f /tmp/php_errors.log
