<?php
namespace O;

class TodoService {

  public static function handle($verb, $id, $data)
  {
    try {
      switch ($verb) {
        case "GET":
          self::response(empty($id) ? Todo::all() : Todo::get($id));
          break;
        case "PUT":
        case "POST":
          /** @var Todo $todo */
          $todo = o($data)->cast("Todo");
          if (!empty($todo)) {
            if (o($todo)->validate($errors)) {
              $todo->save();
              self::response($todo);
            } else {
              throw new \InvalidArgumentException($errors[0]->message);
            };
          } else {
            throw new \InvalidArgumentException("Invalid $verb data");
          }
          break;
        case "DELETE":
          Todo::delete($id);
          break;
      }
    } catch (\Exception $e) {
      self::error($e);
    }
  }

  private static function error($e)
  {
    header("Content-Type: application/json");
    if ($e instanceof \InvalidArgumentException) {
      header('HTTP/1.1 400 Bad Request', true, 400);
    } else {
      header('HTTP/1.1 500 Internal Server Error', true, 500);
    };
    echo json_encode(array(
      "error" => $e->getMessage(),
      "trace" => $e->getTrace()
    ));
  }

  private static function response($data)
  {
    header("Content-Type: application/json");
    echo json_encode($data);
  }

}
