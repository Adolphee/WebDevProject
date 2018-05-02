
<h1><? echo $GLOBALS["imageError"] ?></h1>
<img src="<? echo $userFolder."/".$_FILES['image']['tmp_name']; ?>">
<form action="newBlogValidation.php" method="post">
  <div class="form-group col-md-5" id="image_dropzone" dropzone="copy">
    <div id="image-dropzone-background"></div>
    <label for="image">Optionally drag and drop an image to this area or ...</label><br/>
      <input type="file" name="image">
      <small id="imageError" class="form-text text-muted" style="color: red;"><?php echo $GLOBALS["imageError"]; ?></small>
  </div>
  <input type="submit">
</form>
