# Locally Hosted LLM-Based Chatbot Documentation

## Introduction
Hello, I am Parteek Sharma, and this document outlines the detailed process of designing and setting up a Locally Hosted LLM-based Chatbot. This guide serves as both a personal record and a reference for others who want to replicate or improve upon this project.

## Step 1: Install a Linux-Based Operating System
A Linux-based operating system is essential for this project. While any major distribution (e.g., Fedora, Debian, or Arch) can be used, I recommend **Ubuntu** for beginners due to its user-friendly interface, strong community support, and compatibility with open-source software.

### Why Ubuntu?
- Easy to install and configure
- Large community and extensive documentation
- Ideal for developers and beginners alike

### Prerequisites
- A computer with Windows installed
- At least 20 GB of free unallocated disk space
- A USB flash drive (8 GB or more)
- Ubuntu ISO file from [ubuntu.com](https://ubuntu.com/download/desktop)
- Rufus (Windows tool to create bootable USB): [rufus.ie](https://rufus.ie)

### Installation Steps
1. **Download Ubuntu ISO**:
   - Visit [ubuntu.com](https://ubuntu.com/download/desktop).
   - Download the latest LTS version (e.g., Ubuntu 24.04 LTS).

2. **Create Bootable USB**:
   - Plug in your USB drive.
   - Open Rufus:
     - **Device**: Select your USB drive.
     - **Boot selection**: Choose the Ubuntu `.iso` file.
     - **Partition scheme**: GPT (for UEFI) or MBR (for Legacy BIOS).
     - **File system**: FAT32.
     - Click **Start** and wait for completion.

3. **Prepare Windows for Dual Boot**:
   - Open **Disk Management** (Press `Win + X` → Disk Management).
   - Shrink the main drive (C:):
     - Right-click on C: → **Shrink Volume**.
     - Shrink at least 20,000 MB (20 GB) to create unallocated space.

4. **Boot into Ubuntu Installer**:
   - Restart your PC and enter BIOS/UEFI (common keys: F2, F12, Esc, or Del).
   - Change boot order to prioritize the USB drive.
   - Save changes and boot into the Ubuntu USB.
   - Select **Try Ubuntu** to test compatibility.

5. **Install Ubuntu**:
   - Double-click **Install Ubuntu** on the desktop.
   - Choose:
     - Language
     - Keyboard layout
     - Installation type: Select **Install Ubuntu alongside Windows Boot Manager** if available. If not:
       - Select **Something else**:
         - Choose the unallocated space, click **+**.
         - Create a partition:
           - **Type**: Primary
           - **Size**: e.g., 20,000 MB
           - **Mount point**: `/`
           - **Filesystem**: ext4
         - (Optional) Create a swap area (size = 2x RAM if no hibernation is needed).
       - Select the bootloader location (usually `/dev/sda`).
   - Click **Install Now** and follow prompts (time zone, user info, etc.).

6. **Reboot and Choose OS**:
   - Remove the USB after installation.
   - On startup, the GRUB boot menu will appear.
   - Choose **Ubuntu** or **Windows Boot Manager** to boot into the desired OS.

## Step 2: Install the LAMP Stack
To host the chatbot via a web interface, we need a reliable backend environment. The **LAMP stack** (Linux, Apache, MySQL, PHP) is ideal for this purpose.

### What is LAMP Stack?
LAMP is an acronym for:
- **Linux**: The operating system (Ubuntu in this case).
- **Apache**: The web server.
- **MySQL**: The database server.
- **PHP**: The programming language for dynamic content.

### Installation Steps
1. **Update the System**:
   ```bash
   sudo apt update
   sudo apt upgrade -y
   ```

2. **Install Apache Web Server**:
   ```bash
   sudo apt install apache2 -y
   ```
   - Verify Apache is running by visiting `http://localhost` in your browser. You should see the default Apache welcome page.

3. **Install MySQL (Database Server)**:
   ```bash
   sudo apt install mysql-server -y
   ```
   - Run the secure installation script:
     ```bash
     sudo mysql_secure_installation
     ```
   - Follow prompts to set the root password, remove test databases, and improve security.

4. **Install PHP**:
   ```bash
   sudo apt install php libapache2-mod-php php-mysql -y
   ```
   - Check PHP version:
     ```bash
     php -v
     ```

5. **Restart Apache**:
   ```bash
   sudo systemctl restart apache2
   ```

6. **Verify LAMP Stack Installation**:
   - Create a PHP test file:
     ```bash
     sudo nano /var/www/html/info.php
     ```
   - Add:
     ```php
     <?php
     phpinfo();
     ?>
     ```
   - Save and exit (`Ctrl + O`, `Enter`, `Ctrl + X`).
   - Visit `http://localhost/info.php` in your browser. If you see the PHP configuration page, the LAMP stack is installed correctly.

## Step 3: Install the LLM Model (Locally)
The core of the chatbot is a **Large Language Model (LLM)**, which understands and generates human-like responses.

### Why I Chose Phi?
For this project, I used the **Phi** model via [Ollama](https://ollama.com), because it is:
- Lightweight and fast
- Easy to install and run locally
- Supports CPU inference (suitable for low-end systems)
- Ideal for basic chatbot tasks

### Installation Steps
1. **Install Ollama**:
   ```bash
   curl -fsSL https://ollama.com/install.sh | sh
   ```
   - Start the Ollama service:
     ```bash
     ollama serve
     ```
   - (Optional) Enable Ollama to run in the background:
     ```bash
     sudo systemctl enable ollama
     sudo systemctl start ollama
     ```

2. **Download the Phi Model**:
   ```bash
   ollama run phi
   ```
   - This command pulls the Phi model and starts a containerized instance for interaction via terminal or API.

3. **Verify Installation**:
   - Interact with Phi in the terminal:
     ```bash
     ollama run phi
     >>> What is the capital of France?
     Paris.
     ```

## Step 4: Create the Webpage (Frontend Interface)
The web interface allows users to interact with the LLM via a browser, hosted using Apache.

### Objective
Create a simple, functional chat interface where users can enter queries and receive responses from the Phi model.

### Steps
1. **Navigate to Apache Document Root**:
   ```bash
   cd /var/www/html
   ```

2. **Create `index.html`**:
   ```bash
   sudo nano index.html
   ```
   - Add the following code:
     ```html
     <!DOCTYPE html>
     <html lang="en">
     <head>
       <meta charset="UTF-8">
       <title>🤖 LLM Chatbot</title>
       <style>
         body {
           background-color: #1e1e1e;
           color: white;
           font-family: Arial, sans-serif;
           padding: 20px;
         }
         .chat-box {
           height: 400px;
           overflow-y: auto;
           background: #2c2c2c;
           border-radius: 10px;
           padding: 15px;
           margin-bottom: 20px;
         }
         .message {
           margin: 10px 0;
         }
         .user {
           text-align: right;
           color: #4fc3f7;
         }
         .bot {
           text-align: left;
           color: #aed581;
         }
         input[type="text"] {
           width: 70%;
           padding: 10px;
           border-radius: 6px;
           border: none;
           font-size: 16px;
         }
         button {
           padding: 10px 20px;
           background: #7e57c2;
           border: none;
           border-radius: 6px;
           color: white;
           font-size: 16px;
           cursor: pointer;
         }
       </style>
     </head>
     <body>
       <h2>💬 Chat with AI (Local LLM)</h2>
       <div class="chat-box" id="chatBox"></div>
       <input type="text" id="promptInput" placeholder="Ask something..." />
       <button onclick="sendPrompt()">Send</button>
       <script>
         const input = document.getElementById('promptInput');
         input.addEventListener("keydown", function(e) {
           if (e.key === "Enter") {
             sendPrompt();
           }
         });
         function sendPrompt() {
           const chatBox = document.getElementById('chatBox');
           const prompt = input.value.trim();
           if (!prompt) return;
           chatBox.innerHTML += `<div class="message user"><strong>You:</strong> ${prompt}</div>`;
           const replyId = "reply-" + Date.now();
           chatBox.innerHTML += `<div class="message bot"><strong>Bot:</strong> <span id="${replyId}"></span></div>`;
           chatBox.scrollTop = chatBox.scrollHeight;
           input.value = '';
           const replySpan = document.getElementById(replyId);
           fetch('query_llm.php', {
             method: 'POST',
             headers: { 'Content-Type': 'application/json' },
             body: JSON.stringify({ prompt })
           }).then(response => {
             const reader = response.body.getReader();
             const decoder = new TextDecoder();
             let full = "";
             function readChunk() {
               reader.read().then(({ done, value }) => {
                 if (done) return;
                 const chunk = decoder.decode(value, { stream: true });
                 const lines = chunk.split("\n");
                 for (const line of lines) {
                   if (line.startsWith("data: ")) {
                     let msg = line.replace("data: ", "");
                     msg = msg.replace(/\\n/g, "\n");
                     full += msg + " ";
                     replySpan.innerText = full.trim();
                     chatBox.scrollTop = chatBox.scrollHeight;
                   }
                 }
                 readChunk();
               });
             }
             readChunk();
           });
         }
       </script>
     </body>
     </html>
     ```
   - Save and exit (`Ctrl + O`, `Enter`, `Ctrl + X`).

3. **Create `query_llm.php`**:
   ```bash
   sudo nano /var/www/html/query_llm.php
   ```
   - Add:
     ```php
     <?php
     header('Content-Type: text/event-stream');
     header('Cache-Control: no-cache');
     header('X-Accel-Buffering: no');
     $input = json_decode(file_get_contents("php://input"), true);
     $prompt = $input['prompt'] ?? '';
     $ch = curl_init('http://localhost:11434/api/generate');
     curl_setopt($ch, CURLOPT_POST, true);
     curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
         "model" => "phi",
         "prompt" => $prompt,
         "stream" => true
     ]));
     curl_setopt($ch, CURLOPT_WRITEFUNCTION, function($ch, $data) {
         $lines = explode("\n", $data);
         foreach ($lines as $line) {
             $line = trim($line);
             if (!$line) continue;
             $json = json_decode($line, true);
             if (isset($json['response'])) {
                 echo "data: " . $json['response'] . "\n\n";
                 @ob_flush();
                 flush();
             }
         }
         return strlen($data);
     });
     curl_exec($ch);
     curl_close($ch);
     ?>
     ```
   - Save and exit (`Ctrl + O`, `Enter`, `Ctrl + X`).

4. **Restart Apache (if needed)**:
   ```bash
   sudo systemctl restart apache2
   ```

5. **Run the Model and Test**:
   - Start the Phi model:
     ```bash
     ollama run phi
     ```
   - Open `http://localhost/index.html` in your browser to interact with the chatbot.

## Wrap-Up
Congratulations! You have successfully set up a locally hosted LLM-based chatbot. From installing Ubuntu and the LAMP stack to setting up the Phi model and creating a web interface, you now have a functional prototype running offline and under your control.

> **"AI isn't just in the cloud. With the right tools, it's now on your desk."**