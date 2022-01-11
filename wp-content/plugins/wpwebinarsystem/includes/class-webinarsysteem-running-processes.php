<?php

class WebinarSysteemRunningProcesses {
    protected static function get_key_from_name($name) {
        return 'wpws_is_running_'.$name;
    }

    public static function is_running($name) {
        return get_transient(self::get_key_from_name($name)) != false;
    }

    public static function refresh($name, $expires_in = 60) {
        set_transient(self::get_key_from_name($name), true, $expires_in);
    }
}
