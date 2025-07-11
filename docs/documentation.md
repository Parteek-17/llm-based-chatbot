LLM-Based Chatbot Documentation
   This document, authored by Parteek Sharma, provides a comprehensive guide to designing and setting up a locally hosted chatbot powered by a Large Language Model (LLM). It serves as a detailed reference for replicating or enhancing this project.
Table of Contents

Introduction
Prerequisites
Step 1: Install a Linux-Based Operating System
Step 2: Install the LAMP Stack
Step 3: Install the LLM Model
Step 4: Create the Webpage (Frontend Interface)
Wrap-Up
License

Introduction
   This guide outlines the process of building a locally hosted chatbot using the Phi model, served through a web interface powered by the LAMP stack on Ubuntu. The project is designed for both beginners and experienced developers, offering simplicity and functionality.
Prerequisites
   Before starting, ensure you have:

A computer with Windows installed
At least 20 GB of free unallocated disk space
A USB flash drive (8 GB or more)
Ubuntu ISO file (e.g., Ubuntu 24.04 LTS)
Rufus (Windows tool to create bootable USB)
Internet connection for downloading dependencies

Step 1: Install a Linux-Based Operating System
   A Linux-based OS is recommended. Ubuntu is chosen for its user-friendly interface, extensive community support, and compatibility with open-source software.
Why Ubuntu?

Easy to install and configure
Large community and extensive documentation
Ideal for developers and beginners

Installation Steps

Download Ubuntu ISO

Visit ubuntu.com
Download the latest LTS version (e.g., Ubuntu 24.04 LTS)


Create Bootable USB

Plug in your USB drive
Open Rufus:
Device: Select your USB drive
Boot selection: Choose the Ubuntu ISO file
Partition scheme: GPT (for UEFI) or MBR (for Legacy BIOS)
File system: FAT32
Click Start and wait for completion




Prepare Windows for Dual Boot

Open Disk Management (Win + X → Disk Management)
Shrink the main drive (C:):
Right-click on C: → Shrink Volume
Allocate at least 20,000 MB (20 GB) of unallocated space




Boot into Ubuntu Installer

Restart your PC and enter BIOS/UEFI (common keys: F2, F12, Esc, or Del)
Set the USB drive as the first boot device
Save changes and boot from the USB
Select Try Ubuntu to test compatibility


Install Ubuntu

Double-click Install Ubuntu
Configure:
Language
Keyboard layout
Installation type: Choose Install Ubuntu alongside Windows Boot Manager or:
Select Something else
Choose the unallocated space, click +
Create a partition:
Type: Primary
Size: e.g., 20,000 MB
Mount point: /
Filesystem: ext4


(Optional) Create a swap area (size = 2x RAM, if no hibernation required)


Select the bootloader location (usually /dev/sda)
Click Install Now and follow prompts (time zone, user info, etc.)




Reboot and Choose OS

Remove the USB drive
Reboot to see the GRUB boot menu
Select Ubuntu or Windows Boot Manager



Step 2: Install the LAMP Stack
   The LAMP stack (Linux, Apache, MySQL, PHP) provides a robust environment for hosting the chatbot's web interface.
What is LAMP?
   LAMP stands for:

Linux: Operating system
Apache: Web server
MySQL: Database server
PHP: Scripting language for dynamic content

Installation Steps

Update the System
sudo apt update
sudo apt upgrade -y


Install Apache Web Server
sudo apt install apache2 -y

Verify Apache by visiting http://localhost in your browser (you should see the Apache welcome page).

Install MySQL
sudo apt install mysql-server -y
sudo mysql_secure_installation

Follow prompts to set the root password, remove test databases, and enhance security.

Install PHP
sudo apt install php libapache2-mod-php php-mysql -y

Verify PHP installation:
php -v


Restart Apache
sudo systemctl restart apache2


Verify LAMP Stack
Create a test PHP file:
sudo nano /var/www/html/info.php

Add:
<?php
phpinfo();
?>

Save and exit (Ctrl + O, Enter, Ctrl + X). Visit http://localhost/info.php to confirm the LAMP stack is working.


Step 3: Install the LLM Model
   The chatbot uses a locally hosted Large Language Model (LLM). The Phi model is chosen for its lightweight nature and CPU compatibility.
Why Phi?

Lightweight and fast
Easy to install and run locally
Supports CPU inference
Ideal for basic chatbot tasks

Installation Steps

Install Ollama
Ollama simplifies running LLMs locally:
curl -fsSL https://ollama.com/install.sh | sh

Start the Ollama service:
ollama serve

Enable it to run in the background:
sudo systemctl enable ollama
sudo systemctl start ollama


Download the Phi Model
ollama run phi

This pulls the Phi model and starts a containerized instance for terminal or API interaction.

Verify Installation
Test the model in the terminal:
ollama run phi
>>> What is the capital of France?

Expected response: Paris.


Step 4: Create the Webpage (Frontend Interface)
   The frontend is a simple web interface hosted on Apache —
Objective
   Create a functional chat interface for sending queries to the LLM and displaying responses.
Implementation Steps

Navigate to Apache Document Root
cd /var/www/html


Create index.html
sudo nano index.html

Add the following:
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

Save and exit (Ctrl + O, Enter, Ctrl + X).

Create query_llm.php
sudo nano /var/www/html/query_llm.php

Add the following:
<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('X-Accel-Buffering: no');
$input = json_decode(file_get_contents("php://input"), true);
$prompt = $input['prompt'] ?? '';
$ch = curl_init('http://localhost:11434/api/generate');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type': 'application/json']);
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

Save and exit (Ctrl + O, Enter, Ctrl + X).

Restart Apache (if needed)
sudo systemctl restart apache2


Run the Model
ollama run phi


View the Webpage
Open http://localhost/index.html in your browser to interact with the chatbot.


Wrap-Up
   Congratulations! You've built a fully functional, locally hosted LLM-based chatbot. This prototype includes:

A Linux environment (Ubuntu)
A LAMP stack for web hosting
A lightweight LLM (Phi) for intelligent responses
A basic web interface for user interaction


"AI isn't just in the cloud. With the right tools, it's now on your desk."

   Future enhancements could include:

Advanced styling with CSS frameworks (e.g., Bootstrap)
Improved interactivity with JavaScript frameworks (e.g., React, Vue.js)
Additional LLM models for enhanced capabilities

License
   This project is licensed under the MIT License. See the LICENSE file for details.
