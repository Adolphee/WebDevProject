<?php
  require_once("validation/validationMethods.php");
  //require_once("database/BlogDAO.php");
  class Blog
  {
      private $shortVersion,
              $title="",
              $category = 6, //default category = "other"
              $imagepath = "../model/validation/uploads/1524254425.jpg",
              $id,
              $user_id,
              $category_id,
              $content,
              $timestamp,
              $comments,
              $likes = 0, //blog heeft initieel geen likes
              $is_enabled = 1; //blog is initieel actief (niet verwijderd)

      public function __construct(){
      }

        //Getters
        public function getId(){
          return (integer)$this->id;
        }
        public function getUserId(){
          return $this->user_id;
        }
        public function getContent(){
          return $this->content;
        }
        public function getLikes(){
          return $this->likes;
        }
        public function getNumberOfComments(){
          return $this->comments;
        }
        public function getTimestamp(){
          return $this->timestamp;
        }
        public function getShortVersion(){
          return $this->shortVersion;
        }
        public function getTitle(){
          return $this->title;
        }
        public function getCategory(){
          return $this->category;
        }
        public function getImagePath(){
          return $this->imagepath;
        }
        public function getCategoryId(){
            return $this->category_id;
        }
        public function is_enabled(){
          return $this->is_enabled;
        }

        //Setters
        public function setId($id){
          if(checkId($id)){
            $this->id = $id;
            return true;
          } return false;
        }
        public function setUserId($id){
          if(is_numeric($id)){
            $this->user_id=$id;
            return true;
          }
           return true;
        }
        public function setContent($text){
          if(checkString($text)){
            $this->content = $text;
            return true;
          }
          return false;
        }
        public function setTimestamp($time){
          if(date_timestamp_get($time)){
            $this->timestamp = date_timestamp_get($time);
            return true;
          }
          return false;
        }
        public function setLikes($likes){
          if(is_integer($likes) && $likes > 0){
            $this->likes = $likes;
            return true;
          }
          return false;
        }
        public function setNumberOfComments($likes){
          if(is_integer($likes) && $likes > 0){
            $this->likes = $likes;
            return true;
          }
          return false;
        }
        public function setShortVersion($short){
            $this->shortVersion = $short;
        }
        public function setTitle($title){
          if(checkString($title)){
            $this->title = $title;
            return true;
          }
          return false;
        }
        public function setCategory($cat){
          if(checkString($cat)){
            $this->category = $cat;
            return true;
          }
          return false;
        }
        public function setImagePath($image){
          if(checkString($image)){
            $this->imagepath = $image;
            return true;
          }
          return false;
        }

        public function setEnabled($janee){
          if($janee == 1 || $janee == 0){
            $this->is_enabled = $janee;
            return true;
          }
          return false;
        }


  }


?>
