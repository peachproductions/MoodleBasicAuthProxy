# MoodleBasicAuthProxy

Development testing
-------------------

Start docker Moodle container. From repo root directory:
docker-compose up
(not using -d allows to view output)

Wait for this output before attempting to connect to moodle via browser:
    moodle_1   | moodle  INFO 
    moodle_1   | nami    INFO  moodle successfully initialized
    moodle_1   | INFO  ==> Starting moodle... 

To connect to Moodle app in browser:
https://localhost

Moodle Admin Login: 
  user = user
  password = bitnami
       
Authentication server credentials (username:password):
jeff:letm31n
test:test
user1:password



Can tail Moodle error log:
docker-compose exec moodle bash
tail -f /tmp/php_errors.log