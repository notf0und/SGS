<p align="center">
  <img src="www/public/sgs-icon.png" alt="SGS Logo" width="128">
</p>

# Switch Games Server

Switch Games Server is a lightweight Laravel-based application that exposes your Nintendo Switch game files over the network, making them accessible to homebrew applications like **Tinfoil** and **DBI**.

With SGS, you can install games wirelessly without connecting your Switch to a computer. Once set up, all Nintendo Switch devices on your network can access and install games directly from the server.

## Features

- 🎮 **Network File Sharing** - Share your Switch game files (.nsz, .nsp, .xci, .xcz) over the network
- 📱 **Tinfoil Support** - JSON-based file index for Tinfoil app
- 🗂️ **DBI Support** - Apache-style directory listing for DBI app  
- 🐳 **Docker Ready** - Fully containerized with Docker Compose
- ⚡ **Auto Setup** - Automatic dependency installation on first run

## Quick Start

### Prerequisites

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)
- Git

### Installation

1. **Clone the repository**
   ```bash
   git clone <your-repo-url> SGS
   cd SGS
   ```

2. **Start the application**
   ```bash
   docker-compose up -d
   ```

   That's it! The application will automatically:
   - Install Composer dependencies
   - Install and build npm assets
   - Create storage symlinks
   - Start the web server

3. **Access the application**
   
   Open your browser and navigate to:
   ```
   http://localhost:8030
   ```

   Or replace `localhost` with your server's IP address.

## Adding Games

Place your Nintendo Switch game files in the `games/` directory. Supported formats:
- `.nsz` - Compressed NSP
- `.nsp` - Nintendo Submission Package
- `.xci` - NX Card Image
- `.xcz` - Compressed XCI

## Client Setup

### Tinfoil Setup

See [www/docs/TINFOIL.md](www/docs/TINFOIL.md) for detailed instructions or visit `http://YOUR_SERVER_IP:8030/docs/TINFOIL` in your browser.

### DBI Setup

See [www/docs/DBI.md](www/docs/DBI.md) for detailed instructions or visit `http://YOUR_SERVER_IP:8030/docs/DBI` in your browser.

## API Endpoints

- **Tinfoil Index**: `http://YOUR_SERVER_IP:8030/api/tinfoil`
- **DBI Browser**: `http://YOUR_SERVER_IP:8030/api/dbi`
- **Generic (work for Tinfoil and DBI)**: `http://YOUR_SERVER_IP:8030`

## License

This project is open-source. Feel free to use, modify, and distribute.
