<!-- Premium Chat Widget & Modal Style -->
<div id="ai-chat-root"
    style="font-family: 'Outfit', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">

    <!-- Floating Button (Always Visible) -->
    <button id="ai-chat-btn" onclick="toggleChatbot()" style="
            position: fixed; 
            bottom: 30px; 
            right: 30px; 
            width: 60px; 
            height: 60px; 
            background: #16a2a3; 
            border-radius: 50%; 
            border: none;
            box-shadow: 0 10px 25px #16a2a3; 
            cursor: pointer; 
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        " onmouseover="this.style.transform='scale(1.1) rotate(5deg)'"
        onmouseout="this.style.transform='scale(1) rotate(0deg)'">
        <i class="fa-solid fa-comments" style="color: white; font-size: 24px;"></i>
        <span
            style="position: absolute; top: 2px; right: 2px; width: 14px; height: 14px; background-color: #ef4444; border: 2px solid white; border-radius: 50%;"></span>
    </button>

    <!-- Chat Modal Window -->
    <div id="ai-chat-modal" style="
            display: none; 
            position: fixed; 
            bottom: 100px; 
            right: 30px; 
            width: 380px; 
            height: 600px; 
            background: white; 
            border-radius: 20px; 
            box-shadow: 0 20px 60px rgba(0,0,0,0.15); 
            z-index: 99999;
            flex-direction: column;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.05);
            transform-origin: bottom right;
            transition: all 0.3s ease;
            max-width: calc(100vw - 40px);
            max-height: calc(100vh - 120px);
        ">

        <!-- Custom Header -->
        <div
            style="background: #16a2a3; padding: 20px; color: white; display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div
                    style="width: 40px; height: 40px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(5px);">
                    <i class="fa-solid fa-robot" style="font-size: 20px;"></i>
                </div>
                <div>
                    <h3 style="margin: 0; font-size: 16px; font-weight: 700;">PropertyFinda Assistant</h3>
                    <div
                        style="font-size: 11px; opacity: 0.9; margin-top: 2px; display: flex; align-items: center; gap: 4px;">
                        <span
                            style="width: 6px; height: 6px; background: #4ade80; border-radius: 50%; box-shadow: 0 0 5px #4ade80;"></span>
                        Online now
                    </div>
                </div>
            </div>
            <button onclick="toggleChatbot()"
                style="background: transparent; border: none; color: white; cursor: pointer; opacity: 0.8; padding: 5px;">
                <i class="fa-solid fa-xmark" style="font-size: 18px;"></i>
            </button>
        </div>

        <!-- Messages Container -->
        <div id="ai-messages"
            style="flex: 1; background: #f8fafc; padding: 20px; overflow-y: auto; display: flex; flex-direction: column; gap: 15px;">
            <!-- Initial Greeting -->
            <div class="ai-msg-group" style="display: flex; gap: 10px; align-items: flex-end;">
                <div
                    style="width: 30px; height: 30px; border-radius: 50%; background: #e0f2fe; display: flex; align-items: center; justify-content: center; color: #0284c7; font-size: 12px; flex-shrink: 0;">
                    <i class="fa-solid fa-robot"></i>
                </div>
                <div
                    style="background: white; padding: 12px 16px; border-radius: 18px; border-bottom-left-radius: 4px; font-size: 14px; color: #334155; line-height: 1.5; box-shadow: 0 2px 4px rgba(0,0,0,0.02); border: 1px solid #e2e8f0; max-width: 85%;">
                    Hello! 👋 I can help you find EXACT properties.
                    <br><br>
                    Try searching:
                    <div style="margin-top: 8px; display: flex; flex-direction: column; gap: 6px;">
                        <span onclick="quickSearch('Rent a 2 bed flat in London')"
                            style="cursor: pointer; color: #16a2a3; font-weight: 500; font-size: 13px;">➔ Rent a 2 bed
                            flat in London</span>
                        <span onclick="quickSearch('Buy a 3 bed house in E14')"
                            style="cursor: pointer; color: #16a2a3; font-weight: 500; font-size: 13px;">➔ Buy a 3 bed
                            house in E14</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div style="padding: 15px; background: white; border-top: 1px solid #f1f5f9;">
            <form onsubmit="handleChat(event)" style="display: flex; gap: 10px; position: relative;">
                <input type="text" id="ai-input" placeholder="Type specific requirements..." required
                    style="flex: 1; padding: 12px 16px; padding-right: 45px; border-radius: 25px; border: 1px solid #e2e8f0; outline: none; font-size: 14px; background: #f8fafc; transition: all 0.2s;"
                    onfocus="this.style.borderColor='#16a2a3'; this.style.background='white';"
                    onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc';">
                <button type="submit"
                    style="position: absolute; right: 6px; top: 50%; transform: translateY(-50%); width: 32px; height: 32px; background: #16a2a3; border: none; border-radius: 50%; color: white; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background 0.2s;"
                    onmouseover="this.style.backgroundColor='#16a2a3'"
                    onmouseout="this.style.backgroundColor='#16a2a3'">
                    <i class="fa-solid fa-paper-plane" style="font-size: 12px;"></i>
                </button>
            </form>
            <div style="text-align: center; margin-top: 8px; font-size: 10px; color: #94a3b8;">Powered by PropertyFinda
            </div>
        </div>
    </div>
