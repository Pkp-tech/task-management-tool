$(document).ready(function () {
    let draggedItem = null;

    window.allowDrop = function(ev) {
        ev.preventDefault();
    }
    
    window.drag = function(ev) {
        draggedItem = ev.target;
    }
    
    window.drop = function(event) {
        event.preventDefault();

        // Ensure that the dragged item is not null
        if (draggedItem) {
            // Get the target element where the item is being dropped
            const target = event.target;

            // Find the parent UL element if the target is not a UL element itself
            let ulElement;
            if (target.tagName === "UL") {
                ulElement = target;
            } else if (target.tagName === "DIV") {
                // Event target is a DIV, find the UL element within it using querySelector
                ulElement = target.querySelector("ul.task-list");
            } else {
                ulElement = target.closest("ul.task-list");
            }

            // Check if the UL element exists and if it has the class 'task-list'
            if (ulElement && ulElement.classList.contains("task-list")) {
                // Append the dragged item to the UL element
                ulElement.appendChild(draggedItem);

                // Retrieve the data-status-column-id of the new list (drop target)
                let newStatusColumnId = ulElement
                    .closest(".card")
                    .getAttribute("data-status-column-id");

                // Retrieve the data-task-id of the dragged element (task)
                let taskId = draggedItem.getAttribute("data-task-id");

                // Make an AJAX request to update the task's status_column_id on the server side
                updateTaskStatus(taskId, newStatusColumnId);
            }

            // Reset the dragged item
            draggedItem = null;
        }
    }

    // Function to update the task's status_column_id on the server side
    function updateTaskStatus(taskId, newStatusColumnId) {
        // Perform an AJAX request to update the task's status_column_id
        $.ajax({
            url: `/tasks/${taskId}/update-status`, // Endpoint to update task's status_column_id
            type: "PUT", // Use PUT method for updating data
            data: {
                status_column_id: newStatusColumnId,
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                // Handle successful response (e.g., update the UI)
                console.log("Task staus updated successfully:", response);
            },
            error: function (xhr, status, error) {
                // Handle errors
                console.error("Error updating task status_column_id:", error);
            },
        });
    }
});
