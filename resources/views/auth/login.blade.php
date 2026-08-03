 <!DOCTYPE html>
  <html lang="pt-BR">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Entrar — Baha Lanches</title>

      @vite('resources/css/app.css')
  </head>

  <body class="flex min-h-screen items-center justify-center bg-red-950 px-4">
      <main class="w-full max-w-md rounded-2xl bg-white p-8 shadow-2xl">
          <h1 class="font-jersey text-5xl text-red-950">Baha Lanches</h1>
          <p class="mt-2 text-gray-600">Entre na sua conta.</p>

          <form method="POST" action="{{ route('login.store') }}" class="mt-8 space-y-5">
              @csrf

              <div>
                  <label for="email" class="mb-1 block font-semibold text-gray-800">
                      Email
                  </label>

                  <input
                      id="email"
                      type="email"
                      name="email"
                      value="{{ old('email') }}"
                      required
                      autofocus
                      autocomplete="email"
                      class="w-full rounded-lg border border-gray-300 px-3 py-2 outline-none transition focus:border-yellow-500 focus:ring-2
                      focus:ring-yellow-200"
                  >

                  @error('email')
                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                  @enderror
              </div>

              <div>
                  <label for="senha" class="mb-1 block font-semibold text-gray-800">
                      Senha
                  </label>

                  <input
                      id="senha"
                      type="password"
                      name="senha"
                      required
                      autocomplete="current-password"
                      class="w-full rounded-lg border border-gray-300 px-3 py-2 outline-none transition focus:border-yellow-500 focus:ring-2
                      focus:ring-yellow-200"
                  >
              </div>

              <button
                  type="submit"
                  class="w-full rounded-lg bg-yellow-500 px-4 py-3 font-bold text-black transition hover:bg-yellow-400"
              >
                  Entrar
              </button>
          </form>
      </main>
  </body>
  </html>
