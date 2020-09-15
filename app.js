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

//LOAD ALL TWEETS
var latestReceivedTweetId = -1;
var latestUsersTweetId = -1;
var latestBookmarkedTweetId = -1;
//to the home page
setInterval(async function getTweets() {
  let connection = await fetch(
    `api/api-get-all-tweets.php?latestReceivedTweetId=${latestReceivedTweetId}`
  );
  if (connection.status != 200) {
    console.log("error");
  }
  let sResponse = await connection.text();
  let jResponse = JSON.parse(sResponse);
  jResponse.forEach(tweet => {
    latestReceivedTweetId++;
    let divTweet = `<section class="tweet" data-tweetId="${tweet.id}">
    <div id="more-box" class="more-box">
    <a onclick="editTweet('${tweet.id}')"><svg viewBox="0 0 24 24"><path d="M12 22c-.414 0-.75-.336-.75-.75V2.75c0-.414.336-.75.75-.75s.75.336.75.75v18.5c0 .414-.336.75-.75.75zm5.14 0c-.415 0-.75-.336-.75-.75V7.89c0-.415.335-.75.75-.75s.75.335.75.75v13.36c0 .414-.337.75-.75.75zM6.86 22c-.413 0-.75-.336-.75-.75V10.973c0-.414.337-.75.75-.75s.75.336.75.75V21.25c0 .414-.335.75-.75.75z"></path></svg>edit</a>
    <a onclick="deleteTweet(event, '${tweet.id}')"><svg viewBox="0 0 24 24"><path d="M20.746 5.236h-3.75V4.25c0-1.24-1.01-2.25-2.25-2.25h-5.5c-1.24 0-2.25 1.01-2.25 2.25v.986h-3.75c-.414 0-.75.336-.75.75s.336.75.75.75h.368l1.583 13.262c.216 1.193 1.31 2.027 2.658 2.027h8.282c1.35 0 2.442-.834 2.664-2.072l1.577-13.217h.368c.414 0 .75-.336.75-.75s-.335-.75-.75-.75zM8.496 4.25c0-.413.337-.75.75-.75h5.5c.413 0 .75.337.75.75v.986h-7V4.25zm8.822 15.48c-.1.55-.664.795-1.18.795H7.854c-.517 0-1.083-.246-1.175-.75L5.126 6.735h13.74L17.32 19.732z"></path><path d="M10 17.75c.414 0 .75-.336.75-.75v-7c0-.414-.336-.75-.75-.75s-.75.336-.75.75v7c0 .414.336.75.75.75zm4 0c.414 0 .75-.336.75-.75v-7c0-.414-.336-.75-.75-.75s-.75.336-.75.75v7c0 .414.336.75.75.75z"></path></svg> delete</a>
</div>
    <a id="more" class="more" onclick="showMoreBox()"><svg viewBox="0 0 24 24"><path disabled d="M20.207 8.147c-.39-.39-1.023-.39-1.414 0L12 14.94 5.207 8.147c-.39-.39-1.023-.39-1.414 0-.39.39-.39 1.023 0 1.414l7.5 7.5c.195.196.45.294.707.294s.512-.098.707-.293l7.5-7.5c.39-.39.39-1.022 0-1.413z"></path></svg></a>
      <img
        alt="profile image"
        class="profile-img"
        src="https://abs.twimg.com/sticky/default_profile_images/default_profile_400x400.png"
      />
      <div class="body">
        <div class="top">
          <h2 class="primary">${tweet.username}</h2>
          <h3 class="secondary">@${tweet.username}</h3>
          <h4 class="secondary">25 min</h4>
        </div>
        <p>
          ${tweet.body}
        </p>
        <div class="actions">
          <a href="" class="comments"
            ><svg viewBox="0 0 24 24">
              <path
                d="M14.046 2.242l-4.148-.01h-.002c-4.374 0-7.8 3.427-7.8 7.802 0 4.098 3.186 7.206 7.465 7.37v3.828c0 .108.044.286.12.403.142.225.384.347.632.347.138 0 .277-.038.402-.118.264-.168 6.473-4.14 8.088-5.506 1.902-1.61 3.04-3.97 3.043-6.312v-.017c-.006-4.367-3.43-7.787-7.8-7.788zm3.787 12.972c-1.134.96-4.862 3.405-6.772 4.643V16.67c0-.414-.335-.75-.75-.75h-.396c-3.66 0-6.318-2.476-6.318-5.886 0-3.534 2.768-6.302 6.3-6.302l4.147.01h.002c3.532 0 6.3 2.766 6.302 6.296-.003 1.91-.942 3.844-2.514 5.176z"
              ></path>
            </svg>
            23</a
          >
          <a href="" class="retweets"
            ><svg viewBox="0 0 24 24">
              <path
                d="M23.77 15.67c-.292-.293-.767-.293-1.06 0l-2.22 2.22V7.65c0-2.068-1.683-3.75-3.75-3.75h-5.85c-.414 0-.75.336-.75.75s.336.75.75.75h5.85c1.24 0 2.25 1.01 2.25 2.25v10.24l-2.22-2.22c-.293-.293-.768-.293-1.06 0s-.294.768 0 1.06l3.5 3.5c.145.147.337.22.53.22s.383-.072.53-.22l3.5-3.5c.294-.292.294-.767 0-1.06zm-10.66 3.28H7.26c-1.24 0-2.25-1.01-2.25-2.25V6.46l2.22 2.22c.148.147.34.22.532.22s.384-.073.53-.22c.293-.293.293-.768 0-1.06l-3.5-3.5c-.293-.294-.768-.294-1.06 0l-3.5 3.5c-.294.292-.294.767 0 1.06s.767.293 1.06 0l2.22-2.22V16.7c0 2.068 1.683 3.75 3.75 3.75h5.85c.414 0 .75-.336.75-.75s-.337-.75-.75-.75z"
              ></path>
            </svg>
            3</a
          >
          <a href="" class="likes"
            ><svg viewBox="0 0 24 24">
              <path
                d="M12 21.638h-.014C9.403 21.59 1.95 14.856 1.95 8.478c0-3.064 2.525-5.754 5.403-5.754 2.29 0 3.83 1.58 4.646 2.73.814-1.148 2.354-2.73 4.645-2.73 2.88 0 5.404 2.69 5.404 5.755 0 6.376-7.454 13.11-10.037 13.157H12zM7.354 4.225c-2.08 0-3.903 1.988-3.903 4.255 0 5.74 7.034 11.596 8.55 11.658 1.518-.062 8.55-5.917 8.55-11.658 0-2.267-1.823-4.255-3.903-4.255-2.528 0-3.94 2.936-3.952 2.965-.23.562-1.156.562-1.387 0-.014-.03-1.425-2.965-3.954-2.965z"
              ></path>
            </svg>
            4</a
          >
          <a href="" class="bookmarks" onclick="bookmarkTweet(event, '${tweet.id}'); return false"
            ><svg viewBox="0 0 24 24"><path d="M23.074 3.35H20.65V.927c0-.414-.337-.75-.75-.75s-.75.336-.75.75V3.35h-2.426c-.414 0-.75.337-.75.75s.336.75.75.75h2.425v2.426c0 .414.335.75.75.75s.75-.336.75-.75V4.85h2.424c.414 0 .75-.335.75-.75s-.336-.75-.75-.75zM19.9 10.744c-.415 0-.75.336-.75.75v9.782l-6.71-4.883c-.13-.095-.285-.143-.44-.143s-.31.048-.44.144l-6.71 4.883V5.6c0-.412.337-.75.75-.75h6.902c.414 0 .75-.335.75-.75s-.336-.75-.75-.75h-6.9c-1.242 0-2.25 1.01-2.25 2.25v17.15c0 .282.157.54.41.668.25.13.553.104.78-.062L12 17.928l7.458 5.43c.13.094.286.143.44.143.117 0 .234-.026.34-.08.252-.13.41-.387.41-.67V11.495c0-.414-.335-.75-.75-.75z"></path></svg>
            </a
          >
        </div>
      </div>
    </section>`;

    document
      .querySelector("#tweets")
      .insertAdjacentHTML("afterbegin", divTweet);
    if (!tweet.editable) {
      document.querySelector("#more").style.display = "none";
    }
    if (tweet.bookmarked) {
      document.querySelector(".bookmarks").classList.add("bookmarked");
    }
  });
}, 1000);
//to the bookmark page
setInterval(async function getBookmarkedTweets() {
  let connection = await fetch(
    `api/api-get-bookmarked-tweets.php?latestBookmarkedTweetId=${latestBookmarkedTweetId}`
  );
  if (connection.status != 200) {
    console.log("error");
  }
  let sResponse = await connection.text();
  let jResponse = JSON.parse(sResponse);

  jResponse.forEach(tweet => {
    latestBookmarkedTweetId++;
    let divTweet = `<section class="tweet" data-tweetId="${tweet.id}">
    <div id="more-box" class="more-box">
    <a onclick="editTweet('${tweet.id}')"><svg viewBox="0 0 24 24"><path d="M12 22c-.414 0-.75-.336-.75-.75V2.75c0-.414.336-.75.75-.75s.75.336.75.75v18.5c0 .414-.336.75-.75.75zm5.14 0c-.415 0-.75-.336-.75-.75V7.89c0-.415.335-.75.75-.75s.75.335.75.75v13.36c0 .414-.337.75-.75.75zM6.86 22c-.413 0-.75-.336-.75-.75V10.973c0-.414.337-.75.75-.75s.75.336.75.75V21.25c0 .414-.335.75-.75.75z"></path></svg>edit</a>
    <a onclick="deleteTweet(event, '${tweet.id}')"><svg viewBox="0 0 24 24"><path d="M20.746 5.236h-3.75V4.25c0-1.24-1.01-2.25-2.25-2.25h-5.5c-1.24 0-2.25 1.01-2.25 2.25v.986h-3.75c-.414 0-.75.336-.75.75s.336.75.75.75h.368l1.583 13.262c.216 1.193 1.31 2.027 2.658 2.027h8.282c1.35 0 2.442-.834 2.664-2.072l1.577-13.217h.368c.414 0 .75-.336.75-.75s-.335-.75-.75-.75zM8.496 4.25c0-.413.337-.75.75-.75h5.5c.413 0 .75.337.75.75v.986h-7V4.25zm8.822 15.48c-.1.55-.664.795-1.18.795H7.854c-.517 0-1.083-.246-1.175-.75L5.126 6.735h13.74L17.32 19.732z"></path><path d="M10 17.75c.414 0 .75-.336.75-.75v-7c0-.414-.336-.75-.75-.75s-.75.336-.75.75v7c0 .414.336.75.75.75zm4 0c.414 0 .75-.336.75-.75v-7c0-.414-.336-.75-.75-.75s-.75.336-.75.75v7c0 .414.336.75.75.75z"></path></svg> delete</a>
    </div>
    <a id="more" class="more" onclick="showMoreBox()"><svg viewBox="0 0 24 24"><path disabled d="M20.207 8.147c-.39-.39-1.023-.39-1.414 0L12 14.94 5.207 8.147c-.39-.39-1.023-.39-1.414 0-.39.39-.39 1.023 0 1.414l7.5 7.5c.195.196.45.294.707.294s.512-.098.707-.293l7.5-7.5c.39-.39.39-1.022 0-1.413z"></path></svg></a>
      <img
        alt="profile image"
        class="profile-img"
        src="https://abs.twimg.com/sticky/default_profile_images/default_profile_400x400.png"
      />
      <div class="body">
        <div class="top">
          <h2 class="primary">${tweet.username}</h2>
          <h3 class="secondary">@${tweet.username}</h3>
          <h4 class="secondary">25 min</h4>
        </div>
        <p>
          ${tweet.body}
        </p>
        <div class="actions">
          <a href="" class="comments"
            ><svg viewBox="0 0 24 24">
              <path
                d="M14.046 2.242l-4.148-.01h-.002c-4.374 0-7.8 3.427-7.8 7.802 0 4.098 3.186 7.206 7.465 7.37v3.828c0 .108.044.286.12.403.142.225.384.347.632.347.138 0 .277-.038.402-.118.264-.168 6.473-4.14 8.088-5.506 1.902-1.61 3.04-3.97 3.043-6.312v-.017c-.006-4.367-3.43-7.787-7.8-7.788zm3.787 12.972c-1.134.96-4.862 3.405-6.772 4.643V16.67c0-.414-.335-.75-.75-.75h-.396c-3.66 0-6.318-2.476-6.318-5.886 0-3.534 2.768-6.302 6.3-6.302l4.147.01h.002c3.532 0 6.3 2.766 6.302 6.296-.003 1.91-.942 3.844-2.514 5.176z"
              ></path>
            </svg>
            23</a
          >
          <a href="" class="retweets"
            ><svg viewBox="0 0 24 24">
              <path
                d="M23.77 15.67c-.292-.293-.767-.293-1.06 0l-2.22 2.22V7.65c0-2.068-1.683-3.75-3.75-3.75h-5.85c-.414 0-.75.336-.75.75s.336.75.75.75h5.85c1.24 0 2.25 1.01 2.25 2.25v10.24l-2.22-2.22c-.293-.293-.768-.293-1.06 0s-.294.768 0 1.06l3.5 3.5c.145.147.337.22.53.22s.383-.072.53-.22l3.5-3.5c.294-.292.294-.767 0-1.06zm-10.66 3.28H7.26c-1.24 0-2.25-1.01-2.25-2.25V6.46l2.22 2.22c.148.147.34.22.532.22s.384-.073.53-.22c.293-.293.293-.768 0-1.06l-3.5-3.5c-.293-.294-.768-.294-1.06 0l-3.5 3.5c-.294.292-.294.767 0 1.06s.767.293 1.06 0l2.22-2.22V16.7c0 2.068 1.683 3.75 3.75 3.75h5.85c.414 0 .75-.336.75-.75s-.337-.75-.75-.75z"
              ></path>
            </svg>
            3</a
          >
          <a href="" class="likes"
            ><svg viewBox="0 0 24 24">
              <path
                d="M12 21.638h-.014C9.403 21.59 1.95 14.856 1.95 8.478c0-3.064 2.525-5.754 5.403-5.754 2.29 0 3.83 1.58 4.646 2.73.814-1.148 2.354-2.73 4.645-2.73 2.88 0 5.404 2.69 5.404 5.755 0 6.376-7.454 13.11-10.037 13.157H12zM7.354 4.225c-2.08 0-3.903 1.988-3.903 4.255 0 5.74 7.034 11.596 8.55 11.658 1.518-.062 8.55-5.917 8.55-11.658 0-2.267-1.823-4.255-3.903-4.255-2.528 0-3.94 2.936-3.952 2.965-.23.562-1.156.562-1.387 0-.014-.03-1.425-2.965-3.954-2.965z"
              ></path>
            </svg>
            4</a
          >
          <a href="" class="bookmarks bookmarked" onclick="bookmarkTweet(event, '${tweet.id}'); return false"
            ><svg viewBox="0 0 24 24"><path d="M23.074 3.35H20.65V.927c0-.414-.337-.75-.75-.75s-.75.336-.75.75V3.35h-2.426c-.414 0-.75.337-.75.75s.336.75.75.75h2.425v2.426c0 .414.335.75.75.75s.75-.336.75-.75V4.85h2.424c.414 0 .75-.335.75-.75s-.336-.75-.75-.75zM19.9 10.744c-.415 0-.75.336-.75.75v9.782l-6.71-4.883c-.13-.095-.285-.143-.44-.143s-.31.048-.44.144l-6.71 4.883V5.6c0-.412.337-.75.75-.75h6.902c.414 0 .75-.335.75-.75s-.336-.75-.75-.75h-6.9c-1.242 0-2.25 1.01-2.25 2.25v17.15c0 .282.157.54.41.668.25.13.553.104.78-.062L12 17.928l7.458 5.43c.13.094.286.143.44.143.117 0 .234-.026.34-.08.252-.13.41-.387.41-.67V11.495c0-.414-.335-.75-.75-.75z"></path></svg>
            </a
          >
        </div>
      </div>
    </section>`;

    document
      .querySelector("#bookmarked-tweets")
      .insertAdjacentHTML("afterbegin", divTweet);
  });
}, 1000);
//to the profile page
setInterval(async function getUserTweets() {
  let connection = await fetch(
    `api/api-get-user-tweets.php?latestReceivedTweetId=${latestUsersTweetId}`
  );
  if (connection.status != 200) {
    console.log("error");
  }
  let sResponse = await connection.text();
  let jResponse = JSON.parse(sResponse);

  jResponse.forEach(tweet => {
    latestUsersTweetId++;
    let bookmarkStatus = "";
    if (tweet.bookmarked) {
      bookmarkStatus = "bookmarked";
      //document.querySelector(".bookmarks").classList.add("bookmarked");
    }
    let divTweet = `<section class="tweet" data-tweetId="${tweet.id}">
    <div id="more-box" class="more-box">
    <a onclick="editTweet('${tweet.id}')"><svg viewBox="0 0 24 24"><path d="M12 22c-.414 0-.75-.336-.75-.75V2.75c0-.414.336-.75.75-.75s.75.336.75.75v18.5c0 .414-.336.75-.75.75zm5.14 0c-.415 0-.75-.336-.75-.75V7.89c0-.415.335-.75.75-.75s.75.335.75.75v13.36c0 .414-.337.75-.75.75zM6.86 22c-.413 0-.75-.336-.75-.75V10.973c0-.414.337-.75.75-.75s.75.336.75.75V21.25c0 .414-.335.75-.75.75z"></path></svg>edit</a>
    <a onclick="deleteTweet(event, '${tweet.id}')"><svg viewBox="0 0 24 24"><path d="M20.746 5.236h-3.75V4.25c0-1.24-1.01-2.25-2.25-2.25h-5.5c-1.24 0-2.25 1.01-2.25 2.25v.986h-3.75c-.414 0-.75.336-.75.75s.336.75.75.75h.368l1.583 13.262c.216 1.193 1.31 2.027 2.658 2.027h8.282c1.35 0 2.442-.834 2.664-2.072l1.577-13.217h.368c.414 0 .75-.336.75-.75s-.335-.75-.75-.75zM8.496 4.25c0-.413.337-.75.75-.75h5.5c.413 0 .75.337.75.75v.986h-7V4.25zm8.822 15.48c-.1.55-.664.795-1.18.795H7.854c-.517 0-1.083-.246-1.175-.75L5.126 6.735h13.74L17.32 19.732z"></path><path d="M10 17.75c.414 0 .75-.336.75-.75v-7c0-.414-.336-.75-.75-.75s-.75.336-.75.75v7c0 .414.336.75.75.75zm4 0c.414 0 .75-.336.75-.75v-7c0-.414-.336-.75-.75-.75s-.75.336-.75.75v7c0 .414.336.75.75.75z"></path></svg> delete</a>
</div>
    <a id="more" class="more" onclick="showMoreBox()"><svg viewBox="0 0 24 24"><path disabled d="M20.207 8.147c-.39-.39-1.023-.39-1.414 0L12 14.94 5.207 8.147c-.39-.39-1.023-.39-1.414 0-.39.39-.39 1.023 0 1.414l7.5 7.5c.195.196.45.294.707.294s.512-.098.707-.293l7.5-7.5c.39-.39.39-1.022 0-1.413z"></path></svg></a>
      <img
        alt="profile image"
        class="profile-img"
        src="https://abs.twimg.com/sticky/default_profile_images/default_profile_400x400.png"
      />
      <div class="body">
        <div class="top">
          <h2 class="primary">${tweet.username}</h2>
          <h3 class="secondary">@${tweet.username}</h3>
          <h4 class="secondary">25 min</h4>
        </div>
        <p>
          ${tweet.body}
        </p>
        <div class="actions">
          <a href="" class="comments"
            ><svg viewBox="0 0 24 24">
              <path
                d="M14.046 2.242l-4.148-.01h-.002c-4.374 0-7.8 3.427-7.8 7.802 0 4.098 3.186 7.206 7.465 7.37v3.828c0 .108.044.286.12.403.142.225.384.347.632.347.138 0 .277-.038.402-.118.264-.168 6.473-4.14 8.088-5.506 1.902-1.61 3.04-3.97 3.043-6.312v-.017c-.006-4.367-3.43-7.787-7.8-7.788zm3.787 12.972c-1.134.96-4.862 3.405-6.772 4.643V16.67c0-.414-.335-.75-.75-.75h-.396c-3.66 0-6.318-2.476-6.318-5.886 0-3.534 2.768-6.302 6.3-6.302l4.147.01h.002c3.532 0 6.3 2.766 6.302 6.296-.003 1.91-.942 3.844-2.514 5.176z"
              ></path>
            </svg>
            23</a
          >
          <a href="" class="retweets"
            ><svg viewBox="0 0 24 24">
              <path
                d="M23.77 15.67c-.292-.293-.767-.293-1.06 0l-2.22 2.22V7.65c0-2.068-1.683-3.75-3.75-3.75h-5.85c-.414 0-.75.336-.75.75s.336.75.75.75h5.85c1.24 0 2.25 1.01 2.25 2.25v10.24l-2.22-2.22c-.293-.293-.768-.293-1.06 0s-.294.768 0 1.06l3.5 3.5c.145.147.337.22.53.22s.383-.072.53-.22l3.5-3.5c.294-.292.294-.767 0-1.06zm-10.66 3.28H7.26c-1.24 0-2.25-1.01-2.25-2.25V6.46l2.22 2.22c.148.147.34.22.532.22s.384-.073.53-.22c.293-.293.293-.768 0-1.06l-3.5-3.5c-.293-.294-.768-.294-1.06 0l-3.5 3.5c-.294.292-.294.767 0 1.06s.767.293 1.06 0l2.22-2.22V16.7c0 2.068 1.683 3.75 3.75 3.75h5.85c.414 0 .75-.336.75-.75s-.337-.75-.75-.75z"
              ></path>
            </svg>
            3</a
          >
          <a href="" class="likes"
            ><svg viewBox="0 0 24 24">
              <path
                d="M12 21.638h-.014C9.403 21.59 1.95 14.856 1.95 8.478c0-3.064 2.525-5.754 5.403-5.754 2.29 0 3.83 1.58 4.646 2.73.814-1.148 2.354-2.73 4.645-2.73 2.88 0 5.404 2.69 5.404 5.755 0 6.376-7.454 13.11-10.037 13.157H12zM7.354 4.225c-2.08 0-3.903 1.988-3.903 4.255 0 5.74 7.034 11.596 8.55 11.658 1.518-.062 8.55-5.917 8.55-11.658 0-2.267-1.823-4.255-3.903-4.255-2.528 0-3.94 2.936-3.952 2.965-.23.562-1.156.562-1.387 0-.014-.03-1.425-2.965-3.954-2.965z"
              ></path>
            </svg>
            4</a
          >
          <a href="" class="bookmarks ${bookmarkStatus}" onclick="bookmarkTweet(event, '${tweet.id}'); return false"
            ><svg viewBox="0 0 24 24"><path d="M23.074 3.35H20.65V.927c0-.414-.337-.75-.75-.75s-.75.336-.75.75V3.35h-2.426c-.414 0-.75.337-.75.75s.336.75.75.75h2.425v2.426c0 .414.335.75.75.75s.75-.336.75-.75V4.85h2.424c.414 0 .75-.335.75-.75s-.336-.75-.75-.75zM19.9 10.744c-.415 0-.75.336-.75.75v9.782l-6.71-4.883c-.13-.095-.285-.143-.44-.143s-.31.048-.44.144l-6.71 4.883V5.6c0-.412.337-.75.75-.75h6.902c.414 0 .75-.335.75-.75s-.336-.75-.75-.75h-6.9c-1.242 0-2.25 1.01-2.25 2.25v17.15c0 .282.157.54.41.668.25.13.553.104.78-.062L12 17.928l7.458 5.43c.13.094.286.143.44.143.117 0 .234-.026.34-.08.252-.13.41-.387.41-.67V11.495c0-.414-.335-.75-.75-.75z"></path></svg>
            </a
          >
        </div>
      </div>
    </section>`;

    document
      .querySelector("#profile-tweets")
      .insertAdjacentHTML("afterbegin", divTweet);
  });
}, 1000);

