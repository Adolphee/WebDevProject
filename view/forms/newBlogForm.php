<?php
  session_start();
 ?>

    <form action="<?php
      if($GLOBALS["isValidationPage"] == true){
        echo "newBlogFormValidation.php";
      } else {
        echo "../model/validation/newBlogFormValidation.php";
      }
     ?>" method="POST" enctype="multipart/form-data">
  <div class="echte-form">
   <div class="jumbotron">
      <h1 class="text-center"> Create Blog </h1>
   </div>
   <div class="form-row">
     <div class="form-group col-md-7">
       <label for="bTitle">Title</label>
       <input type="text" name="bTitle" class="form-control" id="bTitle" placeholder="Enter title">
       <small id="titleError" class="errorMessage" style="color: red;"><?php echo $_SESSION["titleError"]; ?></small>
     </div>
     <div class="form-group col-md-5">
       <label for="bCategory">Category</label>
       <select name="bCategory" class="form-control" id="bCategory">
         <option value="" disabled selected>
             Choose a category...
         </option>
         <?php
           $categories = getAllBlogCategories();
           for($i = 0; $i < count($categories); $i++) { ?>

             <option value="<? echo $categories[$i]->getId(); ?>" title="<? echo $categories[$i]->getDescription(); ?>">
                 <?php echo $categories[$i]->getName(); ?>
             </option>
           <? } ?>
       </select>
       <small id="categoryError" class="errorMessage" style="color: red;"><?php echo $_SESSION["categoryError"]; ?></small>
     </div>
   </div>
   <div class="form-row">
     <div class="form-group col-md-7">
       <label for="shortVersion">Summary</label>
         <textarea name="shortVersion" class="form-control" id="shortVersion" placeholder="Provide a short summary for to spark their interest!" maxlength="100" max="100" cols="100" rows="3"></textarea>
         <small id="shortVersionError" class="errorMessage" style="color: red;"><?php echo $_SESSION["shortVersionError"]; ?></small>
     </div>
     <div class="form-group col-md-5" id="image_dropzone" dropzone="copy">
       <div id="image-dropzone-background"></div>
       <label for="image">Optionally drag and drop an image to this area or ...</label><br/>
         <input type="file" name="image" size="25" />
         <small id="imageError" class="errorMessage" style="color: red;"><?php echo $_SESSION["imageError"]; ?></small>
     </div>
   </div>
   <div class="form-row">
    <div class="form-group">
      <label for="bContent">Content</label>
      <small id="contentError" class="form-text" style="color: red;"><?php echo $_SESSION["contentError"]; ?></small>
        <textarea name="bContent" class="form-control" id="bContent" placeholder="Now spill the tea!! Tell them all about it :-)" cols="100" rows="10"></textarea>
    </div>
    </div
    <div class="form-row">
      <div class="form-group">
         <input type="hidden" name="user_id">
         <input type="hidden" name="likes" value="0">
     </div>
    </div>
    <input type="submit" class="btn btn-primary">

  </div>
</form>
