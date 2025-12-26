# DBI Setup Guide

Setup SGS with DBI on your Nintendo Switch.

## Prerequisites

- Nintendo Switch with CFW
- DBI installed
- SGS server running
- Same network

## Instructions

### 1. Find Server IP

Run `ip addr show` (Linux), `ipconfig` (Windows), or `ifconfig` (macOS) to find your server's IP address.

### 2. Create DBI Locations File

On your SD card, create or edit the file `/switch/dbi/dbi.locations`

Add the following content:

```ini
[Location_0]
Name=Switch Games Server
Type=ApacheHTTP
URL=http://YOUR_IP:8030/
```

**Or** if you prefer the API endpoint:

```ini
[Location_0]
Name=Switch Games Server
Type=ApacheHTTP
URL=http://YOUR_IP:8030/api/dbi
```

**Note**: If you already have other locations configured, use `[Location_X]` where X is the next available number (e.g., if you have `Location_0` and `Location_1`, use `Location_2`).

### 3. Launch DBI

Open DBI from your Switch home menu.

### 4. Select Your Server

Choose "Switch Games Server" from the list.

### 5. Browse and Install

Navigate through folders and install your games!

## Features

- Apache-style directory listing
- Folder navigation
- Supports .nsz, .nsp, .xci, .xcz

## Troubleshooting

- **Connection Timeout**: Check network and firewall
- **Empty Folders**: Verify games in `games/` directory
- **Install Fails**: Check Switch storage space
- **Server Not Listed**: Verify the `dbi.locations` file is in the correct location and properly formatted
