# Locally Hosted LLM-Based Chatbot

This repository provides a comprehensive guide to designing and setting up a locally hosted chatbot powered by a Large Language Model (LLM). Authored by Parteek Sharma, this project serves as both a personal record and a reference for developers aiming to replicate or enhance this chatbot.

## Table of Contents

- [Introduction](#introduction)
- [Prerequisites](#prerequisites)
- [Step 1: Install a Linux-Based Operating System](#step-1-install-a-linux-based-operating-system)
- [Step 2: Install the LAMP Stack](#step-2-install-the-lamp-stack)
- [Step 3: Install the LLM Model](#step-3-install-the-llm-model)
- [Step 4: Create the Webpage (Frontend Interface)](#step-4-create-the-webpage-frontend-interface)
- [Wrap-Up](#wrap-up)
- [License](#license)

## Introduction

This guide outlines the process of building a locally hosted chatbot using a lightweight LLM, specifically the Phi model, served through a web interface powered by the LAMP stack on Ubuntu. The project is designed for beginners and experienced developers alike, offering a balance of simplicity and functionality.

## Prerequisites

Before starting, ensure you have the following:

- A computer with Windows installed
- At least 20 GB of free unallocated disk space
- A USB flash drive (8 GB or more)
- [Ubuntu ISO file](https://ubuntu.com/download/desktop) (e.g., Ubuntu 24.04 LTS)
- [Rufus](https://rufus.ie/) (Windows tool to create bootable USB)
- Internet connection for downloading dependencies

## Step 1: Install a Linux-Based Operating System

A Linux-based OS is recommended for this project. Ubuntu is chosen for its user-friendly interface, extensive community support, and compatibility with open-source software.

### Why Ubuntu?

- Easy to install and configure
- Large community and extensive documentation
- Ideal for developers and beginners

### Installation Steps

1. **Download Ubuntu ISO**
   - Visit [ubuntu.com](https://ubuntu.com/download/desktop)
   - Download the latest LTS version (e.g., Ubuntu 24.04 LTS)

2. **Create Bootable USB**
   - Plug in your USB drive
   - Open Rufus:
     - **Device**: Select your USB drive
     - **Boot selection**: Choose the Ubuntu ISO file
     - **Partition scheme**: GPT (for UEFI) or MBR (for Legacy BIOS)
     - **File system**: FAT32
     - Click **Start** and wait for completion

3. **Prepare Windows for Dual Boot**
   - Open **Disk Management** (Win + X → Disk Management)
   - Shrink the main drive (C:):
     - Right-click on C: → **Shrink Volume**
     - Allocate at least 20,000 MB (20 GB) of unallocated space

4. **Boot into Ubuntu Installer**
   - Restart your PC and enter BIOS/UEFI (common keys: F2, F12, Esc, or Del)
   - Set the USB drive as the first boot device
   - Save changes and boot from the USB
   - Select **Try Ubuntu** to test compatibility

5. **Install Ubuntu**
   - Double-click **Install Ubuntu**
   - Configure:
     - Language
     - Keyboard layout
     - Installation type: Choose **Install Ubuntu alongside Windows Boot Manager** or:
       - Select **Something else**
       - Choose the unallocated space, click **+**
       - Create a partition:
         - **Type**: Primary
         - **Size**: e.g., 20,000 MB
         - **Mount point**: /
         - **Filesystem**: ext4
       - (Optional) Create a swap area (size = 2x RAM, if no hibernation required)
     - Select the bootloader location (usually `/dev/sda`)
     - Click **Install Now** and follow prompts (time zone, user info, etc.)

6. **Reboot and Choose OS**
   - Remove the USB drive
   - Reboot to see the GRUB boot menu
   - Select **Ubuntu** or **Windows Boot Manager**

## Step 2: Install the LAMP Stack

The LAMP stack (Linux, Apache, MySQL, PHP) provides a robust environment for hosting the chatbot's web interface.

### What is LAMP?

LAMP stands for:

- **Linux**: Operating system
- **Apache**: Web server
- **MySQL**: Database server
- **PHP**: Scripting language for dynamic content

### Installation Steps

1. **Update the System**

   ```bash
   sudo apt update
   sudo apt upgrade -y
