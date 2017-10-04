<?php


defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {

    // Introductory explanation.
    $settings->add(new admin_setting_heading('auth_basicauthproxy/pluginname', '', new lang_string('auth_basicauthproxydescription', 'auth_basicauthproxy')));

    // Host.
    $settings->add(new admin_setting_configtext('auth_basicauthproxy/host', get_string('auth_basicauthproxyhost_key', 'auth_basicauthproxy'),
            get_string('auth_basicauthproxyhost', 'auth_basicauthproxy') . ' ' .get_string('auth_multiplehosts', 'auth'),
            '127.0.0.1', PARAM_RAW));

//    // Type.
//    $imapoptions = array();
//    $imaptypes = array('imap', 'imapssl', 'imapcert', 'imapnosslcert', 'imaptls');
//    foreach ($imaptypes as $imaptype) {
//        $imapoptions[$imaptype] = $imaptype;
//    }
//
//    $settings->add(new admin_setting_configselect('auth_imap/type',
//        new lang_string('auth_imaptype_key', 'auth_imap'),
//        new lang_string('auth_imaptype', 'auth_imap'), 'imap', $imapoptions));
//
//    // Port.
//    $settings->add(new admin_setting_configtext('auth_imap/port', get_string('auth_imapport_key', 'auth_imap'),
//            get_string('auth_imapport', 'auth_imap'), '143', PARAM_INT));
//
//    // Password change URL.
//    $settings->add(new admin_setting_configtext('auth_imap/changepasswordurl',
//            get_string('auth_imapchangepasswordurl_key', 'auth_imap'),
//            get_string('changepasswordhelp', 'auth'), '', PARAM_URL));
//
//    // Display locking / mapping of profile fields.
//    $authplugin = get_auth_plugin('imap');
//    display_auth_lock_options($settings, $authplugin->authtype, $authplugin->userfields,
//            get_string('auth_fieldlocks_help', 'auth'), false, false);

}
