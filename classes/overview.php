<?php

class Overview {
    public $conn;

    function __construct() {
        include './classes/db.php';

        $db = new Database();
        $this->conn = $db->getConn();
    }

    public function showTasks() {
        $userID = $_SESSION["userID"] ?? NULL;

        if (empty($userID)) {
          header("location: login.php");
        }

        $registerSql = $this->conn->prepare("SELECT taak_id, opmerkingen, status FROM onderhoudstaak WHERE personeel_id = ?");
        $registerSql->execute([$userID]);
        $tasks = $registerSql->fetchAll();

        foreach ($tasks as $task) {
          $taskID = $task["taak_id"];
          $taskName = $task["opmerkingen"];
          $taskStatus = $task["status"];
          echo "<div class='task'>
          <span class='task-text'>$taskName</span>
          <span class='task-text'>$taskStatus</span>
          <a href='?edit=$taskID' class='update-link'>UPDATE STATUS</a>
          </div>";
        }
    }

    public function showWorkers() {
        $rows = ["personeel_id", "naam", "rol", "gebruikersnaam", "adres"];
        $headerRows = array_merge($rows, ["EDIT"]);
        $tableRows = implode(",", $rows);

        foreach ($headerRows as $row) {
          echo "<th>" . $row . "</th>";
        }

        $registerSql = $this->conn->prepare("SELECT " . $tableRows . " FROM personeel");
        $registerSql->execute();
        $users = $registerSql->fetchAll();

        foreach ($users as $user) {
          echo "<tr>";
          foreach ($headerRows as $row) {
            if ($row === "EDIT") {
              echo "<td><a href='edit-worker.php?userid=" . $user[0] . "'>EDIT</a></td>";
            } else {
              echo "<td>" . $user[$row] . "</td>";
            }
          }
          echo "</tr>";
        }
    }
}