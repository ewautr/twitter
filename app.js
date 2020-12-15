var latestTweetId = 1;

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
async function createTweet(inputId, formId) {
  let tweet_body = document.querySelector(`#${inputId}`).value;
  if (tweet_body < 2 || tweet_body > 280) {
    return;
  }

  let data = new FormData(document.querySelector(`#${formId}`));
  let connection = await fetch("api/api-tweet.php", {
    body: data,
    method: "POST"
  });

  if (!connection.ok) {
    console.log("connection status is not ok");
    return;
  }

  let response = await connection.json();
  console.log(response);
  findHashtags(tweet_body, response.tweet_id);
  document.querySelector(`#${inputId}`).value = "";
}
//EDIT TWEET
function editTweet(event, tweetId) {
  //show edit tweet modal
  document.querySelector("#edit-modal-wrapper").style.visibility = "visible";
  document.querySelector("#edit-modal-wrapper").style.opacity = 1;
  document.querySelector(
    "#newTweetBody"
  ).value = event.target.parentNode.parentNode.querySelector("p").innerText;
  document.querySelector("#newTweetId").value = tweetId;
}
//UPDATE TWEET
async function updateTweet() {
  //validate form data
  if (
    document.querySelector("#newTweetBody").value.length < 2 ||
    document.querySelector("#newTweetBody").value.length > 280
  ) {
    return false;
  }
  let data = new FormData(document.querySelector("#edit-tweet-form"));

  let connection = await fetch("api/api-edit-tweet.php", {
    body: data,
    method: "POST"
  });

  if (!connection.ok) {
    console.log("connection is not okay");
    return;
  }

  let response = await connection.json();
  console.log(response);
}
//DELETE TWEET
async function deleteTweet(event, tweetId) {
  let form = new FormData();
  form.append("tweet_id", tweetId);
  let connection = await fetch(`api/api-delete-tweet.php`, {
    method: "POST",
    body: form
  });
  let response = await connection.json();
  console.log(response);

  //removing the tweet from all places on the website
  document.querySelectorAll(`[data-tweetid="${tweetId}"]`).forEach(element => {
    element.remove();
  });
}

