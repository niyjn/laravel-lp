<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Criar conta - Baha Lanches</title>
    <link rel="icon" href="{{ asset('fav.ico') }}" sizes="any">
    @vite('resources/css/app.css')
</head>

<body class="flex min-h-screen items-center justify-center bg-red-950 px-4 text-white">

    <main class="w-full max-w-md rounded-3xl bg-white p-8 text-black shadow-2xl">

        <h1 class="text-center font-jersey text-6xl text-red-950">
            Baha Lanches
        </h1>

        <p class="mt-2 text-center font-bold text-gray-700">
            Crie sua conta
        </p>
        <a href="{{ route('home') }}" class="mt-5 inline-block font-bold text-red-950 hover:underline">← Voltar ao cardápio</a>

        @if ($errors->any())
            <div class="mt-6 rounded-lg bg-red-100 p-4 text-sm text-red-900">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $erro)
                        <li>{{ $erro }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form method="POST" action="{{ route('register.store') }}" class="mt-8 space-y-5">

            @csrf

            <div>
                <label for="nome" class="font-bold text-red-950">
                    Nome
                </label>

                <input
                    id="nome"
                    type="text"
                    name="nome"
                    value="{{ old('nome') }}"
                    required
                    class="mt-2 w-full rounded-lg border-2 border-yellow-500 px-4 py-3 outline-none focus:border-red-950"
                >
            </div>


            <div>
                <label for="email" class="font-bold text-red-950">
                    Email
                </label>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    class="mt-2 w-full rounded-lg border-2 border-yellow-500 px-4 py-3 outline-none focus:border-red-950"
                >
            </div>


            <div>
                <label for="senha" class="font-bold text-red-950">
                    Senha
                </label>

                <input
                    id="senha"
                    type="password"
                    name="senha"
                    required
                    autocomplete="new-password"
                    class="mt-2 w-full rounded-lg border-2 border-yellow-500 px-4 py-3 outline-none focus:border-red-950"
                >
            </div>


            <div>
                <label for="senha_confirmation" class="font-bold text-red-950">
                    Confirmar senha
                </label>

                <input
                    id="senha_confirmation"
                    type="password"
                    name="senha_confirmation"
                    required
                    autocomplete="new-password"
                    class="mt-2 w-full rounded-lg border-2 border-yellow-500 px-4 py-3 outline-none focus:border-red-950"
                >
            </div>


            <button
                type="submit"
                class="w-full rounded-xl bg-yellow-500 px-6 py-4 font-jersey text-4xl text-black shadow-lg transition hover:scale-105 hover:bg-yellow-400"
            >
                Criar conta
            </button>

        </form>


        <p class="mt-6 text-center font-bold text-gray-700">
            Já possui conta?

            <a
                href="{{ route('login') }}"
                class="text-red-950 underline hover:text-red-700"
            >
                Entrar
            </a>
        </p>

    </main>

</body>
</html>
