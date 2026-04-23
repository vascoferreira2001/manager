/project-root
├─ .env
├─ composer.json
├─ phpunit.xml
├─ README.md
├─ public
│  ├─ index.php
│  └─ assets
│     ├─ css
│     └─ js
├─ app
│  ├─ Config
│  │  ├─ Routes.php
│  │  └─ App.php
│  ├─ Controllers
│  │  ├─ AuthController.php
│  │  ├─ CheckoutController.php
│  │  ├─ WebhookController.php
│  │  └─ AdminController.php
│  ├─ Models
│  │  ├─ UserModel.php
│  │  ├─ PlanModel.php
│  │  ├─ OrderModel.php
│  │  └─ InvoiceModel.php
│  ├─ Services
│  │  ├─ CustomerCodeService.php
│  │  ├─ EncryptionService.php
│  │  ├─ PaymentService.php
│  │  └─ ProvisionService.php
│  ├─ Jobs
│  │  ├─ ProcessWebhookJob.php
│  │  └─ ProvisionJob.php
│  ├─ Libraries
│  │  └─ Queue.php
│  ├─ Views
│  │  ├─ public
│  │  │  ├─ catalog.php
│  │  │  └─ product.php
│  │  └─ client
│  │     ├─ dashboard.php
│  │     └─ invoices.php
│  └─ Migrations
│     └─ 20260423_create_users.sql
├─ storage
│  ├─ logs
│  └─ invoices
└─ ci
   └─ azure-pipelines.yml
