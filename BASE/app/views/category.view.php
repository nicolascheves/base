<?php

class CategoryView {
    public function showCategories ($categories){
        $count = count($categories);
        
        require_once './templates/categories.phtml';
    }
    public function showAddCategoriesForm ($categories){
        $count = count($categories);
        require_once './templates/form.add.category.phtml';
    }

    public function showEditFormCategory ($category){
        
        require_once './templates/form.edit.categories.phtml';

    }
    public function showError($error) {
        echo "<h1>$error</h1>";
    }
}


