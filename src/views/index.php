<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Todos</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <script data-main="app/config" src="assets/js/libs/require.js"></script>
    <script>
      // define the bootstrap module inside index.php so we can easily inject the default collection
      define("bootstrap", [], function() {
        return function(todoList) {
          todoList.reset(<?= json_encode($todos); ?>);
        };
      });

      // require main to kickstart the app
      require(["main"]);
    </script>
  </head>
  <body>
    <div class="shell container-fluid">
      <div class="page-header">
        <h1>Todos</h1>
      </div>
      <div id="todo-container" class="hidden transition-opacity row-fluid">
        <div class="span2">
          <div id="todo-stats"></div>
        </div>

        <div class="span10">
          <div class="row">
            <div class="span8">
              <div id="todo-add"></div>
              <div id="todo-list"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
