Todo demo app for php-o
=======================

This is an example implementation of [TodoMVC](http://todomvc.com/) on top of a REST service demonstrating the capabilities of the [php-o framework](https://github.com/jsebrech/php-o).

Based on a similar [Ruby implementation by David Richart](https://github.com/drichard/todo-backbone-sample).

To run:

    composer install
    php.exe -S localhost:80 -t o-demo-rest/public o-demo-rest/app.php
