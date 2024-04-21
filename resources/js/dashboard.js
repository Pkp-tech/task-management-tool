$(document).ready(function () {
    // Function to add a new column
    function addColumn() {
        // var newColumnId = generateColumnId();
        var newColumn = `
                <div class="card min-w-[400px] max-h-[400px] overflow-y-auto">
                    <div class="bg-yellow-100 p-4 rounded-md mb-4">
                        <button id="add-list-btn" class="add-list-btn text-yellow-700">+ Add another list</button>
                        <div class="flex justify-between items-center mb-4">
                            <div id="list-input" class="list-input" style="display: none;">
                                <input type="text" id="list-status-column" class="list-status-column" placeholder="Enter List Title">
                            </div>
                            <h2 class="list-title font-semibold text-lg" style="display: none;"></h2>
                            <div class="relative">
                                <button class="more-options-btn hidden">⋮</button>
                                <div class="more-options-menu hidden absolute right-0 mt-2 bg-white shadow-lg rounded z-100 p-2">
                                    <ul>
                                        <li><button class="edit-status-column-btn" data-status-column-id="">Edit</button></li>
                                        <li><button class="delete-status-column-btn" data-status-column-id="" data-status-column-title="">Delete</button></li>
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
                </div>
            `;
        $(".card").last().after(newColumn);
    }

    // Add List Button Click Event
    $(document).on("click", ".add-list-btn", function () {
        $(this).hide();
        $(this).closest(".card").find(".list-input").show();
        $(this).closest(".card").find(".list-status-column").focus();
    });

    // Add click event listener to the edit button in the more-options-menu
    $(document).on("click", ".edit-status-column-btn", function () {
        // Retrieve the card and the current statusColumn details
        var card = $(this).closest(".card");
        var listTitle = card.find(".list-title");
        var listStatusColumnInput = card.find(".list-input");
        var listStatusColumn = card.find(".list-status-column");
        var currentStatusColumn = listTitle.text();

        // Hide the list title and show the input field with the current statusColumn
        listTitle.hide();
        listStatusColumnInput.show();
        listStatusColumn.val(currentStatusColumn).focus();

        // Close the more-options dropdown
        $(this).closest(".more-options-menu").addClass("hidden");
    });

    // Add List StatusColumn Input Keyup Event
    $(document).on("keyup", ".list-status-column", function (event) {
        if (event.keyCode === 13) {
            var statusColumn = $(this).val().trim();
            var card = $(this).closest(".card");
            var statusColumnId = card.data("status-column-id");
            if (statusColumn !== "") {
                // Check if statusColumnId is defined
                if (statusColumnId !== undefined && statusColumnId !== null) {
                    // If statusColumnId is defined, update the statusColumn
                    updateStatusColumn(statusColumnId, statusColumn, card);
                } else {
                    // If statusColumnId is not defined, add the statusColumn
                    addStatusColumn(statusColumn, card);
                }
            }
        }
    });

    // Add blur event listener to list status column input
    $(document).on("blur", ".list-status-column", function () {
        // Get the input element and the corresponding card
        var listStatusColumnInput = $(this);
        var card = listStatusColumnInput.closest(".card");

        // Check if the input value is empty
        if (listStatusColumnInput.val().trim() === "") {
            // Hide the input and show the "+ Add List" button
            card.find(".list-input").hide();
            card.find(".add-list-btn").show();
            // card.find(".list-title").show();
        }
    });

    // Function to add statusColumn through AJAX
    function addStatusColumn(statusColumn, card) {
        $.ajax({
            url: "/add-status-column",
            type: "POST",
            data: {
                statusColumn: statusColumn,
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                // StatusColumn added successfully
                console.log(response.message);
                // Update UI to show statusColumn
                card.find(".list-title").text(statusColumn).show();
                card.find(".more-options-btn").removeClass("hidden");
                card.find(".list-input").hide();
                card.find(".add-task-btn").removeClass("hidden");
                // Update the data-status-column-id attribute with the received statusColumn ID
                card.attr("data-status-column-id", response.statusColumnId);
                card.find(
                    ".edit-status-column-btn, .delete-status-column-btn"
                ).attr("data-status-column-id", response.statusColumnId);
                card.find(".delete-status-column-btn").attr(
                    "data-status-column-title",
                    statusColumn
                );
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

    // Function to update the statusColumn through AJAX
    function updateStatusColumn(statusColumnId, newStatusColumn, card) {
        $.ajax({
            url: "/update-status-column",
            type: "PATCH",
            data: {
                status_column_id: statusColumnId,
                status_column_name: newStatusColumn,
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                // StatusColumn updated successfully
                console.log(response.message);
                // Update the UI with the new statusColumn
                card.find(".list-title").text(newStatusColumn).show();
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
                var statusColumnId = card.data("status-column-id");
                addTask(task, card, statusColumnId);
            }
        }
    });

    // Task Input Field Blur Event
    $(document).on("blur", ".task-status", function () {
        // If the input is empty, hide it and show the "+ Add Task" button
        if ($(this).val().trim() === "") {
            var card = $(this).closest(".card");
            $(this).closest(".task-input").hide();
        }
    });

    // Function to add task through AJAX
    function addTask(task, card, statusColumnId) {
        $.ajax({
            url: "/add-task",
            type: "POST",
            data: {
                task: task,
                status_column_id: statusColumnId,
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
        // Retrieve task ID, title, description, and statusColumn ID from data attributes
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
        // Retrieve task ID, title, description, and statusColumn ID from data attributes
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

            // Error message div
            const errorMessageDiv = EditModal.find(".edit-task-error-message");
            errorMessageDiv.text("").addClass("hidden");
            EditModal.find(".new-label-input").val("");

            // Populate the form in the modal with the retrieved task data
            EditModal.find("#task-id").val(response.task_id); // Hidden input field for task ID
            EditModal.find("#task-title").val(response.title);
            EditModal.find("#task-description").val(response.description);
            // response contains the task files
            var taskFilesDiv = EditModal.find(".file-list"); // Select the div with class 'task-file'

            // Clear previous file list
            taskFilesDiv.empty();

            // Iterate over the files in the response
            response.files.forEach(function (file, index) {
                // Create a container div for each file
                var fileContainer = $("<div>").addClass(
                    "file-container flex justify-between items-center mb-2"
                );

                // Create a serial number element
                var serialNumber = $("<span>")
                    .addClass("file-serial-number mr-2")
                    .text(index + 1 + "."); // Serial numbers start from 1

                // Create a file link
                var fileLink = $("<a>")
                    .attr("href", response.storage_url + "/" + file.file_path)
                    .attr("target", "_blank")
                    .text(file.file_name);

                // Create a remove button for each file
                var removeButton = $("<button>")
                    .addClass("remove-file-btn text-red-500 ml-2 font-bold")
                    .attr("type", "button")
                    .attr("data-file-id", file.id) // Attach file ID for removal
                    .text("X");

                // Append serial number, file link, and remove button to the file container
                // fileContainer.append(serialNumber);
                fileContainer.append(fileLink);
                fileContainer.append(removeButton);

                // Append the file container to the task files div
                taskFilesDiv.append(fileContainer);
            });

            // Initialize an array to hold the label IDs
            let taskLabelIds = [];

            // Iterate through the response array to extract the label IDs
            response.taskLabels.forEach(function (label) {
                taskLabelIds.push(label.label_id);
            });

            console.log(taskLabelIds);

            // Iterate through the label checkboxes
            EditModal.find('.label-checkboxes input[type="checkbox"]').each(
                function () {
                    const labelId = $(this).val(); // Get the value of the checkbox (label ID)

                    // Check the checkbox if the label ID is in the taskLabelIds array
                    if (taskLabelIds.includes(parseInt(labelId))) {
                        $(this).prop("checked", true);
                    } else {
                        $(this).prop("checked", false);
                    }
                }
            );

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
     * StatusColumn delete
     */
    // Add click event listener to the delete button
    $(document).on("click", ".delete-status-column-btn", function () {
        var statusColumnId = $(this).data("status-column-id");
        var statusColumnTitle = $(this).data("status-column-title");

        // Close the more-options dropdown
        $(this).closest(".more-options-menu").addClass("hidden");

        // Open the modal for deleting the task
        var DeleteModal = $("#delete-status-column-modal");

        // Populate the form in the modal with the retrieved task data
        DeleteModal.find("#status-column-id").val(statusColumnId); // Hidden input field for task ID
        DeleteModal.find("#status-column-title").val(statusColumnTitle);

        // Show the modal
        DeleteModal.removeClass("hidden");
    });

    /**
     * Label tasks
     */
    $(document).on("click", ".add-new-label-btn", function () {
        // Find the form that the clicked button belongs to
        const form = $(this).closest("form");

        // Find the input element for new label within the form
        const newLabelInput = form.find(".new-label-input");

        // Find the container for the checkboxes
        const labelCheckboxes = form.find(".label-checkboxes");

        // Get the new label name from the input field
        const newLabelName = newLabelInput.val().trim();

        // Error message div
        const errorMessageDiv = form.find(".edit-task-error-message");

        //Check if the input is empty
        if (!newLabelName) {
            errorMessageDiv.text("Please enter a label name.").removeClass("hidden");
            return;
        }

        if (newLabelName !== "") {
            // Send AJAX request to server to create a new label
            $.ajax({
                url: "/add-label",
                type: "POST",
                data: {
                    name: newLabelName,
                    _token: $('meta[name="csrf-token"]').attr("content"), // CSRF token for security
                },
                success: function (data) {
                    // Hide the error message div on success
                    errorMessageDiv.addClass("hidden");

                    if (data.success) {
                        // Create a new checkbox for the new label and add it to the container
                        const newCheckbox = $(`
                            <div class="label flex items-center space-x-2 mb-2">
                                <input type="checkbox" class="label-checkbox" name="label_ids[]" value="${data.label_id}" id="${data.label_id}">
                                <label for="${data.label_id}">${data.label_name}</label>
                                <i class="fas fa-trash text-red-500 remove-label-btn" data-label-id="${data.label_id}"></i>
                            </div>
                        `);
                        labelCheckboxes.append(newCheckbox);

                        // Clear the new label input field
                        newLabelInput.val("");
                    } else {
                        // Show the error message
                        errorMessageDiv
                            .text(data.message)
                            .removeClass("hidden");
                    }
                },
                error: function (err) {
                    // Show the error message div with the error message
                    errorMessageDiv
                        .text("Error adding label: " + err.responseJSON.message)
                        .removeClass("hidden");
                },
            });
        }
    });

    /**
     * remove file
     */
    // Add an event listener for the remove button
    $(document).on("click", ".remove-file-btn", function () {
        // Get the file ID and file path from data attributes
        var fileId = $(this).data("file-id");

        // Send an AJAX request to remove the file from the server
        $.ajax({
            url: "/remove-file", // Server-side route to handle file removal
            type: "DELETE", // Use the DELETE HTTP method
            data: {
                file_id: fileId, // Include the file ID as data
                _token: $('meta[name="csrf-token"]').attr("content"), // CSRF token for security
            },
            success: function (response) {
                if (response.success) {
                    // Remove the corresponding file row from the modal
                    $(this).closest(".file-container").remove();
                } else {
                    // Display an error message
                    alert("Failed to remove the file: " + response.error);
                }
            }.bind(this),
            error: function () {
                // Display an error message if an error occurs
                alert("An error occurred while trying to remove the file.");
            },
        });
    });

    /**
     * remove label
     */
    $(document).on("click", ".remove-label-btn", function () {
        // Get the label ID from the data attribute
        const labelId = $(this).data("label-id");

        var labelElement = $(this).closest(".label");

        // Send an AJAX request to remove the label
        $.ajax({
            url: "/remove-label", // Server endpoint for removing a label
            type: "DELETE",
            data: {
                id: labelId,
                _token: $('meta[name="csrf-token"]').attr("content"), // CSRF token for security
            },
            success: function (response) {
                if (response.success) {
                    // Remove the label's list and button from the DOM
                    labelElement.remove();
                } else {
                    console.error("Error removing label:", response.message);
                }
            },
            error: function (err) {
                console.error("Error removing label:", err);
            },
        });
    });
});
