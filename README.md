# Clínica ULBRA · Sistema de gestão de pacientes

Sistema web para cadastro e gestão de pacientes, feito como Trabalho de Conclusão de Curso na ULBRA. Tem formulário de entrada, área administrativa com controle de acesso por permissão, busca de pacientes e geração de ficha em PDF.

> Projeto acadêmico. Todos os dados da demonstração são **fictícios**.

## Funcionalidades
- Cadastro de paciente por formulário.
- Autenticação (login e cadastro) com Laravel Jetstream.
- Área administrativa protegida por permissão (papel de admin).
- Listagem e busca de pacientes.
- Editar, visualizar e remover paciente.
- Geração da ficha do paciente em PDF.

## Tecnologias
- PHP 8 e **Laravel 9**
- Jetstream, Fortify e Sanctum (autenticação)
- Livewire (componentes)
- spatie/laravel-permission (permissões)
- barryvdh/laravel-dompdf (PDF)
- Blade, Tailwind CSS e Vite (frontend)
- Banco: SQLite (local) ou PostgreSQL (produção)

## Rodando localmente
Pré-requisitos: PHP 8, Composer e Node.

```bash
composer install
npm install

cp .env.example .env
touch database/database.sqlite     # usando SQLite local
php artisan key:generate

php artisan migrate --seed          # cria as tabelas e os dados ficticios
npm run build
php artisan serve
```

Abra http://127.0.0.1:8000.

As credenciais de demonstração aparecem na própria tela de login.

## Segurança
Cuidados aplicados no projeto:
- Validação server-side em todos os cadastros e edições.
- Proteção contra mass assignment (whitelist de campos no model).
- Limite de envio (rate limit) e honeypot anti-spam no formulário público.
- E-mail em modo log na demonstração (não dispara envio real).

## Deploy (Render + Neon, gratuito)
Já vem pronto pra publicar:
- **Render** (Docker, plano free) roda a aplicação. Veja `Dockerfile` e `render.yaml`.
- **Neon** (PostgreSQL free) guarda os dados, informado via `DATABASE_URL`.
- No Render, defina `APP_KEY` (gere com `php artisan key:generate --show`) e `DATABASE_URL` (do Neon).

## Créditos
Trabalho de Conclusão de Curso. Uso educacional.
