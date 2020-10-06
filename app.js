//ROUTING
function showPage(pageId) {
  document.querySelectorAll("a").forEach(a => {
    a.classList.remove("active");
  });
  event.target.classList.add("active");

  document.querySelectorAll(".subpage").forEach(subpage => {
    subpage.style.display = "none";
  });
  document.getElementById(pageId).style.display = "block";
  return false;
}
document.getElementById("home").style.display = "block";

//MODALS FUNCTIONALITY
function showTweetModal() {
  document.querySelector(".post-tweet-modal-wrapper").style.visibility =
    "visible";
  document.querySelector(".post-tweet-modal-wrapper").style.opacity = "1";
  return false;
}
function closeTweetModal() {
  document.querySelector(".post-tweet-modal-wrapper").style.opacity = "0";
  document.querySelector(".post-tweet-modal-wrapper").style.visibility =
    "hidden";
  return false;
}
function showMoreBox() {
  event.target.parentNode.previousElementSibling.classList.toggle("show");
}

//CREATE TWEET
async function tweet() {
  form = event.target;
  var connection = await fetch("api/api-tweet.php", {
    method: "POST",
    body: new FormData(form)
  });
  var sResponse = await connection.text();
  console.log(JSON.parse(sResponse));
  if (connection.status != 200) {
    console.log("contact admin");
    return;
  }
}
