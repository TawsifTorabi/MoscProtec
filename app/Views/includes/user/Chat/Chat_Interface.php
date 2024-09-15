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

            <div class="input-group input-group-merge">
              <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
              <input type="text" class="form-control" placeholder="Search..." aria-label="Search..." aria-describedby="basic-addon-search31">
            </div>

            <ul class="list-unstyled mb-0" id="conversationList"></ul>

          </div>
        </div>

      </div>

      <div class="col-md-12 col-lg-12 col-xl-8">
        <div class="row" style="max-height: 34em; overflow-y: scroll;">
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


        // Function to load conversation for a specific user
        function loadConversation(otherUserID, otherUserName, otherUserPhoto) {
          const chatContainer = document.getElementById('conversationThread'); // Select the chat container
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

              // Check if there are any messages
              if (data.length === 0) {
                // If no messages, display "Start a Conversation"
                chatContainer.innerHTML = `
          <div class="text-center my-4">
            <p class="text-muted">Start a Conversation</p>
          </div>
        `;
              } else {
                // Loop through each chat message
                data.forEach(chat => {
                  // Create a list item for each message
                  const messageItem = document.createElement('li');
                  messageItem.classList.add('d-flex', 'justify-content-between', 'mb-4');

                  // Determine if the message is from the current user or the other user
                  if (chat.sender == currentUserID) {
                    // Current user message (Right side)
                    messageItem.innerHTML = `
              <div class="w-50"></div>  
              <div class="card w-50">
                  <div class="card-header d-flex justify-content-between p-3">
                      <p class="fw-bold mb-0">You</p>
                      <p class="text-muted small mb-0"><i class="far fa-clock"></i> ${chat.created_at}</p>
                  </div>
                  <div class="card-body">
                      <p class="mb-0">${chat.message}</p>
                  </div>
              </div>
          `;
                  } else {
                    // Other user message (Left side)
                    messageItem.innerHTML = `
              <div class="card w-50">
                  <div class="card-header d-flex justify-content-between p-3">
                      <div class="avatar avatar-online">
                          <img src="${otherUserPhoto}" alt="${otherUserName}" class="w-px-60 h-auto rounded-circle">
                      </div>
                      <p class="fw-bold mb-0">${otherUserName}</p>
                      <p class="text-muted small mb-0"><i class="far fa-clock"></i> ${chat.created_at}</p>
                  </div>
                  <div class="card-body">
                      <p class="mb-0">${chat.message}</p>
                  </div>
              </div>
          `;
                  }

                  // Append the message item to the chat container
                  chatContainer.appendChild(messageItem);
                });
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