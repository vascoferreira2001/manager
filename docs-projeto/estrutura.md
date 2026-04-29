## Estrutura Detalhada do Projeto

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
│  │  └─ HomeController.php
│  ├─ Core/
│  │  ├─ BaseController.php
│  │  ├─ BaseModel.php
│  │  ├─ Response.php
│  │  └─ Session.php
│  ├─ Helpers/
│  │  ├─ auth.php
│  │  ├─ response.php
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
│  │  │  ├─ Views/
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
│  │  │  │  ├─ Invoice.php
│  │  │  │  ├─ InvoiceItem.php
│  │  │  │  ├─ Payment.php
│  │  │  │  └─ Transction.php
│  │  │  └─ Services/
│  │  │     ├─ BillingService.php
│  │  │     └─ PaymentService.php
│  │  ├─ Clients/
│  │  │  ├─ Controllers/
│  │  │  │  ├─ ClientController.php
│  │  │  │  └─ DashboardController.php
│  │  │  ├─ Models/
│  │  │  │  └─ Hosting.php
│  │  │  ├─ Services/
│  │  │  │  └─ ClientDashboardService.php
│  │  │  └─ Views/
│  │  │     ├─ dashboard/
│  │  │     │  ├─ hosting.php
│  │  │     │  ├─ index.php
│  │  │     │  └─ manage.php
│  │  │     └─ layout.php
│  │  ├─ Domains/
│  │  │  ├─ Controllers/ (vazia)
│  │  │  ├─ Drivers/ (vazia)
│  │  │  ├─ Models/ (vazia)
│  │  │  └─ Services/ (vazia)
│  │  ├─ Hosting/
│  │  │  ├─ Controllers/
│  │  │  │  └─ HostingController.php
│  │  │  ├─ Models/
│  │  │  │  └─ Hosting.php
│  │  │  ├─ Repositories/
│  │  │  │  └─ HostingRepository.php
│  │  │  ├─ Services/
│  │  │  │  └─ HostingService.php
│  │  │  └─ Views/ (vazia)
│  │  ├─ Orders/
│  │  │  ├─ Controllers/
│  │  │  │  └─ OrderController.php
│  │  │  ├─ Models/
│  │  │  │  ├─ Order.php
│  │  │  │  └─ OrderItem.php
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
│  │  │     └─ ProvisioningService.php
│  │  ├─ Services/
│  │  │  └─ RBACService.php
│  │  └─ Support/ (vazia)
│  ├─ Repositories/
│  │  ├─ InvoiceRepository.php
│  │  └─ OrderRepository.php
│  └─ Views/
│     └─ layouts/
│        └─ base.php
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
│  ├─ logs/
│  │  └─ app.log
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
   │     ├─ CHANGELOG.md
   │     ├─ LICENSE
   │     ├─ README.md
   │     ├─ composer.json
   │     └─ lib/
   └─ stripe/
      ├─ stripe-php/
      │  ├─ .claude/
      │  ├─ .gitignore
      │  ├─ CHANGELOG.md
      │  ├─ CODEGEN_VERSION
      │  ├─ CONTRIBUTING.md
      │  ├─ LICENSE
      │  ├─ OPENAPI_VERSION
      │  ├─ README.md
      │  ├─ VERSION
      │  ├─ composer.json
      │  ├─ data/
      │  ├─ init.php
      │  ├─ justfile
      │  └─ lib/


   ---

   ## Funcionalidades e Lógicas do Sistema

   ### Gestão de Clientes
   - CRUD completo de clientes (listar, criar, editar, eliminar)
   - Proteção por middleware de autenticação

   ### Dashboard do Cliente
   - Mostra resumo de serviços ativos, faturas e ordens
   - Lista de serviços de hosting recentes
   - Detalhe de cada serviço de hosting

   ### Provisionamento Automático
   - Serviço de provisionamento (`ProvisioningService`) que:
     - Evita duplicação de contas
     - Busca dados do cliente e produto
     - Gera credenciais e domínio
     - Usa driver Plesk para criar conta de hosting
     - Regista sucesso ou falha na base de dados

   ### Integração com Plesk
   - Driver para criar, suspender, alterar password e gerar login SSO para contas de hosting

   ### Gestão de Orders, Products, Invoices
   - Cada módulo tem controllers, models e services para manipulação dos dados
   - Ligação entre orders, produtos e planos

   ### Segurança
   - Middleware de autenticação protege rotas sensíveis
   - Separação clara entre lógica de negócio (Services), acesso a dados (Models) e apresentação (Views)
