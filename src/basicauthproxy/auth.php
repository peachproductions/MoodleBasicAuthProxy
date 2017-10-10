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
require_once(dirname(__FILE__) . '/vendor/autoload.php');

use GuzzleHttp\Client;

class auth_plugin_basicauthproxy extends auth_plugin_base
{
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

        $host = $this->config->host;
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Basic ' . base64_encode("$username:$password"),
        ];
        $client = new Client([
                'base_uri' => $host,
                'headers' => $headers
            ]
        );

        try {
            $response = $client->request('POST');
            $CFG->payload = json_decode($response->getBody()->getContents(), true);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Post authentication hook. This method is called from authenticate_user_login() for all enabled auth plugins.
     *
     * @param stdClass $user The user
     * @param string $username The username
     * @param string $password The password
     */
    public function user_authenticated_hook(&$user, $username, $password)
    {
        global $CFG, $DB;

        $this->log("user_authenticated_hook with user ID: $user->id");
        $this->log($CFG->payload);
    }

    public function is_internal()
    {
        return false;
    }

    public function is_synchronised_with_external()
    {
        return true;
    }

    private function log($msg)
    {
        global $CFG;
        if (!getenv('MOODLE_DEBUG')) return;

        if (is_object($msg)) {
            $msg = json_encode($msg);
        }
        if (is_array($msg)) {
            $msg = print_r($msg, true);
        }

        error_log("***** BasicAuthProxy: ${msg}");
    }
}