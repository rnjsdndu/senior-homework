<?php 
function ss() {
  return $_SESSION['ss'] ?? false;
}

function move($uri, $msg = null){
  if($msg) echo "<script>alert('$msg')</script>";
  echo "<script>location.href='$uri'</script>";
}

function view($page){
  require_once "../views/template/header.php";
  require_once "../views/$page.php";
  require_once "../views/template/footer.php";
}