//CREATE TWEET
async function createTweet(inputId, formId) {
  if (
    document.querySelector(`#${inputId}`).value < 2 ||
    document.querySelector(`#${inputId}`).value > 280
  ) {
    return;
  }

  let data = new FormData(document.querySelector(`#${formId}`));
  let connection = await fetch("api/api-create-tweet.php", {
    body: data,
    method: "POST"
  });

  if (connection.status != 200) {
    console.log("error");
  }

  let sResponse = await connection.text();
  document.querySelector(`#${inputId}`).value = "";
}

//DELETE TWEET
async function deleteTweet(event, tweetId) {
  let connection = await fetch(`api/api-delete-tweet.php?tweetId=${tweetId}`);
  let sResponse = await connection.text();

  //event.target.parentNode.parentNode.remove();
  //removing the tweet from all places on the website
  document.querySelectorAll(`[data-tweetid="${tweetId}"]`).forEach(element => {
    element.remove();
  });
}

//EDIT TWEET
async function editTweet(tweetId) {
  //get tweet data
  let connection = await fetch(`api/api-get-tweet.php?tweetId=${tweetId}`);
  if (connection.status != 200) {
    console.log("error");
  }
  let sResponse = await connection.text();
  let jResponse = JSON.parse(sResponse);
  console.log(jResponse);

  //show edit tweet modal
  document.querySelector("#edit-modal-wrapper").style.visibility = "visible";
  document.querySelector("#edit-modal-wrapper").style.opacity = 1;

  //populate modal with data
  document.querySelector("#newTweetBody").value = jResponse.body;
  document.querySelector("#newTweetId").value = jResponse.id;
}
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

  let sResponse = await connection.text();
  let jResponse = JSON.parse(sResponse);
  console.log(jResponse);
}