//LOAD ALL TWEETS
async function getTweets() {
  let connection = await fetch(
    `api/api-get-tweets.php?latestTweetId=${latestTweetId}`
  );
  if (!connection.ok) {
    console.log("connection is not okay");
    return;
  }
  let response = await connection.json();
  for (const tweet of response) {
    latestTweetId = tweet.tweet_id;
    let likes = await getLikes(tweet.tweet_id);
    let alreadyLiked;
    likes.likedByCurrentUser == 1
      ? (alreadyLiked = "liked")
      : (alreadyLiked = "");
    let divTweet = `<section class="tweet" data-tweetId="${tweet.tweet_id}" data-userId="${tweet.user_fk}">
      <div id="more-box" class="more-box">
      <a onclick="editTweet(event,'${tweet.tweet_id}')"><svg viewBox="0 0 24 24"><path d="M12 22c-.414 0-.75-.336-.75-.75V2.75c0-.414.336-.75.75-.75s.75.336.75.75v18.5c0 .414-.336.75-.75.75zm5.14 0c-.415 0-.75-.336-.75-.75V7.89c0-.415.335-.75.75-.75s.75.335.75.75v13.36c0 .414-.337.75-.75.75zM6.86 22c-.413 0-.75-.336-.75-.75V10.973c0-.414.337-.75.75-.75s.75.336.75.75V21.25c0 .414-.335.75-.75.75z"></path></svg>edit</a>
      <a onclick="deleteTweet(event, '${tweet.tweet_id}')"><svg viewBox="0 0 24 24"><path d="M20.746 5.236h-3.75V4.25c0-1.24-1.01-2.25-2.25-2.25h-5.5c-1.24 0-2.25 1.01-2.25 2.25v.986h-3.75c-.414 0-.75.336-.75.75s.336.75.75.75h.368l1.583 13.262c.216 1.193 1.31 2.027 2.658 2.027h8.282c1.35 0 2.442-.834 2.664-2.072l1.577-13.217h.368c.414 0 .75-.336.75-.75s-.335-.75-.75-.75zM8.496 4.25c0-.413.337-.75.75-.75h5.5c.413 0 .75.337.75.75v.986h-7V4.25zm8.822 15.48c-.1.55-.664.795-1.18.795H7.854c-.517 0-1.083-.246-1.175-.75L5.126 6.735h13.74L17.32 19.732z"></path><path d="M10 17.75c.414 0 .75-.336.75-.75v-7c0-.414-.336-.75-.75-.75s-.75.336-.75.75v7c0 .414.336.75.75.75zm4 0c.414 0 .75-.336.75-.75v-7c0-.414-.336-.75-.75-.75s-.75.336-.75.75v7c0 .414.336.75.75.75z"></path></svg> delete</a>
  </div>
      <a id="more" class="more" onclick="showMoreBox()"><svg viewBox="0 0 24 24"><path disabled d="M20.207 8.147c-.39-.39-1.023-.39-1.414 0L12 14.94 5.207 8.147c-.39-.39-1.023-.39-1.414 0-.39.39-.39 1.023 0 1.414l7.5 7.5c.195.196.45.294.707.294s.512-.098.707-.293l7.5-7.5c.39-.39.39-1.022 0-1.413z"></path></svg></a>
        <img
          alt="profile image"
          class="profile-img"
          src="images/${tweet.user_imagepath}"
        />
        <div class="body">
          <div class="top">
            <h2 class="primary">${tweet.user_name} ${tweet.user_lastname}</h2>
            <h3 class="secondary">@${tweet.user_username}</h3>
            <h4 class="secondary">${tweet.tweet_created}</h4>
          </div>
          <p>
            ${tweet.tweet_body}
          </p>
          <div class="actions">
          <a href="" class="likes ${alreadyLiked}" onclick="likeTweet(event, '${tweet.tweet_id}'); return false"
              ><svg viewBox="0 0 24 24">
                <path
                  d="M12 21.638h-.014C9.403 21.59 1.95 14.856 1.95 8.478c0-3.064 2.525-5.754 5.403-5.754 2.29 0 3.83 1.58 4.646 2.73.814-1.148 2.354-2.73 4.645-2.73 2.88 0 5.404 2.69 5.404 5.755 0 6.376-7.454 13.11-10.037 13.157H12zM7.354 4.225c-2.08 0-3.903 1.988-3.903 4.255 0 5.74 7.034 11.596 8.55 11.658 1.518-.062 8.55-5.917 8.55-11.658 0-2.267-1.823-4.255-3.903-4.255-2.528 0-3.94 2.936-3.952 2.965-.23.562-1.156.562-1.387 0-.014-.03-1.425-2.965-3.954-2.965z"
                ></path>
                
              </svg>
              <span>${tweet.tweet_total_likes}</span></a
            >
            <a href="" class="comments"
              ><svg viewBox="0 0 24 24">
                <path
                  d="M14.046 2.242l-4.148-.01h-.002c-4.374 0-7.8 3.427-7.8 7.802 0 4.098 3.186 7.206 7.465 7.37v3.828c0 .108.044.286.12.403.142.225.384.347.632.347.138 0 .277-.038.402-.118.264-.168 6.473-4.14 8.088-5.506 1.902-1.61 3.04-3.97 3.043-6.312v-.017c-.006-4.367-3.43-7.787-7.8-7.788zm3.787 12.972c-1.134.96-4.862 3.405-6.772 4.643V16.67c0-.414-.335-.75-.75-.75h-.396c-3.66 0-6.318-2.476-6.318-5.886 0-3.534 2.768-6.302 6.3-6.302l4.147.01h.002c3.532 0 6.3 2.766 6.302 6.296-.003 1.91-.942 3.844-2.514 5.176z"
                ></path>
              </svg>
              <span>${tweet.tweet_total_comments}</span></a
            >
            <a href="" class="bookmarks" onclick="bookmarkTweet(event, '${tweet.tweet_id}'); return false"
              ><svg viewBox="0 0 24 24"><path d="M23.074 3.35H20.65V.927c0-.414-.337-.75-.75-.75s-.75.336-.75.75V3.35h-2.426c-.414 0-.75.337-.75.75s.336.75.75.75h2.425v2.426c0 .414.335.75.75.75s.75-.336.75-.75V4.85h2.424c.414 0 .75-.335.75-.75s-.336-.75-.75-.75zM19.9 10.744c-.415 0-.75.336-.75.75v9.782l-6.71-4.883c-.13-.095-.285-.143-.44-.143s-.31.048-.44.144l-6.71 4.883V5.6c0-.412.337-.75.75-.75h6.902c.414 0 .75-.335.75-.75s-.336-.75-.75-.75h-6.9c-1.242 0-2.25 1.01-2.25 2.25v17.15c0 .282.157.54.41.668.25.13.553.104.78-.062L12 17.928l7.458 5.43c.13.094.286.143.44.143.117 0 .234-.026.34-.08.252-.13.41-.387.41-.67V11.495c0-.414-.335-.75-.75-.75z"></path></svg>
              </a
            >
          </div>
        </div>
      </section>`;

    document
      .querySelector("#tweets")
      .insertAdjacentHTML("afterbegin", divTweet);
    if (!document.querySelector(`html[user="${tweet.user_fk}"]`)) {
      document.querySelector("#more").style.display = "none";
    }
    // if (tweet.bookmarked) {
    //   document.querySelector(".bookmarks").classList.add("bookmarked");
    // }
  }
}
setInterval(getTweets, 1000);

