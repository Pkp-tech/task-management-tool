$(document).ready(function () {
    // Function to add a new column
    function addColumn() {
        // var newColumnId = generateColumnId();
        var newColumn = `
                <div class="card bg-yellow-100 rounded-md p-4 mb-4">
                <button id="add-list-btn" class="add-list-btn text-yellow-700">+ Add another list</button>
                <div class="flex justify-between items-center mb-4">
                    <div id="list-input" class="hidden list-input">
                        <input type="text" id="list-label" class="list-label" placeholder="Enter List Title">
                    </div>
                    <h2 class="list-title font-semibold text-lg" style="display: none;"></h2>
                    <div class="relative">
                        <button class="more-options-btn hidden">⋮</button>
                        <div class="more-options-menu hidden absolute right-0 mt-2 bg-white shadow-lg rounded z-100 p-2">
                            <ul>
                                <li><button class="edit-label-btn" data-label-id="">Edit</button></li>
                                <li><button class="delete-label-btn" data-label-id="" data-label-title="">Delete</button></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <ul class="task-list"></ul>
                <div class="task-input hidden">
                    <input type="text" class="task-status" placeholder="Enter Task">
                </div>
                <button class="add-task-btn hidden text-yellow-700">+ Add Task</button>
                </div>
            `;
        $(".card").last().after(newColumn);
    }

    // Add List Button Click Event
    $(document).on("click", ".add-list-btn", function () {
        $(this).hide();
        $(this).closest(".card").find(".list-input").show();
        $(this).closest(".card").find(".list-label").focus();
    });

    // Add click event listener to the edit button in the more-options-menu
    $(document).on("click", ".edit-label-btn", function () {
        // Retrieve the card and the current label details
        var card = $(this).closest(".card");
        var listTitle = card.find(".list-title");
        var listLabelInput = card.find(".list-input");
        var listLabel = card.find(".list-label");
        var currentLabel = listTitle.text();

        // Hide the list title and show the input field with the current label
        listTitle.hide();
        listLabelInput.show();
        listLabel.val(currentLabel).focus();

        // Close the more-options dropdown
        $(this).closest(".more-options-menu").addClass("hidden");
    });

    // Add List Label Input Keyup Event
    $(document).on("keyup", ".list-label", function (event) {
        if (event.keyCode === 13) {
            var label = $(this).val().trim();
            var card = $(this).closest(".card");
            var labelId = card.data("label-id");
            if (label !== "") {
                // Check if labelId is defined
                if (labelId !== undefined && labelId !== null) {
                    // If labelId is defined, update the label
                    updateLabel(labelId, label, card);
                } else {
                    // If labelId is not defined, add the label
                    addLabel(label, card);
                }
            }
        }
    });

    // Function to add label through AJAX
    function addLabel(label, card) {
        $.ajax({
            url: "/add-label",
            type: "POST",
            data: {
                label: label,
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                // Label added successfully
                console.log(response.message);
                // Update UI to show label
                card.find(".list-title").text(label).show();
                card.find(".more-options-btn").removeClass("hidden");
                card.find(".list-input").hide();
                card.find(".add-task-btn").removeClass("hidden");
                // Update the data-label-id attribute with the received label ID
                card.attr("data-label-id", response.labelId);
                card.find(".edit-label-btn, .delete-label-btn").attr(
                    "data-label-id",
                    response.labelId
                );
                card.find(".delete-label-btn").attr("data-label-title", label);
                addColumn();

                // Add the ondrop attribute to the task list
                card.attr("ondrop", "drop(event)");
                card.find("task-list").attr("ondrop", "drop(event)");

                // Add the ondragover attribute to the task list
                card.attr("ondragover", "allowDrop(event)");
                card.find(".task-list").attr("ondragover", "allowDrop(event)");
            },
            error: function (xhr, status, error) {
                // Handle error
                console.error(error);
            },
        });
    }

    // Function to update the label through AJAX
    function updateLabel(labelId, newLabel, card) {
        $.ajax({
            url: "/update-label",
            type: "PATCH",
            data: {
                label_id: labelId,
                label_name: newLabel,
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                // Label updated successfully
                console.log(response.message);
                // Update the UI with the new label
                card.find(".list-title").text(newLabel).show();
                card.find(".list-input").hide();
            },
            error: function (xhr, status, error) {
                // Handle error
                console.error(error);
            },
        });
    }

    // Task Button Click Event
    $(document).on("click", ".add-task-btn", function () {
        var card = $(this).closest(".card");
        card.find(".task-input").show();
        card.find(".task-status").focus();
    });

    // Task Input Field Keyup Event
    $(document).on("keyup", ".task-status", function (event) {
        if (event.keyCode === 13) {
            var task = $(this).val().trim();
            if (task !== "") {
                var card = $(this).closest(".card");
                var labelId = card.data("label-id");
                addTask(task, card, labelId);
            }
        }
    });

    // Function to add task through AJAX
    function addTask(task, card, labelId) {
        $.ajax({
            url: "/add-task",
            type: "POST",
            data: {
                task: task,
                label_id: labelId,
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                // Task added successfully
                console.log(response.message);
                // Update UI to show the new task
                var taskItem = $(
                    '<li class="draggable bg-white rounded-md p-2 mb-4 flex justify-between items-center" data-task-id="' +
                        response.taskId +
                        '" draggable="true" ondragstart="drag(event)">' +
                        "<span>" +
                        task +
                        "</span>" +
                        '<div class="relative">' +
                        '<button class="more-options-btn">⋮</button>' +
                        '<div class="more-options-menu hidden absolute right-0 mt-2 bg-white shadow-lg rounded z-100 p-2">' +
                        "<ul>" +
                        '<li><button class="edit-task-btn" data-task-id="' +
                        response.taskId +
                        '">Edit</button></li>' +
                        '<li><button class="delete-task-btn" data-task-id="' +
                        response.taskId +
                        '">Delete</button></li>' +
                        "</ul>" +
                        "</div>" +
                        "</div>" +
                        "</li>"
                );
                card.find(".task-list").append(taskItem);
                card.find(".task-status").val("");
                card.find(".task-input").hide();
            },
            error: function (xhr, status, error) {
                // Handle error
                console.error(error);
            },
        });
    }

    //Set task group
    $("#task-group-dropdown").change(function () {
        var selectedTaskGroupId = $(this).val();

        // Make an AJAX request to update the session variable
        $.ajax({
            url: "/update-task-group-session",
            type: "POST",
            data: {
                task_group_id: selectedTaskGroupId,
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                // Session variable updated successfully
                console.log(response.message);
                // Reload the page
                window.location.reload();
            },
            error: function (xhr, status, error) {
                // Handle error
                console.error(error);
            },
        });
    });

    // Add click event listener to more options buttons
    $(document).on("click", ".more-options-btn", function () {
        // Hide all other more-options-menu elements before toggling the clicked menu
        $(".more-options-menu").addClass("hidden");

        // Get the corresponding more-options-menu for the clicked button
        var menu = $(this).siblings(".more-options-menu");

        // Toggle the visibility of the clicked menu
        menu.toggleClass("hidden");
    });

    // Add click event listener to hide the menu when clicking outside of it
    $(document).on("click", function (event) {
        // Check if the clicked element is not a more-options-btn or inside the more-options-menu
        if (
            !$(event.target).closest(".more-options-btn, .more-options-menu")
                .length
        ) {
            // Hide all more-options-menu elements
            $(".more-options-menu").addClass("hidden");
        }
    });

    // Add click event listener to the edit button
    $(document).on("click", ".edit-task-btn", function () {
        // Retrieve task ID, title, description, and label ID from data attributes
        var taskId = $(this).data("task-id");

        // Close the more-options dropdown
        $(this).closest(".more-options-menu").addClass("hidden");

        // Make an AJAX request to retrieve the task data for the given task ID
        $.ajax({
            url: "/get-task/" + taskId,
            type: "GET",
            success: function (response) {
                // Open the modal for editing the task
                openModal("Edit Task", taskId, response);
            },
            error: function (xhr, status, error) {
                console.error("Error fetching task data:", error);
                // Handle error (e.g., show error message)
            },
        });
    });

    // Add click event listener to the delete button
    $(document).on("click", ".delete-task-btn", function () {
        // Retrieve task ID, title, description, and label ID from data attributes
        var taskId = $(this).data("task-id");
        // var taskTitle = $(this).data("task-title");

        // Populate the modal input fields with the task data
        $("#task-id").val(taskId);
        // $("#task-title").val(taskTitle);

        // Close the more-options dropdown
        $(this).closest(".more-options-menu").addClass("hidden");

        // Make an AJAX request to retrieve the task data for the given task ID
        $.ajax({
            url: "/get-task/" + taskId,
            type: "GET",
            success: function (response) {
                // Open the modal for deleting the task
                openModal("Delete Task", taskId, response);
            },
            error: function (xhr, status, error) {
                console.error("Error fetching task data:", error);
                // Handle error (e.g., show error message)
            },
        });
    });

    // Function to open the modal
    function openModal(action, taskId, response) {
        // Set the modal content based on action
        if (action === "Edit Task") {
            var EditModal = $("#edit-task-modal");

            // Populate the form in the modal with the retrieved task data
            EditModal.find("#task-id").val(response.task_id); // Hidden input field for task ID
            EditModal.find("#task-title").val(response.title);
            EditModal.find("#task-description").val(response.description);
            // response contains the task files
            var taskFilesDiv = EditModal.find('.file-list'); // Select the div with class 'task-file'
            
            // Clear previous file list
            taskFilesDiv.empty();

            console.log(response.files);
            
            // Iterate over the files in the response
            response.files.forEach(function(file) {
                // Create a file link and append to taskFilesDiv
                var fileLink = $('<a>')
                    .attr('href', response.storage_url+'/'+file.file_path)
                    .attr('target', '_blank')
                    .text(file.file_path);
                taskFilesDiv.append(fileLink);
                taskFilesDiv.append('<br>'); // Add a line break for each file
            });

            // Show the modal
            EditModal.removeClass("hidden");
        } else if (action === "Delete Task") {
            var DeleteModal = $("#delete-task-modal");

            // Populate the form in the modal with the retrieved task data
            DeleteModal.find("#task-id").val(response.task_id); // Hidden input field for task ID
            DeleteModal.find("#task-title").val(response.title);

            // Show the modal
            DeleteModal.removeClass("hidden");
        }
    }

    // Close the modal when clicking the close button
    $(".modal-close").click(function () {
        // Hide the modal
        $(".task-modal").addClass("hidden");
    });

    /**
     * Label delete
     */
    // Add click event listener to the delete button
    $(document).on("click", ".delete-label-btn", function () {
        var labelId = $(this).data("label-id");
        var labelTitle = $(this).data("label-title");

        // Close the more-options dropdown
        $(this).closest(".more-options-menu").addClass("hidden");

        // Open the modal for deleting the task
        var DeleteModal = $("#delete-label-modal");

        // Populate the form in the modal with the retrieved task data
        DeleteModal.find("#label-id").val(labelId); // Hidden input field for task ID
        DeleteModal.find("#label-title").val(labelTitle);

        // Show the modal
        DeleteModal.removeClass("hidden");
    });

    /**
     * Drag & Drop feature
     */
    // let draggedItem = null;

    // function allowDrop(ev) {
    //     ev.preventDefault();
    // }

    // function drag(ev) {
    //     draggedItem = ev.target;
    // }

    // function drop(ev) {
    //     ev.preventDefault();
    //     if (draggedItem) {
    //         // Check if the drop target is a list itself
    //         if (ev.target.tagName === "UL") {
    //             // Append the dragged item to the target list
    //             ev.target.appendChild(draggedItem);
    //         }
    //         // Check if the drop target is a list item
    //         else if (ev.target.tagName === "LI") {
    //             // Append the dragged item before or after the target item
    //             if (
    //                 ev.clientY <
    //                 ev.target.getBoundingClientRect().top +
    //                     ev.target.offsetHeight / 2
    //             ) {
    //                 ev.target.parentNode.insertBefore(draggedItem, ev.target); // Append before the target
    //             } else {
    //                 ev.target.parentNode.insertBefore(
    //                     draggedItem,
    //                     ev.target.nextSibling
    //                 ); // Append after the target
    //             }
    //         }
    //         console.log("Task moved");
    //         draggedItem = null;
    //     }
    // }
});
