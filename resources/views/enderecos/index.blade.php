<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Meus endereços — Baha Lanches</title>
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-red-950 text-white">
    <header class="bg-yellow-500 px-4 py-5 shadow-lg sm:px-6">
        <div class="mx-auto flex max-w-5xl items-center justify-between gap-4">
            <a href="{{ route('home') }}" class="font-jersey text-4xl text-black sm:text-5xl">Baha Lanches</a>
            <nav class="flex items-center gap-4">
                <a href="{{ route('perfil') }}" class="font-bold text-black hover:underline">Meu perfil</a>
                <a href="{{ route('checkout') }}" class="rounded-lg bg-red-950 px-3 py-2 text-sm font-bold text-white">Checkout</a>
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-5xl px-4 py-12 sm:px-6">
        <div class="flex flex-wrap items-end justify-between gap-5">
            <div>
                <p class="font-bold uppercase tracking-[0.2em] text-yellow-500">Entrega</p>
                <h1 class="mt-1 font-jersey text-5xl sm:text-6xl">Meus endereços</h1>
                <p class="mt-3 text-red-100">Cadastre onde você deseja receber seus pedidos.</p>
            </div>
            <a href="{{ route('enderecos.create') }}" class="rounded-lg bg-yellow-500 px-5 py-3 font-bold text-black transition hover:bg-yellow-400">
                + Novo endereço
            </a>
        </div>

        @if (session('success'))
            <div class="mt-8 rounded-lg border border-green-300 bg-green-100 px-4 py-3 font-semibold text-green-900">
                {{ session('success') }}
            </div>
        @endif

        <section class="mt-10 grid gap-5 md:grid-cols-2">
            @forelse ($enderecos as $endereco)
                <article class="rounded-2xl bg-white p-6 text-black shadow-xl">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-yellow-500 text-2xl">📍</div>
                        <div class="flex-1">
                            <h2 class="font-jersey text-3xl text-red-950">{{ $endereco->logradouro }}, {{ $endereco->numero }}</h2>
                            <p class="mt-2 text-gray-700">{{ $endereco->bairro }} — {{ $endereco->cidade }}/{{ $endereco->estado }}</p>
                            <p class="mt-1 text-sm text-gray-500">CEP {{ $endereco->cep }}</p>
                            @if ($endereco->complemento)
                                <p class="mt-3 rounded-lg bg-gray-100 px-3 py-2 text-sm text-gray-600">{{ $endereco->complemento }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="mt-6 flex items-center gap-4 border-t border-gray-200 pt-5">
                        <a href="{{ route('enderecos.edit', $endereco) }}" class="font-bold text-red-950 hover:underline">Editar</a>
                        <form action="{{ route('enderecos.destroy', $endereco) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Excluir este endereço?')" class="font-bold text-red-700 hover:underline">Excluir</button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="rounded-2xl border border-red-800 bg-red-900/40 p-10 text-center md:col-span-2">
                    <p class="font-jersey text-4xl text-yellow-500">Nenhum endereço cadastrado</p>
                    <p class="mt-2 text-red-100">Você precisa de um endereço para finalizar um pedido.</p>
                    <a href="{{ route('enderecos.create') }}" class="mt-6 inline-block rounded-lg bg-yellow-500 px-5 py-3 font-bold text-black transition hover:bg-yellow-400">Cadastrar endereço</a>
                </div>
            @endforelse
        </section>
    </main>
</body>
</html>