//LIKE TWEET
async function likeTweet(event, tweet_id) {
  if (event.target.parentNode.classList.contains("liked")) {
    dislikeTweet(event, tweet_id);
    return;
  }
  document
    .querySelectorAll(`[data-tweetid="${tweet_id}"] .likes`)
    .forEach(element => {
      element.classList.add("liked");
    });
  let likes = event.target.nextElementSibling.innerText;
  var form = new FormData();
  form.append("tweet_id", tweet_id);
  likes++;
  event.target.nextElementSibling.innerText = likes;

  var con = await fetch("api/api-like-tweet.php", {
    method: "POST",
    body: form
  });
  if (!con.ok) {
    console.log("error");
    return;
  }
  let response = await con.json();
  console.log(response);
}

//DISLIKE TWEET
async function dislikeTweet(event, tweet_id) {
  document
    .querySelectorAll(`[data-tweetid="${tweet_id}"] .likes`)
    .forEach(element => {
      element.classList.remove("liked");
    });
  let likes = event.target.nextElementSibling.innerText;
  var form = new FormData();
  form.append("tweet_id", tweet_id);
  likes--;
  event.target.nextElementSibling.innerText = likes;

  var con = await fetch("api/api-dislike-tweet.php", {
    method: "POST",
    body: form
  });
  if (!con.ok) {
    console.log("error");
    return;
  }
  let response = await con.json();
  console.log(response);
}

//GET LIKES NUMBER
async function getLikes(tweet_id) {
  let connection = await fetch(`api/api-get-likes.php?tweet_id=${tweet_id}`);
  let response = await connection.json();
  return response;
}

//SEARCH FUNCTIONALITY
async function startSearch() {
  var searchFor = document.querySelector("#searchFor").value;
  if (searchFor == "") {
    document.querySelector("#search-results").innerHTML = "";
    return;
  }
  var connection = await fetch(
    "api/api-search-by-userprofilename.php?userProfileName=" + searchFor
  );
  if (!connection.ok) {
    console.log("connection is not okay");
  }
  let result = await connection.json();
  document.querySelector("#search-results").innerHTML = "";
  result.forEach(user => {
    let sResultDiv = `
    <div class="result" data-id="${user.user_id}" onclick="showProfile(${user.user_id}); return showPage('profile')">
      <img alt="profile image" src="images/${user.user_imagepath}">
      <div>
          <p class="primary">${user.user_name} ${user.user_lastname}</p>
          <p class="secondary">@${user.user_username}</p>
      </div>
    </div>
    `;
    document
      .querySelector("#search-results")
      .insertAdjacentHTML("afterbegin", sResultDiv);
  });
}
function showSearchResults() {
  document.querySelector("#search-results").style.opacity = 1;
  document.querySelector("#search-results").innerHTML = "";
}

