# Especificação de Requisitos do Sistema

## Sistema de Gestão de Biblioteca

**Versão:** 1.0  
**Data:** Novembro de 2024  
**Instituição:** Desenvolvimento de Sistemas para Web  
**Tecnologias:** PHP 8, MySQL, HTML5, CSS3, JavaScript

---

## 1. Introdução

### 1.1 Objetivo do Documento
Este documento apresenta a especificação completa de requisitos funcionais e não-funcionais do Sistema de Gestão de Biblioteca, destinado ao controle de usuários, livros e reservas em ambiente bibliotecário.

### 1.2 Escopo do Sistema
O sistema visa automatizar e facilitar a gestão de bibliotecas através de:
- Controle de acesso baseado em perfis (Usuário, Bibliotecário, Administrador)
- Gerenciamento completo de acervo bibliográfico
- Sistema de reservas e empréstimos
- Controle de disponibilidade de exemplares
- Histórico de movimentações

### 1.3 Definições, Acrônimos e Abreviações
- **CRUD**: Create, Read, Update, Delete
- **ISBN**: International Standard Book Number
- **PDO**: PHP Data Objects
- **MVC**: Model-View-Controller
- **RF**: Requisito Funcional
- **RNF**: Requisito Não-Funcional

---

## 2. Descrição Geral do Sistema

### 2.1 Perspectiva do Sistema
Sistema web standalone desenvolvido em arquitetura MVC com três camadas:
- **Modelo (Model)**: Acesso a dados via PDO
- **Visão (View)**: Interfaces HTML/CSS/JavaScript
- **Controlador (Controller)**: Lógica de negócio e validações

### 2.2 Funções do Sistema
- Autenticação e controle de acesso
- Gestão de usuários (cadastro, edição, exclusão)
- Gestão de acervo (livros)
- Sistema de reservas
- Processamento de retiradas e devoluções
- Pesquisa e filtros de livros
- Gerenciamento de perfis de usuário

### 2.3 Características dos Usuários

#### 2.3.1 Usuário Comum
- **Descrição**: Leitor que utiliza os serviços da biblioteca
- **Responsabilidades**: Reservar livros, gerenciar suas reservas
- **Conhecimento técnico**: Básico (navegação web)

#### 2.3.2 Bibliotecário
- **Descrição**: Funcionário responsável pelo atendimento
- **Responsabilidades**: Processar empréstimos/devoluções, cadastrar livros e usuários
- **Conhecimento técnico**: Intermediário (operação de sistemas)

#### 2.3.3 Administrador
- **Descrição**: Gestor do sistema com privilégios totais
- **Responsabilidades**: Gerenciar todo o sistema e seus usuários
- **Conhecimento técnico**: Avançado (gestão completa)

### 2.4 Restrições Gerais
- Sistema web acessível via navegadores modernos
- Requer PHP 8.0 ou superior
- Requer MySQL 5.7 ou superior
- Não possui versão mobile nativa (apenas responsiva)

---

## 3. Requisitos Funcionais

### 3.1 Módulo de Autenticação

#### RF01 - Login de Usuário
**Descrição**: O sistema deve permitir login via e-mail e senha  
**Entrada**: E-mail válido, senha  
**Processamento**: Validação de credenciais no banco de dados  
**Saída**: Redirecionamento ao dashboard ou mensagem de erro  
**Prioridade**: ALTA  
**Regras de Negócio**:
- RN01: Usuário deve estar ativo (ativo = 1)
- RN02: Senha deve ser validada com password_verify()
- RN03: Sessão deve ser iniciada após autenticação bem-sucedida

#### RF02 - Logout de Usuário
**Descrição**: O sistema deve permitir encerrar a sessão  
**Entrada**: Clique no botão "Sair"  
**Processamento**: Destruição da sessão  
**Saída**: Redirecionamento para tela de login  
**Prioridade**: ALTA

#### RF03 - Controle de Sessão
**Descrição**: O sistema deve manter usuário logado durante a navegação  
**Prioridade**: ALTA  
**Regras de Negócio**:
- RN04: Verificar sessão em todas as páginas protegidas
- RN05: Redirecionar para login se sessão inválida

### 3.2 Módulo de Usuários

