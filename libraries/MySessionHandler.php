<?php

class MySessionHandler
{
    public function isUserLoggedIn() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset ( $_SESSION ['loggedIn'] ) && $_SESSION ['loggedIn'] == true) {
            $time = time();

            $timeout_duration = 1800;
            $sessionid_update_duration = 600;

            if (isset($_SESSION['lastActivity']) && ($time - $_SESSION['lastActivity']) > $timeout_duration) {
                session_unset();
                setcookie(session_name(), "", 1);
                setcookie(session_name(), false);
                unset($_COOKIE[session_name()]);
                session_destroy();
                return false;
            }

            if (isset($_SESSION['lastSessionUpdate']) && ($time - $_SESSION['lastSessionUpdate']) > $sessionid_update_duration) {
                session_regenerate_id();
                $_SESSION['lastSessionUpdate'] = $time;
            }

            $_SESSION['lastActivity'] = $time;
            return true;

        } else {
            return false;
        }
    }
}