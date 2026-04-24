# Laravel to Vercel Deployment Guide

## 🚀 Quick Start

### 1. Install Vercel CLI
```bash
npm i -g vercel
```

### 2. Login to Vercel
```bash
vercel login
```

### 3. Deploy Project
```bash
cd /path/to/your/project
vercel --prod
```

## ⚙️ Configuration Files Created

### ✅ vercel.json
- Laravel framework detection
- Build command: `npm run build`
- Output directory: `public`
- URL rewrites to `index.php`

### ✅ Environment Setup
Update your `.env` file for production:
```env
APP_ENV=production
APP_URL=https://your-domain.vercel.app
APP_DEBUG=false
```

## 🔧 Build Process

Vercel automatically:
1. Installs dependencies
2. Runs `npm run build`
3. Deploys `public/` directory
4. Configures CDN for assets

## 🌐 After Deployment

1. **Domain Setup**: Your domain will be `your-domain.vercel.app`
2. **SSL Certificate**: Automatic free SSL
3. **Global CDN**: Assets served from edge locations
4. **Zero Downtime**: Instant rollbacks

## 🐛 Troubleshooting

### Assets Not Loading
- Clear Vercel cache: `vercel --prod --force`
- Check browser DevTools Network tab
- Verify asset URLs in page source

### Database Issues
Vercel supports external databases:
- **PlanetScale** (PostgreSQL)
- **Upstash** (Redis)
- **MongoDB Atlas**

Add to `.env`:
```env
DB_CONNECTION=pgsql
DB_HOST=your-db-host.vercel.app
DB_DATABASE=your_db_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

## 📱 Assets & Performance

- Images automatically optimized
- CSS/JS minified and gzipped
- Edge caching for static files
- Brotli compression enabled

## 🔄 Custom Domain

1. Add custom domain in Vercel dashboard
2. Update DNS to point to Vercel
3. Update `APP_URL` in `.env`

## 📊 Monitoring

- Vercel Analytics built-in
- Real-time logs
- Performance metrics
- Error tracking

---

**Need help?** Check Vercel docs: https://vercel.com/docs/frameworks/laravel
