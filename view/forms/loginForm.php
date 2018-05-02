<li class="subMenuItem">
  <form action="../model/validation/loginFormValidation.php" method="post" class="px-4 py-3">
    <div class="form-group">
      <input name="username" type="text" class="form-control" placeholder="Username">
    </div>
    <div class="form-group">
      <input name="password" type="password" class="form-control" placeholder="Password">
    </div>
    <div class="form-check">
      <small style="color = red;">
        <?php echo $GLOBALS["loginError"]; ?>
      </small>
    </div>
    <div class="button-group">
        <button type="submit" class="btn btn-success"><i class="fa fa-arrow-circle-right"></i></button>
        <!-- <a href="registration.php" class="btn btn-warning" title="Register today!!!"><i class="fa fa-undo"></i></a> -->
    </div>
    <div class="dropdown-divider"></div>
  </form>
</li>
