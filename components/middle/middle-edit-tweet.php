<div class="modal-wrapper" id="edit-modal-wrapper">
    <div class="modal" id="edit-tweet-modal">
        <a href="" onclick="return closeEditModal()" class="close">
            <svg viewBox="0 0 24 24">
                <path d="M13.414 12l5.793-5.793c.39-.39.39-1.023 0-1.414s-1.023-.39-1.414 0L12 10.586 6.207 4.793c-.39-.39-1.023-.39-1.414 0s-.39 1.023 0 1.414L10.586 12l-5.793 5.793c-.39.39-.39 1.023 0 1.414.195.195.45.293.707.293s.512-.098.707-.293L12 13.414l5.793 5.793c.195.195.45.293.707.293s.512-.098.707-.293c.39-.39.39-1.023 0-1.414L13.414 12z"></path>
            </svg>
        </a>
        <form action="" class="post-tweet" id="edit-tweet-form" onsubmit="updateTweet()">
            <img alt="profile image" class="profile-img" src="https://abs.twimg.com/sticky/default_profile_images/default_profile_400x400.png" />
            <div>
                <textarea name="newTweetBody" id="newTweetBody" placeholder="Type your updated tweet" type="text" value=""></textarea>
                <input type="text" value="" name="newTweetId" id="newTweetId">
                <div class="bottom">
                    <div>
                        <svg viewbox="0 0 24 24">
                            <path d="M19.75 2H4.25C3.01 2 2 3.01 2 4.25v15.5C2 20.99 3.01 22 4.25 22h15.5c1.24 0 2.25-1.01 2.25-2.25V4.25C22 3.01 20.99 2 19.75 2zM4.25 3.5h15.5c.413 0 .75.337.75.75v9.676l-3.858-3.858c-.14-.14-.33-.22-.53-.22h-.003c-.2 0-.393.08-.532.224l-4.317 4.384-1.813-1.806c-.14-.14-.33-.22-.53-.22-.193-.03-.395.08-.535.227L3.5 17.642V4.25c0-.413.337-.75.75-.75zm-.744 16.28l5.418-5.534 6.282 6.254H4.25c-.402 0-.727-.322-.744-.72zm16.244.72h-2.42l-5.007-4.987 3.792-3.85 4.385 4.384v3.703c0 .413-.337.75-.75.75z"></path>
                            <circle cx="8.868" cy="8.309" r="1.542"></circle>
                        </svg>
                    </div>
                    <button class="btn">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>