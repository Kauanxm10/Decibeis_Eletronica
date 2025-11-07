-- Banco de dados MySQL para Decibéis Eletrônica
-- Execute este script para criar todas as tabelas necessárias

CREATE DATABASE IF NOT EXISTS decibeis_eletronica CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE decibeis_eletronica;

-- Tabela de usuários administrativos
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(80) NOT NULL UNIQUE,
    email VARCHAR(120) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    is_admin BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de submissões de contato
CREATE TABLE contact_submission (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(120) NOT NULL,
    phone VARCHAR(20),
    message TEXT NOT NULL,
    appointment_date DATE,
    appointment_time TIME,
    file_path VARCHAR(200),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de notícias
CREATE TABLE news_item (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    content TEXT NOT NULL,
    url VARCHAR(300),
    image_url VARCHAR(300),
    published_date DATETIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de FAQ
CREATE TABLE faq (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question VARCHAR(300) NOT NULL,
    answer TEXT NOT NULL,
    order_position INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de horários disponíveis
CREATE TABLE available_time (
    id INT AUTO_INCREMENT PRIMARY KEY,
    time_slot VARCHAR(10) NOT NULL,
    description VARCHAR(100),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de informações da empresa
CREATE TABLE company_info (
    id INT AUTO_INCREMENT PRIMARY KEY,
    info_key VARCHAR(50) NOT NULL UNIQUE,
    info_value TEXT NOT NULL,
    description VARCHAR(200),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Inserir dados iniciais

-- Usuário admin padrão (senha: admin123)
INSERT INTO users (username, email, password_hash, is_admin) VALUES 
('admin', 'admin@decibeiseletronica.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', TRUE);

-- Informações da empresa
INSERT INTO company_info (info_key, info_value, description) VALUES
('company_name', 'Decibéis Eletrônica', 'Nome da empresa'),
('phone', '(11) 9999-9999', 'Telefone principal'),
('email', 'contato@decibeiseletronica.com', 'Email de contato'),
('address', 'Rua dos Equipamentos, 123, São Paulo - SP', 'Endereço'),
('whatsapp_number', '5511999887766', 'Número do WhatsApp'),
('business_hours', 'Segunda à Sexta: 9h às 18h | Sábado: 9h às 14h', 'Horário de funcionamento');

-- Horários disponíveis
INSERT INTO available_time (time_slot, description, is_active) VALUES
('09:00', 'Manhã - Início do expediente', TRUE),
('10:00', 'Manhã - Horário popular', TRUE),
('11:00', 'Manhã - Antes do almoço', TRUE),
('14:00', 'Tarde - Início do expediente', TRUE),
('15:00', 'Tarde - Horário popular', TRUE),
('16:00', 'Tarde - Horário flexível', TRUE),
('17:00', 'Tarde - Final do expediente', TRUE);

-- FAQs iniciais
INSERT INTO faq (question, answer, order_position, is_active) VALUES
('Vocês fazem reparo de mesa de som?', 'Sim, realizamos manutenção e reparo completo de mesas de som de todas as marcas e modelos. Nossa equipe possui experiência em equipamentos analógicos e digitais.', 1, TRUE),
('Quanto tempo demora um reparo?', 'O tempo de reparo varia conforme a complexidade do problema. Reparos simples podem ser concluídos em 2-3 dias úteis, enquanto casos mais complexos podem levar até 2 semanas.', 2, TRUE),
('Vocês trabalham com equipamentos de outras marcas?', 'Sim, atendemos equipamentos de todas as marcas: Yamaha, Behringer, Mackie, Allen & Heath, Soundcraft, e muitas outras.', 3, TRUE),
('Fazem orçamento gratuito?', 'Sim, realizamos avaliação e orçamento gratuitos. Você só paga se aprovar o serviço.', 4, TRUE),
('Vocês vendem peças de reposição?', 'Sim, trabalhamos com peças originais e compatíveis para diversos equipamentos de áudio profissional.', 5, TRUE);