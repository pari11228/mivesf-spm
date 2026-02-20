#!/usr/bin/env bash
# Server-side helper script to run on the hosting server (SSH or cPanel Terminal)
# Usage: place spm-clean.zip in the target directory (/domains/mivesf.ir/private_html/woocom)
# then run: sudo bash server_setup.sh

set -euo pipefail

BACKUP_DIR="backup-before-deploy-$(date +%Y%m%d%H%M%S)"
ROOT_DIR="$(pwd)"

echo "Root dir: $ROOT_DIR"
echo "Creating backup..."
mkdir -p "$BACKUP_DIR"
cp -a . "$BACKUP_DIR/website_files"

if [ -f spm-clean.zip ]; then
  echo "Extracting spm-clean.zip"
  unzip -o spm-clean.zip -d .
else
  echo "spm-clean.zip not found in current directory. Place it in $ROOT_DIR and re-run." >&2
  exit 2
fi

echo "Removing installer and sensitive files if present..."
rm -f setup-final.php setup-simple.php create-fruit-shop.php complete-setup.php install-woocommerce.php quick-import.php import-products.php reset-password.php *.sql *.env* FILES-PACKAGE.txt FINAL-INSTALL-STEPS.txt QUICK-INSTALL.txt

echo "Setting recommended permissions..."
find . -type d -exec chmod 755 {} +
find . -type f -exec chmod 644 {} +

echo "If WP-CLI is installed on server, next commands will run. If not, run them manually via cPanel Terminal or ask host to enable WP-CLI."

if command -v wp >/dev/null 2>&1; then
  echo "Running WP-CLI maintenance tasks..."
  # Fix site URLs if needed (replace example placeholders below if necessary)
  # wp option update home 'https://mivesf.ir/woocom'
  # wp option update siteurl 'https://mivesf.ir/woocom'

  # Ensure WooCommerce is installed and activated
  wp plugin install woocommerce --activate --allow-root || wp plugin activate woocommerce --allow-root

  # Ensure admin user exists — DO NOT change credentials unless you intend to
  if ! wp user get mahmud --allow-root >/dev/null 2>&1; then
    echo "User 'mahmud' not found — creating user with provided password (change after login)"
    wp user create mahmud mahmud@example.com --user_pass=1270156659 --role=administrator --allow-root
  else
    echo "Resetting password for 'mahmud'"
    wp user update mahmud --user_pass=1270156659 --allow-root
  fi

  echo "Flushing rewrite rules and clearing cache (if WP-CLI cache plugins present)"
  wp rewrite flush --allow-root
else
  echo "WP-CLI not found. Install WP-CLI or use cPanel Terminal to run these commands manually:"
  echo "  wp plugin install woocommerce --activate"
  echo "  wp user update mahmud --user_pass=1270156659"
  echo "  wp rewrite flush"
fi

echo "Finished. Backup saved in: $BACKUP_DIR"
