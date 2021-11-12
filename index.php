<?php

	// admin\model\catalog\product.php
	// class ModelCatalogProduct extends Model {	

	public function isHas($product_id,$category_id){

	       $query =	$this->db->query("SELECT * FROM ".DB_PREFIX."product_to_category WHERE category_id='".$category_id."' AND product_id='".$product_id."' ");

		   if($query->num_rows > 0 ){

			   return true ;

		   }else{

			   return false;

		   }

	}

	public function findParent ($category_id) {

		$category_row       = $this->db->query("SELECT * FROM ".DB_PREFIX."category WHERE category_id='".$category_id."' ")->row;
	
		$category_parent_id = $category_row['parent_id'];
	
		$category_id        = $category_row['category_id'];
	
		$category_data      = $category_id;
	
		if( $category_parent_id !=0 ){
	
			$category_data .= ",".$this->findParent ($category_parent_id);
	
		}
	 
		return  $category_data ;
	}


	//public function addProduct($data) {
	
	if (isset($data['product_category'])) {

		foreach ($data['product_category'] as $category_id) {

			$all_cat_id         =  $this->findParent ($category_id);	

			if (strpos($all_cat_id, ',') !== false) {
			 
				$all_cat_ids          =  explode(",", $all_cat_id);

			}else{
				$all_cat_ids[0]        =  $all_cat_id;
			}

			foreach($all_cat_ids as $cat_id){

				if(!$this->isHas($product_id,$cat_id)){

					$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$cat_id . "'");
				}
			}
			
		}

	}	


	//public function editProduct($product_id, $data) {

	$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_category'])) {

			foreach ($data['product_category'] as $category_id) {
  
				$all_cat_id         =  $this->findParent ($category_id);	

				if (strpos($all_cat_id, ',') !== false) {
				 
					$all_cat_ids          =  explode(",", $all_cat_id);
	
				}else{
					$all_cat_ids[0]        =  $all_cat_id;
				}
 
				foreach($all_cat_ids as $cat_id){

					if(!$this->isHas($product_id,$cat_id)){

						$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$cat_id . "'");
					}
				}
				
			}

		}


?>