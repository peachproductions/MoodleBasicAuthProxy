<?php


defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {

    // Introductory explanation.
    $settings->add(new admin_setting_heading('auth_basicauthproxy/pluginname', '', new lang_string('auth_basicauthproxydescription', 'auth_basicauthproxy')));

    // URL
    $settings->add(new admin_setting_configtext('auth_basicauthproxy/host', get_string('auth_basicauthproxyhost_key', 'auth_basicauthproxy'),
            get_string('auth_basicauthproxyhost', 'auth_basicauthproxy'),
            '', PARAM_RAW));

}
