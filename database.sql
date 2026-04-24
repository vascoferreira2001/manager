-- Users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(150) UNIQUE,
    password VARCHAR(255),
    role VARCHAR(50),
    twofa_secret VARCHAR(255) NULL,
    twofa_enabled TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Clients
CREATE TABLE clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150),
    email VARCHAR(150),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Roles
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    slug VARCHAR(100) UNIQUE
);

-- Permissions
CREATE TABLE permissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150),
    slug VARCHAR(150) UNIQUE
);

-- Relação Role → Permissions
CREATE TABLE role_permissions (
    role_id INT,
    permission_id INT,
    PRIMARY KEY (role_id, permission_id)
);

-- Relação User → Roles
CREATE TABLE user_roles (
    user_id INT,
    role_id INT,
    PRIMARY KEY (user_id, role_id)
);

INSERT INTO roles (name, slug) VALUES
('Administrador', 'admin'),
('Suporte Técnico', 'support-technical'),
('Suporte Financeiro', 'support-finance'),
('Suporte ao Cliente', 'support-client'),
('Cliente', 'client');

INSERT INTO permissions (name, slug) VALUES
('Ver Clientes', 'view_clients'),
('Criar Clientes', 'create_clients'),
('Editar Clientes', 'edit_clients'),
('Eliminar Clientes', 'delete_clients'),

('Ver Faturas', 'view_invoices'),
('Gerir Faturas', 'manage_invoices'),

('Gerir Tickets', 'manage_tickets');

-- ADMIN (todas)
INSERT INTO role_permissions
SELECT r.id, p.id
FROM roles r, permissions p
WHERE r.slug = 'admin';

INSERT INTO role_permissions (role_id, permission_id)
SELECT r.id, p.id
FROM roles r, permissions p
WHERE r.slug = 'support-technical'
AND p.slug IN (
    'view_clients',
    'manage_tickets'
);

INSERT INTO role_permissions (role_id, permission_id)
SELECT r.id, p.id
FROM roles r, permissions p
WHERE r.slug = 'support-finance'
AND p.slug IN (
    'view_invoices',
    'manage_invoices'
);

INSERT INTO role_permissions (role_id, permission_id)
SELECT r.id, p.id
FROM roles r, permissions p
WHERE r.slug = 'support-client'
AND p.slug IN (
    'view_clients',
    'manage_tickets'
);

INSERT INTO role_permissions (role_id, permission_id)
SELECT r.id, p.id
FROM roles r, permissions p
WHERE r.slug = 'client'
AND p.slug IN (
    'view_clients'
);

INSERT INTO user_roles (user_id, role_id)
SELECT 1, id FROM roles WHERE slug = 'admin';

