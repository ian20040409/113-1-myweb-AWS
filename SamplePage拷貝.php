<?php include "../inc/dbinfo.inc"; ?>
<html>
<body>
<h1>Sample page</h1>
<?php
  /* 连接到MySQL并选择数据库。 */
  $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

  if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

  $database = mysqli_select_db($connection, DB_DATABASE);

  /* 确保EMPLOYEES表存在。 */
  VerifyEmployeesTable($connection, DB_DATABASE);

  /* 处理删除操作 */
  if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    DeleteEmployee($connection, $id);
  }

  /* 处理编辑操作 */
  $employee_id = '';
  $employee_name = '';
  $employee_address = '';
  $action = 'add';

  if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
    $employee_id = intval($_GET['id']);
    $employee = GetEmployee($connection, $employee_id);
    if ($employee) {
      $employee_name = $employee['NAME'];
      $employee_address = $employee['ADDRESS'];
      $action = 'update';
    }
  }

  /* 处理表单提交 */
  if (isset($_POST['action'])) {
    $action_post = $_POST['action'];
    $employee_name_post = htmlentities($_POST['NAME']);
    $employee_address_post = htmlentities($_POST['ADDRESS']);
    if ($action_post == 'add') {
      if (strlen($employee_name_post) || strlen($employee_address_post)) {
        AddEmployee($connection, $employee_name_post, $employee_address_post);
      }
    } elseif ($action_post == 'update' && isset($_POST['id'])) {
      $id_post = intval($_POST['id']);
      UpdateEmployee($connection, $id_post, $employee_name_post, $employee_address_post);
    }
  }
?>
<!-- 输入表单 -->
<form action="<?PHP echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
  <input type="hidden" name="action" value="<?php echo $action; ?>" />
  <?php if ($action == 'update') { ?>
      <input type="hidden" name="id" value="<?php echo $employee_id; ?>" />
  <?php } ?>
  <table border="0">
    <tr>
      <td>NAME</td>
      <td>ADDRESS</td>
    </tr>
    <tr>
      <td>
        <input type="text" name="NAME" maxlength="45" size="30" value="<?php echo $employee_name; ?>" />
      </td>
      <td>
        <input type="text" name="ADDRESS" maxlength="90" size="60" value="<?php echo $employee_address; ?>" />
      </td>
      <td>
        <input type="submit" value="<?php echo ($action == 'update') ? 'Update Data' : 'Add Data'; ?>" />
      </td>
    </tr>
  </table>
</form>

<!-- 搜索表单 -->
<form action="<?PHP echo $_SERVER['SCRIPT_NAME'] ?>" method="GET">
  <table border="0">
    <tr>
      <td>Search by Name:</td>
      <td><input type="text" name="search_name" maxlength="45" size="30" value="<?php if (isset($_GET['search_name'])) echo htmlentities($_GET['search_name']); ?>" /></td>
    </tr>
    <tr>
      <td>Search by Address:</td>
      <td><input type="text" name="search_address" maxlength="90" size="60" value="<?php if (isset($_GET['search_address'])) echo htmlentities($_GET['search_address']); ?>" /></td>
      <td><input type="submit" value="Search" /></td>
    </tr>
  </table>
</form>

<!-- 显示表格数据 -->
<table border="1" cellpadding="2" cellspacing="2">
  <tr>
    <td>ID</td>
    <td>NAME</td>
    <td>ADDRESS</td>
    <td>ACTIONS</td>
  </tr>

<?php
  /* 处理查询 */
  $search_conditions = array();

  if (isset($_GET['search_name']) && $_GET['search_name'] != '') {
    $search_name = mysqli_real_escape_string($connection, $_GET['search_name']);
    $search_conditions[] = "NAME LIKE '%$search_name%'";
  }

  if (isset($_GET['search_address']) && $_GET['search_address'] != '') {
    $search_address = mysqli_real_escape_string($connection, $_GET['search_address']);
    $search_conditions[] = "ADDRESS LIKE '%$search_address%'";
  }

  $query = "SELECT * FROM EMPLOYEES";
  if (count($search_conditions) > 0) {
    $query .= " WHERE " . implode(' AND ', $search_conditions);
  }

  $result = mysqli_query($connection, $query);

  while($query_data = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>",$query_data['ID'], "</td>",
         "<td>",$query_data['NAME'], "</td>",
         "<td>",$query_data['ADDRESS'], "</td>";
    echo "<td>";
    echo "<a href='", $_SERVER['SCRIPT_NAME'], "?action=edit&id=", $query_data['ID'], "'>Edit</a> | ";
    echo "<a href='", $_SERVER['SCRIPT_NAME'], "?action=delete&id=", $query_data['ID'], "' onclick=\"return confirm('Are you sure you want to delete this employee?');\">Delete</a>";
    echo "</td>";
    echo "</tr>";
  }
?>
</table>

<!-- 清理资源 -->
<?php
  mysqli_free_result($result);
  mysqli_close($connection);
?>
</body>
</html>

<?php
/* 添加员工到表中 */
function AddEmployee($connection, $name, $address) {
   $n = mysqli_real_escape_string($connection, $name);
   $a = mysqli_real_escape_string($connection, $address);

   $query = "INSERT INTO EMPLOYEES (NAME, ADDRESS) VALUES ('$n', '$a');";

   if(!mysqli_query($connection, $query)) echo("<p>Error adding employee data.</p>");
}

/* 更新员工信息 */
function UpdateEmployee($connection, $id, $name, $address) {
    $id = intval($id);
    $n = mysqli_real_escape_string($connection, $name);
    $a = mysqli_real_escape_string($connection, $address);

    $query = "UPDATE EMPLOYEES SET NAME = '$n', ADDRESS = '$a' WHERE ID = $id";

    if(!mysqli_query($connection, $query)) echo("<p>Error updating employee data.</p>");
}

/* 删除员工 */
function DeleteEmployee($connection, $id) {
    $id = intval($id);
    $query = "DELETE FROM EMPLOYEES WHERE ID = $id";

    if(!mysqli_query($connection, $query)) echo("<p>Error deleting employee data.</p>");
}

/* 获取单个员工信息 */
function GetEmployee($connection, $id) {
    $id = intval($id);
    $query = "SELECT * FROM EMPLOYEES WHERE ID = $id";
    $result = mysqli_query($connection, $query);
    if ($result) {
        return mysqli_fetch_assoc($result);
    }
    return null;
}

/* 检查表是否存在，如果不存在则创建 */
function VerifyEmployeesTable($connection, $dbName) {
  if(!TableExists("EMPLOYEES", $connection, $dbName))
  {
     $query = "CREATE TABLE EMPLOYEES (
         ID int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
         NAME VARCHAR(45),
         ADDRESS VARCHAR(90)
       )";

     if(!mysqli_query($connection, $query)) echo("<p>Error creating table.</p>");
  }
}

/* 检查表是否存在 */
function TableExists($tableName, $connection, $dbName) {
  $t = mysqli_real_escape_string($connection, $tableName);
  $d = mysqli_real_escape_string($connection, $dbName);

  $checktable = mysqli_query($connection,
      "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_NAME = '$t' AND TABLE_SCHEMA = '$d'");

  if(mysqli_num_rows($checktable) > 0) return true;

  return false;
}
?>