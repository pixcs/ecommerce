<!-- component -->
<div class="fixed bottom-0 right-0 mb-4 mr-4">
    <button id="open-chat"
        class="bg-indigo-800 text-white py-2 px-4 rounded-md hover:bg-rose-600 transition duration-300 flex items-center">
        <i class="fa-regular fa-comment-dots text-xl"></i>
    </button>
</div>
<div id="chat-container" class="hidden fixed bottom-16 right-4 w-96">
    <div class="bg-white shadow-md rounded-lg max-w-lg w-full">
        <div class="p-4 border-b bg-indigo-800 text-white rounded-t-lg flex justify-between items-center">
            <p class="text-lg font-semibold">Customer Support</p>
            <button id="close-chat" class="text-gray-300 hover:text-gray-400 focus:outline-none focus:text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
        <div id="chatbox" class="p-4 h-80 overflow-y-auto">
            <!-- Chat messages will be displayed here -->
        </div>
        <div class="p-4 border-t flex">
            <input id="user-input" type="text" placeholder="Type a message"
                class="w-full px-3 py-2 border rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button id="send-button"
                class="bg-indigo-800 text-white px-4 py-2 rounded-r-md hover:bg-rose-600 transition duration-300">Send</button>
        </div>
    </div>
</div>
<script>
    const chatbox = document.getElementById("chatbox");
    const chatContainer = document.getElementById("chat-container");
    const userInput = document.getElementById("user-input");
    const sendButton = document.getElementById("send-button");
    const openChatButton = document.getElementById("open-chat");
    const closeChatButton = document.getElementById("close-chat");

    let isChatboxOpen = true; 

    function toggleChatbox() {
        chatContainer.classList.toggle("hidden");
        isChatboxOpen = !isChatboxOpen; 
    }

    openChatButton.addEventListener("click", toggleChatbox);
    closeChatButton.addEventListener("click", toggleChatbox);

    sendButton.addEventListener("click", function() {
        const userMessage = userInput.value.trim();
        if (userMessage !== "") {
            socket.emit('sendChatToServer', userMessage); 
            userInput.value = ""; 
        }
    });

    userInput.addEventListener("keyup", function(event) {
        if (event.key === "Enter") {
            const userMessage = userInput.value.trim();
            if (userMessage !== "") {
                socket.emit('sendChatToServer', userMessage);
                userInput.value = "";
            }
        }
    });

    $(document).ready(() => {
        socket.on('sendChatToClient', (message) => {
            console.log("Message from server:", message);

            $('#chatbox').append(`
                <div class="mb-2 flex items-end">
                    <p class="bg-gray-200 text-gray-700 rounded-lg py-2 px-4 inline-block">${message}</p>
                </div>
            `);

            chatbox.scrollTop = chatbox.scrollHeight;
        });

        console.log('Socket is listening');
    });
</script>