#### RF04 - Cadastrar Usuário
**Descrição**: Bibliotecários e administradores podem cadastrar usuários  
**Entrada**: Nome, e-mail, senha, CPF, telefone, perfil, status  
**Processamento**: Validação de dados e inserção no banco  
**Saída**: Confirmação de cadastro ou mensagens de erro  
**Prioridade**: ALTA  
**Regras de Negócio**:
- RN06: E-mail deve ser único no sistema
- RN07: CPF deve ser único e válido (algoritmo completo)
- RN08: Senha deve ter mínimo 6 caracteres, 1 maiúscula, 1 minúscula, 1 número, 1 especial
- RN09: Bibliotecário só pode criar usuários com perfil "usuario"
- RN10: Senha deve ser criptografada com password_hash()

#### RF05 - Listar Usuários
**Descrição**: Exibir todos os usuários cadastrados  
**Entrada**: Acesso à página de listagem  
**Saída**: Tabela com dados dos usuários  
**Prioridade**: MÉDIA  
**Regras de Negócio**:
- RN11: Ordenar por nome (ASC)
- RN12: Não exibir senha

#### RF06 - Editar Usuário
**Descrição**: Permitir alteração de dados cadastrais  
**Entrada**: ID do usuário, novos dados  
**Processamento**: Validação e atualização  
**Saída**: Confirmação ou erro  
**Prioridade**: ALTA  
**Regras de Negócio**:
- RN13: Bibliotecário só edita usuários com perfil "usuario"
- RN14: Administrador edita qualquer usuário
- RN15: E-mail deve permanecer único
- RN16: CPF deve permanecer único

#### RF07 - Alterar Senha de Usuário
**Descrição**: Bibliotecários/administradores podem alterar senha de usuários  
**Entrada**: ID do usuário, nova senha (2x para confirmação)  
**Processamento**: Validação e atualização  
**Saída**: Confirmação ou erro  
**Prioridade**: MÉDIA  
**Regras de Negócio**:
- RN17: Senhas devem conferir
- RN18: Nova senha deve atender requisitos de segurança

#### RF08 - Excluir Usuário
**Descrição**: Remover usuário do sistema  
**Entrada**: ID do usuário  
**Processamento**: Exclusão do banco de dados  
**Saída**: Confirmação ou erro  
**Prioridade**: BAIXA  
**Regras de Negócio**:
- RN19: Solicitar confirmação antes de excluir
- RN20: Verificar se usuário possui reservas ativas

#### RF09 - Editar Próprio Perfil
**Descrição**: Usuário logado pode editar seus próprios dados  
**Entrada**: Novos dados (nome, e-mail, CPF, telefone)  
**Processamento**: Validação e atualização  
**Saída**: Confirmação ou erro  
**Prioridade**: MÉDIA  
**Regras de Negócio**:
- RN21: Não pode alterar perfil
- RN22: Sessão deve ser atualizada após mudança

#### RF10 - Alterar Própria Senha
**Descrição**: Usuário pode alterar sua senha  
**Entrada**: Senha atual, nova senha (2x)  
**Processamento**: Validação e atualização  
**Saída**: Confirmação ou erro  
**Prioridade**: MÉDIA  
**Regras de Negócio**:
- RN23: Validar senha atual antes de alterar
- RN24: Novas senhas devem conferir

### 3.3 Módulo de Livros

#### RF11 - Cadastrar Livro
**Descrição**: Cadastrar novo livro no acervo  
**Entrada**: Título, autor, ISBN, gênero, editora, resumo, ano publicação, edição, qtd páginas, qtd total, URL capa  
**Processamento**: Validação e inserção  
**Saída**: Confirmação ou erro  
**Prioridade**: ALTA  
**Regras de Negócio**:
- RN25: ISBN deve ser único
- RN26: ISBN deve ser válido (ISBN-10 ou ISBN-13)
- RN27: Quantidade disponível = quantidade total no cadastro
- RN28: Livro criado como ativo por padrão

#### RF12 - Listar Livros para Gerenciamento
**Descrição**: Exibir todos os livros do acervo  
**Entrada**: Acesso à página  
**Saída**: Tabela com dados dos livros  
**Prioridade**: MÉDIA  
**Regras de Negócio**:
- RN29: Ordenar por título (ASC)
- RN30: Exibir status (ativo/inativo)

#### RF13 - Editar Livro
**Descrição**: Alterar dados de um livro  
**Entrada**: ID do livro, novos dados  
**Processamento**: Validação e atualização  
**Saída**: Confirmação ou erro  
**Prioridade**: ALTA  
**Regras de Negócio**:
- RN31: ISBN não pode ser alterado
- RN32: Quantidade disponível ≤ quantidade total
- RN33: Não permitir quantidade disponível negativa

