<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Meu perfil — Baha Lanches</title>
    <link rel="icon" href="{{ asset('fav.ico') }}" sizes="any">
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-red-950 text-white">
    <header class="bg-yellow-500 px-4 py-5 shadow-lg sm:px-6">
        <div class="mx-auto flex max-w-3xl items-center justify-between gap-4">
            <a href="{{ route('home') }}" class="font-jersey text-4xl text-black sm:text-5xl">Baha Lanches</a>
            <nav class="flex items-center gap-4">
                <a href="{{ route('home') }}#produtos" class="font-bold text-black hover:underline">← Cardápio</a>
                @can('gerenciar-produtos')
                    <a href="{{ route('produtos.index') }}" class="rounded-lg bg-red-950 px-3 py-2 text-sm font-bold text-white">Administrar</a>
                @endcan
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-3xl px-4 py-12 sm:px-6">
        <div class="mb-8">
            <p class="font-bold uppercase tracking-[0.2em] text-yellow-500">Minha conta</p>
            <h1 class="mt-1 font-jersey text-5xl sm:text-6xl">Meu perfil</h1>
            <p class="mt-3 text-red-100">Atualize seus dados e mantenha sua conta segura.</p>
        </div>

        @if (session('success'))
            <div class="mb-6 rounded-lg border border-green-300 bg-green-100 px-4 py-3 font-semibold text-green-900">
                {{ session('success') }}
            </div>
        @endif

        <section class="rounded-2xl bg-white p-6 text-black shadow-2xl sm:p-8">
            <div class="flex items-center gap-4 border-b border-gray-200 pb-6">
                <div class="flex h-14 w-14 items-center justify-center rounded-full bg-yellow-500 font-jersey text-3xl text-red-950">
                    {{ mb_strtoupper(mb_substr($cliente->nome, 0, 1)) }}
                </div>
                <div>
                    <h2 class="font-jersey text-3xl text-red-950">{{ $cliente->nome }}</h2>
                    <p class="text-sm text-gray-600">{{ $cliente->email }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('perfil.update') }}" class="mt-8 space-y-5">
                @csrf
                @method('PATCH')

                <div>
                    <label for="nome" class="mb-1 block font-semibold text-gray-800">Nome</label>
                    <input id="nome" type="text" name="nome" value="{{ old('nome', $cliente->nome) }}" required autocomplete="name" class="w-full rounded-lg border border-gray-300 px-3 py-2 outline-none transition focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200">
                    @error('nome')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="mb-1 block font-semibold text-gray-800">E-mail</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $cliente->email) }}" required autocomplete="email" class="w-full rounded-lg border border-gray-300 px-3 py-2 outline-none transition focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="border-t border-gray-200 pt-6">
                    <h2 class="font-jersey text-3xl text-red-950">Alterar senha</h2>
                    <p class="mt-1 text-sm text-gray-600">Deixe os campos vazios se não quiser trocar sua senha.</p>
                </div>

                <div>
                    <label for="senha" class="mb-1 block font-semibold text-gray-800">Nova senha</label>
                    <input id="senha" type="password" name="senha" autocomplete="new-password" class="w-full rounded-lg border border-gray-300 px-3 py-2 outline-none transition focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200">
                    @error('senha')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="senha_confirmation" class="mb-1 block font-semibold text-gray-800">Confirme a nova senha</label>
                    <input id="senha_confirmation" type="password" name="senha_confirmation" autocomplete="new-password" class="w-full rounded-lg border border-gray-300 px-3 py-2 outline-none transition focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200">
                </div>

                <button type="submit" class="w-full rounded-lg bg-yellow-500 px-4 py-3 font-bold text-black transition hover:bg-yellow-400">Salvar alterações</button>
            </form>
        </section>

        <section class="mt-6 rounded-2xl border border-red-800 bg-red-900/40 p-6 sm:p-8">
            <h2 class="font-jersey text-3xl text-yellow-500">Encerrar sessão</h2>
            <p class="mt-2 text-red-100">Ao sair, você precisará informar suas credenciais novamente.</p>
            <form method="POST" action="{{ route('logout') }}" class="mt-5">
                @csrf
                <button type="submit" class="rounded-lg border-2 border-yellow-500 px-5 py-3 font-bold text-yellow-500 transition hover:bg-yellow-500 hover:text-black">Sair da conta</button>
            </form>
        </section>
    </main>
</body>
</html>
