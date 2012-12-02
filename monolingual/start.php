<?php
/**
 * Removing language selection in user settings
 * and set user language to site default language at login
 * if this user is not an admin
 *
 * (c) iionly 2012
 */

elgg_register_event_handler('init', 'system', 'monolingual_init');

function monolingual_init() {
    // React on login event
    elgg_register_event_handler('login', 'user', 'monolingual_set_user_language');

}

/**
 * Set the user language to site language at login time to take into account the currently selected site langage
 */
function monolingual_set_user_language($event, $object_type, $object) {

    global $CONFIG;

    if($event == 'login' && $object_type=='user' && $object instanceof ElggUser) {

        if (!(elgg_is_admin_user($object->guid))) {

            if (isset($CONFIG->language) && ($CONFIG->language)) {
                $object->language = $CONFIG->language;
                $object->save();
            }
        }
    }

    return true;
}