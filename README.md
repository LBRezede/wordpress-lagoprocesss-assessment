# Lucas Bacellar Portfolio and Showcase

Custom WordPress portfolio for `lagoprocess.fusioncore.com.br`.

## Scope

This repository is intended to version only the subdomain portfolio assets:

- `public/wp-content/themes/lago-process`
- `public/wp-content/plugins/lago-process-toolkit`
- `public/wp-content/mu-plugins`
- Docker and documentation files in this directory

WordPress core, uploads, cache, database dumps and secrets are intentionally ignored.

## Local Docker Review

```bash
docker compose up -d
```

The compose stack runs WordPress and MySQL for local review of the theme, plugin and mu-plugins. Production remains on the existing Nginx/PHP-FPM setup for `lagoprocess.fusioncore.com.br`.

## GitHub Publication

```bash
git init
git add README.md docker-compose.yml .gitignore public/wp-content/themes/lago-process public/wp-content/plugins/lago-process-toolkit public/wp-content/mu-plugins
git commit -m "Initial Lucas Bacellar portfolio showcase"
git branch -M main
git remote add origin git@github.com:YOUR_USER/lucas-bacellar-portfolio-showcase.git
git push -u origin main
```
