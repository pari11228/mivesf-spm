**WP-CLI Commands (run on server via SSH or cPanel Terminal)**

- Set site URLs (if migrating / if incorrect):

```bash
wp option update home 'https://mivesf.ir/woocom'
wp option update siteurl 'https://mivesf.ir/woocom'
```

- Install & activate WooCommerce:

```bash
wp plugin install woocommerce --activate
```

- Install recommended plugins (example):

```bash
wp plugin install woocommerce-admin --activate
```

- Ensure admin user `mahmud` exists or reset password:

```bash
wp user get mahmud || wp user create mahmud mahmud@example.com --user_pass=1270156659 --role=administrator
wp user update mahmud --user_pass=1270156659
```

- Import database SQL (if you have a `.sql` file):

```bash
wp db import fruit-shop-setup.sql
```

- Search/Replace URLs after import (if moving domain):

```bash
wp search-replace 'http://old.example' 'https://mivesf.ir/woocom' --skip-columns=guid
```

- Flush rewrite rules & rebuild caches:

```bash
wp rewrite flush
wp cache flush || true
```

Notes:
- Use `--allow-root` on some hosted environments if running as root.
- If `wp` command is not available, ask host to enable WP-CLI or use cPanel Terminal.
