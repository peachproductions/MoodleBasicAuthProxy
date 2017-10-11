<?php
/**
 * Use a remote login service and enrol new user if not already in Moodle database
 *
 * @package auth_remote
 * @author Jeff Lloyd
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/authlib.php');
require_once(dirname(__FILE__) . '/vendor/autoload.php');

use BasicAuthProxy\AuthenticatorFactory;

class auth_plugin_basicauthproxy extends auth_plugin_base
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        global $CFG;
        $this->authtype = 'BasicAuthProxy';
        $this->config = get_config('auth_basicauthproxy');
    }

    /**
     * Returns true if the username and password work or don't exist and false
     * if the user exists and the password is wrong.
     *
     * @param string $username The username
     * @param string $password The password
     * @return bool Authentication success or failure.
     */
    public function user_login($username, $password)
    {
        global $CFG;

        $auth = AuthenticatorFactory::create($this);

        try {
            $response = $auth->requestAuthentication($username, $password);
            $CFG->payload = $response->getRequiredData();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Post authentication hook.
     * This method is called from authenticate_user_login() for all enabled auth plugins.
     *
     * @param object $user user object, later used for $USER
     * @param string $username (with system magic quotes)
     * @param string $password plain text password (with system magic quotes)
     */
    public function user_authenticated_hook(&$user, $username, $password)
    {
        global $CFG, $DB;

        $dbUser = $DB->get_record('user', array('username'=>$username, 'mnethostid'=>$CFG->mnet_localhost_id));

        if (empty($dbUser)) { // trouble
            error_log("Cannot update non-existent user: $username");
            print_error('auth_dbusernotexist','auth_basicauthproxy',$username);
            die;
        }

        $needsupdate = empty($dbUser->firstname) || empty($dbUser->lastname) || empty($dbUser->email);

        if ($needsupdate) {
            require_once($CFG->dirroot . '/user/lib.php');
            $updateuser = clone($user);
            $updateuser->firstname = $CFG->payload['firstname'];
            $updateuser->lastname = $CFG->payload['lastname'];
            $updateuser->email = $CFG->payload['email'];

            user_update_user($updateuser);

            $user->firstname = $CFG->payload['firstname'];
            $user->lastname = $CFG->payload['lastname'];
            $user->email = $CFG->payload['email'];
        }
        unset($CFG->payload);
    }
}