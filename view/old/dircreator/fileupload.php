<?php
function getRelativePath($from, $to){
    // some compatibility fixes for Windows paths
    $from = is_dir($from) ? rtrim($from, '\/') . '/' : $from;
    $to   = is_dir($to)   ? rtrim($to, '\/') . '/'   : $to;
    $from = str_replace('\\', '/', $from);
    $to   = str_replace('\\', '/', $to);

    $from     = explode('/', $from);
    $to       = explode('/', $to);
    $relPath  = $to;

    foreach($from as $depth => $dir) {
        // find first non-matching dir
        if($dir === $to[$depth]) {
            // ignore this directory
            array_shift($relPath);
        } else {
            // get number of remaining dirs to $from
            $remaining = count($from) - $depth;
            if($remaining > 1) {
                // add traversals up to first matching dir
                $padLength = (count($relPath) + $remaining - 1) * -1;
                $relPath = array_pad($relPath, $padLength, '..');
                break;
            } else {
                $relPath[0] = './' . $relPath[0];
            }
        }
    }
    return implode('/', $relPath);
}

//Bestandsnaam
echo $_POST["image"]["name"]."<br/>";
//Bestandstype/mime-type (vb: "image/jpeg") echo $_FILES["bestand"]["type"];
//Bestandsgrootte in bytes
echo $_POST["image"]["size"]."<br/>";
//Tijdelijke bestandsnaam op server echo $_FILES["bestand"]["tmp_name"];
//Eventuele fouten die bij uploaden zijn opgetreden
echo $_POST["image"]["error"]."<br/>";

// $imagepath = "dircreator2/";
//
// move_uploaded_file($_FILES["image"]["tmp_name"], $imagepath);
//
// $r = parse_url($imagepath);
// $imageUrl = $r["scheme"] . "://" . $r["host"] . "/" . $imageRelativeUrl;
//
// if(file_exists(realpath($imagepath))){
//   echo getRelativePath(getcwd(), realpath($imagepath));
// }
//
// echo "<img src=\"".getRelativePath(getcwd(), realpath($imagepath))."\"></img>";
?>
