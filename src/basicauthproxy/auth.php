<?php
/**
 * Use a remote login service and modify user
 *
 * @package auth_remote
 * @author Jeff Lloyd
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/authlib.php');

class auth_plugin_basicauthproxy extends auth_plugin_base
{
    const DEBUG = true;

    /**
     * Constructor.
     */
    public function __construct()
    {
        global $CFG;
        $this->authtype = 'basicauthproxy';
        $this->config = get_config('auth_basicauthproxy');
    }

    /**
     * Called when attempting to access a restricted page
     * and the user is not logged in.
     */
    public function pre_loginpage_hook()
    {
        $this->log("In pre_loginpage_hook");
        $this->loginpage_hook();
    }

    /**
     * Called when user goes directly to login page
     */
    public function loginpage_hook()
    {
        global $CFG, $DB, $USER, $SESSION;
        $this->log("In loginpage_hook");
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
        global $CFG, $DB;
        $this->log("In user_login");
        $host = $this->config->host;
        $this->log("Host = ${host}");

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $host,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_NOBODY => true,
            CURLOPT_USERPWD => "$username:$password",
            CURLOPT_TIMEOUT => 30,
            CURLOPT_POST => true
        ));
        $result = curl_exec($curl);
        curl_close($curl);

        $this->log($result);

        if (strpos($result, '200 OK')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * This method is called from authenticate_user_login() right after the user object is generated.
     * This gives the auth plugin an option to make modification to the user object
     * before the verification process starts.
     *
     * @param stdClass $user The user
     */
    public function pre_user_login_hook(&$user)
    {
        $this->log("pre_user_login_hook");
        $this->log(json_encode($user));
    }

    /**
     * Post authentication hook. This method is called from authenticate_user_login() for all enabled auth plugins.
     *
     * @param stdClass $user The user
     * @param string $username The username
     * @param string $password The password
     */
    public function user_authenticated_hook($user, $username, $password)
    {
        $this->log("user_authenticated_hook");
    }

    private function log($msg)
    {
        if (!self::DEBUG) return;
        global $CFG;

        error_log("***** BasicAuthProxy: ${msg}");

    }
}