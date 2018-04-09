<?php

     function getBrowser()
    {
        static $agent = null;

        if (empty($agent)) {
            $agent = $_SERVER['HTTP_USER_AGENT'];

            if (stripos($agent, 'Firefox') !== false) {
                $agent = 'Firefox';
            } elseif (stripos($agent, 'MSIE') !== false) {
                $agent = 'Internet Explorer';
            } elseif (stripos($agent, 'iPad') !== false) {
                $agent = 'IPAD';
            } elseif (stripos($agent, 'Android') !== false) {
                $agent = 'Android';
            } elseif (stripos($agent, 'Chrome') !== false) {
                $agent = 'Chrome';
            } elseif (stripos($agent, 'Safari') !== false) {
                $agent = 'Safari';
            } elseif (stripos($agent, 'AIR') !== false) {
                $agent = 'AIR';
            } elseif (stripos($agent, 'Fluid') !== false) {
                $agent = 'Fluid';
            }
        }
        return $agent;
    }

    
    ?>