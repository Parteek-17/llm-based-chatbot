# Locally Hosted LLM-Based Chatbot

## Overview
This project is a locally hosted chatbot powered by a Large Language Model (LLM), specifically the **Phi** model via [Ollama](https://ollama.com). The chatbot runs on a Linux-based system (Ubuntu recommended) with a web interface served through a LAMP stack (Linux, Apache, MySQL, PHP). It allows users to interact with the LLM via a browser-based UI or API, all running offline on your local machine.

## Features
- **Local LLM**: Run the lightweight Phi model for fast, CPU-compatible inference.
- **Web Interface**: Simple, functional chat UI hosted on Apache.
- **API Support**: Query the LLM programmatically via POST requests.
- **GitHub Hosted**: Source code and documentation available for collaboration.

## Quick Setup
1. **Install Ubuntu**:
   - Download the Ubuntu LTS ISO from [ubuntu.com](https://ubuntu.com/download/desktop).
   - Create a bootable USB with Rufus and install Ubuntu alongside Windows (20 GB free space required).

2. **Install LAMP Stack**:
   ```bash
   sudo apt update
   sudo apt install apache2 mysql-server php libapache2-mod-php php-mysql -y
   ```

3. **Install Ollama and Phi Model**:
   ```bash
   curl -fsSL https://ollama.com/install.sh | sh
   ollama run phi
   ```

4. **Set Up Web Interface**:
   - Create `/var/www/html/index.html` and `/var/www/html/query_llm.php` (see [documentation.md](documentation.md) for code).
   - Restart Apache:
     ```bash
     sudo systemctl restart apache2
     ```

5. **Run and Test**:
   - Start the Phi model: `ollama run phi`.
   - Open `http://localhost/index.html` in your browser.

## Detailed Instructions
For a complete step-by-step guide, including dual-boot setup, LAMP stack installation, and web interface code, see [documentation.md](documentation.md).

## Project Structure
```
your-repo/
├── index.html          # Web interface for the chatbot
├── query_llm.php       # PHP script to interface with Ollama API
├── documentation.md    # Detailed setup guide
├── README.md           # This file
```

## Contributing
1. Fork the repository.
2. Create a feature branch (`git checkout -b feature-branch`).
3. Commit changes (`git commit -m "Add feature"`).
4. Push to your fork (`git push origin feature-branch`).
5. Open a pull request.

## License
This project is licensed under the MIT License. See the `LICENSE` file for details.