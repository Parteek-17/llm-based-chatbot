LLM-Based Chatbot
   A locally hosted chatbot powered by the Phi Large Language Model (LLM) and the LAMP stack on Ubuntu. This project, authored by Parteek Sharma, provides a simple yet functional chatbot interface for local deployment.
Overview
   This repository contains the code and documentation for building a chatbot that runs offline using the Phi LLM, served through an Apache web server. The project includes:

A web interface (index.html, query_llm.php) for user interaction
Detailed setup instructions for Ubuntu, LAMP stack, and Phi model
A professional, open-source structure with MIT License

   For detailed setup instructions, see docs/documentation.md.
Getting Started
   Follow the instructions in docs/documentation.md to:

Install Ubuntu and set up a dual-boot system
Configure the LAMP stack
Install the Phi LLM using Ollama
Deploy the web interface

Usage

Ensure the LAMP stack and Ollama are running:sudo systemctl start apache2
ollama run phi


Open http://localhost/index.html in your browser.
Interact with the chatbot by entering queries.

Files

index.html: Frontend interface for the chatbot
query_llm.php: Backend script to communicate with the Phi model
docs/documentation.md: Full setup guide
LICENSE: MIT License
.gitignore: Excludes non-project files

License
   This project is licensed under the MIT License. See LICENSE for details.
