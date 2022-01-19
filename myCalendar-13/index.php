<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri().'/css/main.css'; ?>">
  <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri().'/css/current-day.css'; ?>">
  <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri().'/css/calendar.css'; ?>">
  <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri().'/css/modal.css'; ?>">
  <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri().'/css/portrait.css'; ?>">
  <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri().'/css/calendar-border.css' ?>">
  <link rel="icon" href="images/icon1.png" type="<?php echo get_stylesheet_directory_uri().'/image/png'; ?>" sizes="72x72">
  <script src="https://kit.fontawesome.com/e45ac9a14a.js" crossorigin="anonymous"></script>
  <title>My Calendar</title>

  <style>

  </style>

</head>
<body>
<?php
function db_insertNote($uid, $color, $text){ //新增記事資料函式
  global $connection;
  $text = mysqli_real_escape_string($connection, $text);
  $query = "INSERT INTO notes(note_id, note_color, note_text) VALUES('$uid', '$color', '$text')";
  $result = mysqli_query($connection, $query);
  if(!$result){
      die("Something went wrong...");
  }
}  

if(isset($_POST['new_note_uid'])){ //前端傳來新增記事資料
  db_insertNote($_POST['new_note_uid'], $_POST['new_note_color'], $_POST['new_note_text']);
}
// function db_insertNote($uid, $color, $text){ //新增記事資料函式
//   global $wpdb;  //宣告WordPress的全域資料庫物件    
//   $text = $wpdb->_real_escape($text);

//   $wpdb->insert($wpdb->prefix.`u1085123_wp_dev`, array(
//     "note_id" => $uid, 
//     "note_color" => $color,
//     "note_text" => $text
//   ),array(
//     "%s",
//     "%s",
//     "%s"
//   ));
//   $query = "INSERT INTO notes(note_id, note_color, note_text) VALUES('$uid', '$color', '$text')";
//    $result = mysqli_query($connection, $query);
// }  

// if(isset($_POST['new_note_uid'])){ //前端傳來新增記事資料
//   db_insertNote($_POST['new_note_uid'], $_POST['new_note_color'], $_POST['new_note_text']);
// }

    $connection = mysqli_connect("localhost", "u1085123", "mutemute1085123", "u1085123_wp_dev"); //連線資料庫
    if(!$connection){ //如果連線失敗
        die("There was an error connecting to the database."); //網頁宣告到此die，並在網頁輸出…
    }
    function db_updateTheme($newTheme){
        global $connection;
        $query = "UPDATE `u1085123_wp_dev`.`theme` SET cur_theme = '$newTheme' WHERE id = 1"; //更新theme資料表格中，id欄位值為1的資料列中的cur_theme欄位值為$newTheme
        $result = mysqli_query($connection, $query); //送出SQL查詢
        if(!$result){ //查詢失敗的話…
            die("Query failed: " . mysqli_error($connection));
          }
        }
        function setTheme(){
          global $connection;
          $query = "SELECT * FROM `u1085123_wp_dev`.`theme`";
          $result = mysqli_query($connection, $query);
          if(!$result){
              die("Something went wrong...`");
          }
      
          while($row = mysqli_fetch_assoc($result)){
              return $row['cur_theme'];
          }
      }
    if(isset($_POST['color'])){ //透過關聯陣列$_POST['color']取得傳送過來的color資料
      db_updateTheme($_POST['color']); //呼叫db_updateTheme方法
    }
