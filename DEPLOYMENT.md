# Deployment Guide

## 🚀 Quick Deployment

### Local Development
```bash
./docker-setup.sh
```

### Server Deployment
```bash
./server-setup.sh
```

## 📁 Key Files

### Server Deployment Files
- **`Dockerfile.simple`**: Optimized for server environments
- **`docker-entrypoint.sh`**: Handles dependency installation and Laravel setup
- **`docker-compose.server.yml`**: Server-specific configuration
- **`server-setup.sh`**: Automated server deployment

### Local Development Files
- **`Dockerfile`**: Standard development setup
- **`docker-compose.yml`**: Standard configuration
- **`docker-setup.sh`**: Local development setup

## 🔧 Troubleshooting

### Server Issues
1. Use `./server-setup.sh` for fresh server deployment
2. Check logs: `docker compose logs -f`
3. Restart: `docker compose restart`

### Database Issues
1. Remove volume: `docker volume rm pdf-generate_dbdata`
2. Restart: `docker compose up -d`
3. Setup: `docker compose exec app php artisan migrate:fresh --seed`

## 🌐 Access Points
- **Application**: http://localhost:8000 (local) / http://152.42.201.131:8000 (server)
- **Compensation List**: http://localhost:8000/compensations
- **Database**: localhost:3307 