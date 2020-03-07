var prevWasAdd = true;

var selectedRow = "";
<<<<<<< HEAD
var selected;
=======
>>>>>>> 2846238ed0b4a9f3569ca416b588d8123b97fdaf

function entitiesToChar(str) {
  return str.replace(/&amp;/g, "&")
      .replace(/&lt;/g, "<")
      .replace(/&gt;/g, ">")
      .replace(/&quot;/g, "\"")
      .replace(/&#039;/g, "'");
}

document.addEventListener("click", function(e) {
  var target = e.target;
  if (target.className == "tasks__edit") {
    var newSelectedRow = target.getAttribute("data-index");
    if (prevWasAdd) {
      formSubmits[0].classList.add("form__submit--half");
      formSubmits[1].style.display = "block";
    }
    showEl(modal);
    if (!prevWasAdd) {
      if (newSelectedRow == selectedRow) {
        return;
      }
    }
    prevWasAdd = false;
    selectedRow = newSelectedRow;
    selected = target.parentNode.children;
    formTitle.innerHTML = "Edit Task";
    formInputs[0].value = entitiesToChar(selected[0].children[0].innerHTML);
    formInputs[1].value = selected[1].children[0].innerHTML;
    formInputs[2].value = entitiesToChar(selected[2].children[0].innerHTML);
    formInputs[3].value = (selected[3].children[0].innerHTML == "Done" ? "done" : "progress");
  }
});

document.getElementsByClassName("header__logout")[0].onclick = function(e) {
  e.preventDefault();
  ajax({
    url: this.href,
    method: "GET",
    callback: function(response) {
      if (response[0] === "error")
        ShowPopup(response[1], response[2], true);
      else if (response[0] === "result") {
        if (response[1] === "true")
          location.reload();
        else
          ShowPopup("Error", "Error occured while logging out", true);
      }
    }
  });
}

document.getElementsByClassName("add__btn")[0].addEventListener("click", function() {
  if (!prevWasAdd)
    clearAddModal();
  prevWasAdd = true;
});

formSubmits[0].onclick = function(e) {
  e.preventDefault();
  if (!prevWasAdd && formInputs[0].value == selected[0].children[0].innerHTML &&
    formInputs[1].value == selected[1].children[0].innerHTML &&
    formInputs[2].value == selected[2].children[0].innerHTML &&
    formInputs[3].value == (selected[3].children[0].innerHTML == "Done" ? "done" : "progress")) {
      prevWasAdd = true;
      closeAfterConfirm();
      return;
  }
  var req = formRequest();
  if (req == "")
    return;
  ajax({
    url: this.parentNode.action + "?action=" + (prevWasAdd ? "add" : "edit&query=" + selectedRow) + req + (!prevWasAdd && formInputs[2].value == selected[2].children[0].innerHTML ? "" : "&taskedited=true"),
    method: "GET",
    callback: function(response) {
      console.log(response);
      if (response[0] === "error")
        ShowPopup(response[1], response[2], true);
      else if (response[0] === "result") {
        if (response[1] === "true") {
          ShowPopup("Success", "Task was " + (prevWasAdd ? "added" : "saved") + " successfully", false);
          prevWasAdd = true;
          closeAfterConfirm();
        } else
          ShowPopup("Error", "Error occured while " + (prevWasAdd ? "adding" : "saving") + " task", true);
      } else if (response[0] === "redirect") {
        if (response[1] === "login")
          window.location = "./login.php?popup=error&title=Permission denied&msg=You have to be authorized to edit tasks";
      }
    }
  });
}

formSubmits[1].onclick = function(e) {
  e.preventDefault();
  ajax({
    url: this.parentNode.action + "?action=delete&query=" + selectedRow,
    method: "GET",
    callback: function(response) {
      if (response[0] === "error")
        ShowPopup(response[1], response[2], true);
      else if (response[0] === "result") {
        if (response[1] === "true") {
          ShowPopup("Success", "Task deleted successfully", false);
          prevWasAdd = true;
          closeAfterConfirm();
        } else
          ShowPopup("Error", "Error occured while deleting this task", true);
      } else if (response[0] === "redirect") {
        if (response[1] === "login")
          window.location = "./login.php?popup=error&title=Permission denied&msg=You have to be authorized to delete tasks";
      }
    }
  });
}

updateTasks = function() {
  var y = 0;
  for (var i = (currentPage-1) * elsPerPage; i < currentPage * elsPerPage; i++) {
    if (i == tasks.length)
      break;
    taskFields[y].children[0].children[0].innerHTML = tasks[i]["author"];
    taskFields[y].children[1].children[0].innerHTML = tasks[i]["email"];
    taskFields[y].children[2].children[0].innerHTML = tasks[i]["task"];
    if (tasks[i]["edited"] == "1") {
      if (taskFields[y].children[2].children[1] === undefined) {
        var edited = document.createElement("span");
        edited.className = "tasks__edited";
        edited.innerHTML = "(edited)";
        taskFields[y].children[2].appendChild(edited);
      }
    } else {
      if (taskFields[y].children[2].children[1] !== undefined)
        taskFields[y].children[2].removeChild(taskFields[y].children[2].children[1]);
    }
    taskFields[y].children[3].children[0].innerHTML = (tasks[i]["done"] === "1" ? "Done" : "In progress");
    taskFields[y].children[4].setAttribute("data-index", tasks[i]["id"]);
    y++;
  }
}

addTask = function(args) {
  var task = document.createElement("div");
  task.className = "tasks__row";
  for (var i = 0; i < 4; i++) {
    var cell = document.createElement("div");
    cell.className = "tasks__cell";
    var span = document.createElement("span");
    span.innerHTML = args[i];
    cell.appendChild(span);
    task.appendChild(cell);
  }
  if (args[4] == "1") {
    var edited = document.createElement("span");
    edited.className = "tasks__edited";
    edited.innerHTML = "(edited)";
    task.children[2].appendChild(edited);
  }
  var editBtn = document.createElement("img");
  editBtn.src = "./img/edit.png";
  editBtn.className = "tasks__edit";
  editBtn.setAttribute("data-index", args[5]);
  task.appendChild(editBtn);
  tasksTable.appendChild(task);
}