  <!DOCTYPE html>
  <html lang="pt-BR">
  <head>
      <meta charset="UTF-8">
      <title>Meu perfil</title>
  </head>
  <body>
      <h1>Meu perfil</h1>

      <form method="POST" action="{{ route('perfil.update') }}">
          @csrf
          @method('PATCH')

          <div>
              <label for="nome">Nome</label>

              <input
                  id="nome"
                  type="text"
                  name="nome"
                  value="{{ old('nome', $cliente->nome) }}"
                  required
              >

              @error('nome')
                  <p>{{ $message }}</p>
              @enderror
          </div>

          <div>
              <label for="email">Email</label>

              <input
                  id="email"
                  type="email"
                  name="email"
                  value="{{ old('email', $cliente->email) }}"
                  required
              >

              @error('email')
                  <p>{{ $message }}</p>
              @enderror
          </div>

          <h2>Alterar senha</h2>
          <p>Deixe em branco se não quiser trocar a senha.</p>

          <div>
              <label for="senha">Nova senha</label>

              <input
                  id="senha"
                  type="password"
                  name="senha"
                  autocomplete="new-password"
              >

              @error('senha')
                  <p>{{ $message }}</p>
              @enderror
          </div>

          <div>
              <label for="senha_confirmation">Confirme a nova senha</label>

              <input
                  id="senha_confirmation"
                  type="password"
                  name="senha_confirmation"
                  autocomplete="new-password"
              >
          </div>

          <button type="submit">Salvar alterações</button>
      </form>

      <hr>

      <form method="POST" action="{{ route('logout') }}">
          @csrf

          <button type="submit">Sair</button>
      </form>
  </body>
  </html>
