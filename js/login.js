document.getElementsByClassName("form__inputs")[0].onsubmit = function(e) {
  e.preventDefault();
  var req = "";

  var first = false;
  for (var input of document.getElementsByClassName("form__input")) {
    if (first)
      req += "&";
    first = true;
    req += input.name + "=" + input.value;
  }

  ajax({
    url: this.action,
    method: "POST",
    request: req,
    callback: function(response) {
      if (response[0] === "error")
        ShowPopup(response[1], response[2], true);
      else if (response[0] === "result") {
        if (response[1] === "true")
          window.location.replace("./");
        else
          ShowPopup("Authorization Error", "Such user has not been found in allowed users", true);
      }
    }
  });
}