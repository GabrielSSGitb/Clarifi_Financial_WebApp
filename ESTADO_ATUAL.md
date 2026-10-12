# ClariFi — Estado Atual do Projeto

> Aplicação web de controle financeiro pessoal criada com Laravel. Documento gerado em 15/09/2026.

## Visão Geral

O **ClariFi** é uma plataforma de gestão financeira pessoal (receitas, despesas, investimentos, planejamento futuro e histórico). O nome do projeto local é `Clarifi_Web_Financial_Control`, com repositório remoto em `https://github.com/GabrielSSGitb/Clarifi_Financial_WebApp.git`.

## Stack Tecnológico

| Camada | Tecnologia |
|---|---|
| Backend | PHP ^8.2, Laravel ^11.0 |
| Autenticação | Laravel Fortify ^1.20 (login, registro, 2FA, passkeys) |
| Frontend | Blade, Tailwind CSS v4, Flowbite v4, Vite ^8 |
| Gráficos | Chart.js 4 (via CDN) |
| Exportação | maatwebsite/excel (XLSX) e CSV nativo |
| Banco de dados | MySQL (local: `clarifiapp`) |
| Formatação | Laravel Pint ^1.13 |
| Testes | PHPUnit ^11 (PHPUnit, não Pest) |

## Estrutura do Projeto

```
app/
├── Actions/Fortify/          # Fluxo de auth (Fortify)
├── Console/Commands/         # MakeServiceCommand
├── Exports/                  # IncomesExport (exportação Excel)
├── Http/Controllers/         # Controllers dos módulos
├── Models/                   # User, Incomes, Expense, Annotation, role
├── Policies/                 # UserPolicy
├── Services/                 # DashboardService (cálculos do dashboard)
└── Providers/                # AppServiceProvider, FortifyServiceProvider

resources/
├── css/app.css               # Estilo global (Tailwind)
├── js/app.js                 # Entry point do Vite
├── js/calculator/            # Módulo da calculadora (display, funções, math)
└── views/webSite/            # Views Blade (layouts, partials e auth)

routes/web.php                # Rotas web (prefixo /dashboard)
database/migrations/          # Migrations do schema
```

## Módulos Existentes

### Autenticação (`Fortify`)
- Login, registro, esqueci a senha, reset de senha.
- Autenticação em duas etapas (2FA) e passkeys habilitados no model `User`.

### Dashboard (`DashboardService` + `UserController`)
- Exibe greeting por horário, saldo atual, receitas, despesas e investimentos do mês (com filtro mês/ano).
- Gráfico anual (Chart.js) com receitas/despesas/investimentos.
- Regra de fechamento no último dia do mês (atualiza `MouthLastIncomesTotal`).

### Receitas (Incomes)
- Formulário de registro de receitas (`dashboard.incomes.send`).
- Registro em tabela `incomes` (amount, description, category, date).

### Despesas (Expenses)
- Formulário de registro de despesas (`dashboard.expenses.send`).
- Tabela `expenses` com mesma estrutura básica das receitas.

### Transações Futuras / Simulador
- Página `dashboard.futureTransactions` (commit `e588d27`).
- Simulador de projeção financeira: saldo inicial, aporte mensal, despesas futuras e rendimento mensal (%).
- Gráfico de projeção com Chart.js (1–60 meses).

### Histórico + Exportação
- `HistoryController`: total de receitas, despesas e saldo acumulado (somente valores totais; listagens ainda globais).
- Exportação CSV (`ExportCSVController`).
- Exportação Excel/XLSX (`ExportExcelFileController` + `IncomesExport`, via maatwebsite/excel).

### Calendário
- Anotações por data (tabela `annotations`).
- Criação via `dashboard.calendar.save`; destruição automática das anotações no último dia do mês.
- Permissão espelhada em `CalendarController::destroy()`.

### Investimentos
- `InvestmentsController`: lista as despesas com categoria `investment`.

