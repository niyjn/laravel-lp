# ?? Baha Lanches ? Sistema de Delivery e Gest?o de Lanchonete

Aplica??o web completa desenvolvida com o framework **Laravel 12 / PHP 8.4**, seguindo rigorosamente o padr?o de arquitetura **MVC**, banco de dados relacional **PostgreSQL**, autentica??o moderna com **Laravel Breeze**, controle de acesso baseado em pap?is (**RBAC com 3 n?veis**), autoriza??o via **Policies** e valida??o desacoplada atrav?s de **Form Requests** aplicando o princ?pio **SRP** (Single Responsibility Principle).

---

## ?? Integrantes do Grupo

| Nome | E-mail Institucional | Atribui??es no Projeto |
| :--- | :--- | :--- |
| **Gabriel Schafranski** | `engs-gabrielschafranski@camporeal.edu.br` | Arquitetura MVC, Modelagem do Banco de Dados, Migrations, Seeders, Autentica??o Breeze, Policies, Middleware de Acesso e Frontend Blade |

---

## ?? Descri??o do Sistema

O **Baha Lanches** ? uma plataforma completa de pedidos e delivery gastron?mico. O sistema atende desde o cliente final (que navega pelo card?pio, adiciona itens ao carrinho, gerencia m?ltiplos endere?os de entrega e acompanha o status de seus pedidos em tempo real) at? a equipe operacional e administrativa da lanchonete:
- **Clientes (Usu?rio Comum):** Cadastro de conta, login com throttling, gerenciamento de m?ltiplos endere?os de entrega, cria??o de pedidos com c?lculo din?mico no servidor e hist?rico pessoal de pedidos.
- **Gerentes Operacionais:** Painel operacional exclusivo para acompanhamento do fluxo de pedidos da cozinha e atualiza??o de status (*aguardando confirma??o* ? *em preparo* ? *enviado* ? *entregue*), com timestamp de confirma??o e despacho.
- **Administradores:** Controle total da plataforma, incluindo CRUD completo de produtos do card?pio (cria??o, edi??o, exclus?o segura com integridade referencial protegida e ativa??o/desativa??o de itens), al?m de acesso integral ao painel de pedidos.

---

## ??? Tecnologias Utilizadas

- **Linguagem:** PHP 8.4
- **Framework:** Laravel 12 (compat?vel com 11/12)
- **Banco de Dados:** PostgreSQL (Neon / PgBouncer) com fallback transparente para SQLite
- **Autentica??o:** Laravel Breeze (sess?es seguras, prote??o contra for?a bruta com RateLimiter e CSRF token)
- **Frontend / Template Engine:** Blade + Tailwind CSS + Vite
- **Testes Automatizados:** Pest PHP / PHPUnit com cobertura para fluxos de autentica??o, autoriza??o de roles e integridade de pedidos

---

## ?? Controle de Acesso e Pap?is (3 N?veis)

O sistema implementa o campo `role` na tabela `cliente` (com mapeamento compat?vel para `User`):

| Papel (`role`) | Acesso a `/produtos/create` (CRUD) | Acesso a `/admin/pedidos` | Checkout & Endere?os | Descri??o |
| :--- | :---: | :---: | :---: | :--- |
| **`admin`** | ? Sim | ? Sim | ? Sim | Acesso total: gerencia card?pio e todos os pedidos |
| **`gerente`** | ? N?o (403) | ? Sim | ? Sim | Gest?o da cozinha: visualiza e atualiza status de pedidos |
| **`usuario`** | ? N?o (403) | ? N?o (403) | ? Sim | Cliente final: compra lanches e gerencia seus pr?prios dados |

### Credenciais de Teste (Criadas via Seeders)

| N?vel / Papel | E-mail | Senha |
| :--- | :--- | :--- |
| ??? **Administrador** | `admin@bahalanches.com` | `12345678` |
| ?? **Gerente Operacional** | `gerente@bahalanches.com` | `12345678` |
| ?? **Cliente / Usu?rio** | `usuario@bahalanches.com` | `12345678` |

---

## ??? Boas Pr?ticas e Arquitetura Implementada

1. **MVC e Eloquent ORM:**
   - Separa??o clara entre Models (`Cliente`, `Produto`, `Endereco`, `Pedido`, `ProdutoPedido`), Controllers e Views Blade.
   - Relacionamentos mapeados: `Cliente hasMany Endereco`, `Cliente hasMany Pedido`, `Pedido belongsTo Cliente`, `Pedido belongsTo Endereco`, `Pedido hasMany Itens (ProdutoPedido)`, `ProdutoPedido belongsTo Produto`.
2. **Princ?pio da Responsabilidade ?nica (SRP):**
   - Regras de valida??o desacopladas dos controllers e centralizadas em **Form Requests**:
     - `StoreProdutoRequest` & `UpdateProdutoRequest`
     - `StoreEnderecoRequest` & `UpdateEnderecoRequest`
     - `StorePedidoRequest` & `UpdatePedidoStatusRequest`
     - `LoginRequest` (Laravel Breeze)
