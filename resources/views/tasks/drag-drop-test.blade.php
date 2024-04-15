<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-3 gap-4">
            <!-- To Do Column -->
            <div class="bg-yellow-100 p-4 rounded-md">
                <h2 class="font-semibold text-lg mb-4">To Do</h2>
                <ul class="sortable" id="todo-list" ondrop="drop(event)" ondragover="allowDrop(event)">
                    <li class="draggable bg-white rounded-md p-2 mb-4" draggable="true" ondragstart="drag(event)" id="task1">Task 1</li>
                    <li class="draggable bg-white rounded-md p-2 mb-4" draggable="true" ondragstart="drag(event)" id="task2">Task 2</li>
                </ul>
            </div>

            <!-- In Progress Column -->
            <div class="bg-purple-100 p-4 rounded-md">
                <h2 class="font-semibold text-lg mb-4">In Progress</h2>
                <ul class="sortable" id="in-progress-list" ondrop="drop(event)" ondragover="allowDrop(event)">
                    <li class="draggable bg-white rounded-md p-2 mb-4" draggable="true" ondragstart="drag(event)" id="task3">Task 3</li>
                </ul>
            </div>

            <!-- Completed Column -->
            <div class="bg-green-100 p-4 rounded-md">
                <h2 class="font-semibold text-lg mb-4">Completed</h2>
                <ul class="sortable" id="completed-list" ondrop="drop(event)" ondragover="allowDrop(event)">
                    <!-- Add tasks for Completed column here -->
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    let draggedItem = null;

    function allowDrop(ev) {
        ev.preventDefault();
    }

    function drag(ev) {
        draggedItem = ev.target;
    }

    function drop(ev) {
        ev.preventDefault();
        if (draggedItem) {
            // Check if the drop target is a list itself
            if (ev.target.tagName === 'UL') {
                // Append the dragged item to the target list
                ev.target.appendChild(draggedItem);
            }
            // Check if the drop target is a list item
            else if (ev.target.tagName === 'LI') {
                // Append the dragged item before or after the target item
                if (ev.clientY < ev.target.getBoundingClientRect().top + ev.target.offsetHeight / 2) {
                    ev.target.parentNode.insertBefore(draggedItem, ev.target); // Append before the target
                } else {
                    ev.target.parentNode.insertBefore(draggedItem, ev.target.nextSibling); // Append after the target
                }
            }
            console.log('Task moved');
            draggedItem = null;
        }
    }
</script>