<?php
  require_once('validation/validationMethods.php');
  class Comment
  {
    // Ik vond het een beetje vreemd dat een comment een titel heeft dus liet ik dat acherwege
    private $blog_id,
            $id,
            $user_id,
            $content,
            $timestamp,
            $likes;


    public function __construct(){
    }



    //Getters
    public function getBlogId(){
      return $this->blog_id;
    }
    public function getId(){
      return $this->id;
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
    public function getTimestamp(){
      return $this->timestamp;
    }

    //Setters
    public function setBlogId($id){
      if(checkId($id)){
        $this->blog_id = $id;
        return true;
      }
      return false;
    }
    public function setId($id){
      if(checkId($id)){
        $this->id = $id;
        return true;
      } return false;
    }
    public function setUserId($id){
      if(checkId($id)){
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

  }

 ?>