function hideSearchResults() {
  document.querySelector("#search-results").style.opacity = 0;
}

//FOLLOW SUGGESTIONS
getFollowSuggestions();
async function getFollowSuggestions() {
  var connection = await fetch("api/api-follow-suggestions.php");
  if (!connection.ok) {
    console.log("connection is not okay");
  }
  let result = await connection.json();
  result.forEach(user => {
    let divProfile = `
    <div class="item">
    <img src="images/${user.user_imagepath}" alt="profile image">
    <div class="user-info">
            <h4 class="primary">${user.user_name} ${user.user_lastname}</h4>
            <p class="secondary">@${user.user_username}</p>
    </div>
    <button class="btn btn-outline" onclick="followUser(event, ${user.user_id})">Follow</button>
    </div>`;
    document
      .querySelector("#follow-suggestion-items")
      .insertAdjacentHTML("afterbegin", divProfile);
  });
}

//FOLLOW USER
async function followUser(event, user_id) {
  event.target.classList.remove("btn-outline");
  event.target.innerText = "Following";
  setTimeout(() => {
    event.target.parentNode.style.display = "none";
  }, 2000);

  var form = new FormData();
  form.append("user_id", user_id);
  var connection = await fetch("api/api-follow-user.php", {
    method: "POST",
    body: form
  });
  if (!connection.ok) {
    console.log("connection is not okay");
    return;
  }
  let response = await connection.json();
  console.log(response);
}

//HASHTAGS FUNCTIONALITY
function findHashtags(tweet_body, tweet_id) {
  var regexp = /\B\#\w\w+\b/g;
  hashtags = tweet_body.match(regexp);
  if (hashtags) {
    hashtags.forEach(hashtag => {
      addHashtag(hashtag, tweet_id);
    });
    //return result;
  } else {
    return false;
  }
}
async function addHashtag(hashtag, tweet_id) {
  var form = new FormData();
  form.append("hashtag", hashtag);
  form.append("tweet_id", tweet_id);
  var connection = await fetch("api/api-hashtag.php", {
    method: "POST",
    body: form
  });
  if (!connection.ok) {
    console.log("connection is not okay");
    return;
  }
  let response = await connection.json();
  console.log(response);
}

//TRENDING HASHTAGS
getTrends();
async function getTrends() {
  var connection = await fetch("api/api-get-trends.php");
  if (!connection.ok) {
    console.log("connection is not okay");
  }
  let result = await connection.json();
  result.forEach(trend => {
    let div = `
    <div class="item">
            <p class="secondary">Trending in Denmark</p>
            <h4 class="primary">${trend.hashtag_name}</h4>
            <p class="secondary">${trend.magnitude} Tweets</p>
    </div>`;
    document.querySelector("#trends").insertAdjacentHTML("beforeend", div);
  });
}