### Perfil
- Visualização/edição de perfil e atualização de avatar (`ProfileController`, via AJAX).
- Imagens de avatar são salvas e exibidas a partir do storage público.

### Widget Calculadora
- Calculadora flutuante global presente no layout `basicSetup`, com histórico, operações básicas e exponenciação; lógica em `resources/js/calculator/`.

## Banco de Dados (Migrations)

| Tabela | Notas |
|---|---|
| `users` | Auth padrão + coluna `avatar` |
| `roles` / `roles_user` | Papéis N:N com usuários (`User::roles()`) |
| `incomes` | Receitas + `MouthLastIncomesTotal` |
| `expenses` | Despesas |
| `annotations` | Anotações do calendário |
| `cache`, `passkeys`, `sessions` | Infra (cache, passkeys da Fortify, sessão) |

Motor de cache e filas: database. Sessão: database.

## Rotas Principais (`routes/web.php`)

- `GET /` e `GET /dashboard` → `UserController@index` (nome `dashboard`, ambas com auth+verified)
- `dashboard/incomes` (GET + POST `send`), `dashboard/expenses` (GET + POST `send`)
- `dashboard/futureTransactions`, `dashboard/history`, `dashboard/calendar` (+ `save`), `dashboard/investments`
- `dashboard/profile` (GET + POST) e `dashboard/profile/avatar` (POST)
- `dashboard/history/csv` (POST) e `dashboard/history/xlsx` (POST) → exportações

## Estado do Git

- Branch atual: `main` (tracking `origin/master`), árvore de trabalho limpa.
- Últimos commits: simulador de transações futuras, arquitetura inicial do módulo de transações futuras, correções de usuário/avatar e calculadora.
- Branches existentes: `main`, `DashBoard`, `Expense-Page`, `Incomes-page`, `Investments-Page`, `Website-design`, `authentication`, `database`, `developer`, `docker-environment`, `login-Page` (com contrapartes remotas, ex.: `calendar-view`, `history-Page`, `calculator`, `docker-implementation`, `Export-Excel_Files`).

## Testes

- Apenas testes de exemplo: `tests/Feature/ExampleTest.php` e `tests/Unit/ExampleTest.php`.
- Não há cobertura real dos módulos ainda (PHPUnit).

## Pontos de Atenção / Pendências

1. **Rotas duplicadas**: `GET /` e `GET /dashboard` registram o mesmo nome `dashboard`.
2. **IncomesController**: imports não utilizados (`Carbon`, `DB`, `MongoDB\Driver\Session`).
3. **Exportação CSV**: nome do arquivo sem `.` antes de `csv` e header `Content-Disposition` com aspas incompletas.
4. **IncomesExport**: 5 colunas no `select` mas apenas 4 headings definidos.
5. **HistoryController**: `Incomes::all()` / `Expense::all()` sem filtro por usuário (potencial vazamento entre usuários).
6. **CalendarController::destroy()**: apaga anotações de todos os usuários (sem filtro por `user_id`).
7. **Migration `annotations`**: `down()` tenta dropar `calendar_annotations` (nome diferente da tabela criada).
8. **DashboardService** (`updateMonthlyTotalIfLastDay`): atualiza todas as linhas de `MouthLastIncomesTotal` do usuário, sem filtro de mês.
9. **Nomenclatura`: alguns nomes mesclam inglês/português (ex.: `MouthLastIncomesTotal`).
10. **Segurança/validação**: criação de roles e regras de autorização ainda a validar (há `UserPolicy`, mas permissões parecem não ser aplicadas nas rotas).

## Próximos Passos Sugeridos

- Adicionar testes de feature para todos os módulos (receitas, despesas, calendário e exportações).
- Corrigir filtros por usuário no histórico e nas anotações do calendário.
- Padronizar nomenclatura dos campos e colunas de banco.
- Revisar validação de entrada e mensagens de erro nas views.
- Consolidar as branches antigas de features dentro de `main` antes de fechar o escopo.