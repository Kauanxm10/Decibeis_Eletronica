# ⚡ Decibéis Eletrônica

Este documento descreve a estrutura técnica, dependências e instruções de configuração para o site da **Decibéis Eletrônica**.

---

## 🧭 1. Visão Geral do Projeto

O site da Decibéis Eletrônica é uma plataforma institucional e profissional desenvolvida para apresentar os **serviços da empresa**, **informações de contato**, **notícias do setor** e um **espaço para perguntas frequentes**.

O projeto utiliza **PHP** para o processamento no servidor e **MySQL** para o gerenciamento de conteúdo dinâmico.

---

## 🧰 2. Tecnologias Utilizadas

| Categoria | Tecnologia |
|------------|-------------|
| **Back-end** | PHP 8.x |
| **Banco de Dados** | MySQL 8.x |
| **Front-end** | HTML5, CSS3, JavaScript |
| **Frameworks/Bibliotecas** | Bootstrap 5, Font Awesome |
| **Ambiente de Desenvolvimento** | Servidor Web (Apache, Nginx, etc.) com PHP e MySQL instalados |

---

## 📂 3. Estrutura de Arquivos

A estrutura do projeto foi organizada para ser **modular** e de **fácil manutenção**, separando arquivos de configuração, templates e recursos estáticos.

```
/
├── admin/                  # Futuro painel de administração
├── css/
│   └── style.css           # Arquivo de estilos personalizado
├── includes/
│   ├── db_connect.php      # Conexão com o banco de dados
│   ├── header.php          # Cabeçalho do site (meta tags, navegação)
│   └── footer.php          # Rodapé do site (scripts, copyright)
├── assets/                 # Imagens, vídeos, etc.
├── index.php               # Página inicial
├── about.php               # Página "Sobre Nós"
├── technical.php           # Página "Serviços Técnicos"
├── contact.php             # Página "Contato"
├── faq.php                 # Página de Perguntas Frequentes
├── config.php              # Arquivo de configuração global
└── .htaccess               # Configuração do servidor (URLs amigáveis)
```

---

## ⚙️ 4. Configuração e Instalação

### ✅ Requisitos
Antes de iniciar, certifique-se de que seu ambiente (local ou produção) tenha:
- PHP 8.x instalado e configurado  
- MySQL 8.x disponível e acessível  
- Servidor Web (Apache ou Nginx)

---

### 🗄️ Banco de Dados
1. Crie um banco de dados MySQL com o nome:
   ```
   decibeis_eletronica
   ```
2. Execute o script SQL fornecido anteriormente para criar todas as tabelas e inserir os dados iniciais.

---

### 🔐 Configuração de Credenciais
No arquivo `includes/db_connect.php`, atualize as credenciais conforme seu ambiente:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'decibeis_eletronica');
define('DB_USER', 'seu_usuario');
define('DB_PASS', 'sua_senha');
```

---

### ☁️ Upload dos Arquivos
1. Faça o upload de todos os arquivos do projeto para o diretório raiz do seu servidor web.  
2. Verifique se as permissões estão corretas para leitura e execução dos arquivos PHP.

---

### 🧪 Teste
Após o upload:
- Acesse o domínio ou IP do seu servidor no navegador.  
- A página inicial (`index.php`) e as demais páginas deverão carregar corretamente.  
- Verifique se os dados são exibidos dinamicamente a partir do banco de dados.

---

## 🗂️ Resumo das Seções
1. Visão Geral do Projeto  
2. Tecnologias Utilizadas  
3. Estrutura de Arquivos  
4. Configuração e Instalação  

---

## 👨‍💻 Autor
**Desenvolvido por Kauan Xavier Moreira – 2025**  
💡 Projeto institucional desenvolvido para **Decibéis Eletrônica**.