?>

  <h3 id="back-year" class="background-text off-color">2020</h3>
  <h4 class="background-text off-color">Calendar</h4>

  <!-- 左欄 今日資訊  -->
  <div id="current-day-info" class="color">
    <h1 id="app-name-landscape" class="off-color center default-cursor">102 Calendar</h1>
    <div>
      <h2 id="cur-year" class="center default-cursor current-day-heading">2020</h2>
    </div>
    <div class="">
      <h1 id="cur-day" class="center default-cursor current-day-heading">Wednesday</h1>
      <h1 id="cur-month" class="center default-cursor current-day-heading">November</h1>
      <h1 id="cur-date" class="center default-cursor current-day-heading">13<sup>th</sup></h1>
    </div>
    <div class="">
      <button id="theme-landscape" type="button" name="button" class="font button" onclick="openFavColor();">Change Theme</button>
    </div>
  </div>  

  <!-- 右欄 月曆表格 -->
  <div id="calendar">
    <h1 id="app-name-portrait" class="center off-color">My Calendar</h1>
    <table>
      <thead class="color">
        <tr>
          <th colspan="7" class="border-color">
            <h4 id="cal-year">2020</h4>
            <div>
              <i class="fas fa-caret-left icon" onclick="previousMonth();"></i>
              <h3 id="cal-month">December</h3>
              <i class="fas fa-caret-right icon" onclick="nextMonth();"></i>
            </div>
          </th>
        </tr>
        <tr>
          <th class="weekday border-color">Sun</th>
          <th class="weekday border-color">Mon</th>
          <th class="weekday border-color">Tue</th>
          <th class="weekday border-color">Wed</th>
          <th class="weekday border-color">Thu</th>
          <th class="weekday border-color">Fri</th>
          <th class="weekday border-color">Sat</th>
        </tr>
      </thead>
      <tbody id="table-body" class="border-color">
        <tr>
          <td onclick="dayClicked(this);">1</td>
          <td onclick="dayClicked(this);">1</td>
          <td onclick="dayClicked(this);">1</td>
          <td onclick="dayClicked(this);">1</td>
          <td onclick="dayClicked(this);">1</td>
          <td onclick="dayClicked(this);">1</td>
          <td onclick="dayClicked(this);">1</td>
        </tr>
        <tr>
          <td onclick="dayClicked(this);">1</td>
          <td onclick="dayClicked(this);">1</td>
          <td onclick="dayClicked(this);">1</td>
          <td id="current-day" onclick="dayClicked(this);">1</td>
          <td onclick="dayClicked(this);">1</td>
          <td onclick="dayClicked(this);">1</td>
          <td onclick="dayClicked(this);">1</td>
        </tr>
        <tr>
          <td onclick="dayClicked(this);">1</td>
          <td onclick="dayClicked(this);">1</td>
          <td onclick="dayClicked(this);">1</td>
          <td class="tooltip" onclick="dayClicked(this);">1 <img src="<?php echo get_stylesheet_directory_uri().'/images/note2.png'; ?>" alt="記事"><span>這是提示！！！</span></td>
          <td onclick="dayClicked(this);">1</td>
          <td onclick="dayClicked(this);">1</td>
          <td onclick="dayClicked(this);">1</td>
        </tr>
        <tr>
          <td onclick="dayClicked(this);">1</td>
          <td onclick="dayClicked(this);">1</td>
          <td onclick="dayClicked(this);">1</td>
          <td onclick="dayClicked(this);">1</td>
          <td onclick="dayClicked(this);">1</td>
          <td onclick="dayClicked(this);">1</td>
          <td onclick="dayClicked(this);">1</td>
        </tr>
        <tr>
          <td onclick="dayClicked(this);">1</td>
          <td onclick="dayClicked(this);">1</td>
          <td onclick="dayClicked(this);">1</td>
          <td onclick="dayClicked(this);">1</td>
          <td onclick="dayClicked(this);">1</td>
          <td onclick="dayClicked(this);">1</td>
          <td onclick="dayClicked(this);">1</td>
        </tr>
        <tr>
          <td onclick="dayClicked(this);">1</td>
          <td onclick="dayClicked(this);">1</td>
          <td onclick="dayClicked(this);">1</td>
          <td onclick="dayClicked(this);">1</td>
          <td onclick="dayClicked(this);">1</td>
          <td onclick="dayClicked(this);">1</td>
          <td onclick="dayClicked(this);">1</td>
        </tr>
      </tbody>
    </table>
    <button id="theme-portrait" type="button" name="button" class="font button color" onclick="openFavColor();">Change Theme</button>
  </div>

  <!-- 對話方塊 -->
  <dialog id="modal">
    <!-- 色彩對話方塊 -->
    <div id="fav-color" hidden>
      <div class="popup">
        <h4 class="center">What's your favorite color?</h4>
        <div id="color-options">
          <div class="color-option">
            <div class="color-preview" id="blue" style="background-color: #1B19CD;" onclick="addCheckMark('blue');"><i class="fas fa-check checkmark"></i></div>
            <h5>Blue</h5>
          </div>
          <div class="color-option">
            <div class="color-preview" id="red" style="background-color: #D01212;" onclick="addCheckMark('red');"></div>
            <h5>Red</h5>
          </div>
          <div class="color-option">
            <div class="color-preview" id="purple" style="background-color: #721D89;" onclick="addCheckMark('purple');"></div>
            <h5>Purple</h5>
          </div>
          <div class="color-option">
            <div class="color-preview" id="green" style="background-color: #158348;" onclick="addCheckMark('green');"></div>
            <h5>Green</h5>
          </div>
          <div class="color-option">
            <div class="color-preview" id="orange" style="background-color: #EE742D;" onclick="addCheckMark('orange');"></div>
            <h5>Orange</h5>
          </div>
          <div class="color-option">
            <div class="color-preview" id="deep-orange" style="background-color: #F13C26;" onclick="addCheckMark('deep-orange');"></div>
            <h5>Deep Orange</h5>
          </div>
          <div class="color-option">
            <div class="color-preview" id="baby-blue" style="background-color: #31B2FC;" onclick="addCheckMark('baby-blue');"></div>
            <h5>Baby Blue</h5>
          </div>
          <div class="color-option">
            <div class="color-preview" id="cerise" style="background-color: #EA3D69;" onclick="addCheckMark('cerise');"></div>
            <h5>Cerise</h5>
          </div>
          <div class="color-option">
            <div class="color-preview" id="lime" style="background-color: #36C945;" onclick="addCheckMark('lime');"></div>
            <h5>Lime</h5>
          </div>
          <div class="color-option">
            <div class="color-preview" id="teal" style="background-color: #2FCCB9;" onclick="addCheckMark('teal');"></div>
            <h5>Teal</h5>
          </div>
          <div class="color-option">
            <div class="color-preview" id="pink" style="background-color: #F50D7A;" onclick="addCheckMark('pink');"></div>
            <h5>Pink</h5>
          </div>
          <div class="color-option">
            <div class="color-preview" id="black" style="background-color: #212524;" onclick="addCheckMark('black');"></div>
            <h5>Black</h5>
          </div>
        </div>
        <button id="update-theme-button" class="button font" onclick="changeColor();">Update</button>
      </div>
    </div>    

    <!-- 記事對話方塊 -->
    <div id="make-note" hidden>
      <div class="popup">
        <h4>Add a note to the calendar</h4>
        <textarea id="edit-post-it" class="font" name="post-it" autofocus></textarea>
        <div>
          <button class="button font post-it-button" id="add-post-it" onclick="submitPostIt();">Post It</button>
          <button class="button font post-it-button" id="delete-button" onclick="deleteNote();">Delete It</button>
        </div>
    </div>  
  </dialog>

  <script src="<?php echo get_stylesheet_directory_uri().'/js/updateDate.js'; ?>"></script>  
  <script src="<?php echo get_stylesheet_directory_uri().'/js/changeTheme.js'; ?>"></script>
  <script src="<?php echo get_stylesheet_directory_uri().'/js/postIts.js'; ?>"></script>
  <script src="<?php echo get_stylesheet_directory_uri().'/js/ajax.js'; ?>"></script>

  <script>  
    currentColor.name = <?php echo(json_encode(setTheme())); ?> ; //js_encode將回傳的資料包裝成字串，然後指定給currentColor.name
   function ajax(object){
        var request = new XMLHttpRequest();
        request.open("POST", "index.php");
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.send(objectToString(object));
    }
    function objectToString(object){
        let str = "";
        Object.keys(object).forEach(function(key){
            str += key;
            str += `=${object[key]}&`; //``模板字符串 
        });
        console.log(str);
        return str;
    }
    var styleSheetDirectory = "<?php echo get_stylesheet_directory_uri(); ?>";
    <?php 
    global $current_user; wp_get_current_user(); 
    if ( is_user_logged_in() ) { //如果WordPress使用者有登入的話
      echo "var currentUserName = ".'"'.$current_user->display_name.'";'; 
    } 
  ?>
  
  if (typeof currentUserName !== 'undefined') {//若currentUserName不是未定義的話…
    document.getElementById("app-name-landscape").innerHTML = currentUserName;
    document.getElementById("app-name-portrait").innerHTML = currentUserName;
  }
    let today = new Date();  //新增一個Date物件，命名為today
    let thisYear = today.getFullYear();
    let thisMonth = today.getMonth();      
    let thisDate = today.getDate();
    updateDates();
    fillInMonth(thisYear, thisMonth, thisDate);    

  </script>
</body>
</html>