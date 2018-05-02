<?php
    require_once('validation/validationMethods.php');
  class User
  {
    private $user_id    ="null",
            $username   ,
            $firstname   ,
            $lastname   ,
            $email      ,
            $password   ,
            $birthdate  ="null",
            $is_enabled = 1,
            $is_admin   = 0;

    //Fetch_Object() werkt niet naar behoren als ik de constructor parameters geef.
    public function __construct(){
    }


    //Getters
    public function getId(){
      return $this->user_id;
    }
    public function getUsername(){
      return $this->username;
    }
    public function getFirstname(){
      return $this->firstname;
    }
    public function getLastname(){
      return $this->lastname;
    }
    public function getEmail(){
      return $this->email;
    }
    public function getPassword(){
      return $this->password;
    }
    // public function getBirthdate(){
    //   return $this->birthdate;
    // }
    public function isEnabled(){
      return $this->is_enabled;
    }
    public function isAdmin(){
      return $this->is_admin;
    }

    //Setters
    public function setId($id){
     if(checkId($id)){
        $this->user_id = $id;
       return true;
     } else $this->user_id = "null";
     return false;
    }
    public function setUsername($username){
     if(checkString($username)){
        $this->username = $username;
       return true;
     }
     return false;
    }
    public function setFirstname($firstname){
     if(checkString($firstname)){
        $this->firstname = $firstname;
       return true;
     }
     return false;
    }
    public function setLastname($lastname){
     if(checkString($lastname)){
        $this->lastname = $lastname;
       return true;
     }
     return false;
    }
    public function setEmail($email){
     if(checkEmail($email)){
        $this->email = $email;
       return true;
     }
     return false;
    }
    public function setPassword($password){
     if(checkString($password)){
        $this->password = $password;
       return true;
     }
     return false;
    }
    // public function setBirthdate($birthdate){
    //     $this->birthdate = $birthdate;
    // }
    public function setEnabled($activation){
      if(is_bool($activation)){
        $this->is_enabled = $activation;
        return true;
      }
      return false;
    }
    public function setAdmin($promotion){
      if($promotion === 1 || $promotion === 0){
        $this->is_admin = $promotion;
        return true;
      }
      return false;
    }

    public function toString(){
      $serializedObject = "Object(User){ user id: ".$this->getId().",
      first name: ".$this->getFirstname().",
      last name: ".$this->getLastname().",
      username: ".$this->getUsername().",
      email: ".$this->getEmail()." }";
      return $serializedObject;

    }

  }
?>
