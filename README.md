# DecoyGuard
### Intelligent Cyber Intrusion Detection Through Cyber Decoys

DecoyGuard is a web-based cyber intrusion detection prototype that uses decoy files as bait to detect suspicious file access activity on monitored Windows hosts.

The system monitors access to designated decoy files, collects relevant Windows Security Event Log activities, and sends detected events to a centralized Laravel application through an authenticated API. Detection events are recorded and presented as alerts for further investigation.

## Project Overview

Traditional security monitoring can be challenging when suspicious activities are difficult to distinguish from legitimate user operations. DecoyGuard addresses this challenge by placing designated decoy files in monitored locations.

When a monitored decoy file is accessed, the Windows agent identifies the relevant event and reports it to the DecoyGuard application. The application records the event and generates an alert to help administrators investigate potentially suspicious activity.

## Key Features

- **Monitored Hosts** â€” Manage Windows hosts connected to the monitoring system.
- **Decoy Folders** â€” Organize directories used to store decoy files.
- **Decoy Assets** â€” Manage registered decoy files and their active status.
- **Event Detection** â€” Receive file-access events collected from Windows Security Event Log.
- **Alert Management** â€” Review alerts, acknowledge them, and mark them as resolved.
- **Detection History** â€” View recorded detection events and related information.
- **API Authentication** â€” Authenticate agent requests using a Bearer token.

## How It Works

1. An administrator registers a monitored host and configures decoy folders and assets.
2. A Windows PowerShell agent monitors Windows Security Event Log activities.
3. The agent checks for file access events involving the configured decoy file.
4. Matching events are sent to the DecoyGuard API using an authenticated request.
5. The application validates the agent token and the associated folder and asset.
6. The detection event is stored, and an alert is generated based on its severity.
7. Administrators review and manage alerts through the web dashboard.

## System Architecture

**Windows Monitoring Agent**
- PowerShell script
- Windows Security Event Log
- File access event filtering

**Centralized Web Application**
- Laravel 12
- REST API
- MySQL database
- Web-based dashboard
- Event and alert management

## Technology Stack

| Component | Technology |
|---|---|
| Backend | Laravel 12 |
| Programming Language | PHP |
| Database | MySQL |
| Frontend | Blade, HTML, CSS, JavaScript |
| Monitoring Agent | Windows PowerShell |
| Event Source | Windows Security Event Log |
| API Communication | HTTP REST API with Bearer Token |
| Development Environment | XAMPP |

## Project Structure

```text
DecoyGuard/
â”œâ”€â”€ agent/
â”‚   â””â”€â”€ decoy-agent.ps1
â”œâ”€â”€ app/
â”‚   â”œâ”€â”€ Http/
â”‚   â”‚   â””â”€â”€ Controllers/
â”‚   â””â”€â”€ Models/
â”œâ”€â”€ database/
â”‚   â””â”€â”€ migrations/
â”œâ”€â”€ resources/
â”‚   â””â”€â”€ views/
â”œâ”€â”€ routes/
â”‚   â”œâ”€â”€ api.php
â”‚   â””â”€â”€ web.php
â”œâ”€â”€ tests/
â”œâ”€â”€ DecoyAssets/
â”œâ”€â”€ composer.json
â””â”€â”€ README.md
```

## Requirements

- PHP 8.2 or later
- Composer
- Node.js and npm
- MySQL
- XAMPP or another compatible PHP development environment
- Windows operating system for the monitoring agent
- Appropriate Windows Security Auditing configuration and permissions

## Installation

### 1. Clone the repository

```bash
git clone https://github.com/nabillah4125/DecoyGuard.git
cd DecoyGuard
```

### 2. Install dependencies

```bash
composer install
npm install
```

### 3. Configure environment

Copy `.env.example` to `.env`, then configure the application environment and MySQL connection.

```bash
copy .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Create the database and configure the database connection in `.env`.

### 4. Build frontend assets

```bash
npm run build
```

### 5. Start the application

```bash
php artisan serve
```

Open the application at:

```text
http://127.0.0.1:8000
```

**Database setup note:** The database schema and migration history must be aligned before performing a fresh installation. In particular, the current project database includes an alerts table whose migration still needs to be documented.

## Windows Agent Configuration

The monitoring agent is located at:

```text
agent/decoy-agent.ps1
```

Before running the agent, review its configuration values:

- `DecoyFile` â€” Path to the decoy file being monitored.
- `ApiUrl` â€” DecoyGuard event API endpoint.
- `FolderId` â€” Registered decoy folder identifier.
- `AssetId` â€” Registered decoy asset identifier.
- `TokenPath` â€” Location of the agent authentication token.

The agent uses Windows Security Event ID **4663** to identify relevant object access activities. It filters for read operations involving the configured decoy file.

The Windows host must have the appropriate object access auditing and file system auditing settings enabled. The agent also requires sufficient permissions to read the Security event log.

## API Endpoint

| Method | Endpoint | Description |
|---|---|---|
| GET | `/api/test` | Check API availability |
| POST | `/api/events` | Submit a detection event |

The event submission endpoint requires a valid Bearer token.

## Current Implementation Notes

- The monitoring agent currently uses a configured decoy file path and API endpoint.
- The agent checks Windows Security Event Log periodically.
- Event detection currently focuses on read access to the configured decoy file.
- The monitoring agent uses configured folder and asset identifiers.
- The application records detection events and generates alerts based on event severity.

## Security Considerations

- Do not publish `.env` files, API tokens, credentials, or production database exports.
- Use synthetic data for demonstration purposes.
- Keep agent authentication tokens confidential.
- Configure appropriate permissions for Windows Security Event Log access.
- Do not deploy the prototype to production without additional security testing.

## Project Information

**Project:** DecoyGuard
**Tagline:** Intelligent Cyber Intrusion Detection Through Cyber Decoys
**Category:** Penangkalan
**Event:** Kartika Cyber Hackathon 2026

**Developer:** Nabillah Usti Humairaa

---

*DecoyGuard is a cybersecurity project prototype developed for the Kartika Cyber Hackathon 2026.*
