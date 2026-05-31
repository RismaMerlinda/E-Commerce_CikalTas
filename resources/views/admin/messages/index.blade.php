<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Support - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { margin: 0; padding: 0; font-family: 'Nunito Sans', sans-serif; background-color: #D2BBA2; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap');

    .chat-app {
        font-family: 'Inter', sans-serif;
        display: flex;
        height: calc(100vh - 120px);
        background: #f8f9fa;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .chat-sidebar {
        width: 350px;
        background: #fff;
        border-right: 1px solid #e0e0e0;
        display: flex;
        flex-direction: column;
    }
    .chat-sidebar-header {
        padding: 20px;
        background: #8B5A2B; /* CikalTas Brown */
        color: white;
        font-weight: 600;
        font-size: 1.1rem;
    }
    .chat-list {
        overflow-y: auto;
        flex: 1;
    }
    .chat-list-item {
        padding: 15px 20px;
        border-bottom: 1px solid #f0f0f0;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .chat-list-item:hover, .chat-list-item.active {
        background: #fdfbf7;
    }
    .chat-list-item.active {
        border-left: 4px solid #8B5A2B;
    }
    .chat-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: #e0e0e0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: #666;
        margin-right: 15px;
    }
    .chat-info {
        flex: 1;
        overflow: hidden;
    }
    .chat-name {
        font-weight: 600;
        color: #333;
        margin-bottom: 2px;
        font-size: 0.95rem;
    }
    .chat-preview {
        color: #888;
        font-size: 0.85rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .chat-meta {
        text-align: right;
    }
    .chat-time {
        font-size: 0.75rem;
        color: #aaa;
        margin-bottom: 5px;
    }
    .badge-status {
        font-size: 0.7rem;
        padding: 3px 8px;
        border-radius: 12px;
    }
    .status-pending { background: #fff3cd; color: #856404; }
    .status-replied { background: #d4edda; color: #155724; }
    .status-closed { background: #e2e3e5; color: #383d41; }
    
    .chat-main {
        flex: 1;
        display: flex;
        flex-direction: column;
        background: #efeae2; /* WA web background feel */
    }
    .chat-main-header {
        padding: 15px 20px;
        background: #fff;
        border-bottom: 1px solid #e0e0e0;
        display: flex;
        align-items: center;
    }
    .chat-main-header .chat-name {
        font-size: 1.1rem;
        margin-bottom: 0;
    }
    .chat-box {
        flex: 1;
        padding: 20px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    .chat-bubble {
        max-width: 65%;
        padding: 10px 15px;
        border-radius: 15px;
        font-size: 0.95rem;
        position: relative;
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }
    .chat-bubble .time {
        font-size: 0.7rem;
        color: rgba(0,0,0,0.5);
        text-align: right;
        margin-top: 5px;
        display: block;
    }
    .chat-user {
        background: #fff;
        align-self: flex-start;
        border-top-left-radius: 0;
    }
    .chat-admin {
        background: #dcf8c6;
        align-self: flex-end;
        border-top-right-radius: 0;
    }
    .chat-ai {
        background: #e3f2fd;
        align-self: flex-start;
        border-top-left-radius: 0;
        border: 1px solid #90caf9;
    }
    .chat-input-area {
        padding: 15px 20px;
        background: #f0f0f0;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .chat-input-area input {
        flex: 1;
        padding: 12px 20px;
        border-radius: 25px;
        border: none;
        outline: none;
        font-size: 0.95rem;
    }
    .btn-send {
        background: #8B5A2B;
        color: white;
        border: none;
        border-radius: 50%;
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background 0.2s;
    }
    .btn-send:hover {
        background: #6e4722;
    }
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: #888;
    }
</style>
</head>
<body>
    @include('admin.partials.navbar')

<div class="container-fluid py-4">
    <div class="chat-app">
        <!-- Sidebar -->
        <div class="chat-sidebar">
            <div class="chat-sidebar-header">
                Customer Support
            </div>
            <div class="chat-list" id="chat-list">
                @foreach($conversations as $conv)
                <div class="chat-list-item" onclick="openChat({{ $conv->id }}, '{{ $conv->user->name }}', '{{ $conv->status }}')">
                    <div class="chat-avatar">{{ substr($conv->user->name, 0, 1) }}</div>
                    <div class="chat-info">
                        <div class="chat-name">{{ $conv->user->name }}</div>
                        <div class="chat-preview">
                            @if($conv->messages->count() > 0)
                                {{ $conv->messages->first()->message }}
                            @else
                                Belum ada pesan
                            @endif
                        </div>
                    </div>
                    <div class="chat-meta">
                        <div class="chat-time">{{ $conv->last_message_at ? $conv->last_message_at->diffForHumans() : '' }}</div>
                        <span class="badge badge-status status-{{ $conv->status }}">{{ ucfirst($conv->status) }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Chat Area -->
        <div class="chat-main">
            <div class="empty-state" id="empty-state">
                <i class="fas fa-comments fa-3x mb-3"></i>
                <h5>Pilih percakapan untuk mulai membalas</h5>
            </div>

            <div id="chat-area" class="d-none h-100 flex-column">
                <div class="chat-main-header">
                    <div class="chat-avatar" id="active-avatar">U</div>
                    <div>
                        <div class="chat-name" id="active-name">User Name</div>
                        <small class="text-muted" id="active-status">Status</small>
                    </div>
                </div>
                
                <div class="chat-box" id="chat-box">
                    <!-- Messages will be loaded here via AJAX -->
                </div>

                <div class="chat-input-area">
                    <form id="reply-form" class="w-100 d-flex gap-3 m-0" onsubmit="sendReply(event)">
                        @csrf
                        <input type="hidden" id="conversation_id" name="conversation_id">
                        <input type="text" id="reply-input" placeholder="Ketik balasan..." required autocomplete="off">
                        <button type="submit" class="btn-send"><i class="fas fa-paper-plane"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let currentConversationId = null;
    let autoRefreshInterval = null;

    function formatTime(dateString) {
        if(!dateString) return '';
        const date = new Date(dateString);
        return date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
    }

    function openChat(id, name, status) {
        currentConversationId = id;
        document.getElementById('empty-state').classList.add('d-none');
        const chatArea = document.getElementById('chat-area');
        chatArea.classList.remove('d-none');
        chatArea.classList.add('d-flex');
        
        document.getElementById('active-name').innerText = name;
        document.getElementById('active-avatar').innerText = name.substring(0, 1);
        document.getElementById('active-status').innerText = status.toUpperCase();
        document.getElementById('conversation_id').value = id;

        // Fetch messages
        fetchMessages();

        // Setup auto-refresh every 5 seconds
        if(autoRefreshInterval) clearInterval(autoRefreshInterval);
        autoRefreshInterval = setInterval(fetchMessages, 5000);
    }

    async function fetchMessages() {
        if (!currentConversationId) return;
        
        try {
            const res = await fetch(`/admin/messages/${currentConversationId}`);
            const data = await res.json();
            
            const chatBox = document.getElementById('chat-box');
            chatBox.innerHTML = '';
            
            data.messages.forEach(msg => {
                const bubble = document.createElement('div');
                let typeClass = 'chat-user';
                if(msg.sender_type === 'admin') typeClass = 'chat-admin';
                if(msg.sender_type === 'ai') typeClass = 'chat-ai';
                
                let senderLabel = '';
                if(msg.sender_type === 'ai') senderLabel = '<strong>🤖 AI:</strong><br>';
                
                bubble.className = `chat-bubble ${typeClass}`;
                bubble.innerHTML = `${senderLabel}${msg.message} <span class="time">${formatTime(msg.created_at)}</span>`;
                chatBox.appendChild(bubble);
            });
            
            // Auto scroll to bottom if new messages
            chatBox.scrollTop = chatBox.scrollHeight;
        } catch (e) {
            console.error('Error fetching messages', e);
        }
    }

    async function sendReply(e) {
        e.preventDefault();
        const input = document.getElementById('reply-input');
        const message = input.value.trim();
        if(!message) return;
        
        input.value = '';
        
        try {
            const res = await fetch(`/admin/messages/${currentConversationId}/reply`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({ message: message })
            });
            
            if(res.ok) {
                fetchMessages();
            }
        } catch (e) {
            console.error('Error sending reply', e);
        }
    }
</script>
</body>
</html>
