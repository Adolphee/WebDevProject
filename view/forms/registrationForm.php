
 <div class="jumbotron text-center" id="registrationJumbotron">
  <h1><?php
    if(isset($_SESSION["registrationJumbotron"]) && !empty($_SESSION["registrationJumbotron"])) echo $_SESSION["registrationJumbotron"]; else echo "Register today !!" ?> </h1>
<?php
    if($_SESSION["registrationJumbotron"] == null){ ?>  <h3>... or log in by using the sidebar to your left! :) </h3>

    <?php } else { ?> <a href="index.php" class="btn btn-primary">Register here!!<a> <?php } ?>
</div>

<?php if(!isset($_SESSION["registrationJumbotron"]) && empty($_SESSION["registrationJumbotron"])){ ?>

  <form id="registrationForm" action="
   <?php
      if($GLOBALS["isValidationPage"] == false){
          echo "../model/validation/registrationFormValidation.php";
      } else {
          echo "registrationFormValidation.php";
      } ?>" method="POST" class="form">

      <div class="form-row">
        <div id="firstnameError" class="col-md-3 text-center">
            <small style="color: red;"><?php
            echo $GLOBALS["firstnameError"]; ?></small>
        </div>
        <div class="form-group col-md-6">
          <label for="firstname">First name</label>
          <input name="firstname" type="text" class="form-control" placeholder="What is your first name..?" required>
        </div>
        <div class="col-md-3"></div>
      </div>
      <div class="form-row">
        <div id="lastnameError" class="col-md-3 text-center">
            <small style="color: red;"><?php
            echo $GLOBALS["lastnameError"]; ?></small>
        </div>
        <div class="form-group col-md-6">
          <label for="lastname">Last name</label>
          <input name="lastname" type="text" class="form-control" placeholder="What is your last name..?" required>
        </div>
        <div class="col-md-3"></div>
      </div>
    <div class="form-row">
      <div id="emailError" class="col-md-3 text-center">
         <small style="color: red;"><?php
             echo $GLOBALS["emailError"]; ?></small>
      </div>
      <div class="form-group col-md-6">
        <label for="email">Email</label>
        <input name="email" type="text" class="form-control" placeholder="Please provide an email address.." required>
      </div>
      <div class="col-md-3"></div>
    </div>
    <div class="form-row">
      <div id="usernameError" class="col-md-3 text-center">
          <small style="color: red;"><?php
          echo $GLOBALS["usernameError"]; ?></small>
      </div>
      <div class="form-group col-md-6">
        <label for="username">Username</label>
        <input name="username" type="text" class="form-control" placeholder="Choose a username..." required>
      </div>
      <div class="col-md-3"></div>
    </div>
    <div class="form-row">
      <div id="passwordError" class="col-md-3 text-center">
         <small style="color: red;"><?php
          echo $GLOBALS["passwordError"]; ?></small>
      </div>
      <div class="form-group col-md-6">
        <label for="password">Password</label>
        <input type="password" name="password" class="form-control" id="inputPassword4" placeholder="Password" required>
      </div>
      <div class="col-md-3"></div>
    </div>
    <div class="form-row">
      <div id="passwordConfirmationError" class="col-md-3 text-center">
         <small style="color: red;"><?php
          echo $GLOBALS["passwordConfirmationError"]; ?></small>
      </div>
      <div class="form-group col-md-6">
        <label for="password">Confirm password</label>
        <input type="password" name="passwordConfirm" class="form-control" placeholder="Please confirm..." required>
      </div>
      <div class="col-md-3"></div>
    </div>
    <div class="form-row">
      <div class="col-md-3"></div>
        <div class="col-md-6">
          <input type="submit" value="Sing In" class="btn btn-primary"></input>
        </div>
      <div class="col-md-3"></div>
    </div>
  </form>

<?php
} else {
  $_SESSION["registrationJumbotron"] = null;
} ?>