3. **Policies (Autoriza??o de Recursos):**
   - `ProdutoPolicy`: garante que apenas `admin` pode criar, editar ou excluir itens do card?pio.
   - `PedidoPolicy`: assegura que um cliente s? veja seus pr?prios pedidos, enquanto `admin` e `gerente` podem auditar e atualizar o fluxo operacional.
   - `EnderecoPolicy`: impede que um usu?rio acesse ou modifique endere?os de outros clientes.
4. **Middleware de Controle de Acesso:**
   - Middleware `CheckRole` registrado em `bootstrap/app.php` com o alias `'role'`.
   - Rotas agrupadas por permiss?o: `role:admin` e `role:admin,gerente`.

---

## ?? Instala??o Passo a Passo

### Pr?-requisitos
- PHP >= 8.2 (recomendado PHP 8.4)
- Composer
- Node.js & NPM
- Git

### 1. Clonar o Reposit?rio
```bash
git clone https://github.com/niyjn/laravel-lp.git
cd laravel-lp
```

### 2. Instalar Depend?ncias do PHP
```bash
composer install
```

### 3. Configurar o Ambiente
Copie o arquivo de exemplo para `.env`:
```bash
cp .env.example .env
```
Gere a chave da aplica??o:
```bash
php artisan key:generate
```

Configure a conex?o de banco de dados no seu `.env` (PostgreSQL ou SQLite):
```env
DB_CONNECTION=pgsql
DB_HOST=seu_host_neon
DB_PORT=5432
DB_DATABASE=seu_banco
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```
*Dica:* Caso queira testar rapidamente com SQLite local:
```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```
*(Crie o arquivo com `touch database/database.sqlite` se necess?rio).*

### 4. Reconstruir Banco de Dados e Popular Dados de Teste
Execute o comando de rebuild e seed completo:
```bash
php artisan migrate:fresh --seed
```
Este comando criar? todo o schema e inserir? automaticamente os 3 usu?rios de teste, produtos do card?pio, endere?os e pedidos de demonstra??o.

### 5. Instalar Depend?ncias Frontend e Compilar
```bash
npm install
npm run build
```

---

## ?? Execu??o do Projeto

Inicie o servidor de desenvolvimento do Laravel:
```bash
php artisan serve
```
Acesse a aplica??o no navegador em: **[http://localhost:8000](http://localhost:8000)**

Para rodar os testes automatizados da su?te:
```bash
php artisan test
```

---

## ?? Roteiro de Demonstra??o (Checklist para Apresenta??o)

Siga este roteiro durante a apresenta??o do projeto para demonstrar 100% dos requisitos avaliados:

1. **Vis?o Geral e Vitrine P?blica (Guest):**
   - Acesse `http://localhost:8000`.
   - Mostre a vitrine de lanches do card?pio com pre?os e descri??es.
   - Mostre o bot?o "Entrar" e "Criar conta".
2. **Autentica??o com Laravel Breeze:**
   - Fa?a login com o cliente de teste (`usuario@bahalanches.com` / `12345678`).
   - Mostre que o menu de navega??o ? atualizado dinamicamente.
   - Acesse **Meu Perfil** e visualize a badge verde `Cliente (Pedidos e Endere?os)`.
3. **CRUD de Endere?os e Realiza??o de Pedido (Usu?rio Comum):**
   - Acesse **Meus Endere?os** (`/enderecos`) e cadastre ou edite um endere?o.
   - Adicione produtos ao carrinho na p?gina inicial.
   - V? para o **Checkout** (`/checkout`), selecione o endere?o de entrega e confirme o pedido.
   - Mostre o pedido criado na lista de **Meus Pedidos** (`/pedidos`).
4. **Demonstra??o do Gerente Operacional (N?vel 2):**
   - Realize logout e fa?a login como `gerente@bahalanches.com` / `12345678`.
   - Mostre o badge ?mbar `Gerente Operacional` no perfil.
   - Acesse o **Painel Pedidos** (`/admin/pedidos`).
   - Altere o status de um pedido de *Aguardando Confirma??o* para *Em Preparo* e depois para *Enviado*.
   - Tente for?ar a URL de cadastro de produtos (`/produtos/create`) e confirme que o acesso ? bloqueado com **HTTP 403 Forbidden** (gra?as ao `role:admin` e `ProdutoPolicy`).
5. **Demonstra??o do Administrador (N?vel 3):**
   - Realize logout e fa?a login como `admin@bahalanches.com` / `12345678`.
   - Mostre o badge vermelho `Administrador (Acesso Total)`.
   - Acesse a **Gest?o de Produtos** (`/produtos`).
   - Clique em **+ Novo produto**, cadastre um novo lanche e mostre-o aparecendo no card?pio.
   - Edite um produto e demonstre a valida??o de formul?rios via `FormRequest`.
6. **Inspe??o de C?digo e Arquitetura:**
   - Abra `app/Http/Middleware/CheckRole.php` e `bootstrap/app.php` para comprovar o Middleware.
   - Abra `app/Policies/ProdutoPolicy.php` e `app/Policies/PedidoPolicy.php` para comprovar as Policies.
   - Abra `app/Http/Requests/StoreProdutoRequest.php` para comprovar os Form Requests e SRP.
   - Execute `php artisan test` no terminal para demonstrar a aprova??o de todos os testes unit?rios e de integra??o.