#### RF14 - Listar Livros (Catálogo Público)
**Descrição**: Usuários podem visualizar livros disponíveis  
**Entrada**: Acesso à página  
**Saída**: Grid/cards com livros  
**Prioridade**: ALTA  
**Regras de Negócio**:
- RN34: Exibir apenas livros ativos
- RN35: Mostrar quantidade disponível
- RN36: Destacar livros indisponíveis

#### RF15 - Buscar Livros
**Descrição**: Pesquisar livros por múltiplos critérios  
**Entrada**: Título, autor, gênero, ISBN, editora (qualquer combinação)  
**Processamento**: Query com filtros dinâmicos  
**Saída**: Lista de resultados  
**Prioridade**: ALTA  
**Regras de Negócio**:
- RN37: Busca com LIKE (parcial)
- RN38: Combinar múltiplos filtros com AND
- RN39: Busca case-insensitive

### 3.4 Módulo de Reservas

#### RF16 - Criar Reserva
**Descrição**: Usuário reserva um livro  
**Entrada**: ID do livro  
**Processamento**: Criação da reserva  
**Saída**: Confirmação ou erro  
**Prioridade**: ALTA  
**Regras de Negócio**:
- RN40: Livro deve estar disponível (qtd_disponivel > 0)
- RN41: Reserva criada com status "pendente"
- RN42: Data reserva = agora
- RN43: Decrementar quantidade disponível (implementação futura)

#### RF17 - Listar Minhas Reservas
**Descrição**: Usuário visualiza suas reservas  
**Entrada**: Usuário logado  
**Saída**: Lista de reservas do usuário  
**Prioridade**: ALTA  
**Regras de Negócio**:
- RN44: Exibir com join de livros (título)
- RN45: Ordenar por data reserva (DESC)

#### RF18 - Cancelar Reserva
**Descrição**: Usuário cancela reserva pendente  
**Entrada**: ID da reserva  
**Processamento**: Exclusão da reserva  
**Saída**: Confirmação ou erro  
**Prioridade**: MÉDIA  
**Regras de Negócio**:
- RN46: Apenas reservas "pendente" podem ser canceladas pelo usuário
- RN47: Usuário só cancela suas próprias reservas
- RN48: Incrementar quantidade disponível (implementação futura)

#### RF19 - Listar Todas as Reservas
**Descrição**: Bibliotecários visualizam todas as reservas  
**Entrada**: Acesso à página  
**Saída**: Tabela com todas as reservas  
**Prioridade**: ALTA  
**Regras de Negócio**:
- RN49: Ordenar por data reserva (DESC)
- RN50: Permitir filtro por status

#### RF20 - Processar Retirada
**Descrição**: Bibliotecário registra retirada de livro  
**Entrada**: ID da reserva, data prevista devolução  
**Processamento**: Atualização da reserva  
**Saída**: Confirmação ou erro  
**Prioridade**: ALTA  
**Regras de Negócio**:
- RN51: Reserva deve estar "pendente"
- RN52: Alterar status para "ativa"
- RN53: Registrar data_retirada = hoje
- RN54: Registrar bibliotecario_retirada_id
- RN55: Data prevista devolução deve ser futura

#### RF21 - Processar Devolução
**Descrição**: Bibliotecário registra devolução de livro  
**Entrada**: ID da reserva, observações (opcional)  
**Processamento**: Atualização da reserva  
**Saída**: Confirmação ou erro  
**Prioridade**: ALTA  
**Regras de Negócio**:
- RN56: Reserva deve estar "ativa"
- RN57: Alterar status para "concluida"
- RN58: Registrar data_devolucao = agora
- RN59: Registrar bibliotecario_devolucao_id
- RN60: Incrementar quantidade disponível do livro

---

## 4. Requisitos Não-Funcionais

### 4.1 Requisitos de Usabilidade

#### RNF01 - Interface Intuitiva
O sistema deve possuir interface amigável e de fácil navegação para usuários com conhecimento básico de informática.

#### RNF02 - Responsividade
O sistema deve ser responsivo e funcionar adequadamente em dispositivos desktop, tablets e smartphones.

#### RNF03 - Feedback Visual
O sistema deve fornecer feedback claro sobre ações realizadas (sucesso, erro, carregamento).