//DISPLAYING PROFILE
function showProfile(user_id) {
  document.querySelector("#profile-tweets").innerHTML = "";
  document.querySelector("#user-info").innerHTML = "";
  getUserInfo(user_id);
  getUserTweets(user_id);
}
async function getUserInfo(user_id) {
  var form = new FormData();
  form.append("user_id", user_id);
  var connection = await fetch("api/api-get-user-profile.php", {
    method: "POST",
    body: form
  });
  if (!connection.ok) {
    console.log("connection is not okay");
  }
  let response = await connection.json();
  let divInfo = `<div>
  <h1 class="primary userFullName">${response.user_name} ${response.user_lastname}</h1>
  <h2 class="secondary userUsername">@${response.user_username}</h2>
  <h2 class="secondary userDateJoined">Joined ${response.user_created}</h2>
</div>
<div>
  <h2 class="secondary userFollowed"><b>${response.user_total_follows}</b> Following</h2>
  <h2 class="secondary userFollowers"><b>${response.user_total_followers}</b> Followers</h2>
</div>`;
  document
    .querySelector("#user-info")
    .insertAdjacentHTML("afterbegin", divInfo);

  document.querySelector("#username-heading").innerText =
    "@" + response.user_username;
  document.querySelector("#profile-imagepath").src =
    "images/" + response.user_imagepath;
  response.user_username;
}
async function getUserTweets(user_id) {
  //getting user's tweets
  var form = new FormData();
  form.append("user_id", user_id);
  var connection = await fetch("api/api-get-user-tweets.php", {
    method: "POST",
    body: form
  });
  if (connection.status == 404) {
    let response = await connection.json();
    let divTweet = `<h3>${response.message}</h3>`;
    document
      .querySelector("#profile-tweets")
      .insertAdjacentHTML("afterbegin", divTweet);
    return;
  }
  let response = await connection.json();
  for (const tweet of response) {
    let likes = await getLikes(tweet.tweet_id);
    let alreadyLiked;
    likes.likedByCurrentUser == 1
      ? (alreadyLiked = "liked")
      : (alreadyLiked = "");
    let divTweet = `<section class="tweet" data-tweetId="${tweet.tweet_id}" data-userId="${tweet.user_fk}">
    <div id="more-box" class="more-box">
    <a onclick="editTweet(event,'${tweet.tweet_id}')"><svg viewBox="0 0 24 24"><path d="M12 22c-.414 0-.75-.336-.75-.75V2.75c0-.414.336-.75.75-.75s.75.336.75.75v18.5c0 .414-.336.75-.75.75zm5.14 0c-.415 0-.75-.336-.75-.75V7.89c0-.415.335-.75.75-.75s.75.335.75.75v13.36c0 .414-.337.75-.75.75zM6.86 22c-.413 0-.75-.336-.75-.75V10.973c0-.414.337-.75.75-.75s.75.336.75.75V21.25c0 .414-.335.75-.75.75z"></path></svg>edit</a>
    <a onclick="deleteTweet(event, '${tweet.tweet_id}')"><svg viewBox="0 0 24 24"><path d="M20.746 5.236h-3.75V4.25c0-1.24-1.01-2.25-2.25-2.25h-5.5c-1.24 0-2.25 1.01-2.25 2.25v.986h-3.75c-.414 0-.75.336-.75.75s.336.75.75.75h.368l1.583 13.262c.216 1.193 1.31 2.027 2.658 2.027h8.282c1.35 0 2.442-.834 2.664-2.072l1.577-13.217h.368c.414 0 .75-.336.75-.75s-.335-.75-.75-.75zM8.496 4.25c0-.413.337-.75.75-.75h5.5c.413 0 .75.337.75.75v.986h-7V4.25zm8.822 15.48c-.1.55-.664.795-1.18.795H7.854c-.517 0-1.083-.246-1.175-.75L5.126 6.735h13.74L17.32 19.732z"></path><path d="M10 17.75c.414 0 .75-.336.75-.75v-7c0-.414-.336-.75-.75-.75s-.75.336-.75.75v7c0 .414.336.75.75.75zm4 0c.414 0 .75-.336.75-.75v-7c0-.414-.336-.75-.75-.75s-.75.336-.75.75v7c0 .414.336.75.75.75z"></path></svg> delete</a>
</div>
    <a id="more" class="more" onclick="showMoreBox()"><svg viewBox="0 0 24 24"><path disabled d="M20.207 8.147c-.39-.39-1.023-.39-1.414 0L12 14.94 5.207 8.147c-.39-.39-1.023-.39-1.414 0-.39.39-.39 1.023 0 1.414l7.5 7.5c.195.196.45.294.707.294s.512-.098.707-.293l7.5-7.5c.39-.39.39-1.022 0-1.413z"></path></svg></a>
      <img
        alt="profile image"
        class="profile-img"
        src="images/${tweet.user_imagepath}"
      />
      <div class="body">
        <div class="top">
          <h2 class="primary">${tweet.user_name} ${tweet.user_lastname}</h2>
          <h3 class="secondary">@${tweet.user_username}</h3>
          <h4 class="secondary">${tweet.tweet_created}</h4>
        </div>
        <p>
          ${tweet.tweet_body}
        </p>
        <div class="actions">
        <a href="" class="likes " onclick="likeTweet(event, '${tweet.tweet_id}'); return false"
            ><svg viewBox="0 0 24 24">
              <path
                d="M12 21.638h-.014C9.403 21.59 1.95 14.856 1.95 8.478c0-3.064 2.525-5.754 5.403-5.754 2.29 0 3.83 1.58 4.646 2.73.814-1.148 2.354-2.73 4.645-2.73 2.88 0 5.404 2.69 5.404 5.755 0 6.376-7.454 13.11-10.037 13.157H12zM7.354 4.225c-2.08 0-3.903 1.988-3.903 4.255 0 5.74 7.034 11.596 8.55 11.658 1.518-.062 8.55-5.917 8.55-11.658 0-2.267-1.823-4.255-3.903-4.255-2.528 0-3.94 2.936-3.952 2.965-.23.562-1.156.562-1.387 0-.014-.03-1.425-2.965-3.954-2.965z"
              ></path>
              
            </svg>
            <span>${tweet.tweet_total_likes}</span></a
          >
          <a href="" class="comments"
            ><svg viewBox="0 0 24 24">
              <path
                d="M14.046 2.242l-4.148-.01h-.002c-4.374 0-7.8 3.427-7.8 7.802 0 4.098 3.186 7.206 7.465 7.37v3.828c0 .108.044.286.12.403.142.225.384.347.632.347.138 0 .277-.038.402-.118.264-.168 6.473-4.14 8.088-5.506 1.902-1.61 3.04-3.97 3.043-6.312v-.017c-.006-4.367-3.43-7.787-7.8-7.788zm3.787 12.972c-1.134.96-4.862 3.405-6.772 4.643V16.67c0-.414-.335-.75-.75-.75h-.396c-3.66 0-6.318-2.476-6.318-5.886 0-3.534 2.768-6.302 6.3-6.302l4.147.01h.002c3.532 0 6.3 2.766 6.302 6.296-.003 1.91-.942 3.844-2.514 5.176z"
              ></path>
            </svg>
            <span>${tweet.tweet_total_comments}</span></a
          >
          <a href="" class="bookmarks" onclick="bookmarkTweet(event, '${tweet.tweet_id}'); return false"
            ><svg viewBox="0 0 24 24"><path d="M23.074 3.35H20.65V.927c0-.414-.337-.75-.75-.75s-.75.336-.75.75V3.35h-2.426c-.414 0-.75.337-.75.75s.336.75.75.75h2.425v2.426c0 .414.335.75.75.75s.75-.336.75-.75V4.85h2.424c.414 0 .75-.335.75-.75s-.336-.75-.75-.75zM19.9 10.744c-.415 0-.75.336-.75.75v9.782l-6.71-4.883c-.13-.095-.285-.143-.44-.143s-.31.048-.44.144l-6.71 4.883V5.6c0-.412.337-.75.75-.75h6.902c.414 0 .75-.335.75-.75s-.336-.75-.75-.75h-6.9c-1.242 0-2.25 1.01-2.25 2.25v17.15c0 .282.157.54.41.668.25.13.553.104.78-.062L12 17.928l7.458 5.43c.13.094.286.143.44.143.117 0 .234-.026.34-.08.252-.13.41-.387.41-.67V11.495c0-.414-.335-.75-.75-.75z"></path></svg>
            </a
          >
          
        </div>
      </div>
    </section>`;
    document
      .querySelector("#profile-tweets")
      .insertAdjacentHTML("afterbegin", divTweet);
  }
}
