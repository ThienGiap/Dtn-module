function sendToChatGPT() {
    const inputElem = document.getElementById("chatgpt-input");
    const input = inputElem.value.trim();
    const responseContainer = document.getElementById("chatgpt-response");

    if (!input) return;

    const formKey = document.querySelector('input[name="form_key"]').value;

    // In câu hỏi người dùng ra giao diện
    appendMessage(input, 'user');
    inputElem.value = "";

    // In trạng thái đang phản hồi
    const loadingMessageId = 'loading-msg-' + Date.now();
    appendMessage("Just a moment...", 'bot', loadingMessageId);

    fetch('/dtn/index/index', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            question: input,
            form_key: formKey
        })
    })
        .then(response => response.json())
        .then(data => {
            // Xoá loading message
            const loadingElem = document.getElementById(loadingMessageId);
            if (loadingElem) loadingElem.remove();

            if (data.success) {
                appendMessage(data.answer, 'bot');
            } else {
                appendMessage("Lỗi: " + data.error, 'bot');
            }
        })
        .catch(error => {
            const loadingElem = document.getElementById(loadingMessageId);
            if (loadingElem) loadingElem.remove();

            console.error("Error:", error);
            appendMessage("Oops! Có lỗi xảy ra.", 'bot');
        });
}

function appendMessage(content, sender = 'user', customId = null) {
    const responseContainer = document.getElementById("chatgpt-response");
    const messageDiv = document.createElement("div");
    messageDiv.style.margin = "10px 0";
    messageDiv.style.display = "flex";
    messageDiv.style.justifyContent = sender === 'user' ? "flex-end" : "flex-start";

    const bubble = document.createElement("div");
    bubble.style.maxWidth = "80%";
    bubble.style.padding = "10px";
    bubble.style.borderRadius = "10px";
    bubble.style.whiteSpace = "pre-wrap";
    bubble.style.background = sender === 'user' ? "#dcf8c6" : "#ffffff";
    bubble.style.boxShadow = "0 1px 3px rgba(0,0,0,0.1)";
    bubble.style.fontFamily = "Arial, sans-serif";
    bubble.style.position = "relative";

    if (customId) {
        bubble.id = customId;
    }

    messageDiv.appendChild(bubble);
    responseContainer.appendChild(messageDiv);
    responseContainer.scrollTop = responseContainer.scrollHeight;

    if (sender === 'bot') {
        renderFormattedContent(bubble, content);
    } else {
        bubble.textContent = content;
    }
}

function renderFormattedContent(container, content) {
    const codeBlockRegex = /```([\s\S]*?)```/g;
    let lastIndex = 0;
    let match;

    const segments = [];

    while ((match = codeBlockRegex.exec(content)) !== null) {
        const textBefore = content.slice(lastIndex, match.index);
        if (textBefore) {
            segments.push({ type: 'text', value: textBefore });
        }

        const codeContent = match[1].trim();
        segments.push({ type: 'code', value: codeContent });

        lastIndex = codeBlockRegex.lastIndex;
    }

    const remaining = content.slice(lastIndex);
    if (remaining) {
        segments.push({ type: 'text', value: remaining });
    }

    // Render từng phần tử
    (async () => {
        for (const segment of segments) {
            if (segment.type === 'text') {
                await typeTextAsync(container, segment.value);
            } else if (segment.type === 'code') {
                renderCodeBlock(container, segment.value);
            }
        }
    })();
}

function renderCodeBlock(container, codeContent) {
    const wrapper = document.createElement("div");
    wrapper.style.position = "relative";
    wrapper.style.marginTop = "10px";

    const pre = document.createElement("pre");
    pre.textContent = codeContent;
    pre.style.background = "#f5f5f5";
    pre.style.padding = "10px";
    pre.style.borderRadius = "8px";
    pre.style.overflowX = "auto";
    pre.style.fontSize = "14px";
    pre.style.fontFamily = "monospace";

    const copyBtn = document.createElement("button");
    copyBtn.textContent = "Copy";
    copyBtn.style.position = "absolute";
    copyBtn.style.top = "5px";
    copyBtn.style.right = "5px";
    copyBtn.style.fontSize = "12px";
    copyBtn.style.padding = "5px 10px";
    copyBtn.style.border = "none";
    copyBtn.style.borderRadius = "5px";
    copyBtn.style.cursor = "pointer";
    copyBtn.style.background = "#007bff";
    copyBtn.style.color = "white";

    copyBtn.onclick = () => {
        navigator.clipboard.writeText(codeContent);
        copyBtn.textContent = "Copied!";
        setTimeout(() => (copyBtn.textContent = "Copy"), 1000);
    };

    wrapper.appendChild(copyBtn);
    wrapper.appendChild(pre);
    container.appendChild(wrapper);
}

function typeTextAsync(container, text, speed = 15) {
    return new Promise(resolve => {
        let i = 0;
        const span = document.createElement("span");
        container.appendChild(span);

        function type() {
            if (i < text.length) {
                const char = text[i];
                span.innerHTML += char === '\n' ? '<br>' : char;
                i++;
                setTimeout(type, speed);
            } else {
                resolve();
            }
        }
        type();
    });
}

window.addEventListener("DOMContentLoaded", () => {
    document.getElementById("chatgpt-response");
    appendMessage("What's up 👋! Bro?", "bot");
});

const textarea = document.getElementById("chatgpt-input");
// Auto resize
textarea.addEventListener("input", () => {
    textarea.style.height = "auto";
    textarea.style.height = textarea.scrollHeight + "px";
});

textarea.addEventListener("keydown", function (e) {
    if (e.key === "Enter" && !e.shiftKey) {
        e.preventDefault();
        sendToChatGPT();
    }
});
