<a href="todo/add" class="button right">Add a new Todo List</a>

<?php foreach ($todos as $todo) include_view('project/todo/show', array('todo' => $todo)); ?>