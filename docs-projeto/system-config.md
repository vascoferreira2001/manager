## Visão Arquitetural (Macro)

- Camadas

[ Presentation Layer ]
    ├── Admin Panel (Bootstrap + jQuery)
    ├── Client Portal
    └── API (REST)

[ Application Layer ]
    ├── Services (Business Logic)
    ├── Use Cases (Actions)
    └── Validators

[ Domain Layer ]
    ├── Entities (Client, Invoice, Service, Domain, Ticket)
    ├── Value Objects
    └── Contracts (Interfaces)

[ Infrastructure Layer ]
    ├── DB (MySQL)
    ├── External APIs (Stripe, PayPal, Plesk)
    ├── Email सिस्टम
    └── Logging / Queue / Cache

## Estrutura Modular (Core do Sistema)

/modules
    /Clients
    /Billing
    /Services
    /Domains
    /Support
    /Auth
    /Notifications
    /Provisioning
    /Reports
    /Settings

Cada módulo contém:

Controllers/
Services/
Repositories/
Entities/
Routes.php
Migrations/

## Modelagem de Domínio

Core Entities
Client
User (staff)
Role / Permission
Service (hosting)
Domain
Invoice
InvoiceItem
Transaction
Ticket
Department
Contract
Quote (Orçamento)

## Fluxo de Compra (Checkout)

Cliente → Escolhe plano
        → Escolhe domínio
        → Checkout
        → Criação de Order
        → Geração de Invoice
        → Pagamento
            ├── Automático (Stripe/PayPal)
            │       → Webhook
            │       → Confirm Payment
            │       → Provision Service
            │
            └── Manual
                    → Aguarda validação
                    → Finance aprova
                    → Provision Service

## Fluxo de Provisionamento

Payment Confirmed
    ↓
Provisioning Service
    ↓
Driver (Plesk / cPanel)
    ↓
Create Account
    ↓
Guardar credenciais
    ↓
Enviar email ao cliente

Provisionamento Interface

ProvisioningInterface
    ├── PleskDriver
    ├── CPanelDriver

## Fluxo de Billing Automático

Cron Job diário:
    → Ver serviços a expirar
    → Gerar invoices
    → Enviar notificações
    → Se não pago:
        → Suspender serviço
    → Se pago:
        → Renovar automaticamente

## Fluxo de Tickets

Cliente abre ticket
    ↓
Departamento atribuído
    ↓
Staff responde
    ↓
Logs + notificações
    ↓
Encerramento

## Segurança

Password hashing → password_hash()
2FA → TOTP (Google Authenticator)
CSRF Tokens
Rate limiting (login + API)
Logs auditáveis:
- user_id
- action
- entity
-  timestamp
- ip

## Sistema de Permissões

Administrador - admin
Suporte Técnico - support-technical
Suporte Financeiro - support-finance
Suporte ao Cliente - support-client
Cliente - client

admin
 ├── acesso total

support-technical
 ├── gerir serviços
 ├── ver clientes
 ├── gerir tickets técnicos

support-finance
 ├── ver faturas
 ├── gerir pagamentos
 ├── validar transferências

support-client
 ├── responder tickets
 ├── ver clientes
 ├── não mexe em billing

client
 ├── acesso ao portal
 ├── ver serviços próprios


## Sistema de Integrações

Pagamentos
- Paypal
- Stipe

PaymentGatewayInterface
    ├── StripeGateway
    ├── PayPalGateway

Provisionamento
- Plesk XML API
- cPanel API

Webhooks
/api/webhooks/stripe
/api/webhooks/paypal

## Sistema de Notificações

Multi-channel:
- Email
- In-app
- (futuro) SMS

NotificationService
    ├── EmailDriver
    ├── DatabaseDriver

## Sistema de Versões / Updates 

Implementa:
Version table:
- version
- applied_at
- changes

Update runner:
/updates/1.0.1.php
/updates/1.0.2.php

Rollback capability

## Cron no Servidor 

php /var/www/vhosts/teusite.com/httpdocs/cron.php

## Integração futura com pagamentos
Mais tarde vais ligar isto a:
Stripe
PayPal
Transferência manual

Fluxo:
Pagamento → webhook → marcar invoice como paid

Fluxo completo do sistema

Admin cria invoice
    ↓
Cliente recebe
    ↓
Cliente paga
    ↓
Sistema recebe pagamento
    ↓
Invoice → PAID
    ↓
(automação futura → provisionamento hosting)

## Fluxo completo (Stripe)

Cliente → Clica pagar
    ↓
Sistema cria Stripe Checkout Session
    ↓
Cliente paga no Stripe
    ↓
Stripe envia Webhook
    ↓
Sistema marca Invoice como PAID


## WEBHOOK NO STRIPE (ATIVAR AINDA)

🌐 8. Configurar Webhook no Stripe
Vai ao dashboard Stripe:
👉 Developers → Webhooks
Adiciona:
http://teusite.com/stripe/webhook
Eventos:
checkout.session.completed
🧪 9. Testes locais (importante)
Usa Stripe CLI:
stripe listen --forward-to localhost/stripe/webhook

## Fluxo do sistema (fundamental)

Cliente escolhe produto
    ↓
Cria ORDER
    ↓
Sistema gera INVOICE automaticamente
    ↓
Cliente paga (Stripe)
    ↓
Webhook → marca invoice como PAID
    ↓
(Próximo passo: provisionamento automático)

