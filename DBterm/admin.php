<?php 
  /*로그인 상태 아니면 로그인 페이지로*/
  session_start();
  if(!isset($_SESSION["id"])){
    header('Location: ./');
  }
  include("./database.php");
  $conn = initDB();
  $deptq = "(select * from department)";
  $depts = pg_query($conn,$deptq);
  $courseq = "(select * from $deptq as T natural left join course)";
  $instq = "(select * from $deptq as S natural left join instructor)";
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>메인 페이지</title>
  <link rel="stylesheet" href="./css/common.css">
  <link rel="stylesheet" href="./css/main.css">
  <script src="./js/jquery-1.12.4.min.js"></script>
  <style>
    .edit input{
      width: 400px;
    }
    .edit button{
      width: 200px;
    }
    .edit select,option{
      font-size: 14pt;
    }
    .eidt .row{
      width: 100%;
    }
    table{
      border-collapse: collapse;
    }
    table th{
      text-align: center;
      padding-bottom: 10px;
      border-bottom: 1px solid #DDD;
    }
    .section select, option, input{
      font-size: 10pt; 
    }
    .section input{
      height: 25px;
    }
    .section .btn_wrap{
      text-align: right;
      margin-bottom: 15px;
    }
  </style>
</head>
<body>
  <?php include("./header.php") ?>
  <div id="content">
    <div class="left">
      <div class="box notice">
        <h2>관리자 페이지</h2>
        <div class="edit dept">
          <h3>학과 추가</h3>
          <div class="row">
            <label for="dept">
              <input type="text" id="dept_input" name="dept_input" placeholder="학과 이름을 입력하세요">
              <button id="dept_btn">등록</button>
            </label>
          </div>
        </div>
        <div class="edit inst">
          <h3>교수 추가</h3>
          <div class="row">
            <table>
              <tr>
                <th>학과</th> 
                <th>교수명</th>
                <th></th>
              </tr>
              <tr>
                <td>
                  <select name="dept" id="dept">
                    <?php 
                      $depts = pg_query($conn,$deptq);
                      while($data = pg_fetch_assoc($depts)){
                     ?>
                    <option value="<?=$data["dept_name"]?>"><?=$data["dept_name"]?></option>
                   <?php } ?>
                  </select>
                </td>
                <td>
                 <input type="text" id="inst_input" name="inst_input" placeholder="교수명" style="width:250px;">
                </td>
                <td>
                  <button id="inst_btn">등록</button>
                </td>
              </tr>
            </table>
          </div>
        </div>
        <div class="edit course">
          <h3>강의 추가</h3>
          <div class="row">
            <table>
              <tr>
                <th>학과</th> 
                <th>과목 코드</th>
                <th>강의명</th>
                <th>학점</th>
                <th></th>
              </tr>
              <tr>
                <td>
                  <select name="dept" id="dept">
                    <?php 
                      $depts = pg_query($conn,$deptq);
                      while($data = pg_fetch_assoc($depts)){
                     ?>
                    <option value="<?=$data["dept_name"]?>"><?=$data["dept_name"]?></option>
                   <?php } ?>
                  </select>
                </td>
                <td>
                  <input type="text" id="course_id" name="course_id" placeholder="과목코드" style="width:150px;">
                </td>
                <td>
                  <input type="text" id="course_name" name="course_name" placeholder="강의명" style="width:150px;">
                </td>
                <td>
                  <select name="credit" id="credit">
                    <option value="1">1학점</option>
                    <option value="2">2학점</option>
                    <option value="3">3학점</option>
                  </select>
                </td>
                <td>
                  <button id="course_btn">등록</button>
                </td>
              </tr>
            </table>
          </div>
        </div>
        <div class="edit section">
          <h3>수업 추가</h3>
          <div class="row">
            <table>
              <tr>
                <th>학과</th> 
                <th>과목</th>
                <th>교수명</th>
                <th>분반코드</th>
                <th>년도</th>
                <th>학기</th>
              </tr>
              <tr>
                <td>
                  <select name="dept" id="dept"> 
                    <option value="">선택하세요</option>
                    <?php 
                      $depts = pg_query($conn,$deptq);
                      while($data = pg_fetch_assoc($depts)){
                     ?>
                    <option value="<?=$data["dept_name"]?>"><?=$data["dept_name"]?></option>
                   <?php } ?>
                  </select>
                </td>
                <td>
                  <select name="course" id="course">
                  </select>
                </td>
                <td>
                  <select name="inst" id="inst">
                  </select>
                </td>
                <td>
                  <input type="text" id="course_name" name="course_name" placeholder="분반 코드" style="width:130px;">
                </td>
                <td>
                  <input type="text" id="year" name="year" placeholder="년도" style="width:100px;">
                </td>
                <td>
                  <select name="semester" id="semester">
                    <option value="1">1학기</option>
                    <option value="2">2학기</option>
                  </select>
                </td>
              </tr>
            </table>
            <div class="btn_wrap">
              <button id="section_btn">등록</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include("./right.php") ?>
  </div>
  <div id="footer">
    <div class="inner">
      <div class="copyright">2016 DB <strong>Term Project</strong></div>
    </div>
  </div>
  <script>
    var dept_btn = $("#dept_btn");
    var inst_btn = $("#inst_btn");
    var course_btn = $("#course_btn");
    var section_btn = $("#section_btn");
    var dept = $(".section select").eq(0);

    dept_btn.on("click", insertDept);
    inst_btn.on("click", insertInst);
    course_btn.on("click", insertCourse);
    section_btn.on("click", insertSection);
    dept.on("change", changeDept);

    function insertDept(){
      var dept = $("#dept_input");
      if(!submitCheck(dept.val())){
        alert("입력 양식이 맞지 않습니다!");
      }
      else{
        var form = {
          mode : "dept",
          dept_name : dept.val()
        }
        /*AJAX requeset*/
        $.ajax({
          type : 'POST',
          url : './ajax/admin_ajax.php',
          datatype : 'json',
          data: form,
          /*response*/
          success:function(data){
            if(data === "success"){
              alert("데이터 등록 성공");
              location.href = "./admin.php";
            }
            else{
              alert(data);
            }
          }
        });
      }
    }

    function insertInst(){
      var dept = $(".inst select").val();
      var inst_name = $("#inst_input").val();
      console.log(dept, inst_name);
      if(!submitCheck(inst_name)){
        alert("입력 양식이 맞지 않습니다!");
      }
      else{
        var form = {
          mode : "inst",
          dept_name : dept,
          instructor_name : inst_name
        }
        /*AJAX requeset*/
        $.ajax({
          type : 'POST',
          url : './ajax/admin_ajax.php',
          datatype : 'json',
          data: form,
          /*response*/
          success:function(data){
            if(data === "success"){
              alert("데이터 등록 성공");
              location.href = "./admin.php";
            }
            else{
              alert(data);
            }
          }
        });
      }
    }

    function insertCourse(){
      var dept = $(".course select").eq(0).val();
      var course_id = $("#course_id").val();
      var course_name = $("#course_name").val();
      var credit = $(".course select").eq(1).val();
      console.log(dept, course_id, course_name, credit);
      if(!(submitCheck(course_id)&&submitCheck(course_name))){
        alert("입력 양식이 맞지 않습니다!");
      }
      else{
        var form = {
          mode : "course",
          dept_name : dept,
          course_id : course_id,
          course_name : course_name,
          credit : credit
        }
        /*AJAX requeset*/
        $.ajax({
          type : 'POST',
          url : './ajax/admin_ajax.php',
          datatype : 'json',
          data: form,
          /*response*/
          success:function(data){
            if(data === "success"){
              alert("데이터 등록 성공");
              location.href = "./admin.php";
            }
            else{
              alert(data);
            }
          }
        });
      }
    }

    function insertSection(){
      var dept = $(".section select").eq(0).val();
      var course_id = $(".section select").eq(1).val();
      var instructor_id = $(".section select").eq(2).val();
      var section_id = $(".section input").eq(0).val();
      var year = $(".section input").eq(1).val();
      var semester = $(".section select").eq(3).val();
      console.log(dept, course_id, instructor_id, section_id, year, semester);
      if(!(submitCheck(section_id)&&submitCheck(course_name))){
        alert("입력 양식이 맞지 않습니다!");
      }
      else{
        var form = {
          mode : "section",
          course_id : course_id,
          instructor_id : instructor_id,
          section_id : section_id,
          year : year,
          semester : semester
        }
        /*AJAX requeset*/
        $.ajax({
          type : 'POST',
          url : './ajax/admin_ajax.php',
          datatype : 'json',
          data: form,
          /*response*/
          success:function(data){
            if(data === "success"){
              alert("데이터 등록 성공");
              location.href = "./admin.php";
            }
            else{
              alert(data);
            }
          }
        });
      }
    }
    function changeDept(){
      var value = dept.val();
      console.log(value);

      var form = {
        dept_name : value
      }

      $.ajax({
          type : 'POST',
          url : './ajax/select_ajax.php',
          datatype : 'json',
          data: form,
          /*response*/
          success:function(data){
            $(".section select").eq(1).html(data);
          }
      });

      $.ajax({
          type : 'POST',
          url : './ajax/select_ajax2.php',
          datatype : 'json',
          data: form,
          /*response*/
          success:function(data){
            $(".section select").eq(2).html(data);
          }
      });
    }
    /*input checker*/
    function submitCheck(str){
      if(str === "")
        return false;
      else
        return true;
    }

  </script>
</body>
</html>