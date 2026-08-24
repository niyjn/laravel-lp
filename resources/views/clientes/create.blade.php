<!DOCTYPE html>
  <html lang="pt-BR">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Criar conta — Baha Lanches</title>
      <link rel="icon" href="{{ asset('fav.ico') }}" sizes="any">

      @vite('resources/css/app.css')
  </head>

  <body class="flex min-h-screen items-center justify-center bg-red-950 p-4">
      <main class="w-full max-w-md rounded-2xl bg-white p-8 shadow-2xl">
          <h1 class="font-jersey text-5xl text-red-950">Criar conta</h1>
          <a href="{{ route('home') }}" class="mt-4 inline-block font-bold text-red-950 hover:underline">← Voltar ao cardápio</a>

          <form method="POST" action="{{ route('register.store') }}" class="mt-4 space-y-4">
              @csrf

              <input
                  name="nome"
                  value="{{ old('nome') }}"
                  placeholder="Seu nome"
                  required
                  class="w-full rounded-lg border border-gray-300 px-3 py-2"
              >

              <input
                  type="email"
                  name="email"
                  value="{{ old('email') }}"
                  placeholder="Seu email"
                  required
                  class="w-full rounded-lg border border-gray-300 px-3 py-2"
              >

              <input
                  type="password"
                  name="senha"
                  placeholder="Senha"
                  required
                  class="w-full rounded-lg border border-gray-300 px-3 py-2"
              >

              <input
                  type="password"
                  name="senha_confirmation"
                  placeholder="Confirme a senha"
                  required
                  class="w-full rounded-lg border border-gray-300 px-3 py-2"
              >

              @if ($errors->any())
                  <p class="text-sm text-red-600">
                      {{ $errors->first() }}
                  </p>
              @endif

              <button class="w-full rounded-lg bg-yellow-500 px-4 py-3 font-bold text-black">
                  Criar minha conta
              </button>
          </form>

          <p class="mt-4 text-center text-sm">
              Já possui conta?
              <a href="{{ route('login') }}" class="font-bold text-red-950 underline">
                  Entrar
              </a>
          </p>
      </main>
  </body>
  </html>
