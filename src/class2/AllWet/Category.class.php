<?php
/**
 * All Wet
 * 2018
 * 
 * Class
 * Category
 */

namespace AllWet;

class Category {

    // Properties
    public $mysqli;

    public $category_array;

    public $category_id;
    public $category_name;
    public $category_description;
    public $category_code;

    // Method

    /**
     * __construct
     * @param: $mysqli
     * @return: void
     */
    function __construct($mysqli){
        $this->mysqli = $mysqli;
    }

   /**
     * add
     * @param: Array $c_array
     * @return: Boolean
     */
    final public function add(Array $c_array){

        // Handle Params
        if($c_array['category_name']) $this->category_name = $c_array['category_name'];
        if($c_array['category_description']) $this->category_description = $c_array['category_description'];
        if($c_array['category_code']) $this->category_code = $c_array['category_code'];

        // Check if code already exists
        if($this->codeExists($this->category_code)){
            return False;
        } else {
            // Insert into DB
            $stmt = $this->mysqli->prepare("INSERT INTO `category`(category_name, category_description, category_code) VALUES (?,?,?)");
            $stmt->bind_param("sss",$this->category_name, $this->category_description, $this->category_code);
            $stmt->execute();

            // Return true
            return True;
        }
    }
      
    /**
     * codeExists
     * 
     * @param: Int $category_code
     * @return: Boolean
     */
    final public function codeExists(Int $category_code){
        // Handle Params
        $this->category_code = $category_code;

        // Query if Category Code already exists
        $stmt = $this->mysqli->prepare("SELECT category_id FROM `category` WHERE category_code = ? LIMIT 1");
        $stmt->bind_param("s", $this->category_code);
        $stmt->execute();

        $result = $stmt->get_result();

        if($result->fetch_assoc()){
            return True;
        } else {
            return False;
        }

    }
   
   /**
     * delete
     * 
     * @param: Int $category_id
     * @return: Boolean
     */
    final public function delete(Int $category_id){
        // Handle Params
        $this->category_id = $category_id;

        // Delete from DB
        $stmt = $this->mysqli->prepare("DELETE FROM `category` WHERE category_id = ?");
        $stmt->bind_param("s",$this->category_id);
        $stmt->execute();

        // Check if deleted
        $stmt = $this->mysqli->prepare("SELECT category_id FROM `category` WHERE category_id = ? LIMIT 1");
        $stmt->bind_param("s",$this->category_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $result = $result->fetch_assoc();

        if(empty($result)){
            return True;
        } else {
            return False;
        }

    }

   /**
     * get
     * 
     * @param: Int $category_id
     * @return: Array
    */
    final public function get(Int $category_id){
        // Handle Param
        $this->category_id = $category_id;

        // Prepare Statement
        $stmt = $this->mysqli->prepare("SELECT * FROM `category` WHERE `category_id` = ?");
        // Bind and execute
        $stmt->bind_param("s",$this->category_id);
        $stmt->execute();

        // Handle Result
        $result = $stmt->get_result();

        // Return Result
        return $result->fetch_assoc();
    }
   
    /**
     * getAll
     * 
     * @param: none
     * @return: Array
     */
    final public function getAll(){

        // Query
        $stmt = $this->mysqli->prepare("SELECT * FROM category");
        $stmt->execute();
        $cats = $stmt->get_result();

        // Create placeholder array
        $this->category_array = array();

        // Loop along results
        while($cat = $cats->fetch_array()){

            $category_id = $cat['category_id'];
            $category_name = $cat['category_name'];
            $category_description = $cat['category_description'];
            $category_code = $cat['category_code'];

            $prep_arr = array(
                "category_id"=>$category_id,
                "category_name"=>$category_name,
                "category_description"=>$category_description,
                "category_code"=>$category_code
            );

            // Push to placeholder array
            array_push($this->category_array,$prep_arr);
        }

        // Return Result
        return $this->category_array;
    }

    /**
     * update
     * 
     * @param: Array $c_array
     * @return: Boolean
     */
    final public function update(Array $c_array){
        // Handle Params
        $this->category_id = $c_array['category_id'];
        $this->category_name = $c_array['category_name'];
        $this->category_description = $c_array['category_description'];
        $this->category_code = $c_array['category_code'];

        // Check if Category Entry Exists
        if($this->get($this->category_id)){

            // Update Entry
            $stmt = $this->mysqli->prepare("UPDATE `category` SET `category_name` = ?, `category_description` = ?, `category_code` = ? WHERE `category_id` = ?");
            $stmt->bind_param("ssss", $this->category_name, $this->category_description, $this->category_code, $this->category_id);
            $stmt->execute();

            return True;

        } else {

            return False;

        }

    }
    

 }
?>