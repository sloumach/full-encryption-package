# 🔐 Full Encryption for Laravel:

A lightweight Laravel package that enables **user-specific encryption and decryption** using a unique encrypted key stored per user.  
Useful for securely storing sensitive user data like messages or personal info.

---

## 🚀 Features:

- Simple methods: `fullEncrypt()` and `fullDecrypt()`
- Each user has a unique encryption key (`enckey`)
- Easy integration using a **trait** or **facade**
- Laravel versions supported: `^8.0 | ^9.0 | ^10.0 | ^11.0 | ^12.0`

---

## 📦 Installation

```bash
composer require sloumach/full-encryption-package


```
# If you're using a GitHub VCS repo:

```json
"repositories": [
  {
    "type": "vcs",
    "url": "https://github.com/sloumach/full-encryption-package"
  }
]
```

## 🔧 Configuration & Setup:

# Publish config and migration
php artisan vendor:publish --tag=full-encryption-config
php artisan vendor:publish --tag=full-encryption-migrations

Then run the migration:
php artisan migrate

Generate encrypted keys for all users
php artisan full:generate-keys

## 🧬 Usage:

# Option 1 – Via Facade:
```php
use FullEncryption\Facades\FullEncrypted;
use App\Models\User;
$user = User::first();
$encrypted = FullEncrypted::fullEncrypt('Hello world!', $user);
$decrypted = FullEncrypted::fullDecrypt($encrypted, $user);
```
# Option 2 – Via Trait:
```php
use FullEncryption\Traits\Encryptable;
class User extends Authenticatable {
    use Encryptable;
}
```
# Then call:
```php
$user = User::first();
$encrypted = $user->fullEncrypt('Hello word');
$decrypted = $user->fullDecrypt($encrypted);
```
# ⚙️ How It Works:

Each user has an enckey (stored encrypted) generated from their email.
This enckey is used as a symmetric key for AES-based encryption.
The package does not depend on Laravel's APP_KEY.

# 🛡️ Security Notes:

The encrypted key itself is protected using Laravel's encryption system.
You can override the logic by extending the service class.