<?php

$valid_file = true;
//if they DID upload a file...
if($_FILES['photo']['name'])
{
	//if no errors...
	if(!$_FILES['photo']['error'])
	{
		//now is the time to modify the future file name and validate the file
		$new_file_name = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_FILENAME).time().".".pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION)); //rename file
		if($_FILES['photo']['size'] > (1024000)) //can't be larger than 1 MB
		{
			$valid_file = false;
			$message = 'Oops!  Your file\'s size is to large.';
		}

		//if the file has passed the test
		if($valid_file)
		{
      //nu gaan we de image verplaatsen naar de file server
			if(move_uploaded_file($_FILES['photo']['tmp_name'], "dircreator2/".$new_file_name)){
        // als dat gelukt is gaan we de path onthouden naar de image
        $imagepath = "dircreator2/".$new_file_name;
        var_dump($new_file_name);
        var_dump($imagepath);
        ?> <img src="<? echo $imagepath; ?>"> <?
      }
		}
	}
	//if there is an error...
	else
	{
		//set that to be the returned message
		$message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['photo']['error'];
	}
} else{
  echo "...";
}

//you get the following information for each file:
// $_FILES['field_name']['name']
// $_FILES['field_name']['size']
// $_FILES['field_name']['type']
// $_FILES['field_name']['tmp_name']
echo $message;
?>
<img src="<?php echo $imagepath ?> ">
