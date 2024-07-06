<?php
function get_domain($url)
{
  $pieces = parse_url($url);
  $domain = isset($pieces['host']) ? $pieces['host'] : $pieces['path'];
  if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
    return $regs['domain'];
  }
  return false;
}


function geteync($plaintext,$dynctype){
  $enyctext="";
  if($dynctype=="md5"){
      $enyctext = md5($plaintext);
      $isExecuted=true;
  }elseif($dynctype=="sha1"){
      $enyctext = sha1($plaintext);
      $isExecuted=true;
  }elseif($dynctype=="sha256"){
      $enyctext = hash('sha256',$plaintext);
      $isExecuted=true;
  }elseif($dynctype=="sha512"){
      $enyctext = hash('sha512',$plaintext);
      $isExecuted=true;
  }elseif($dynctype=="bcrypt"){
      $enyctext = password_hash($plaintext, PASSWORD_BCRYPT);
      $isExecuted=true;
  }elseif($dynctype=="snefru256"){
      $enyctext = hash('snefru256',$plaintext);
      $isExecuted=true;
  }
  return $enyctext;

}
?>