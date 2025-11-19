# Backend - Sistema de Agendamento

Arquivos incluídos:
- config.php        : configurações de DB e funções utilitárias
- install.php       : cria tabelas no banco e insere admin padrão (admin/admin123)
- api.php           : API REST (endpoints para events e admin)
- db.sql            : script SQL para criar banco/tabelas

Instruções rápidas:
1. Ajuste `config.php` com o usuário e senha do seu MySQL.
2. Acesse via CLI ou navegador: `php install.php` para criar tabelas e o usuário admin.
3. Coloque `api.php`, `config.php` e `install.php` em um diretório público do seu servidor (ex: /var/www/html/agendamento).
4. Garanta que seu servidor web esteja usando HTTPS em produção.

Endpoints principais:
- GET  /api.php/events                => lista todos eventos (opcional ?room=)
- POST /api.php/events                => cria evento
- PUT  /api.php/events/{id}           => atualiza evento (requer admin_password)
- DELETE /api.php/events/{id}         => deleta evento (requer admin_password)
- POST /api.php/admin/change-password => altera senha do admin
