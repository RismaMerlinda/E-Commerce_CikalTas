@extends('admin.layout')

@section('title', 'Customer Support')

@push('styles')
<style>
    /* Utility Classes replacement since Bootstrap is removed */
    .d-none { display: none !important; }
    .d-flex { display: flex !important; }
    .flex-column { flex-direction: column !important; }
    .h-100 { height: 100% !important; }
    .w-100 { width: 100% !important; }
    .gap-3 { gap: 1rem !important; }
    .m-0 { margin: 0 !important; }
    .mb-3 { margin-bottom: 1rem !important; }

    .chat-app {
        font-family: 'Inter', sans-serif;
        display: flex;
        height: calc(100vh - 180px);
        background: var(--white);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(61,35,20,0.08);
        border: 1px solid rgba(196,149,106,0.12);
    }
    .chat-sidebar {
        width: 320px;
        background: var(--white);
        border-right: 1px solid var(--sand);
        display: flex;
        flex-direction: column;
    }
    .chat-sidebar-header {
        padding: 20px;
        background: var(--espresso);
        color: var(--white);
        font-weight: 600;
        font-size: 1.1rem;
        font-family: 'Cormorant Garamond', serif;
    }
    .chat-list {
        overflow-y: auto;
        flex: 1;
    }
    .chat-list-item {
        padding: 15px 20px;
        border-bottom: 1px solid var(--cream);
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .chat-list-item:hover, .chat-list-item.active {
        background: var(--cream);
    }
    .chat-list-item.active {
        border-left: 4px solid var(--brown);
    }
    .chat-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--brown-light), var(--brown));
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: var(--white);
        margin-right: 12px;
    }
    .chat-info {
        flex: 1;
        overflow: hidden;
    }
    .chat-name {
        font-weight: 600;
        color: var(--espresso);
        margin-bottom: 2px;
        font-size: 0.95rem;
    }
    .chat-preview {
        color: var(--gray-soft);
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
        color: var(--gray-soft);
        margin-bottom: 5px;
    }
    
    .chat-main {
        flex: 1;
        display: flex;
        flex-direction: column;
        background: var(--cream);
    }
    .chat-main-header {
        padding: 15px 20px;
        background: var(--white);
        border-bottom: 1px solid var(--sand);
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
        padding: 12px 16px;
        border-radius: 18px;
        font-size: 0.95rem;
        position: relative;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        line-height: 1.5;
    }
    .chat-bubble .time {
        font-size: 0.7rem;
        color: var(--gray-soft);
        text-align: right;
        margin-top: 6px;
        display: block;
    }
    .chat-user {
        background: var(--white);
        color: var(--charcoal);
        align-self: flex-start;
        border-top-left-radius: 0;
        border: 1px solid rgba(196,149,106,0.12);
    }
    .chat-admin {
        background: var(--espresso);
        color: var(--white);
        align-self: flex-end;
        border-top-right-radius: 0;
    }
    .chat-admin .time {
        color: rgba(255,255,255,0.6);
    }
    .chat-ai {
        background: var(--sand);
        color: var(--espresso);
        align-self: flex-start;
        border-top-left-radius: 0;
        border: 1px solid var(--warm);
    }
    .chat-input-area {
        padding: 15px 20px;
        background: var(--white);
        display: flex;
        align-items: center;
        gap: 15px;
        border-top: 1px solid var(--sand);
    }
    .chat-input-area input {
        flex: 1;
        padding: 12px 20px;
        border-radius: 100px;
        border: 1.5px solid var(--sand);
        outline: none;
        font-size: 0.95rem;
        transition: border-color 0.25s;
        background: var(--cream);
    }
    .chat-input-area input:focus {
        border-color: var(--brown);
    }
    .btn-send {
        background: var(--espresso);
        color: var(--white);
        border: none;
        border-radius: 50%;
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(61,35,20,0.15);
    }
    .btn-send:hover {
        background: var(--brown-dark);
        transform: translateY(-1px);
    }
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: var(--gray-soft);
        text-align: center;
    }

    @media (max-width: 768px) {
        .chat-app {
            flex-direction: column;
            height: auto;
            min-height: calc(100vh - 160px);
        }
        .chat-sidebar {
            width: 100%;
            max-height: 240px;
            border-right: none;
            border-bottom: 1px solid var(--sand);
        }
        .chat-main {
            min-height: 400px;
        }
        .chat-bubble {
            max-width: 85%;
        }
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Customer Support</h1>
        <p class="page-subtitle">Kelola pesan masuk dan interaksi bantuan pelanggan</p>
    </div>
    <a href="{{ route('admin.dashboard') }}" class="btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="chat-app">
    <!-- Sidebar -->
    <div class="chat-sidebar">
        <div class="chat-sidebar-header">
            Daftar Chat Masuk
        </div>
        <div class="chat-list" id="chat-list">
            @foreach($conversations as $conv)
            <div class="chat-list-item" onclick="openChat({{ $conv->id }}, '{{ $conv->user->nama_lengkap ?? $conv->user->name }}', '{{ $conv->status }}')">
                <div class="chat-avatar">{{ substr($conv->user->nama_lengkap ?? $conv->user->name, 0, 1) }}</div>
                <div class="chat-info">
                    <div class="chat-name">{{ $conv->user->nama_lengkap ?? $conv->user->name }}</div>
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
                    <span class="badge badge-{{ $conv->status }}">{{ ucfirst($conv->status) }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Chat Area -->
    <div class="chat-main">
        <div class="empty-state" id="empty-state">
            <i class="fas fa-comments fa-3x mb-3" style="color: var(--brown-light); opacity: 0.6;"></i>
            <h5 style="font-family: 'Cormorant Garamond', serif; font-size: 20px; font-weight: 700; color: var(--espresso);">Pilih percakapan untuk mulai membalas</h5>
        </div>

        <div id="chat-area" class="d-none h-100 flex-column">
            <div class="chat-main-header">
                <div class="chat-avatar" id="active-avatar">U</div>
                <div>
                    <div class="chat-name" id="active-name">User Name</div>
                    <span class="badge" id="active-status" style="font-size: 10px; padding: 2px 8px;">Status</span>
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
@endsection

@push('scripts')
<script>
    let currentConversationId = null;
    let autoRefreshInterval = null;

    function formatTime(dateString) {
        if(!dateString) return '';
        const date = new Date(dateString);
        return date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', timeZone: 'Asia/Jakarta' });
    }

    function openChat(id, name, status) {
        currentConversationId = id;
        document.getElementById('empty-state').classList.add('d-none');
        const chatArea = document.getElementById('chat-area');
        chatArea.classList.remove('d-none');
        chatArea.classList.add('d-flex');
        
        document.getElementById('active-name').innerText = name;
        document.getElementById('active-avatar').innerText = name.substring(0, 1);
        
        const statusBadge = document.getElementById('active-status');
        statusBadge.innerText = status.toUpperCase();
        statusBadge.className = 'badge badge-' + status;
        
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
@endpush

