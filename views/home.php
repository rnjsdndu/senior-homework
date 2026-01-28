<?php
$ss = ss();
$user = DB::fetch("select * from user where id = '$ss'") ?? 0;
$normal = DB::fetch("select * from user where role = '일반' and id = '$ss'");
$manager = DB::fetch("select * from user where role = '서점 관리자' and id = '$ss'");

if($normal):
?>
<a href="/check">서점 조회</a>
<a href="/rental">서점 책 대여</a>
<a href="/my">마이 프로필</a>
<?php elseif($manager):?>
<a href="/regiBook">책 등록</a>
<a href="/rentalUserCheckCalendar">책 대여유저 조회(캘린더)</a>
<a href="/rentalUserCheckGraph">책 대여 유저 조회(표)</a>
<?php endif;?>