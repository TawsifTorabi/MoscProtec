<style>
  .avatar {
    margin-right: 0.7em;
    margin-left: 0.5em;
    margin-top: 0.3em;
  }
</style>
<section>
  <div class="container py-5">

    <div class="row">

      <div class="col-md-6 col-lg-5 col-xl-4 mb-4 mb-md-0">

        <h5 class="font-weight-bold mb-3 text-center text-lg-start">Messenger</h5>
        <div class="card">
          <div class="card-body">

            <!-- Search Input -->
            <div class="input-group input-group-merge">
              <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
              <input type="text" class="form-control" id="searchInput" placeholder="Search..." aria-label="Search..." aria-describedby="basic-addon-search31" onkeyup="searchConversations()">
            </div>

            <!-- Conversation List -->
            <ul class="list-unstyled mb-0" style="overflow-y: auto; max-height: 41em;" id="conversationList"></ul>

          </div>
        </div>

      </div>

      <div class="col-md-12 col-lg-12 col-xl-8">

        <div class="d-flex flex-row">
          <div class="avatar">
            <img id="userImage" src="" class="w-px-60 h-auto rounded-circle">
          </div>
          <div class="pt-1">
            <p class="fw-bold mb-0">
            <h3 id="userNameTitle">Loading...</h3>
            </p>
          </div>
        </div>

        <div class="row" id="threadContainer" style="max-height: 34em; overflow-y: auto;">
          <div class="col-md-12 col-lg-12 col-xl-12">
            <ul class="list-unstyled" id="conversationThread"></ul>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 col-lg-12 col-xl-12">
            <li class="mb-3">
              <div data-mdb-input-init class="form-outline">
                <textarea class="form-control bg-body-tertiary" id="textAreaExample2" rows="4"></textarea>
                <label class="form-label" for="textAreaExample2">Message</label>
              </div>
            </li>
            <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-info btn-rounded float-end">Send</button>
          </div>
        </div>

      </div>


      <script>
        var CurrentChatTargetUserID;
        var CurrentChatTargetUserPhoto;
        var CurrentChatTargetUserName;

        function scrollToBottom() {
          const chatContainer = document.getElementById('threadContainer');

          // Use a timeout to ensure that DOM is updated before scrolling
          setTimeout(() => {
            chatContainer.scrollTop = chatContainer.scrollHeight;
          }, 100); // Delay the scroll by 100ms
        }

        document.addEventListener('DOMContentLoaded', function() {
          const messageInput = document.getElementById('textAreaExample2');
          const sendButton = document.querySelector('.btn.btn-info.btn-rounded.float-end');

          // Function to send the message
          async function sendMessage() {
            const message = messageInput.value.trim();

            if (!message) {
              alert('Message cannot be empty');
              return;
            }

            try {
              const response = await fetch('<?= site_url("/user/messenger/send-message"); ?>?to_id=' + CurrentChatTargetUserID + '&message=' + encodeURIComponent(message), {
                method: 'POST',
              });

              const data = await response.json();

              if (data.status === 'success') {
                messageInput.value = ''; // Clear the message input field

                // Reload the conversation and scroll to the bottom
                loadConversation(CurrentChatTargetUserID, CurrentChatTargetUserName, CurrentChatTargetUserPhoto);

                // Scroll to bottom after sending the message
                scrollToBottom();
              } else {
                console.error('Error sending message:', data);
              }
            } catch (error) {
              console.error('Error during message send:', error);
            }
          }


          // Event listener for button click
          sendButton.addEventListener('click', function() {
            sendMessage();
          });

          // Event listener for pressing Enter key in the textarea
          messageInput.addEventListener('keypress', function(event) {
            if (event.key === 'Enter' && !event.shiftKey) {
              event.preventDefault(); // Prevent newline in the textarea
              sendMessage();
            }
          });
        });





        // Function to perform search and load the results
        async function searchConversations() {
          const searchKey = document.getElementById('searchInput').value.trim();

          if (searchKey === '') {
            loadConversations(); // If search is empty, load all conversations
            return;
          }

          try {
            // Send POST request to search API
            const response = await fetch('<?= site_url('/user/messenger/search'); ?>', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
              },
              body: `key=${encodeURIComponent(searchKey)}`
            });

            let searchResults = await response.json();

            const conversationList = document.getElementById('conversationList');
            conversationList.innerHTML = ''; // Clear existing list

            if (searchResults.length === 0) {
              conversationList.innerHTML = '<li>No users found</li>';
              return;
            }

            // Loop through the search results
            searchResults.forEach(conversation => {
              // Determine if there are unread messages
              const unreadBadge = conversation.unread_count > 0 ?
                `<span class="badge bg-danger float-end">${conversation.unread_count}</span>` :
                '';

              // Check if the message was opened (for the double tick icon)
              const messageStatus = conversation.opened === "1" ?
                '<i class="fas fa-check-double" aria-hidden="true"></i>' :
                '<i class="fas fa-check" aria-hidden="true"></i>';

              // Conditionally apply the `avatar-online` class if the user is online
              const avatarClass = conversation.is_online ?
                'avatar avatar-online' :
                'avatar';

              // Create the list item
              const listItem = `
          <li class="p-2 border-bottom ${conversation.is_online ? 'bg-body-tertiary' : ''}">
            <a href="#!" onclick="loadConversation(${conversation.userid}, '${conversation.name}', '${conversation.profile_picture}')" class="d-flex justify-content-between">
              <div class="d-flex flex-row">
                <div class="${avatarClass}">
                  <img src="${conversation.profile_picture}" alt="${conversation.name}" class="w-px-60 h-auto rounded-circle">
                </div>
                <div class="pt-1">
                  <p class="fw-bold mb-0">${conversation.name}</p>
                  <p class="small text-muted">${conversation.last_message || 'No message yet'}</p>
                </div>
              </div>
              <div class="pt-1">
                <p class="small text-muted mb-1">${conversation.last_message_time || 'Just now'}</p>
                ${unreadBadge}
                <span class="text-muted float-end">${messageStatus}</span>
              </div>
            </a>
          </li>
        `;

              // Append the list item to the conversation list
              conversationList.innerHTML += listItem;
            });

          } catch (error) {
            console.error('Error fetching search results:', error);
          }
        }

        


        // Function to load conversations
        // Function to load conversations
        async function loadConversations() {
          try {
            const response = await fetch('<?= site_url('/user/messenger/conversations'); ?>');
            let conversations = await response.json();

            // Sort conversations by the `last_message_time_raw` in descending order (latest first)
            conversations.sort((a, b) => {
              return b.last_message_time_raw - a.last_message_time_raw;
            });

            const conversationList = document.getElementById('conversationList');
            conversationList.innerHTML = ''; // Clear existing list

            // Loop through the conversations
            conversations.forEach(conversation => {
              // Determine if there are unread messages
              const unreadBadge = conversation.unread_count > 0 ?
                `<span class="badge bg-danger float-end">${conversation.unread_count}</span>` :
                '';

              // Check if the message was opened (for the double tick icon)
              const messageStatus = conversation.opened === "1" ?
                '<i class="fas fa-check-double" aria-hidden="true"></i>' :
                '<i class="fas fa-check" aria-hidden="true"></i>';

              // Conditionally apply the `avatar-online` class if the user is online
              const avatarClass = conversation.is_online ?
                'avatar avatar-online' :
                'avatar';

              // Create the list item
              const listItem = `
        <li class="p-2 border-bottom ${conversation.is_online ? 'bg-body-tertiary' : ''}">
          <a href="#!" onclick="loadConversation(${conversation.userid}, '${conversation.name}', '${conversation.profile_picture}')" class="d-flex justify-content-between">
            <div class="d-flex flex-row">
              <div class="${avatarClass}">
                <img src="${conversation.profile_picture}" alt="${conversation.name}" class="w-px-60 h-auto rounded-circle">
              </div>
              <div class="pt-1">
                <p class="fw-bold mb-0">${conversation.name}</p>
                <p class="small text-muted">${conversation.last_message || 'No message yet'}</p>
              </div>
            </div>
            <div class="pt-1">
              <p class="small text-muted mb-1">${conversation.last_message_time || 'Just now'}</p>
              ${unreadBadge}
              <span class="text-muted float-end">${messageStatus}</span>
            </div>
          </a>
        </li>
      `;
              // Append the list item to the conversation list
              conversationList.innerHTML += listItem;
            });

            // Call loadConversation for the very first conversation (latest one)
            if (conversations.length > 0) {
              const latestConversation = conversations[0];
              loadConversation(latestConversation.userid, latestConversation.name, latestConversation.profile_picture);
            }

          } catch (error) {
            console.error('Error fetching conversations:', error);
          }
        }



        function loadConversation(otherUserID, otherUserName, otherUserPhoto) {

          CurrentChatTargetUserID = otherUserID;
          CurrentChatTargetUserPhoto = otherUserPhoto;
          CurrentChatTargetUserName = otherUserName;

          const chatContainer = document.getElementById('conversationThread');
          document.getElementById('userNameTitle').innerHTML = otherUserName;
          document.getElementById('userImage').src = otherUserPhoto;
          let currentUserID;

          // First, fetch the current user ID
          fetch('http://localhost/ci/moscprotec/user/messenger/getUserID', {
              method: 'GET',
            })
            .then(response => response.json())
            .then(userData => {
              if (userData.status === "success") {
                currentUserID = userData.userid; // Get the current user ID

                // Now, fetch the conversation
                return fetch('http://localhost/ci/moscprotec/user/messenger/get-chats?id_2=' + otherUserID, {
                  method: 'POST',
                });
              } else {
                throw new Error("Unable to fetch current user ID");
              }
            })
            .then(response => response.json())
            .then(data => {
              chatContainer.innerHTML = ''; // Clear existing messages
              if (data.length > 0) {
                data.forEach(chat => {
                  const messageItem = document.createElement('li');
                  messageItem.classList.add('d-flex', 'justify-content-start', 'mb-4');

                  if (chat.sender == currentUserID) {
                    // Current user message (Right side)
                    messageItem.innerHTML = `
            <div class="w-25"></div>  
            <div class="card w-75">
              <div class="card-header d-flex justify-content-start p-3">
              </div>
              <div class="card-body">
                <p class="mb-0">${chat.message}</p>
                <div class="ml-auto p-2">
                  <p class="text-muted small mb-0"><i class='bx bx-time-five'></i> ${chat.created_at}</p>
                </div>
              </div>
            </div>
          `;
                  } else {
                    // Other user message (Left side)
                    messageItem.innerHTML = `
            <div class="card w-75">
              <div class="card-header d-flex p-2">
                <div class="d-flex">
                  <div class="p-2 avatar avatar-online">
                    <img src="${otherUserPhoto}" alt="" class="w-px-60 h-auto rounded-circle">
                  </div>
                </div>
              </div>
              <div class="card-body">
                <p class="mb-0">${chat.message}</p>
                <div class="ml-auto p-2">
                  <p class="text-muted small mb-0"><i class='bx bx-time-five'></i> ${chat.created_at}</p>
                </div>
              </div>
            </div>
          `;
                  }

                  // Append the message item to the chat container
                  chatContainer.appendChild(messageItem);
                });

                // Scroll to the bottom of the conversation thread after messages are loaded
                scrollToBottom();

              } else {
                // If there are no messages, show the "Start a Conversation" text
                chatContainer.innerHTML = `<p class="text-muted">Start a conversation</p>`;
              }
            })
            .catch(error => {
              console.error('Error loading conversation:', error);
            });
        }




        // Load conversations on page load
        loadConversations();
      </script>

    </div>

  </div>
</section>