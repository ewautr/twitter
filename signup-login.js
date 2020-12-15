//MODALS FUNCTIONALITY
function showSignupModal() {
  document.querySelector(".signup-modal-wrapper").style.visibility = "visible";
  document.querySelector(".signup-modal-wrapper").style.opacity = 1;

  return false;
}
function closeSignupModal() {
  document.querySelector(".signup-modal-wrapper").style.visibility = "hidden";
  document.querySelector(".signup-modal-wrapper").style.opacity = 0;

  return false;
}

//FORM VALIDATION
var timeout = null;
function validateEmail() {
  clearTimeout(timeout);
  timeout = setTimeout(() => {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    if (re.test(document.querySelector("#email").value)) {
      document.querySelector("#email-wrapper").classList.remove("invalid");
    } else {
      document.querySelector("#email-wrapper").classList.add("invalid");
    }
  }, 1000);
}
function validateInput(inputid) {
  clearTimeout(timeout);
  timeout = setTimeout(() => {
    if (
      document.querySelector(`#${inputid}`).value.length < 2 ||
      document.querySelector(`#${inputid}`).value.length > 100
    ) {
      document.querySelector(`#${inputid}-wrapper`).classList.add("invalid");
    } else {
      document.querySelector(`#${inputid}-wrapper`).classList.remove("invalid");
    }
  }, 1000);
}
function validateRepeatedPassword() {
  clearTimeout(timeout);
  timeout = setTimeout(() => {
    if (
      document.querySelector(`#repeatedPassword`).value ==
      document.querySelector(`#password`).value
    ) {
      document
        .querySelector(`#repeatedPassword-wrapper`)
        .classList.remove("invalid");
    } else {
      document
        .querySelector(`#repeatedPassword-wrapper`)
        .classList.add("invalid");
    }
  }, 1000);
}

//CREATE NEW USER
async function signup() {
  var form = event.target;
  var connection = await fetch("api/api-signup.php", {
    method: "POST",
    body: new FormData(form)
  });
  var sResponse = await connection.text();
  console.log(JSON.parse(sResponse));

  if (!connection.ok) {
    console.log("contact admin");
    return;
  }

  location.href = "/twitter/home";
}

//LOG IN USER
async function login() {
  var form = event.target;
  var connection = await fetch("api/api-login.php", {
    method: "POST",
    body: new FormData(form)
  });
  if (!connection.ok) {
    console.log("contact admin");
    return;
  }
  var sResponse = await connection.text();
  console.log(JSON.parse(sResponse));
  location.href = "/twitter/home";
}
