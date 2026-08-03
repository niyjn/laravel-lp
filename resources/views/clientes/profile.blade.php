<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Meu Perfil - Baha Lanches</title>

    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-red-950 text-white">

    <header class="bg-yellow-500 p-6 shadow-lg">
        <div class="mx-auto flex max-w-6xl items-center justify-between">

            <a href="{{ route('home') }}" class="font-jersey text-5xl text-black">
                Baha Lanches
            </a>

            <nav>
                <a
                    href="{{ route('home') }}"
                    class="text-xl font-bold text-black hover:text-red-900"
                >
                    Voltar
                </a>
            </nav>

        </div>
    </header>


    <main class="flex min-h-[80vh] items-center justify-center px-4 py-12">

        <section class="w-full max-w-xl rounded-3xl bg-white p-8 text-black shadow-2xl">

            <h1 class="text-center font-jersey text-6xl text-red-950">
                Meu perfil
            </h1>

            <p class="mt-2 text-center text-gray-600">
                Atualize seus dados de cliente.
            </p>


            <form
                method="POST"
                action="{{ route('perfil.update') }}"
                class="mt-8 space-y-5"
            >

                @csrf
                @method('PATCH')


                <div>
                    <label
                        for="nome"
                        class="mb-1 block font-bold text-red-950"
                    >
                        Nome
                    </label>

                    <input
                        id="nome"
                        type="text"
                        name="nome"
                        value="{{ old('nome', $cliente->nome) }}"
                        required
                        class="w-full rounded-xl border-2 border-yellow-500 px-4 py-3 outline-none focus:border-red-950"
                    >

                    @error('nome')
                        <p class="mt-1 font-bold text-red-700">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                <div>
                    <label
                        for="email"
                        class="mb-1 block font-bold text-red-950"
                    >
                        Email
                    </label>

                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email', $cliente->email) }}"
                        required
                        class="w-full rounded-xl border-2 border-yellow-500 px-4 py-3 outline-none focus:border-red-950"
                    >

                    @error('email')
                        <p class="mt-1 font-bold text-red-700">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                <div class="rounded-2xl bg-yellow-100 p-5">

                    <h2 class="font-jersey text-4xl text-red-950">
                        Alterar senha
                    </h2>

                    <p class="mb-4 text-sm text-gray-700">
                        Deixe vazio caso não queira trocar.
                    </p>


                    <label
                        for="senha"
                        class="mb-1 block font-bold text-red-950"
                    >
                        Nova senha
                    </label>

                    <input
                        id="senha"
                        type="password"
                        name="senha"
                        autocomplete="new-password"
                        class="w-full rounded-xl border-2 border-yellow-500 px-4 py-3 outline-none focus:border-red-950"
                    >

                    @error('senha')
                        <p class="mt-1 font-bold text-red-700">
                            {{ $message }}
                        </p>
                    @enderror


                    <label
                        for="senha_confirmation"
                        class="mb-1 mt-4 block font-bold text-red-950"
                    >
                        Confirmar senha
                    </label>

                    <input
                        id="senha_confirmation"
                        type="password"
                        name="senha_confirmation"
                        autocomplete="new-password"
                        class="w-full rounded-xl border-2 border-yellow-500 px-4 py-3 outline-none focus:border-red-950"
                    >

                </div>


                <button
                    type="submit"
                    class="w-full rounded-2xl bg-yellow-500 py-4 font-bold text-black shadow-lg transition hover:scale-105 hover:bg-yellow-400"
                >
                    Salvar alterações
                </button>

            </form>


            <hr class="my-8 border-gray-300">


            <form method="POST" action="{{ route('logout') }}">

                @csrf

                <button
                    type="submit"
                    class="w-full rounded-2xl bg-red-950 py-4 font-bold text-white transition hover:bg-red-900"
                >
                    Sair da conta
                </button>

            </form>


        </section>

    </main>


    <footer class="bg-black p-6 text-center">

        <p class="font-bold">
            Baha Lanches - Guarapuava PR
        </p>

    </footer>


</body>
</html>