//WHO TO FOLLOW
async function showWhoToFollow() {
  let connection = await fetch("api/api-get-suggested-users.php");
  if (connection.status != 200) {
    console.log("error");
  }
  let sResponse = await connection.text();
  let jResponse = JSON.parse(sResponse);
  let numberOfUsersToShow;

  // if the number of users is smaller than 3, display all of them
  jResponse.length > 3
    ? (numberOfUsersToShow = 3)
    : (numberOfUsersToShow = jResponse.length);

  for (i = 0; i < numberOfUsersToShow; i++) {
    let divProfile = `
    <div class="item">
    <img src="https://abs.twimg.com/sticky/default_profile_images/default_profile_400x400.png" alt="profile image">
    <div class="user-info">
            <h4 class="primary">${jResponse[i].username}</h4>
            <p class="secondary">@${jResponse[i].username}</p>
    </div>
    <button class="btn btn-outline">Follow</button>
    </div>`;
    document
      .querySelector("#follow-suggestion-items")
      .insertAdjacentHTML("afterbegin", divProfile);
  }
}
showWhoToFollow();

//BOKMARKING TWEET
async function bookmarkTweet(event, tweetId) {
  let connection = await fetch(
    `api/api-bookmark-tweet.php?bookmarkedTweetId=${tweetId}`
  );
  let sResponse = await connection.text();
  let jResponse = JSON.parse(sResponse);
  console.log(jResponse);

  //styling the bookmark button
  document
    .querySelectorAll(`[data-tweetid="${tweetId}"] .bookmarks`)
    .forEach(element => {
      element.classList.toggle("bookmarked");
    });
}
