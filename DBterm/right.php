<?php 
  $account = $_SESSION["id"];
  $myinfoq = "select index from evaluation where account_id = '$account'";
  $myinfo = pg_query($conn, $myinfoq);
  $num = pg_num_rows($myinfo);

 ?>
<div class="right">
      <div class="box">
        <div class="name_wrap">
          <?php echo $_SESSION["nick"] ?>
        </div>
        <div class="info_wrap" onclick="location.href='./myinfo.php?account_id=<?=$account?>'">
          내 강의평 : <strong><?=$num?></strong>개
        </div>
        <div class="logout_wrap">
          <button onclick="location.href='./logout.php'">로그아웃</button>
        </div>
      </div>
    </div>