<?php 
  $user = DB::fetchAll("
    SELECT DISTINCT u.id, b.title, r.rent_at, r.return_date, r.status
    FROM rent r
    JOIN user u ON r.user_id = u.id
    join book b
    on r.book_idx = b.idx
  ")
?>



<table>
  <tr>
    <th>사용자</th>
    <th>대여 한 책</th>
    <th>대여 기간</th>
    <th>반납 여부</th>
    <th></th>
  </tr>
  <?php foreach($user as $u):?>
    <tr>
      <td><?=$u -> id?></td>
      <td><?=$u -> title?></td>
      <td><?=$u -> rent_at?> ~ <?=$u -> return_date?></td>
      <td><?=$u -> status?></td>
      <td>
        <form action="/userProfile" method="post">
          <input type="hidden" name="user_id" value="<?=$u -> id?>">
          <button>프로필 보기</button>
        </form>
      </td>
    </tr>
    <?php endforeach;?>
  </table>

