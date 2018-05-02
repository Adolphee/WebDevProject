<?php

  function checkId($id){
    return (is_integer($id) && $id > 0);
  }

  function checkString($string){
    return (isset($string) && !empty($string) && $string != "" && !is_numeric($string[0]));
  }

 //StackOverflow methode + beetje zelf mee rondgespeeld --> obsolete
  function vali_Date($date){
    $date_to_check  = explode('/', $date);
    $date_to_check  = explode('-', $date);
    if (count($date_to_check) == 3) {
      // if($date_to_check[0] < 1 || $date_to_check[0] > 31) return false;
      // if($date_to_check[1] < 1 || $date_to_check[1] > 12) return false;
      // $now = new DateTime();
      // if($date_to_check[2] < 1900 || $date_to_check[2] > $now->format("Y")) return false;
    }
    return false;
  }

  function checkEmail($email) {
      if(filter_var($email, FILTER_VALIDATE_EMAIL) == $email){
          return true;
      }
      return false;
   };

   function checkFile($file){

   }


   // DISCLAIMER !!!
   /*
    Het enige probleem dat ik had bij de file upload is dat ik de imagepath
    in de database opsla als absolute pad. Maar die pad werkte niet
    in de HTML <img> element. Dus ik moest een manier vinden om
    absolute pad altijd terug om te zetten naar een relatieve pad wanneer
    ik het uit de database haalde. Zelf kon ik niets vinden dus ben ik beginnen googlen.
    op StackOverflow was er een vriendelijke man bereid om een methode met me te delen
    die dit probleem voor mij zou oplossen.
  */
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


 ?>
