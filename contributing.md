# 🛠️ Developer Guide — ZeShop E-Commerce Platform

> Built on top of [Shopper](https://laravelshopper.dev) — a headless e-commerce admin panel for Laravel.

---

## 📋 Table of Contents

1. [Project Overview](#project-overview)
2. [Tech Stack](#tech-stack)
3. [Local Setup](#local-setup)
4. [Project Architecture](#project-architecture)
5. [Roles & Permissions](#roles--permissions)
6. [How to Add a New Module](#how-to-add-a-new-module)
7. [Extending Existing Shopper Models](#extending-existing-shopper-models)
8. [Adding to the Sidebar](#adding-to-the-sidebar)
9. [Task Distribution](#task-distribution)
10. [Git Workflow](#git-workflow)
11. [Coding Standards](#coding-standards)
12. [Common Commands](#common-commands)

---

## 1. Project Overview

This platform is a full e-commerce and sales management system built for a group project. It extends the Shopper framework with custom modules for:

- **Commission** management (Seller commissions)
- **Delivery** assignment and tracking
- **Financial Reports** (Accountant module)
- **Internal Messaging** between actors
- **Voucher/Receipt** generation from transactions
- **Multi-role hierarchy** (Admin, Manager, Accountant, Stock Manager, Delivery Person, Seller, Buyer)

---

## 2. Tech Stack

| Technology | Version | Purpose |
|------------|---------|---------|
| PHP | 8.3+ | Backend language |
| Laravel | 12.x | PHP Framework |
| Shopper | 2.1.6 | E-commerce admin panel |
| Livewire | 3.x | Reactive UI components |
| Filament | 3.x | Form/Table UI components |
| Tailwind CSS | 4.x | Styling |
| Alpine.js | 3.x | JS interactivity |
| MySQL | 8.x | Database |
| Spatie Permission | 6.x | Roles & permissions |
| Spatie Media Library | 11.x | File/image uploads |

---

## 3. Local Setup

### Prerequisites
- PHP 8.3+ with extensions: `intl`, `zip`, `pdo_mysql`, `mbstring`, `openssl`
- Composer 2.x
- Node.js 18+
- MySQL 8.x (via Laragon recommended)
- Git

### Installation Steps

```bash
# 1. Clone the repository
git clone https://github.com/YOUR_USERNAME/YOUR_REPO.git
cd YOUR_REPO

# 2. Install PHP dependencies
composer install

# 3. Install JS dependencies
npm install

# 4. Copy environment file
cp .env.example .env

# 5. Update .env with shared database credentials
# (Get credentials from team lead)
DB_CONNECTION=mysql
DB_HOST=your_host
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

# 6. Generate app key
php artisan key:generate

# 7. Run migrations and seeders
php artisan migrate
php artisan db:seed

# 8. Publish Shopper assets
php artisan shopper:install
php artisan filament:assets
php artisan storage:link

# 9. Build frontend assets
npm run build

# 10. Start the server
php artisan serve
```

### Access the admin panel
Open your browser at: `http://localhost:8000/cpanel`

---

## 4. Project Architecture

```
app/
├── Models/                    # Eloquent models
│   ├── User.php               # Extends Shopper's User (DO NOT remove existing methods)
│   ├── Commission.php         # New: Seller commission records
│   ├── Message.php            # New: Internal messaging
│   ├── Report.php             # New: Financial/operational reports
│   └── Voucher.php            # New: Payment vouchers/receipts
│
├── Actions/                   # Single-responsibility action classes
│   ├── CreateCommissionAction.php
│   ├── GenerateVoucherAction.php
│   ├── GenerateReportAction.php
│   └── AssignDeliveryAction.php
│
├── Livewire/                  # Livewire page components
│   ├── Commission/
│   │   ├── Index.php
│   │   └── Create.php
│   ├── Messages/
│   │   ├── Index.php
│   │   └── Thread.php
│   ├── Reports/
│   │   └── Index.php
│   └── Vouchers/
│       └── Index.php
│
└── Policies/                  # Authorization policies
    ├── CommissionPolicy.php
    ├── MessagePolicy.php
    └── ReportPolicy.php

database/
├── migrations/                # Database migrations
└── seeders/
    ├── RolesSeeder.php        # Custom roles
    └── DatabaseSeeder.php

resources/
└── views/
    └── livewire/              # Blade view files for Livewire components
        ├── commission/
        ├── messages/
        ├── reports/
        └── vouchers/

routes/
└── web.php                    # Add custom routes here
```

---

## 5. Roles & Permissions

The system uses **Spatie Laravel Permission** for role-based access control.

### Defined Roles

| Role | Description | Access |
|------|-------------|--------|
| `admin` | Full system access | Everything |
| `manager` | Day-to-day operations | Orders, Deliveries, Messages, Reports |
| `accountant` | Financial management | Transactions, Reports, History |
| `stock_manager` | Inventory management | Products, Inventory, Suppliers |
| `delivery_person` | Order fulfillment | Assigned deliveries only |
| `seller` | Product listings | Own products, commissions |
| `customer` | End buyer | Orders, own profile |

### Assigning a Role to a User

```php
$user->assignRole('manager');
$user->assignRole('accountant');

// Check role
$user->hasRole('admin');

// Check permission
$user->can('view reports');
```

### Adding New Permissions

Add permissions in `database/seeders/RolesSeeder.php`:

```php
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

// Create permission
Permission::create(['name' => 'view commissions']);
Permission::create(['name' => 'manage commissions']);

// Assign to role
$manager = Role::findByName('manager');
$manager->givePermissionTo(['view commissions', 'manage commissions']);
```

---

## 6. How to Add a New Module

Follow these steps every time you add a new feature (e.g., Commission module):

### Step 1 — Create the Migration

```bash
php artisan make:migration create_commissions_table
```

Edit the migration file in `database/migrations/`:

```php
public function up(): void
{
    Schema::create('commissions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('order_id')->constrained('sh_orders')->onDelete('cascade');
        $table->decimal('amount', 10, 2);
        $table->decimal('rate', 5, 2); // percentage
        $table->enum('status', ['pending', 'paid', 'cancelled'])->default('pending');
        $table->timestamps();
    });
}
```

Run the migration:
```bash
php artisan migrate
```

### Step 2 — Create the Model

```bash
php artisan make:model Commission
```

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commission extends Model
{
    protected $fillable = [
        'seller_id',
        'order_id',
        'amount',
        'rate',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'rate' => 'decimal:2',
        ];
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(\Shopper\Core\Models\Order::class, 'order_id');
    }
}
```

### Step 3 — Create the Action Class

```bash
mkdir app/Actions
```

Create `app/Actions/CreateCommissionAction.php`:

```php
<?php

namespace App\Actions;

use App\Models\Commission;
use Shopper\Core\Models\Order;

final class CreateCommissionAction
{
    public function execute(Order $order, float $rate = 10.0): Commission
    {
        return Commission::create([
            'seller_id' => $order->seller_id,
            'order_id' => $order->id,
            'amount' => $order->total * ($rate / 100),
            'rate' => $rate,
            'status' => 'pending',
        ]);
    }
}
```

### Step 4 — Create Livewire Components

```bash
php artisan make:livewire Commission/Index
php artisan make:livewire Commission/Create
```

Edit `app/Livewire/Commission/Index.php`:

```php
<?php

namespace App\Livewire\Commission;

use App\Models\Commission;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class Index extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Commission::query())
            ->columns([
                Tables\Columns\TextColumn::make('seller.first_name')
                    ->label('Seller')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('rate')
                    ->suffix('%'),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'paid',
                        'danger' => 'cancelled',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public function render(): View
    {
        return view('livewire.commission.index');
    }
}
```

### Step 5 — Create the Blade View

Create `resources/views/livewire/commission/index.blade.php`:

```blade
<div>
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
            Commissions
        </h1>
        <a href="{{ route('commissions.create') }}"
           class="rounded-lg bg-primary-600 px-4 py-2 text-white hover:bg-primary-700">
            Add Commission
        </a>
    </div>

    {{ $this->table }}
</div>
```

### Step 6 — Add the Route

In `routes/web.php`:

```php
use App\Livewire\Commission\Index as CommissionIndex;
use App\Livewire\Commission\Create as CommissionCreate;

Route::middleware(['auth', 'shopper.auth'])
    ->prefix('cpanel')
    ->group(function () {
        Route::get('/commissions', CommissionIndex::class)->name('commissions.index');
        Route::get('/commissions/create', CommissionCreate::class)->name('commissions.create');
    });
```

### Step 7 — Add to Sidebar (optional)

In `app/Providers/AppServiceProvider.php`, add:

```php
use Shopper\Sidebar\Contracts\Builder\Group;
use Shopper\Sidebar\Contracts\Builder\Item;

// Inside the boot() method:
\Shopper\Sidebar\SidebarManager::addItem(
    group: 'catalog',
    item: fn (Item $item) => $item
        ->name('Commissions')
        ->route('commissions.index')
        ->icon('heroicon-o-currency-dollar')
);
```

---

## 7. Extending Existing Shopper Models

**Never modify files inside `vendor/`** — changes there will be lost on `composer update`.

Instead, override models via config. For example, to extend the Order model:

```php
// app/Models/Order.php
<?php

namespace App\Models;

use Shopper\Core\Models\Order as ShopperOrder;

class Order extends ShopperOrder
{
    // Add your custom methods here
    public function commission()
    {
        return $this->hasOne(Commission::class);
    }
}
```

Then update `config/shopper/models.php`:

```php
'order' => \App\Models\Order::class,
```

---

## 8. Adding to the Sidebar

Shopper's sidebar is managed by the `shopper/sidebar` package. To add a new section:

Publish the sidebar config:
```bash
php artisan vendor:publish --tag=shopper-sidebar
```

Then edit `config/shopper/sidebar.php` to add your custom items.

---

## 9. Task Distribution

| Member | Module | Models | Routes |
|--------|--------|--------|--------|
| Bryan | Architecture + Git + Stock Manager | `User`, `Inventory` | `/cpanel/inventory` |
| Member 2 | Commission System | `Commission` | `/cpanel/commissions` |
| Member 3 | Delivery + Delivery Person | `Delivery` | `/cpanel/deliveries` |
| Member 4 | Reports + Accountant | `Report` | `/cpanel/reports` |
| Member 5 | Messages | `Message` | `/cpanel/messages` |
| Member 6 | Voucher/Receipt | `Voucher` | `/cpanel/vouchers` |

> **Rule:** Each member works on their own branch and submits a Pull Request for review.

---

## 10. Git Workflow

### Branching strategy

```
main              ← Production-ready code only
└── develop       ← Integration branch
    ├── feature/commission
    ├── feature/delivery
    ├── feature/reports
    ├── feature/messages
    └── feature/vouchers
```

### Daily workflow

```bash
# 1. Always pull latest changes before starting work
git checkout develop
git pull origin develop

# 2. Create your feature branch
git checkout -b feature/your-module-name

# 3. Work on your feature...

# 4. Stage and commit your changes
git add .
git commit -m "feat: add commission index page"

# 5. Push your branch
git push origin feature/your-module-name

# 6. Open a Pull Request on GitHub targeting develop
```

### Commit message format

```
feat: add commission model and migration
fix: resolve scopeCustomers error on User model
refactor: move commission logic to action class
docs: update setup instructions
```

---

## 11. Coding Standards

### PHP Rules (enforced by Laravel Pint)

- Always declare `declare(strict_types=1);` at the top of every PHP file
- Use `===` instead of `==` for comparisons
- Action classes must be `final` with a single `execute()` method
- Models use `protected $guarded = []` instead of `$fillable` where possible
- Use arrow functions `fn() =>` instead of `function() {}`

### Naming Conventions

| Type | Convention | Example |
|------|-----------|---------|
| Model | PascalCase | `Commission` |
| Migration | snake_case | `create_commissions_table` |
| Livewire Component | PascalCase | `CommissionIndex` |
| Route name | dot.notation | `commissions.index` |
| Blade view | kebab-case | `commission-index.blade.php` |
| Action class | PascalCase + Action | `CreateCommissionAction` |

### File Organization Rules

- One class per file
- Keep controllers/components thin — move logic to Action classes
- Never put business logic in Blade views
- Always use policies for authorization checks

---

## 12. Common Commands

```bash
# Start development server
php artisan serve

# Run migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Run seeders
php artisan db:seed

# Clear all caches
php artisan optimize:clear

# Generate IDE helpers (if installed)
php artisan ide-helper:generate

# Run code formatter
composer lint

# Create a new Livewire component
php artisan make:livewire ComponentName

# Create a new model with migration
php artisan make:model ModelName -m

# Create a new seeder
php artisan make:seeder SeederName

# List all routes
php artisan route:list

# Rebuild autoloader
composer dump-autoload

# Install npm dependencies and build
npm install && npm run build

# Watch for frontend changes
npm run dev
```

---

## ⚠️ Important Rules

1. **Never commit `.env`** — it contains sensitive credentials
2. **Never edit files in `vendor/`** — use extension/override patterns instead
3. **Always pull before pushing** — avoid merge conflicts
4. **Test your migrations** before pushing — run `php artisan migrate:fresh --seed` locally
5. **One feature per branch** — keep PRs small and focused
6. **Ask before changing shared files** — `User.php`, `AppServiceProvider.php`, `web.php`

---

*Last updated: May 2026 — ZeShop Group Project*