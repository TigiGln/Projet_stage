<?php

/**
 * UserConnection
 * 
 * Created on Thu May 6 2021
 * Latest update on Fri May 7 2021
 * Info - PHP class called in the header to check on each page if we are connected correctly or has rights.
 * If the session don't exist or is broken, check if the cookie yet exist and valid to load it in the session
 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
 */

class UserConnection {

    protected $path;
    protected $secret = "thinker-forge-drive-orchestra";
    protected $time;

    /**
     * __construct
     * Will register the correct path and will start the session if $start is true and init the cookie-session time.
     * @return void
     */
    public function __construct($path, $start) {
        if($start) { session_start(); };
        $this->path = $path;
        $this->time = time()+2592000; //One month lasting
    }
    
    /**
     * isValid will check if the session is correct (ie. if the values of the user stored in the session are correct). 
     * If no, if a cookie-session don't exist and if it does exist but its secret is wrong, will go back to form_connection.
     * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
     * @return void
     */
    public function isValid() {
        /* If session username/userName isn't set, do the cookie check */
        if(((!isset($_SESSION['username']) && !isset($_SESSION['userName'])) || !isset($_SESSION['userID'])) && !strpos($_SERVER["PHP_SELF"], "index.php")) {
            if(!isset($_COOKIE['cookie-session'])) { header('Location: '.$this->path); }
            $cookieData = json_decode($_COOKIE['cookie-session'], true);
            /* Cookie secret check before allowing to load cookie data into session*/
            $_SESSION['connexion'] = $cookieData[2];
            $_SESSION['username'] = $cookieData[2];
            $_SESSION['userName'] = $cookieData[2];
            $_SESSION['userID'] = $cookieData[1];
        } else if(((isset($_SESSION['username']) && isset($_SESSION['userName'])) && isset($_SESSION['userID'])) && strpos($_SERVER["PHP_SELF"], "index.php")) {
            header('Location: '.$this->path.'/tables/page_table.php?status=to_treat');
        }
    }
    
    /**
     * hashSecret will return a hash of the secret. 
     * Used when asking to register the cookie to stay connected.
     * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
     * @return an hash of the $secret
     */
    protected function hashSecret() {
        return password_hash($this->secret, PASSWORD_DEFAULT);
    }
    
    /**
     * generateCookie will generate and set a cookie for the user's datas, lasting $time.
     * If you host on a HTTPS website, you can set the before last parameter of setcookie to true (HTTPS-ONLY) to improve security of the cookie
     * The last parameter of setcookie dissalow front-end to interact with cookie data. Since we mainly rely on php page or AJAX request, we can
     * set it to true to avoid XSS Attack. If you need to access this cookie datas through front-end, you can turn it to false but you should be
     * careful of the risk depending of your usages. 
     * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
     * @param  mixed $datas
     * @param  mixed $time
     * @return void
     */
    public function generateCookie($datas) {
        array_unshift($datas, $this->hashSecret());
        setcookie('cookie-session', json_encode($datas), $this->time, "/", '', false, true); 
    }
}