#### RNF04 - Acessibilidade
O sistema deve utilizar marcação HTML semântica e contrastes adequados para melhor acessibilidade.

### 4.2 Requisitos de Desempenho

#### RNF05 - Tempo de Resposta
As páginas devem carregar em no máximo 3 segundos em conexão de banda larga padrão.

#### RNF06 - Consultas ao Banco
Consultas ao banco de dados devem utilizar índices para otimização de performance.

#### RNF07 - Concorrência
O sistema deve suportar pelo menos 50 usuários simultâneos sem degradação significativa de performance.

### 4.3 Requisitos de Segurança

#### RNF08 - Criptografia de Senhas
Senhas devem ser armazenadas utilizando bcrypt via password_hash() do PHP.

#### RNF09 - Proteção contra SQL Injection
Todas as queries devem utilizar Prepared Statements (PDO).

#### RNF10 - Proteção contra XSS
Toda saída de dados deve utilizar htmlspecialchars() ou equivalente.

#### RNF11 - Validação de Entrada
Todos os dados de entrada devem ser validados no servidor (backend).

#### RNF12 - Controle de Sessão
Sessões devem expirar após período de inatividade e serem validadas em cada requisição.

#### RNF13 - Controle de Acesso
Verificação de permissões deve ocorrer em todas as páginas protegidas.

### 4.4 Requisitos de Confiabilidade

#### RNF14 - Tratamento de Erros
O sistema deve tratar exceções adequadamente sem expor informações sensíveis.

#### RNF15 - Integridade de Dados
Utilizar transações quando necessário para garantir integridade referencial.

#### RNF16 - Backup
Recomenda-se backup diário do banco de dados (responsabilidade do administrador do servidor).

### 4.5 Requisitos de Manutenibilidade

#### RNF17 - Arquitetura MVC
O sistema deve seguir o padrão MVC para separação de responsabilidades.

#### RNF18 - Código Documentado
Código deve conter comentários explicativos em pontos críticos.

#### RNF19 - Nomenclatura Padronizada
Seguir padrões de nomenclatura consistentes (camelCase, PascalCase conforme contexto).

#### RNF20 - Versionamento
Código deve ser versionado (Git recomendado).

### 4.6 Requisitos de Portabilidade

#### RNF21 - Compatibilidade de Navegadores
Suporte aos navegadores: Chrome, Firefox, Safari, Edge (versões recentes).

#### RNF22 - Independência de Sistema Operacional
Sistema deve funcionar em servidores Linux, Windows e macOS.

#### RNF23 - Banco de Dados
Sistema deve utilizar MySQL/MariaDB com PDO para facilitar portabilidade.

---

## 5. Regras de Negócio Consolidadas

### 5.1 Validações de Dados

