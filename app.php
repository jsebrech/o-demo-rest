<?php
namespace O; include "vendor/autoload.php"; O::init();

// built-in web server: route static assets
if (php_sapi_name() == 'cli-server') {
  if (preg_match('/\.(?:js|css|html|png|jpg|jpeg|gif)$/', $_SERVER["REQUEST_URI"])) {
    return false;
  }
}

include "src/models/Todo.php";
include "src/controllers/TodoService.php";

/*
 * HTML:
 *   GET / -> index.php
 * JSON:
 *   GET /todos -> load all as json
 *   GET /todos/1 -> load one as json
 *   PUT /todos/1 -> update one from json
 *   POST /todos -> create one from json
 *   DELETE /todos/1 -> delete one
 */

$parts = cs($_SERVER["REQUEST_URI"])->ltrim("/")->tolower()->split("/");
switch ($parts->shift())
{
  case "todos":
    TodoService::handle(
      $_SERVER["REQUEST_METHOD"],
      (string) $parts->shift(),
      json_decode(file_get_contents("php://input"))
    );
    break;
  default:
    o(array("todos" => Todo::all()))->render(
      __DIR__."/src/views/index.php");
    break;
}
