<?php
        $this->geoXML = simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=$realIP");


function getIP()
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

        if (gethostbyaddr($this->getIP()) == '') {
            $hostName = 'Unknown Host';
        } else {
            $hostName = gethostbyaddr($this->getIP());
        }

function getOS()
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
	
	    function trackDetails()
    {
        $dateTime = date('d-m-Y h:i:s A');

        $referer = '';
        if (isset($_SERVER['HTTP_REFERER'])) {
            $referrer = $_SERVER['HTTP_REFERER'];
        } else {
            $referrer = 'Direct Link';
        }

        $ipAddress = $this->getIP();

        if ($this->geoXML->geoplugin_countryName == '')
            $this->countryName = 'Unknown Country';
        else
            $this->countryName = $this->geoXML->geoplugin_countryName;

        if ($this->geoXML->geoplugin_continentCode == '') {
            $this->continentName = 'Unknown Continent';
        } else {
            $continent_array = array(
                'AF' => 'Africa',
                'AN' => 'Antarctica',
                'AS' => 'Asia',
                'EU' => 'Europe',
                'NA' => 'North America',
                'SA' => 'South America',
                'OC' => 'Oceania',
            );

            $continentCode = $this->geoXML->geoplugin_continentCode;

            foreach ($continent_array as $code => $continentName) {
                if ($continentCode == $code) {
                    $continent = $continentName;
                }
            }
            $this->continentName = $continent;
        }

        if ($this->geoXML->geoplugin_regionName == '') {
            $this->regionName = 'Unknown Region';
        } else {
            $this->regionName = $this->geoXML->geoplugin_regionName;
        }

        $hostName = '';

        if (gethostbyaddr($this->getIP()) == '') {
            $hostName = 'Unknown Host';
        } else {
            $hostName = gethostbyaddr($this->getIP());
        }

        return array('IP' => $this->getIP(), 'Continent' => $this->continentName, 'Region' => $this->regionName, 'Country' => $this->countryName, 'Referrer' => $referrer, 'OS' => $this->getOS(), 'Host' => $hostName, 'Browser' => $this->getBrowser(),'DateTime'=>$dateTime);

    }

	
	$IP = $this->getIP();
	 $OS = $this->getOS();
	 $user_id= $this->session->userdata('admin_id');
	 $user_type = 'admin';
	 
//	  "INSERT INTO logs (ip,user_type,user_id,description,ip, location, trackhost, trackbrowser, trackdatetime) VALUES('$trackDetails[IP]','$trackDetails[Continent]','$trackDetails[Region]','$trackDetails[Country]','$trackDetails[Referrer]','$trackDetails[OS]','$trackDetails[Host]','$trackDetails[Browser]','$trackDetails[DateTime]')";

        mysql_query("INSERT INTO footprintdetails(user_type,user_id,trackip,trackcontinent,trackregion,trackcountry,trackreferrer, trackos, trackhost, trackbrowser, trackdatetime) VALUES('$user_type', '$user_id', '$trackDetails[IP]', '$trackDetails[Continent]','$trackDetails[Region]','$trackDetails[Country]','$trackDetails[Referrer]','$trackDetails[OS]','$trackDetails[Host]','$trackDetails[Browser]','$trackDetails[DateTime]')");
