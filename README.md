# Prompt Image Generator

Ferramenta simples para criação de prompts estruturados para geração de imagens. Construída em PHP 8, MySQL e Tailwind CSS.

## Requisitos
- PHP 8.0+
- MySQL
- Apache com **mod_rewrite**
- Extensões PHP: `pdo_mysql`, `gd` ou `imagick`, `fileinfo`, `json`, `session`

## Instalação no Hostgator (cPanel)
1. Faça upload do projeto para `public_html` ou subdomínio e extraia os arquivos.
2. Crie um Banco MySQL e usuário com todas as permissões.
3. Importe o arquivo `db/install.sql` para criar as tabelas e dados iniciais.
4. Edite `config/database.php` com as credenciais do banco e URL do site.
5. Ajuste permissões:
   - `uploads/` → 755 ou 777
   - arquivos PHP → 644
6. Ative logs de erro no `php.ini` ou `.user.ini`.
7. Certifique-se de que as diretivas PHP atendem:
   - `upload_max_filesize=5M`
   - `post_max_size=50M`
   - `max_execution_time=300`
   - `memory_limit=256M`
   - `max_input_vars=3000`
8. Ative SSL/HTTPS e mantenha o `.htaccess` com redirecionamento.

## Uso
- Acesse o site para montar o prompt selecionando opções por categoria.
- O prompt é atualizado em tempo real e pode ser copiado com um clique.
- Admin: acesse `/admin/login.php` (usuário `admin`, senha `admin123` padrão). Gerencie categorias e opções com upload de imagens.

## Licença
Uso livre, inclusive comercial. Atribuição opcional.
