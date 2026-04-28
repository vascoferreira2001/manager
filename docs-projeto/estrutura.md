/project-root
├─ .env
├─ .git/
├─ .git-rewrite/
├─ .gitignore
├─ Config/
│  ├─ app.php
│  ├─ database.php
│  ├─ plesk.php
│  ├─ routes.php
│  └─ stripe.php
├─ README.MD
├─ app/
│  ├─ Controllers/
│  │  ├─ ClientController.php
│  │  └─ HomeController.php
│  ├─ Core/ (vazia)
│  ├─ Helpers/
│  │  └─ security.php
│  ├─ Middleware/ (vazia)
│  ├─ Models/
│  │  └─ Client.php
│  ├─ Modules/
│  │  ├─ Admin/
│  │  │  ├─ Controllers/
│  │  │  │  ├─ DashboardController.php
│  │  │  │  ├─ RoleController.php
│  │  │  │  └─ UserController.php
│  │  │  ├─ Roles/
│  │  │  │  └─ index.php
│  │  │  ├─ Users/
│  │  │  │  ├─ create.php
│  │  │  │  ├─ edit.php
│  │  │  │  └─ index.php
│  │  │  └─ Views/
│  │  │     ├─ dashboad.php
│  │  │     └─ layout.php
│  │  ├─ Auth/
│  │  │  ├─ Controllers/
│  │  │  │  ├─ AuthController.php
│  │  │  │  └─ ProfileController.php
│  │  │  ├─ Middleware/
│  │  │  │  ├─ AuthMiddleware.php
│  │  │  │  └─ PermissionMiddleware.php
│  │  │  ├─ Models/
│  │  │  │  └─ User.php
│  │  │  └─ Services/
│  │  │     ├─ AuthService.php
│  │  │     └─ TwoFactorService.php
│  │  ├─ Billing/
│  │  │  ├─ Controllers/
│  │  │  │  ├─ InvoiceController.php
│  │  │  │  ├─ PaymentController.php
│  │  │  │  └─ WebhookController.php
│  │  │  ├─ Jobs/
│  │  │  │  └─ InvoiceJob.php
│  │  │  ├─ Models/
│  │  │  │  └─ Invoice.php
│  │  │  └─ Services/
│  │  │     └─ BillingService.php
│  │  ├─ Clients/
│  │  │  ├─ Controllers/
│  │  │  │  └─ ClientController.php
│  │  │  ├─ Services/
│  │  │  │  └─ ClientDashboardService.php
│  │  │  └─ Views/
│  │  │     └─ dashboard/
│  │  │        ├─ hosting.php
│  │  │        ├─ index.php
│  │  │        └─ manager.php
│  │  ├─ Domains/ (vazia)
│  │  ├─ Orders/
│  │  │  ├─ Controllers/
│  │  │  │  └─ OrderController.php
│  │  │  ├─ Models/
│  │  │  │  └─ Order.php
│  │  │  └─ Services/
│  │  │     └─ OrderService.php
│  │  ├─ Products/
│  │  │  └─ Models/
│  │  │     └─ Product.php
│  │  ├─ Provisioning/
│  │  │  ├─ DTO/
│  │  │  │  └─ ProvisioningData.php
│  │  │  ├─ Drivers/
│  │  │  │  └─ PleskDriver.php
│  │  │  ├─ Exceptions/
│  │  │  │  └─ ProvisioningException.php
│  │  │  └─ Provisioning/
│  │  │     ├─ PleskService.php
│  │  │     └─ ProvisioningService.php
│  │  ├─ Services/
│  │  │  └─ RBACService.php
│  │  └─ Support/ (vazia)
│  ├─ Repositories/ (vazia)
│  └─ Services/ (vazia)
├─ composer.json
├─ composer.lock
├─ database.sql
├─ docs-projeto/
│  ├─ estrutura.md
│  └─ system-config.md
├─ public/
│  ├─ .htaccess
│  ├─ assets/ (vazia)
│  └─ index.php
├─ storage/
│  ├─ cache/ (vazia)
│  ├─ logs/ (vazia)
│  └─ uploads/ (vazia)
├─ system/
│  ├─ Bootstrap.php
│  ├─ Controller.php
│  ├─ Database.php
│  ├─ Request.php
│  ├─ Router.php
│  └─ helpers.php
└─ vendor/
   ├─ autoload.php
   ├─ composer/
   │  ├─ ClassLoader.php
   │  ├─ InstalledVersions.php
   │  ├─ LICENSE
   │  ├─ autoload_classmap.php
   │  ├─ autoload_files.php
   │  ├─ autoload_namespaces.php
   │  ├─ autoload_psr4.php
   │  ├─ autoload_real.php
   │  ├─ autoload_static.php
   │  ├─ installed.json
   │  ├─ installed.php
   │  └─ platform_check.php
   ├─ robthree/
   │  └─ twofactorauth/
   └─ stripe/
      ├─ stripe-php/
      │  ├─ CHANGELOG.md
      │  ├─ LICENSE
      │  ├─ README.md
      │  ├─ composer.json
      │  └─ lib/
      ├─ .claude/
      ├─ .gitignore
      ├─ CHANGELOG.md
      ├─ CODEGEN_VERSION
      ├─ CONTRIBUTING.md
      ├─ LICENSE
      ├─ OPENAPI_VERSION
      ├─ README.md
      ├─ VERSION
      ├─ composer.json
      ├─ data/
      ├─ init.php
      ├─ justfile
      └─ lib/
