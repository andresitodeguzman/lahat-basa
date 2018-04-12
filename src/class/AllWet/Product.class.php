<?php
/**
 * All Wet
 * 2018
 * 
 * Class
 * Product
 */

namespace AllWet;

class Product {

    // Properties
    public $mysqli;

    public $product_id;
    public $product_code;
    public $product_name;
    public $product_description;
    public $category_id;
    public $product_price;
    public $product_available;
    public $product_image;

    // Methods

    /**
     * __construct
     * @param: 
     * @return: void
     */
    function __construct($mysqli){
        $this->mysqli = $mysqli;
    }

    /**
     * add
     * 
     * @param: Array $p_array
     * @return: Bool
     */
    final public function add(Array $p_array){
        // Handle Params
        if($p_array['product_code']) $this->product_code = $p_array['product_code'];
        if($p_array['product_name']) $this->product_name = $p_array['product_name'];
        if($p_array['product_description']) $this->product_description = $p_array['product_description'];
        if($p_array['category_id']) $this->category_id = $p_array['category_id'];
        if($p_array['product_price']) $this->product_price = $p_array['product_price'];
        if($p_array['product_available']) $this->product_available = $p_array['product_available'];
        if($p_array['product_image']) $this->product_image = $p_array['product_image'];

        // Check if code exists
        if($this->codeExists($this->product_code)){
            return False;
        } else {
            // Insert in DB
            $stmt = $this->mysqli->prepare("INSERT INTO `product` (product_code, product_name, product_description, category_id, product_price, product_available, product_image) VALUES (?,?,?,?,?,?,?)");
            $stmt->bind_param("sssssss", $this->product_code, $this->product_name, $this->product_description, $this->category_id, $this->product_price, $this->product_available, $this->product_image);
            $stmt->execute();

            return True;
        }
    }

    /**
     * codeExists
     * 
     * @param: Int $product_code
     * @return: Boolean
     */
    final public function codeExists(Int $product_code){
        // Handle Param
        $this->product_code = $product_code;

        // Query in DB
        $stmt = $this->mysqli->prepare("SELECT product_id FROM `product` WHERE `product_id` = ? LIMIT 1");
        $stmt->bind_param("s",$this->product_id);
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
     * @param: Int $product_id
     * @return: Boolean
     */
    final public function delete(Int $product_id){
      $this->product_id = $product_id;
      
      $stmt = $this->mysqli->prepare("DELETE FROM `product` WHERE `product_id` = ?");
      $stmt->bind_param("s", $this->product_id);
      $stmt->execute();
      
      return True;
    }
  
    /**
     * getAll
     * 
     * @param: none
     * @return: Array
     */
    final public function getAll(){
        // Query in DB
        $stmt = $this->mysqli->prepare("SELECT * FROM `product`");
        $stmt->execute();
        $result = $stmt->get_result();

        // Create array placeholder
        $this->product_array = array();

        // Loop along results
        while($prod = $result->fetch_array()){
            $product_id = $prod['product_id'];
            $product_code = $prod['product_code'];
            $product_name = $prod['product_name'];
            $product_description = $prod['product_description'];
            $product_available = $prod['product_available'];
            $category_id = $prod['category_id'];
            $product_price = $prod['product_price'];
            $product_image = $prod['product_image'];

            $prep_arr = array(
                "product_id" => $product_id,
                "product_code" => $product_code,
                "product_name" => $product_name,
                "product_description" => $product_description,
                "product_available" => $product_available,
                "category_id" => $category_id,
                "product_price" => $product_price,
                "product_image" => $product_image
            );

            array_push($this->product_array, $prep_arr);
            
        }

        // Return Array
        return $this->product_array;
    }

    /**
     * get
     * 
     * @param: Int $product_id
     * @return: Array
     */
    final public function get(Int $product_id){
        // Handle Param
        $this->product_id = $product_id;

        // Query in DB
        $stmt = $this->mysqli->prepare("SELECT * FROM `product` WHERE `product_id` = ?");
        $stmt->bind_param("s",$this->product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
        
    }


    /**
     * update
     * 
     * @param: Array $p_array
     * @return: Boolean
     */
    final public function update(Array $p_array){
        // Handle Params
        if($p_array['product_id']) $this->product_id = $p_array['product_id'];
        if($p_array['product_code']) $this->product_code = $p_array['product_code'];
        if($p_array['product_name']) $this->product_name = $p_array['product_name'];
        if($p_array['product_description']) $this->product_description = $p_array['product_description'];
        if($p_array['category_id']) $this->category_id = $p_array['category_id'];
        if($p_array['product_price']) $this->product_price = $p_array['product_price'];
        if($p_array['product_available']) $this->product_available = $p_array['product_available'];
        if($p_array['product_image']) $this->product_image = $p_array['product_image'];

        // Check if in DB
        if($this->get($this->product_id)){
            // Update entry
            $stmt = $this->mysqli->prepare("UPDATE `product` SET `product_code` = ?, `product_name` = ?, `product_description` = ?, `category_id` = ?, `product_price` = ?, `product_available` = ?, `product_image` = ? WHERE `product_id` = ?");
            $stmt->bind_param("ssssssss", $this->product_code, $this->product_name, $this->product_description, $this->category_id, $this->product_price, $this->product_available, $this->product_image, $this->product_id);
            $stmt->execute();

            return True;

        } else {

            return False;

        }
    }

}
?>
