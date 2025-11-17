# Especificação de Requisitos

---
## Controle de usuários
> Teremos três perfis: `usuario`, `bibliotecario` e `administrador`.
- usuario:
  - Criado para controle de acesso ao sistema;
  - Tem as permissões mais baixas do sistema;
  - Podendo acessar listagem de livros;
  - Pesquisar livros;
  - Criar e cancelar reservas em seu nome apenas;
  - Editar seu perfil sem poder trocar seu ID;
  - Trocar sua senha de acesso ao sistema com validação da senha em uso;
- bibliotecario:
  - Terá as mesmas funcionalidades do perfil `usuario`;
  - Somente sobre o perfil `usuario`:
    - Poderá criar novos usuário no sistema;
    - Poderá editar usuários e trocar a senha de usuários sem qualquer validação;
    - Bloquer usuários;
    - Desbloquear usuários;
  - Para livros:
    - Poderá cadastrar novos livros;
    - Editar livros sem alterar ISBN;
    - Bloquear livros na lista de livros;
    - Desbloquear livros na lista de livros;
    - Não permite deletar livros;
  - Para revervas:
    - Pode verificar todas as reservas;
    - Processar o empréstimo de livros;
      - Salvo que existam exemplares disponíveis;
    - Processar a devolução dos livros (informando sempre o estado do livro recebido);
    - Cancelar reservas criadas.
- administrador:
  - Terá todas as funcionalidades do perfil `bibliotecario`;
  - Poderá criar novos usuários no sistema com qualquer perfil;
  - Poderá editar qualquer usuário, sem trocar ID;
  - Poderá trocar a senha de qualquer usuário do sistema;
  - Não poderá deletar usuários, deletar livros tendo em vista a integridade da base de dados e rastreamento de históricos.