| Campo | Regra |
|-------|-------|
| Nome | Sem caracteres especiais perigosos (<, >, ", '), sem palavras-chave maliciosas |
| E-mail | Formato válido (filter_var), único no sistema |
| Senha | Mín. 6 caracteres, 1 maiúscula, 1 minúscula, 1 número, 1 especial (!@#%&*()-_.) |
| CPF | Formato XXX.XXX.XXX-XX ou XXXXXXXXXXX, algoritmo válido, único |
| Telefone | Formato +XX XX XXXXX-XXXX |
| ISBN | ISBN-10 ou ISBN-13 válido, único no sistema |

### 5.2 Permissões por Perfil

| Funcionalidade | Usuário | Bibliotecário | Administrador |
|----------------|---------|---------------|---------------|
| Ver catálogo de livros | ✓ | ✓ | ✓ |
| Criar reserva | ✓ | ✓ | ✓ |
| Ver minhas reservas | ✓ | ✓ | ✓ |
| Cancelar reserva pendente | ✓ (próprias) | ✓ (todas) | ✓ (todas) |
| Editar meu perfil | ✓ | ✓ | ✓ |
| Alterar minha senha | ✓ | ✓ | ✓ |
| Cadastrar usuários | ✗ | ✓ (apenas "usuario") | ✓ (todos) |
| Editar usuários | ✗ | ✓ (apenas "usuario") | ✓ (todos) |
| Excluir usuários | ✗ | ✓ (apenas "usuario") | ✓ (todos) |
| Alterar senha de usuários | ✗ | ✓ (apenas "usuario") | ✓ (todos) |
| Cadastrar livros | ✗ | ✓ | ✓ |
| Editar livros | ✗ | ✓ | ✓ |
| Ver todas as reservas | ✗ | ✓ | ✓ |
| Processar retiradas | ✗ | ✓ | ✓ |
| Processar devoluções | ✗ | ✓ | ✓ |

### 5.3 Estados de Reserva

| Status | Descrição | Transições Permitidas |
|--------|-----------|----------------------|
| pendente | Reserva criada, aguardando retirada | → ativa (processar retirada)<br>→ cancelada (cancelar) |
| ativa | Livro retirado, em posse do usuário | → concluida (processar devolução) |
| concluida | Livro devolvido | (estado final) |
| cancelada | Reserva cancelada | (estado final) |

### 5.4 Cálculos e Controles

**Quantidade Disponível de Livros:**
```
quantidade_disponivel = quantidade_total - livros_emprestados
```

**Prazo Padrão de Empréstimo:**
- 14 dias corridos a partir da data de retirada

**Controle de Disponibilidade:**
- Sistema não permite reserva se quantidade_disponivel = 0
- Quantidade disponível não pode ser negativa
- Quantidade disponível não pode exceder quantidade total

---

## 6. Modelo de Dados

### 6.1 Entidades Principais

#### Tabela: usuarios
| Campo | Tipo | Restrições | Descrição |
|-------|------|------------|-----------|
| id | INT | PK, AUTO_INCREMENT | Identificador único |
| nome | VARCHAR(255) | NOT NULL | Nome completo |
| email | VARCHAR(255) | NOT NULL, UNIQUE | E-mail para login |
| senha | VARCHAR(255) | NOT NULL | Hash bcrypt da senha |
| cpf | VARCHAR(14) | NOT NULL, UNIQUE | CPF do usuário |
| telefone | VARCHAR(20) | NOT NULL | Telefone de contato |
| perfil | ENUM | NOT NULL, DEFAULT 'usuario' | usuario/bibliotecario/administrador |
| ativo | TINYINT(1) | NOT NULL, DEFAULT 1 | Status do usuário |
| data_criacao | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Data de cadastro |
| data_atualizacao | TIMESTAMP | ON UPDATE CURRENT_TIMESTAMP | Última atualização |

#### Tabela: livros
| Campo | Tipo | Restrições | Descrição |
|-------|------|------------|-----------|
| id | INT | PK, AUTO_INCREMENT | Identificador único |
| titulo | VARCHAR(255) | NOT NULL | Título do livro |
| autor | VARCHAR(255) | NOT NULL | Autor do livro |
| isbn | VARCHAR(20) | NOT NULL, UNIQUE | ISBN do livro |
| genero | VARCHAR(100) | NOT NULL | Gênero literário |
| editora | VARCHAR(150) | NOT NULL | Editora |
| resumo | TEXT | NULL | Resumo do livro |
| ano_publicacao | YEAR | NOT NULL | Ano de publicação |
| edicao | VARCHAR(50) | NULL | Edição do livro |
| quantidade_paginas | INT | NULL | Número de páginas |
| quantidade_total | INT | NOT NULL, DEFAULT 1 | Total de exemplares |
| quantidade_disponivel | INT | NOT NULL, DEFAULT 1 | Exemplares disponíveis |
| capa_url | VARCHAR(500) | NULL | URL da imagem da capa |
| ativo | TINYINT(1) | NOT NULL, DEFAULT 1 | Status do livro |
| data_criacao | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Data de cadastro |
| data_atualizacao | TIMESTAMP | ON UPDATE CURRENT_TIMESTAMP | Última atualização |

#### Tabela: reservas
| Campo | Tipo | Restrições | Descrição |
|-------|------|------------|-----------|
| id | INT | PK, AUTO_INCREMENT | Identificador único |
| usuario_id | INT | FK, NOT NULL | Usuário que reservou |
| livro_id | INT | FK, NOT NULL | Livro reservado |
| data_reserva | DATETIME | NOT NULL | Data/hora da reserva |
| data_retirada | DATETIME | NULL | Data/hora da retirada |
| data_prevista_devolucao | DATE | NULL | Data prevista para devolução |
| data_devolucao | DATETIME | NULL | Data/hora da devolução |
| status | ENUM | NOT NULL, DEFAULT 'pendente' | pendente/ativa/concluida/cancelada |
| observacoes | TEXT | NULL | Observações gerais |
| bibliotecario_retirada_id | INT | FK, NULL | Bibliotecário que processou retirada |
| bibliotecario_devolucao_id | INT | FK, NULL | Bibliotecário que processou devolução |
| data_criacao | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Data de cadastro |
| data_atualizacao | TIMESTAMP | ON UPDATE CURRENT_TIMESTAMP | Última atualização |

### 6.2 Relacionamentos

```
usuarios (1) ----< (N) reservas [usuario_id]
livros (1) ----< (N) reservas [livro_id]
usuarios (1) ----< (N) reservas [bibliotecario_retirada_id]
usuarios (1) ----< (N) reservas [bibliotecario_devolucao_id]
```

### 6.3 Índices

**Tabela usuarios:**
- idx_email (email)
- idx_perfil (perfil)
- idx_ativo (ativo)

**Tabela livros:**
- idx_titulo (titulo)
- idx_autor (autor)
- idx_isbn (isbn)
- idx_genero (genero)
- idx_ativo (ativo)

**Tabela reservas:**
- idx_usuario (usuario_id)
- idx_livro (livro_id)
- idx_status (status)
- idx_data_reserva (data_reserva)

---

## 7. Casos de Uso Principais

### 7.1 UC01 - Realizar Login

**Ator Principal:** Usuário (qualquer perfil)  
**Pré-condições:** Usuário deve estar cadastrado e ativo  
**Fluxo Principal:**
1. Usuário acessa a página inicial do sistema
2. Sistema exibe formulário de login
3. Usuário informa e-mail e senha
4. Sistema valida credenciais
5. Sistema cria sessão
6. Sistema redireciona para dashboard
7. Caso de uso encerrado

**Fluxos Alternativos:**
- **FA01 - Credenciais Inválidas:**
  - 4a. Sistema identifica e-mail ou senha incorretos
  - 4b. Sistema exibe mensagem de erro
  - 4c. Retorna ao passo 2
- **FA02 - Usuário Inativo:**
  - 4a. Sistema identifica usuário inativo
  - 4b. Sistema exibe mensagem informando status
  - 4c. Caso de uso encerrado

### 7.2 UC02 - Reservar Livro

**Ator Principal:** Usuário  
**Pré-condições:** Usuário autenticado, livro disponível  
**Fluxo Principal:**
1. Usuário acessa catálogo de livros
2. Sistema exibe lista de livros disponíveis
3. Usuário pesquisa livro (opcional)
4. Usuário clica em "Reservar" no livro desejado
5. Sistema valida disponibilidade
6. Sistema cria reserva com status "pendente"
7. Sistema exibe confirmação
8. Caso de uso encerrado

**Fluxos Alternativos:**
- **FA01 - Livro Indisponível:**
  - 5a. Sistema identifica quantidade_disponivel = 0
  - 5b. Sistema exibe mensagem de indisponibilidade
  - 5c. Caso de uso encerrado

### 7.3 UC03 - Processar Retirada

**Ator Principal:** Bibliotecário  
**Pré-condições:** Reserva em status "pendente"  
**Fluxo Principal:**
1. Bibliotecário acessa lista de todas as reservas
2. Sistema exibe reservas com filtros
3. Bibliotecário localiza reserva pendente
4. Bibliotecário clica em "Processar Retirada"
5. Sistema exibe formulário com detalhes da reserva
6. Bibliotecário informa data prevista de devolução
7. Bibliotecário confirma retirada
8. Sistema valida dados
9. Sistema atualiza reserva (status → "ativa", registra datas e bibliotecário)
10. Sistema exibe confirmação
11. Caso de uso encerrado

**Fluxos Alternativos:**
- **FA01 - Data Inválida:**
  - 8a. Sistema identifica data não futura
  - 8b. Sistema exibe mensagem de erro
  - 8c. Retorna ao passo 6

### 7.4 UC04 - Processar Devolução

**Ator Principal:** Bibliotecário  
**Pré-condições:** Reserva em status "ativa"  
**Fluxo Principal:**
1. Bibliotecário acessa lista de reservas ativas
2. Sistema exibe reservas ativas
3. Bibliotecário localiza reserva a ser devolvida
4. Bibliotecário clica em "Processar Devolução"
5. Sistema exibe formulário de devolução
6. Bibliotecário informa observações (opcional)
7. Bibliotecário confirma devolução
8. Sistema atualiza reserva (status → "concluida", registra data e bibliotecário)
9. Sistema incrementa quantidade_disponivel do livro
10. Sistema exibe confirmação
11. Caso de uso encerrado

---