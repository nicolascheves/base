<?php

class ProductView  {
    
   
    public function showProducts ($products, $categories){
      
        require_once './templates/form.add.product.phtml';
        require_once './templates/products.phtml';
    }
    
    public function showEditFormProducts ($product, $categories){
        
        require_once './templates/form.edit.products.phtml';
    }

    public function showProductDetail ($product){
        
        require_once './templates/product.detail.phtml';
    }

    public function showProductsByCategory ($products, $category){
        
        require_once './templates/categories.detail.phtml';
    }

    public function showError($error) {
        echo "<h1>$error</h1>";
    }

}


