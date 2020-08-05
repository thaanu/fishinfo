<?php 
class User 
{
    public function __construct()
    {

        // Create database instance
        global $config;

        // Create database instance
        $this->conn = new mysqli($config['db']['host'], $config['db']['user'],$config['db']['pass'], $config['db']['name']);
        
    }

    /**
     * Find user by username
     *
     * @param   string  $username  Unique username given for the user
     *
     * @return  array             Return user
     */
    public function findUsername( $username )
    {

        $data = [];

        try {
            $result = $this->conn->query("SELECT * FROM users WHERE username = '$username'");
            if( $result->num_rows == 0 ) { throw new Exception("No user found"); }
            $data = $result->fetch_all(MYSQLI_ASSOC)[0];
        }
        catch( Exception $e ) {
            $this->errors[] = $e->getMessage();
        }

        return $data;

    }

}