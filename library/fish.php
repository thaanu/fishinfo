<?php 


use mysqli;

class Fish
{

    protected $conn;
    protected $errors;

    public function __construct()
    {

        global $config;

        // Create database instance
        $this->conn = new mysqli($config['db']['host'], $config['db']['user'],$config['db']['pass'], $config['db']['name']);

    }

    /**
     * Select all the fish from the database
     *
     * @return  array  Return an array of fishes
     */
    public function selectAllFish()
    {

        $result = $this->conn->query('SELECT * FROM fishes');
        return ( $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : [] );

    }

    /**
     * Select a single fish from the database by the record ID
     * 
     * @param int $id
     *
     * @return  array  Return an array of fish
     */
    public function selectFishByID($id)
    {

        $data = [];

        try {

            $result = $this->conn->query("SELECT * FROM fishes WHERE ID = $id");

            if( $result->num_rows == 0 ) {
                throw new Exception('No records found');
            }

            $data = $result->fetch_all(MYSQLI_ASSOC);

        }
        catch( Exception $e ) {
            
            $this->errors[] = $e->getMessage();

        }
        finally {

            // Close Database Connection
            $this->conn->close();

            // By default return $data
            return $data;

        }

    }


    /**
     * Add a new fish to the database
     * 
     * @param string $fish_name
     * @param string $fish_name_dv
     * @param string $description
     * @param string $tags
     * @param int $created_by
     * @param array $photos
     *
     * @return  boolean  Return TRUE or FALSE
     */
    public function addFish( $fish_name, $fish_name_dv, $description, $tags, $created_by, $photos = [] )
    {

        $result = false;

        try {

            // First add fish into to fish table
            $sql = "INSERT INTO fishes (fish_name,fish_name_dv,fish_desc,fish_tags,created_by) VALUES ('$fish_name', '$fish_name_dv', '$description', '$tags', '$created_by')";
            
            if ($this->conn->query($sql) === FALSE ) {
                throw new Exception($this->conn->error);
            }

            // Get the last record ID
            $last_record_id = $this->conn->insert_id;

            // Loop all the photos
            if( ! empty($photos) ) {
                foreach( $photos as $photo ) {
                    $this->addPhoto($last_record_id, $photo);
                }
            }

            $result = true;

        }
        catch( Exception $e ){

            $this->errors[] = $e->getMessage();

        }
        finally {

            // Return results
            return $result;

        }

    }

    /**
     * Update a fish information
     *
     * @param   int  $fish_id  Fish Row ID
     * @param   array  $params 
     *
     * @return  boolean                Return TRUE or FALSE
     */
    public function updateFish( $fish_id, $params = [] )
    {

        $result = false;

        try {

            if( empty($params) ) {
                throw new Exception("No data to update");
            }

            $fields = '';

            foreach( $params as $key => $value ) {
                $fields .= "$key='$value',";
            }

            $fields = rtrim($fields, ',');

            $sql = "UPDATE fishes SET $fields WHERE id = $fish_id";

            if ($this->conn->query($sql) === FALSE ) {
                throw new Exception($this->conn->error);
            }

            $result = true;

        }
        catch( Exception $e ) {

            $this->errors[] = $e->getMessage();

        }
        finally {

            return $result;
            
        }

    }

    /**
     * Add fish photo to database
     * 
     * @param int $fish_id
     * @param string $photo_name
     *
     * @return  boolean
     */
    public function addPhoto( $fish_id, $photo_name )
    {

        $result = false;

        try {
            
            if ($this->conn->query("INSERT INTO photos (fish_id,photo_name) VALUES ($fish_id, $photo_name)") === FALSE ) {
                throw new Exception($this->conn->error);
            }

            $result = true;

        }
        catch( Exception $e ){

            $this->errors[] = $e->getMessage();

        }
        finally {

            // Return results
            return $result;

        }

    }
    

    /**
     * Return the errors
     *
     * @return  array
     */
    public function errors()
    {
        return $this->errors;
    }

}