</div>

<script>
    function toggleChatbot() {
        const modal = document.getElementById('ai-chat-modal');
        const btn = document.getElementById('ai-chat-btn');
        const icon = btn.querySelector('i');

        if (modal.style.display === 'none') {
            modal.style.display = 'flex';
            modal.animate([
                { opacity: 0, transform: 'scale(0.9) translateY(20px)' },
                { opacity: 1, transform: 'scale(1) translateY(0)' }
            ], { duration: 250, easing: 'cubic-bezier(0.16, 1, 0.3, 1)' });
            icon.classList.remove('fa-comments');
            icon.classList.add('fa-xmark');
            setTimeout(() => document.getElementById('ai-input').focus(), 100);
        } else {
            modal.animate([
                { opacity: 1, transform: 'scale(1) translateY(0)' },
                { opacity: 0, transform: 'scale(0.9) translateY(20px)' }
            ], { duration: 200 }).onfinish = () => { modal.style.display = 'none'; };
            icon.classList.remove('fa-xmark');
            icon.classList.add('fa-comments');
        }
    }

    function quickSearch(text) {
        document.getElementById('ai-input').value = text;
        handleChat(event);
    }

    async function handleChat(e) {
        if (e) e.preventDefault();
        const input = document.getElementById('ai-input');
        const message = input.value.trim();
        if (!message) return;

        appendMessage(message, 'user');
        input.value = '';
        const loadingId = showLoading();

        try {
            const response = await fetch("{{ route('chatbot.chat') }}", {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
                body: JSON.stringify({ message: message })
            });
            const data = await response.json();
            removeLoading(loadingId);

            if (data.error) {
                appendMessage("Checking connection...", 'ai');
            } else {
                appendMessage(data.reply, 'ai');
                if (data.results && data.results.length > 0) {
                    showProperties(data.results);
                }
            }
        } catch (error) {
            removeLoading(loadingId);
            appendMessage("Network error.", 'ai');
        }
    }

    function appendMessage(text, sender) {
        const container = document.getElementById('ai-messages');
        const div = document.createElement('div');
        div.style.display = 'flex'; div.style.marginBottom = '15px'; div.style.alignItems = 'flex-end';
        if (sender === 'user') {
            div.style.justifyContent = 'flex-end';
            div.innerHTML = `<div style="background: #16a2a3; color: white; padding: 12px 16px; border-radius: 18px; border-bottom-right-radius: 4px; font-size: 14px; max-width: 85%; line-height: 1.5; box-shadow: 0 4px 12px rgba(29, 161, 242, 0.2);">${text}</div>`;
        } else {
            div.innerHTML = `<div style="width: 30px; height: 30px; border-radius: 50%; background: #e0f2fe; display: flex; align-items: center; justify-content: center; color: #0284c7; font-size: 12px; flex-shrink: 0; margin-right: 10px;"><i class="fa-solid fa-robot"></i></div><div style="background: white; padding: 12px 16px; border-radius: 18px; border-bottom-left-radius: 4px; font-size: 14px; color: #334155; line-height: 1.5; box-shadow: 0 2px 4px rgba(0,0,0,0.02); border: 1px solid #e2e8f0; max-width: 85%;">${text}</div>`;
        }
        container.appendChild(div); container.scrollTop = container.scrollHeight;
        return div;
    }

    function showLoading() {
        const container = document.getElementById('ai-messages');
        const id = 'loading-' + Date.now();
        const div = document.createElement('div');
        div.id = id; div.style.display = 'flex'; div.style.gap = '10px'; div.style.marginBottom = '15px';
        div.innerHTML = `<div style="width: 30px; height: 30px; border-radius: 50%; background: #e0f2fe; display: flex; align-items: center; justify-content: center; color: #0284c7; font-size: 12px;"><i class="fa-solid fa-robot"></i></div><div style="background: white; padding: 15px; border-radius: 18px; border-bottom-left-radius: 4px; border: 1px solid #e2e8f0; display: flex; gap: 4px; align-items: center;"><span style="width: 5px; height: 5px; background: #94a3b8; border-radius: 50%; animation: typing 1s infinite;"></span><span style="width: 5px; height: 5px; background: #94a3b8; border-radius: 50%; animation: typing 1s infinite 0.2s;"></span><span style="width: 5px; height: 5px; background: #94a3b8; border-radius: 50%; animation: typing 1s infinite 0.4s;"></span></div><style>@keyframes typing { 0%, 100% { opacity: 0.3; transform: scale(0.8); } 50% { opacity: 1; transform: scale(1.2); } }</style>`;
        container.appendChild(div); container.scrollTop = container.scrollHeight; return id;
    }

    function removeLoading(id) { const el = document.getElementById(id); if (el) el.remove(); }

    function showProperties(properties) {
        const container = document.getElementById('ai-messages');
        const wrapper = document.createElement('div');
        wrapper.style.paddingLeft = '40px'; wrapper.style.marginBottom = '15px';

        let html = '<div style="display: flex; gap: 12px; overflow-x: auto; padding-bottom: 10px; padding-top: 5px;">';
        properties.forEach(prop => {
            // New logic: Use prop.image_url provided by backend
            const img = prop.image_url || 'https://via.placeholder.com/300x200?text=No+Image';

            html += `
                <a href="${prop.url}" target="_blank" style="min-width: 200px; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; text-decoration: none; display: block; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="height: 110px; position: relative;">
                        <img src="${img}" style="width: 100%; height: 100%; object-fit: cover;">
                        <span style="position: absolute; top: 8px; left: 8px; background: rgba(255,255,255,0.9); padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: bold; color: #16a2a3;">${prop.type}</span>
                        <div style="position: absolute; bottom: 8px; left: 8px; background: rgba(0,0,0,0.6); color: white; padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: bold;">£${parseInt(prop.price).toLocaleString()}</div>
                    </div>
                    <div style="padding: 10px;">
                        <h4 style="margin: 0 0 4px 0; font-size: 13px; font-weight: bold; color: #334155; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="${prop.property_title}">${prop.property_title}</h4>
                        <div style="font-size: 11px; color: #64748b; margin-bottom: 8px; display: flex; align-items: center; gap: 4px;">
                            <i class="fa-solid fa-location-dot" style="color: #ef4444;"></i> ${prop.address || 'Unknown'}
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 11px; color: #64748b; border-top: 1px solid #f1f5f9; padding-top: 6px;">
                            <span><i class="fa-solid fa-bed"></i> ${prop.bedrooms || 0} Beds</span>
                            <span><i class="fa-solid fa-bath"></i> ${prop.bathrooms || 0} Bath</span>
                        </div>
                    </div>
                </a>`;
        });
        html += '</div>';

        wrapper.innerHTML = html;
        container.appendChild(wrapper);
        container.scrollTop = container.scrollHeight;
    }
</script>