<?php 

/**
 * Retrieve the information
 *
 * @param   string  $value  Value to return
 *
 * @return  string          
 */
function old( $value )
{
    if( isset($_POST) and isset($_POST[$value]) ) {
        return $_POST[$value];
    }
    return '';
}

/**
 * Make a hash
 *
 * @param   string  $str
 * @param   string  $salt 
 *
 * @return  string         
 */
function makeHash( $str, $salt = '' )
{
    return hash('sha256', $str . $salt);
}

/**
 * Generate a salt
 *
 * @param   int  $length  Length of string
 *
 * @return  string         
 */
function makeSalt( $length )
{
    // return mcrypt_create_iv($length);
    return uniqid().md5($length);
    
}

/**
 * Make a unique number
 *
 * @return  string  [return description]
 */
function unique()
{
    return makeHash(uniqid());
}

/**
 * A function to check if user is logged in
 *
 * @return  boolean  Return TRUE or FALSE
 */
function police()
{
    global $config;
    return (isset($_SESSION[$config['app']['session_id']])  ? true : false);
}

/**
 * Send user to given location
 *
 * @param   string  $to  Location
 *
 * @return  void
 */
function redirectTo( $to )
{
    header("Location: $to");
    exit;
}