<div id="profile" class="subpage">
          <header>
            <svg viewBox="0 0 24 24">
              <path
                d="M20 11H7.414l4.293-4.293c.39-.39.39-1.023 0-1.414s-1.023-.39-1.414 0l-6 6c-.39.39-.39 1.023 0 1.414l6 6c.195.195.45.293.707.293s.512-.098.707-.293c.39-.39.39-1.023 0-1.414L7.414 13H20c.553 0 1-.447 1-1s-.447-1-1-1z"
              ></path>
            </svg>
            <h1>@<?= $_SESSION['username'] ?></h1>
          </header>
          <div class="top">
            <img
              src="https://images.unsplash.com/photo-1526304760382-3591d3840148?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=2100&q=80"
              alt="cover image"
              class="cover-image"
            />
            <img
              src="https://abs.twimg.com/sticky/default_profile_images/default_profile_400x400.png"
              alt="profile image"
              class="profile-image"
            />
            <button class="btn btn-outline">Edit profile</button>
          </div>
          <div class="user-info">
            <h1 class="primary userFullName"><?= $_SESSION['sUserName'] ?></h1>
            <h2 class="secondary userUsername">@<?= $_SESSION['sUserEmail'] ?></h2>
            <h2 class="secondary userDateJoined">Joined 11.02.2019</h2>
            <div>
              <h2 class="secondary userFollowed"><b>22</b> Following</h2>
              <h2 class="secondary userFollowers"><b>22</b> Followers</h2>
            </div>
          </div>
          <main class="tweets">
            <ul class="filters">
              <li class="active">Tweets</li>
              <li>Likes</li>
            </ul>
            <div id="profile-tweets"></div>
          </main>
        </div>