<?php
namespace O;

class Todo {
  /** @var int */
  public $id;

  /**
   * @var string
   * @Size(max=200)
   * @NotEmpty
   */
  public $text;

  /** @var bool */
  public $done;

  public function save()
  {
    if (!o($this)->validate($errors)) throw new \Exception($errors[0]->message);
    $db = self::getDb();
    if (!self::get($this->id)) {
      $this->id = intval($db->insert("todos", $this));
    } else {
      $db->update("todos", $this, "id = ?", array($this->id));
    };
  }

  public static function delete($id)
  {
    self::getDb()->delete("todos", "id = ?", array($id));
  }

  public static function get($id)
  {
    return o(self::getDb()->fetchRow(
      "select id, text, done from todos where id = ?",
      array($id)
    ))->cast("Todo");
  }

  public static function all()
  {
    return convertType(self::getDb()->fetchAll(
      "select id, text, done from todos"
    ), 'O\Todo[]');
  }

  private static function getDb()
  {
    static $db;
    if (empty($db)) {
      $path = realpath(__DIR__."/../..");
      $db = new PDO("sqlite:".$path."/data.db");
      $db->exec(
        "CREATE TABLE IF NOT EXISTS todos (
         id INTEGER PRIMARY KEY,
         text TEXT,
         done INTEGER
       )");
    };
    return $db;
  }

}
