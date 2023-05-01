<!DOCTYPE html>
<html>
<head>
    <title>Todo List</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <h1>Todo List</h1>
    <div id="new-task-container">
        <input type="text" id="new-task" placeholder="Add new task">
        <input type="date" id="new-task-deadline">
        <button id="new-task-button" onclick="addTask()">Add</button>
    </div>
    <ul id="todo-list">
        <!-- diisi disini -->
    </ul>
    <footer>copyright by Bagas - 1 Mei 2023</footer>

    <script>
    // fungsi untuk menampilkan daftar tugas
    function displayTasks() {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "get-task.php", true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var tasks = JSON.parse(xhr.responseText);
                var list = document.getElementById("todo-list");
                list.innerHTML = "";
                for (var i = 0; i < tasks.length; i++) {
                    var item = document.createElement("li");
                    var checkbox = document.createElement("input");
                    checkbox.type = "checkbox";
                    checkbox.id = "task" + (i + 1);
                    checkbox.name = "task" + (i + 1);
                    checkbox.value = tasks[i].task_name;
                    checkbox.checked = tasks[i].status == "done";
                    checkbox.onclick = function() {
                        updateTask(this);
                    };
                    var label = document.createElement("label");
                    label.setAttribute("for", checkbox.id);
                    label.innerHTML = tasks[i].task_name;
                    var deadlineInput = document.createElement("input");
                    deadlineInput.type = "date";
                    deadlineInput.id = checkbox.id + "-deadline";
                    deadlineInput.name = checkbox.id + "-deadline";
                    deadlineInput.value = tasks[i].deadline;
                    deadlineInput.onchange = function() {
                        updateTask(this);
                    };
                    var button = document.createElement("button");
                    button.innerHTML = "Delete";
                    button.onclick = function() {
                        deleteTask(this);
                    };
                    item.appendChild(checkbox);
                    item.appendChild(label);
                    item.appendChild(deadlineInput);
                    item.appendChild(button);
                    list.appendChild(item);
                }
            }
        };
        xhr.send();
    }
    // panggil fungsi untuk menampilkan daftar tugas saat halaman dimuat
    displayTasks();

    function addTask() {
    	var task_name = document.getElementById("new-task").value;
    	var deadline = document.getElementById("new-task-deadline").value;
    	if (task_name === "") {
    	    alert("Please enter a task.");
    	    return;
    	}

    	var xhr = new XMLHttpRequest();
    	xhr.open("POST", "add-task.php", true);
    	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    	xhr.onreadystatechange = function() {
    	    if (xhr.readyState === 4 && xhr.status === 200) {
    	        var response = JSON.parse(xhr.responseText);
    	        if (response.status === "success") {
    	            var list = document.getElementById("todo-list");
    	            var item = document.createElement("li");
    	            var checkbox = document.createElement("input");
    	            checkbox.type = "checkbox";
    	            checkbox.id = "task" + (list.getElementsByTagName("li").length + 1);
    	            checkbox.name = "task" + (list.getElementsByTagName("li").length + 1);
    	            checkbox.value = task_name;
    	            var label = document.createElement("label");
    	            label.setAttribute("for", checkbox.id);
    	            label.innerHTML = task_name;
    	            var deadlineInput = document.createElement("input");
    	            deadlineInput.type = "date";
    	            deadlineInput.id = checkbox.id + "-deadline";
    	            deadlineInput.name = checkbox.id + "-deadline";
    	            deadlineInput.value = deadline;
    	            var button = document.createElement("button");
    	            button.innerHTML = "Delete";
    	            button.onclick = function() {
    	                deleteTask(this);
    	            };
    	            item.appendChild(checkbox);
    	            item.appendChild(label);
    	            item.appendChild(deadlineInput);
    	            item.appendChild(button);
    	            list.appendChild(item);
    	            document.getElementById("new-task").value = "";
    	            document.getElementById("new-task-deadline").value = "";
    	        } else {
    	            alert(response.message);
    	        }
    	    }
    	};
    	xhr.send("task_name=" + encodeURIComponent(task_name) + "&deadline=" + encodeURIComponent(deadline));
	}

	function deleteTask(button) {
  		var li = button.parentNode;
  		var checkbox = li.getElementsByTagName("input")[0];
  		var task_name = checkbox.value;

  		var xhr = new XMLHttpRequest();
  		xhr.open("POST", "delete-task.php", true);
  		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  		xhr.onreadystatechange = function() {
  		  if (xhr.readyState === 4 && xhr.status === 200) {
  		    var response = JSON.parse(xhr.responseText);
  		    if (response.status === "success") {
  		      li.parentNode.removeChild(li);
  		    } else {
  		      alert(response.message);
  		    }
  		  }
  		};
  		xhr.send("task_name=" + encodeURIComponent(task_name));
  	}
    </script>
</body>
</html>
