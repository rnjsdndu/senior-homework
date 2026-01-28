<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="./asset/css/style.css">
</head>
<body>
  <header>
    <?php 
    $ss = ss();
    $normal = DB::fetch("select * from user where role = '일반' and id = '$ss'");
    $manager = DB::fetch("select * from user where role = '서점 관리자' and id = '$ss'");
    ?>
    <a href="/">홈</a>
    <?php if(ss()):?>
      <p><?=ss()?>님</p>
      <a href="/logout">로그아웃</a>
    <?php endif;?>

    <?php if(!ss()):?>
    <a href="/login">로그인</a>
    <a href="/join">회원가입</a>
    <?php endif;?>
  </header>