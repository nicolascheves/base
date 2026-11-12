
<?php
class HomeView{
    
     public function showHome($products, $categories) {
        $count = count($products); 
        require_once './templates/home.phtml';
    }
    public function showProductDetail ($product){
        
        require_once './templates/product.detail.phtml';
    }
    public function showProductsByCategoryDetail ($products, $categories){
        
        require_once './templates/categories.detail.phtml';
    }
    public function showError($error) {
    
        echo "<h1>Error: $error</h1>";
    }
}