<x-main-layout>
    <x-slot name="title">Customer Support - CikalTas</x-slot>

    <style>
        .user-chat-app {
            font-family: 'Inter', sans-serif;
            background: #efeae2;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            height: 600px;
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #e0e0e0;
        }
        .user-chat-header {
            padding: 15px 20px;
            background: linear-gradient(135deg, #8B5A2B, #664229);
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .user-chat-header .title {
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .user-chat-box {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .chat-bubble {
            max-width: 75%;
            padding: 12px 18px;
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
            background: #dcf8c6;
            align-self: flex-end;
            border-top-right-radius: 0;
        }
        .chat-admin {
            background: #fff;
            align-self: flex-start;
            border-top-left-radius: 0;
        }
        .chat-ai {
            background: #e3f2fd;
            align-self: flex-start;
            border-top-left-radius: 0;
            border: 1px solid #90caf9;
        }
        .user-chat-input {
            padding: 15px 20px;
            background: #f0f0f0;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .user-chat-input input {
            flex: 1;
            padding: 12px 20px;
            border-radius: 25px;
            border: none;
            outline: none;
            font-size: 0.95rem;
            background: white;
        }
        .btn-chat-send {
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
            flex-shrink: 0;
        }
        .btn-chat-send:hover { background: #6e4722; }
        .badge-status {
            font-size: 0.8rem;
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: 500;
        }
        .status-pending { background: rgba(255,243,205,0.8); color: #856404; }
        .status-replied { background: rgba(212,237,218,0.8); color: #155724; }
        .status-closed  { background: rgba(226,227,229,0.8); color: #383d41; }
    </style>

    <div class="mb-4">
        <h2 class="text-2xl font-bold" style="color: #664229;">💬 Customer Support</h2>
        <p class="text-sm" style="color: #606060;">Chat langsung dengan tim admin CikalTas</p>
    </div>

    <div class="user-chat-app">
        <div class="user-chat-header">
            <h4 class="title">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Customer Support CikalTas
            </h4>
            <div>
                <span class="badge-status status-{{ $conversation->status }}" id="chat-status">
                    {{ ucfirst($conversation->status) }}
                </span>
            </div>
        </div>

        <div class="user-chat-box" id="user-chat-box">
            @forelse($messages as $msg)
                @php
                    $typeClass = 'chat-user';
                    if($msg->sender_type === 'admin') $typeClass = 'chat-admin';
                    if($msg->sender_type === 'ai') $typeClass = 'chat-ai';
                @endphp
                <div class="chat-bubble {{ $typeClass }}">
                    @if($msg->sender_type === 'ai')
                        <strong>🤖 AI:</strong><br>
                    @elseif($msg->sender_type === 'admin')
                        <strong>👨‍💼 Admin:</strong><br>
                    @endif
                    {!! nl2br(e($msg->message)) !!}
                    <span class="time">{{ $msg->created_at->format('H:i') }}</span>
                </div>
            @empty
                <div style="text-align:center; color:#aaa; margin: auto;">
                    <p style="font-size:2rem;">💬</p>
                    <p>Belum ada pesan. Mulai chat dengan admin sekarang!</p>
                </div>
            @endforelse
        </div>

        <div class="user-chat-input">
            <form id="user-reply-form" style="display:flex;gap:12px;width:100%;margin:0;" onsubmit="sendUserMessage(event)">
                @csrf
                <input type="text" id="user-message-input" placeholder="Ketik pesan Anda di sini..." required autocomplete="off">
                <button type="submit" class="btn-chat-send">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M22 2L11 13M22 2L15 22l-4-9-9-4 20-7z"/></svg>
                </button>
            </form>
        </div>
    </div>

    <script>
        const chatBox = document.getElementById('user-chat-box');
        chatBox.scrollTop = chatBox.scrollHeight;

        function formatTime(dateString) {
            if(!dateString) return '';
            const date = new Date(dateString);
            return date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        }

        async function sendUserMessage(e) {
            e.preventDefault();
            const input = document.getElementById('user-message-input');
            const message = input.value.trim();
            if(!message) return;
            input.value = '';

            // Optimistic UI update
            const bubble = document.createElement('div');
            bubble.className = 'chat-bubble chat-user';
            bubble.innerHTML = `${message} <span class="time">${formatTime(new Date())}</span>`;
            chatBox.appendChild(bubble);
            chatBox.scrollTop = chatBox.scrollHeight;

            try {
                const res = await fetch('{{ route('support.reply') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify({ message: message })
                });
                if(res.ok) { fetchUserMessages(); }
            } catch (err) {
                console.error('Error sending message', err);
            }
        }

        async function fetchUserMessages() {
            try {
                const res = await fetch('{{ route('support.fetch') }}');
                const data = await res.json();
                if (data.messages) {
                    chatBox.innerHTML = '';
                    data.messages.forEach(msg => {
                        const bubble = document.createElement('div');
                        let typeClass = 'chat-user';
                        if(msg.sender_type === 'admin') typeClass = 'chat-admin';
                        if(msg.sender_type === 'ai') typeClass = 'chat-ai';
                        let label = '';
                        if(msg.sender_type === 'ai') label = '<strong>🤖 AI:</strong><br>';
                        if(msg.sender_type === 'admin') label = '<strong>👨‍💼 Admin:</strong><br>';
                        bubble.className = `chat-bubble ${typeClass}`;
                        bubble.innerHTML = `${label}${msg.message.replace(/\n/g, '<br>')} <span class="time">${formatTime(msg.created_at)}</span>`;
                        chatBox.appendChild(bubble);
                    });
                    chatBox.scrollTop = chatBox.scrollHeight;
                    const badge = document.getElementById('chat-status');
                    badge.className = `badge-status status-${data.status}`;
                    badge.innerText = data.status.charAt(0).toUpperCase() + data.status.slice(1);
                }
            } catch (err) {
                console.error('Error fetching messages', err);
            }
        }

        setInterval(fetchUserMessages, 5000);
    </script>
</x-main-layout>
