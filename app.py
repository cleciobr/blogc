from flask import Flask
from flask_socketio import SocketIO, send

app = Flask(__name__)
app.config['SECRET_KEY'] = 'shineray_123'
# O cors_allowed_origins="*" permite que seu site PHP acesse o servidor Python
socketio = SocketIO(app, cors_allowed_origins="*")

@socketio.on('message')
def handle_message(data):
    # data agora é um dicionário {'user': 'Nome', 'msg': 'Olá'}
    print(f"Mensagem de {data['user']}: {data['msg']}")
    # Envia para todo mundo exatamente o que recebeu
    send(data, broadcast=True)

if __name__ == '__main__':
    # Roda o servidor na porta 5000
    socketio.run(app, host='0.0.0.0', port=5000, debug=True)



 <!-- Widget do Chat -->
<div class="card direct-chat direct-chat-primary shadow-sm" style="position: fixed; bottom: 20px; right: 20px; width: 300px; z-index: 9999;">
  <div class="card-header">
    <h3 class="card-title">Shineray</h3>
  </div>
  <div class="card-body">
    <!-- Onde as mensagens aparecem -->
    <div id="chat-box" class="direct-chat-messages" style="height: 250px;"></div>
  </div>
  <div class="card-footer">
    <div class="input-group">
      <input type="text" id="message-input" placeholder="Digite..." class="form-control">
      <span class="input-group-append">
        <button type="button" onclick="sendMessage()" class="btn btn-primary">Enviar</button>
      </span>
    </div>
  </div>
</div>

<!-- Scripts de Conexão -->
<script src="https://cdnjs.cloudflare.com"></script>
<script>
    // 1. Conecta no servidor Python (app.py)
    const socket = io("http://localhost:5000"); 

    // 2. Pega o nome do usuário que veio do seu $user->getValues() do PHP
    const userName = "{$user.desperson}"; 

    // 3. Escuta quando alguém envia mensagem
    socket.on('message', function(data) {
        const chatBox = document.getElementById('chat-box');
        const msgElement = document.createElement('div');
        msgElement.className = 'direct-chat-msg';
        msgElement.innerHTML = `
            <div class="direct-chat-infos clearfix">
                <span class="direct-chat-name float-left">${data.user}</span>
            </div>
            <div class="direct-chat-text">${data.msg}</div>
        `;
        chatBox.appendChild(msgElement);
        chatBox.scrollTop = chatBox.scrollHeight; // Auto-scroll
    });

    // 4. Função para enviar
    function sendMessage() {
        const input = document.getElementById('message-input');
        if(input.value !== "") {
            // Enviamos um objeto com o nome e a mensagem
            socket.emit('message', {
                user: userName,
                msg: input.value
            });
            input.value = '';
        }
    }

     // 4. Função para enviar
    function sendMessage() {
        const input = document.getElementById('message-input');
        if(input.value !== "") {
            // Enviamos um objeto com o nome e a mensagem
            socket.emit('message', {
                user: userName,
                msg: input.value
            });
            input.value = '';
        }
    }
    
</script>