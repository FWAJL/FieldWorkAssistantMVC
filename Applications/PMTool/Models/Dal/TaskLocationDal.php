<?php

namespace Applications\PMTool\Models\Dal;

if (!defined('__EXECUTION_ACCESS_RESTRICTION__'))
  exit('No direct script access allowed');

class TaskLocationDal extends \Library\DAL\BaseManager {

  public function selectOne($object) {
    return NULL;
  }

  public function update($object) {
    return NULL;
  }

  /**
   * Returns list of Task_location for Task
   * 
   * @param \Applications\PMTool\Models\Dao\Task_location $object
   * @return array of \Applications\PMTool\Models\Dao\Task_location
   */
  public function selectMany($object) {
    $sql = 'SELECT task_id, location_id FROM task_location where `task_id` = \'' . $object->task_id() . '\';';
    $query = $this->dao->query($sql);
    $query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Applications\PMTool\Models\Dao\Task_location');

    $task_location_list = $query->fetchAll();
    $query->closeCursor();

    return count($task_location_list) > 0 ? $task_location_list : array();
  }

  public function countById($pm_id) {
    return NULL;
  }

  public function add($object) {
    $columns = "";
    $values = "";
    foreach ($object as $key => $value) {
      $columns .= "`" . $key . "`,";
      $values .= "'" . $value . "',";
    }
    $columns = rtrim($columns, ", ");
    $values = rtrim($values, ", ");
    $sql = "INSERT INTO `" . strtolower(get_class($object)) . "` (" . $columns . ") VALUES (" . $values . ");";
    $query = $this->dao->query($sql);
    $result;
    if (!$query) {
      $result = $query->errorCode();
      $query->closeCursor();
    } else {
      if (intval($this->dao->lastInsertId())) {
        $result = intval($this->dao->lastInsertId());
      } else {
        $result = FALSE;
      }
    }

    return $result;
  }

  public function edit($object) {
    $set_clause = "";
    $where_clause = "";
    foreach ($object as $key => $value) {
      if ($key === "task_id") {
        $where_clause = "$key = $value";
      } else {
        $set_clause .= "`" . $key . "` = '" . $value . "',";
      }
    }
    $set_clause = rtrim($set_clause, ",");
    $sql = "UPDATE `task` SET $set_clause  WHERE $where_clause;";
    $query = $this->dao->query($sql);
    $result;
    if (!$query) {
      $result = $query->errorCode();
    } else {
      $result = TRUE;
    }
    $query->closeCursor();
    return $result;
  }

  public function delete($identifier) {
    $sql = "DELETE from `task` WHERE task_id = " . $identifier . ";";
    $query = $this->dao->query($sql);
    $result;
    if (!$query) {
      $result = $query->errorCode();
    } else {
      $result = TRUE;
    }
    $query->closeCursor();
    return $result;
  }

}
