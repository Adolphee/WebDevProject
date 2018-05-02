<?php

    class Category {

      private $category_id, $name, $description;


      function __construct(){

      }

      function getId(){
        return $this->category_id;
      }

      function getName(){
        return $this->name;
      }

      function getDescription(){
        return $this->description;
      }

      function setId($id){
        if(checkId($id)){
          $this->category_id = $id;
          return true;
        }
         return false;
      }

      function setName($name){
        if(checkString($name)){
          $this->name = $name;
          return true;
        }
        return false;
      }

      function setDescription($description){
        if(checkString($description)){
          $this->description = $description;
          return true;
        }
        return false;
      }

    }




?>
