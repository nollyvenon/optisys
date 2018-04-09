<?php
/**
 * @package         PHP-Lib
 * @description     Abstract class is used to track the visitor's details
 * @copyright       Copyright (c) 2013, Peeyush Budhia
 * @author          Peeyush Budhia <peeyush.budhia@gmail.com>
 */
abstract class VisitorFootPrints
{
    private $geoXML;
    private $countryName;
    private $continentName;
    private $regionName;

    /**
     * @author          Peeyush Budhia <peeyush.budhia@gmail.com>
     *  @description    Abstract function
     */
    abstract public function storeInfo();

    /**
     * @author          Peeyush Budhia <peeyush.budhia@gmail.com>
     *  @description    Abstract function
     */
    abstract public function retrieveInfo();

    /**
     * @author          Peeyush Budhia <peeyush.budhia@gmail.com>
     * @description     Use to fetching the information from www.geoplugin.net to get geographical details of the visitor.
     */
    public function __construct()
    {
        $realIP = $this->getIP();

        $this->geoXML = simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=$realIP");

    }

    /**
     * @author          Peeyush Budhia <peeyush.budhia@gmail.com>
     * @description     Use to get the visitor's IP Address
     * @return mixed    IP Address of visitor
     *
     */
    private function getIP()
    {
        if (isset($_SERVER)) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $_realIP = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $_realIP = $_SERVER['HTTP_CLIENT_IP'];
            } else {
                $_realIP = $_SERVER['REMOTE_ADDR'];
            }
        } else {
            if (getenv($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $_realIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } elseif (getenv($_SERVER['HTTP_CLIENT_IP'])) {
                $_realIP = $_SERVER['HTTP_CLIENT_IP'];
            } else {
                $_realIP = $_SERVER['REMOTE_ADDR'];
            }
        }
        return $_realIP;
    }

    /**
     * @author          Peeyush Budhia <peeyush.budhia@gmail.com>
     * @description     Use to get the visitor's OS
     * @return string   Visitor's OS
     */
    private function getOS()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $os_platform = "Unknown OS Platform";
        $os_array = array(
            '/windows nt 6.3/i' => 'Windows 8.1',
            '/windows nt 6.2/i' => 'Windows 8',
            '/windows nt 6.1/i' => 'Windows 7',
            '/windows nt 6.0/i' => 'Windows Vista',
            '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
            '/windows nt 5.1/i' => 'Windows XP',
            '/windows xp/i' => 'Windows XP',
            '/windows nt 5.0/i' => 'Windows 2000',
            '/windows me/i' => 'Windows ME',
            '/win98/i' => 'Windows 98',
            '/win95/i' => 'Windows 95',
            '/win16/i' => 'Windows 3.11',
            '/macintosh|mac os x/i' => 'Mac OS X',
            '/mac_powerpc/i' => 'Mac OS 9',
            '/linux/i' => 'Linux',
            '/ubuntu/i' => 'Ubuntu',
            '/iphone/i' => 'iPhone',
            '/ipod/i' => 'iPod',
            '/ipad/i' => 'iPad',
            '/android/i' => 'Android',
            '/blackberry/i' => 'BlackBerry',
            '/webos/i' => 'Mobile'
        );

        foreach ($os_array as $regex => $value) {

            if (preg_match($regex, $user_agent)) {
                $os_platform = $value;
            }
        }

        return $os_platform;
    }

    /**
     * @author          Peeyush Budhia <peeyush.budhia@gmail.com>
     * @description     Use to get the visitor's Browser
     * @return string   Visitor's Browser
     */
    private function getBrowser()
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

    /**
     * @author          Peeyush Budhia <peeyush.budhia@gmail.com>
     * @description     Function is used to track all the visitor's details: date,time,referrer, ip address, continent, region, country, host name, os, browser.
     * @return array    All visitor's information.
     */
}