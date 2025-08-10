# Quick Deployment Guide for Code Changes

This guide explains how to deploy code changes quickly without running the full deployment script that consumes lots of CPU and time.

## 🚀 Available Deployment Scripts

### 1. `quick-update.sh` - **RECOMMENDED for daily use**
- **What it does**: Pulls latest Git changes + minimal deployment
- **When to use**: After pushing code changes to Git
- **Resource usage**: Very low (no container rebuilds)
- **Time**: ~30 seconds

### 2. `deploy-code-only.sh` - **Ultra-minimal deployment**
- **What it does**: Only clears cache and optimizes (no Git operations)
- **When to use**: When code is already updated on server
- **Resource usage**: Minimal (just Laravel commands)
- **Time**: ~10 seconds

### 3. `deploy-minimal.sh` - **Minimal with migrations**
- **What it does**: Cache clearing + migrations + container restart
- **When to use**: When you need database changes
- **Resource usage**: Low (container restart only)
- **Time**: ~1-2 minutes

### 4. `deploy-production.sh` - **Full deployment**
- **What it does**: Complete rebuild + migrations + setup
- **When to use**: Only when absolutely necessary
- **Resource usage**: High (full rebuild)
- **Time**: 5-10 minutes

## 📋 Quick Update Workflow

### For Small Code Changes (Most Common)

```bash
# 1. Push your changes to Git
git add .
git commit -m "Your commit message"
git push origin master

# 2. On the server, run quick update
./quick-update.sh
```

This will:
- ✅ Pull latest changes from Git
- ✅ Clear Laravel cache
- ✅ Optimize for production
- ✅ No container rebuilds
- ✅ No database operations
- ✅ Ready in ~30 seconds

### For Code Changes Without Git (Direct Server Edit)

```bash
# If you edited files directly on server
./deploy-code-only.sh
```

This will:
- ✅ Clear all Laravel caches
- ✅ Optimize for production
- ✅ No container operations
- ✅ Ready in ~10 seconds

## 🔧 How It Works

Your setup uses **volume mounting** (`./:/var/www` in docker-compose), which means:

- ✅ **Code changes are immediately available** in the container
- ✅ **No need to rebuild containers** for code updates
- ✅ **No need to restart containers** for most changes
- ✅ **Only cache clearing is needed** for Laravel to see changes

## 📊 Resource Usage Comparison

| Script | CPU Usage | Memory | Time | Use Case |
|--------|-----------|---------|------|----------|
| `quick-update.sh` | 🟢 Very Low | 🟢 Low | 🟢 30s | Daily code updates |
| `deploy-code-only.sh` | 🟢 Minimal | 🟢 Low | 🟢 10s | Cache clearing only |
| `deploy-minimal.sh` | 🟡 Low | 🟡 Low | 🟡 1-2m | Code + migrations |
| `deploy-production.sh` | 🔴 High | 🔴 High | 🔴 5-10m | Full rebuild needed |

## 🚨 When to Use Full Deployment

Only use `./deploy-production.sh` when you need:

- 🔄 **New Docker images** (Dockerfile changes)
- 🔄 **New system packages** (apt-get, npm global packages)
- 🔄 **Environment changes** (new environment variables)
- 🔄 **Major infrastructure changes**
- 🔄 **Database schema changes** (if migrations fail)

## 💡 Pro Tips

### 1. **Always use `quick-update.sh` first**
```bash
./quick-update.sh
```

### 2. **If something breaks, try minimal deployment**
```bash
./deploy-minimal.sh
```

### 3. **Only use full deployment as last resort**
```bash
./deploy-production.sh
```

### 4. **Check what changed before deploying**
```bash
git log --oneline -5
```

### 5. **Monitor deployment with logs**
```bash
docker compose -f docker-compose.server.yml logs -f app
```

## 🔍 Troubleshooting

### Code changes not visible?
```bash
# Clear cache manually
docker compose -f docker-compose.server.yml exec app php artisan cache:clear
docker compose -f docker-compose.server.yml exec app php artisan view:clear
```

### Application errors?
```bash
# Check logs
docker compose -f docker-compose.server.yml logs -f app

# Check container status
docker ps
```

### Still not working?
```bash
# Try minimal deployment
./deploy-minimal.sh

# If all else fails, full deployment
./deploy-production.sh
```

## 📱 Quick Commands Reference

```bash
# Daily workflow
./quick-update.sh

# Just clear cache
./deploy-code-only.sh

# With migrations
./deploy-minimal.sh

# Full rebuild (avoid unless necessary)
./deploy-production.sh

# Check status
docker ps
docker compose -f docker-compose.server.yml logs -f app

# Test application
curl http://localhost:8000
```

## 🎯 Best Practices

1. **Always use `quick-update.sh` for code changes**
2. **Commit and push changes before deploying**
3. **Test changes after deployment**
4. **Monitor logs for any errors**
5. **Keep full deployment as backup option**

---

**Remember**: With volume mounting, your code changes are immediately available. You only need to clear Laravel's cache to see them! 🚀
