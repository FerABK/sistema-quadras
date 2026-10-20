# SistemaQuadras — Laravel + Breeze

Conversão do sistema PHP/MySQL original para Laravel 12, com autenticação baseada no fluxo do Laravel Breeze, Models Eloquent, migrations, Controllers e Views Blade.

## Requisitos

- PHP 8.2 ou superior (PHP 8.3+ recomendado)
- Composer
- MySQL/MariaDB
- Node.js e npm

## Instalação no Windows (XAMPP)

1. Extraia a pasta `sistemaquadras-laravel` para `C:\\xampp\\htdocs\\sistemaquadras-laravel` ou outra pasta de sua preferência.
2. Crie um banco de dados MySQL chamado `sistema_quadra` (ou escolha outro nome e atualize o `.env`).
3. Na pasta do projeto, copie `.env.example` para `.env` e confira `DB_DATABASE`, `DB_USERNAME` e `DB_PASSWORD`.
4. Execute:

```bash
composer install
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm install
npm run build
php artisan serve
```

5. Abra `http://127.0.0.1:8000`.

## Primeiro acesso

O seeder cria um administrador inicial:

- Login: `admin`
- Senha: `Admin123!`

Altere a senha após o primeiro acesso. Novos cadastros públicos recebem automaticamente o perfil `cliente`; somente administradores podem criar quadras, gerenciar usuários e abrir relatórios.

## Funcionalidades convertidas

- Cadastro, login e logout
- Permissões de cliente e administrador
- Listagem de quadras e CRUD administrativo, incluindo imagem
- Reserva de quadra por data e horário (blocos de uma hora, entre 05:00 e 22:00)
- Pagamento por dinheiro, débito ou crédito; opção de parcelamento em até seis parcelas
- Listagem e exclusão de reservas (clientes só veem e excluem as próprias)
- Relatórios: todas as reservas, reservas por data, reservas por quadra, faturamento, horários mais usados, gasto médio, quadras mais usadas e perfil de usuários

## Notas sobre a conversão

- O projeto original usava `usuario`, `quadra` e `reserva`; esta versão usa os nomes convencionais `users`, `quadras`, `reservas` e `pagamentos`.
- O login original foi mantido como campo `login`; o campo `password` é utilizado pelo mecanismo de autenticação do Laravel e armazena hash, nunca a senha em texto puro.
- Foram incluídas nas migrations as colunas de imagem e pagamento que o PHP original já tentava utilizar, mas que faltavam no SQL fornecido.
- A tabela `cliente` antiga não foi recriada porque o fluxo existente associava as reservas diretamente ao usuário autenticado e não utilizava o cadastro de cliente.
- Breeze é instalado como dependência de desenvolvimento. A interface de autenticação foi adaptada para manter o campo `login` usado pelo sistema original.
