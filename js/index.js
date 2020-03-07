var formInputs = document.getElementsByClassName("form__input");
var formTitle = document.getElementsByClassName("form__title")[0];
var formSubmits = document.getElementsByClassName("form__submit");

var modal = document.getElementsByClassName("modal")[0];

function hideEl(el) {
  el.style.visibility = "hidden";
  el.style.opacity = 0;
}

function showEl(el) {
  el.style.visibility = "visible";
  el.style.opacity = 1;
}

modal.onclick = function(e) {
  if (e.target == modal)
    hideEl(modal);
}

document.getElementsByClassName("add__btn")[0].onclick = function() {
  showEl(modal);
}

function formRequest() {
  var author = formInputs[0].value;
  var email = formInputs[1].value;
  var task = formInputs[2].value;
  if (author == "") {
    ShowPopup("Form Error", "Name must be specified", true);
    return "";
  } else if (!/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email)) {
    ShowPopup("Form Error", "Email must be valid", true);
    return "";
  } else if (task == "") {
    ShowPopup("Form error", "Task must be specified", true);
    return "";
  }
  req = "&author=" + author + "&email=" + email + "&task=" + task + "&done=" + (formInputs[3].value == "done" ? "true" : "false");
  return req.replace('&amp;', '&').replace('&lt;', '<').replace("&gt;", '>').replace("&quot;", '"');
}

function clearAddModal() {
  formSubmits[0].classList.remove("form__submit--half");
  formSubmits[1].style.display = "none";
  formTitle.innerHTML = "Add Task";
  formInputs[0].value = "";
  formInputs[1].value = "";
  formInputs[2].value = "";
  formInputs[3].value = "progress";
}

function closeAfterConfirm() {
  hideEl(modal);
  setTimeout(clearAddModal, 200);
}

formSubmits[0].onclick = function(e) {
  e.preventDefault();
  var req = formRequest();
  if (req == "")
    return;
  ajax({
    url: this.parentNode.action + "?action=add" + req,
    method: "GET",
    callback: function(response) {
      if (response[0] === "error")
        ShowPopup(response[1], response[2], true);
      else if (response[0] === "result") {
        if (response[1] === "true") {
          ShowPopup("Success", "Task was added successfully", false);
          closeAfterConfirm();
        } else
          ShowPopup("Error", "Error occured while adding task", true);
      }
    }
  });
}

var currentPage = 1;
var elsPerPage = 3;
var pagesNum = Math.ceil(tasks.length / elsPerPage);

var taskFields = document.getElementsByClassName("tasks__wrap")[0].children;
function updateTasks() {
  var y = 0;
  for (var i = (currentPage-1) * elsPerPage; i < currentPage * elsPerPage; i++) {
    if (i == tasks.length)
      break;
    taskFields[y].children[0].children[0].innerHTML = tasks[i]["author"];
    taskFields[y].children[1].children[0].innerHTML = tasks[i]["email"];
    taskFields[y].children[2].children[0].innerHTML = tasks[i]["task"];
    if (tasks[i]["edited"] == "1") {
      var edited = document.createElement("span");
      edited.className = "tasks__edited";
      edited.innerHTML = "(edited)";
      taskFields[y].children[2].appendChild(edited);
    } else if (taskFields[y].children[2].children[1] !== undefined) {
      taskFields[y].children[2].removeChild(taskFields[y].children[2].children[1]);
    }
    taskFields[y].children[3].children[0].innerHTML = (tasks[i]["done"] === "1" ? "Done" : "In progress");
    y++;
  }
}

var headerCells = document.getElementsByClassName("tasks__row--header")[0].children;
for(var i = 0; i < 4; i++) {
  headerCells[i].onclick = function(e) {
    var orderby = this.getAttribute("data-name");
    for(var i = 0; i < 4; i++) {
      if (headerCells[i].getAttribute("data-name") != orderby)
        headerCells[i].className = headerCells[i].classList.item(0);
    }
    if (this.classList.contains("tasks__cell--order-asc")) {
      tasks.sort(function(l, r) { return l[orderby] < r[orderby] ? 1 : -1; });
      this.classList.remove("tasks__cell--order-asc");
      this.classList.add("tasks__cell--order-desc");
    } else if (this.classList.contains("tasks__cell--order-desc")) {
      tasks.sort(function(l, r) { return l[orderby] > r[orderby] ? 1 : -1; });
      this.classList.remove("tasks__cell--order-desc");
      this.classList.add("tasks__cell--order-asc");
    } else {
      tasks.sort(function(l, r) { return l[orderby] > r[orderby] ? 1 : -1; });
      this.classList.add("tasks__cell--order-asc");
    }
    updateTasks();
  }
}

var pagination = document.getElementsByClassName("pages")[0];
var btnPrev = document.getElementsByClassName("pages__btn--prev")[0];
var btnNext = document.getElementsByClassName("pages__btn--next")[0];
var tasksTable = document.getElementsByClassName("tasks__wrap")[0];
var pageIndexes = document.getElementsByClassName("pages__btn--number");

if (pagesNum == 1) {
  pagination.style.display = "none";
} else if (pagesNum == 2) {
  pageIndexes[2].style.display = "none";
}

function addTask(args) {
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
  tasksTable.appendChild(task);
}

function correctPages() {
  pageIndexes[0].innerHTML = currentPage-1;
  pageIndexes[1].innerHTML = currentPage;
  pageIndexes[2].innerHTML = currentPage+1;
}

function changePage() {
  tasksTable.innerHTML = "";

  for (var i = (currentPage-1) * elsPerPage; i < currentPage * elsPerPage; i++) {
    if (i == tasks.length)
      break;
    addTask([tasks[i]["author"], tasks[i]["email"], tasks[i]["task"], (tasks[i]["done"] === "1" ? "Done" : "In progress"), tasks[i]["edited"], tasks[i]["id"]]);
  }

  if (currentPage > 1 && currentPage < pagesNum) {
    correctPages();
    pageIndexes[0].classList.remove("pages__btn--selected");
    pageIndexes[1].classList.add("pages__btn--selected");
    pageIndexes[2].classList.remove("pages__btn--selected");
    showEl(pageIndexes[0]);
    showEl(pageIndexes[2]);
  } else if (pagesNum == 2 && currentPage == 2) {
    pageIndexes[0].classList.remove("pages__btn--selected");
    pageIndexes[1].classList.add("pages__btn--selected");
  }

  if (currentPage == 1) {
    hideEl(btnPrev);
    hideEl(pageIndexes[2]);
    pageIndexes[1].classList.remove("pages__btn--selected");
    pageIndexes[0].classList.add("pages__btn--selected");
  } else {
    showEl(btnPrev);
  }

  if (currentPage == pagesNum) {
    hideEl(btnNext);
    if (pagesNum > 2) {
      pageIndexes[1].classList.remove("pages__btn--selected");
      pageIndexes[2].classList.add("pages__btn--selected");
      hideEl(pageIndexes[0]);
    }
  } else {
    showEl(btnNext);
  }
}

function prevPage() {
  if (currentPage > 1) {
    currentPage--;
    changePage();
  }
}

function nextPage() {
  if (currentPage < pagesNum) {
    currentPage++;
    changePage();
  }
}

btnPrev.onclick = prevPage;
btnNext.onclick = nextPage;