var content = document.getElementsByClassName("content")[0];

function ShowPopup(title, text, error) {
  var popupTitle = document.createElement("div");
  popupTitle.innerHTML = title;
  popupTitle.setAttribute("class", "popup__title");
  var popupBody = document.createElement("div");
  popupBody.innerHTML = text;
  popupBody.setAttribute("class", "popup__body");
  var popup = document.createElement("div");
  popup.className = "popup popup--" + (error ? "error" : "msg");
  popup.appendChild(popupTitle);
  popup.appendChild(popupBody);

  content.appendChild(popup);
  setTimeout(function() {
    popup.style.top = "120px";
    popup.style.opacity = 1;
  }, 0);

  setTimeout(function() {
    popup.style.top = "110px";
    popup.style.opacity = 0;
    setTimeout(function() {
      content.removeChild(popup);
    }, 200);
  }, 2500);
}

function ajax(args) {
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && xhr.status == 200) {
      args.callback(this.responseText.split("\n"));
    }
  }

  xhr.open(args.method, args.url, true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.send(args.method == "POST" ? args.request : null);
}