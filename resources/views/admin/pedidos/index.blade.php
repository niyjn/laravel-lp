<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administrar pedidos — Baha Lanches</title>
    <link rel="icon" href="{{ asset('fav.ico') }}" sizes="any">
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-red-950 text-white">
    <header class="bg-yellow-500 px-4 py-5 shadow-lg sm:px-6">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-4">
            <a href="{{ route('home') }}" class="font-jersey text-4xl text-black sm:text-5xl">Baha Lanches</a>
            <nav class="flex items-center gap-4">
                <a href="{{ route('produtos.index') }}" class="font-bold text-black hover:underline">← Produtos</a>
                <a href="{{ route('perfil') }}" class="rounded-lg bg-red-950 px-3 py-2 text-sm font-bold text-white">Meu perfil</a>
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-6xl px-4 py-12 sm:px-6">
        <div>
            <p class="font-bold uppercase tracking-[0.2em] text-yellow-500">Administração</p>
            <h1 class="mt-1 font-jersey text-5xl sm:text-6xl">Pedidos</h1>
            <p class="mt-3 text-red-100">Acompanhe novos pedidos e atualize o andamento da cozinha.</p>
        </div>

        @if (session('success'))
            <div class="mt-8 rounded-lg border border-green-300 bg-green-100 px-4 py-3 font-semibold text-green-900">
                {{ session('success') }}
            </div>
        @endif

        <section class="mt-10 overflow-hidden rounded-2xl bg-white text-black shadow-2xl">
            <div class="hidden grid-cols-[0.8fr_1.4fr_1.2fr_1fr_auto] gap-4 border-b border-gray-200 bg-gray-100 px-6 py-4 text-sm font-bold text-gray-600 md:grid">
                <span>Pedido</span>
                <span>Cliente</span>
                <span>Data</span>
                <span>Status</span>
                <span></span>
            </div>

            @forelse ($pedidos as $pedido)
                <article class="grid gap-3 border-b border-gray-200 px-5 py-5 last:border-0 md:grid-cols-[0.8fr_1.4fr_1.2fr_1fr_auto] md:items-center md:gap-4 md:px-6">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wide text-gray-500 md:hidden">Pedido</span>
                        <p class="font-jersey text-3xl text-red-950">#{{ $pedido->id }}</p>
                        <p class="font-bold text-red-950">R$ {{ number_format($pedido->valor, 2, ',', '.') }}</p>
                    </div>

                    <div>
                        <span class="text-xs font-bold uppercase tracking-wide text-gray-500 md:hidden">Cliente</span>
                        <p class="font-bold">{{ $pedido->cliente->nome }}</p>
                        <p class="text-sm text-gray-600">{{ $pedido->cliente->email }}</p>
                    </div>

                    <div>
                        <span class="text-xs font-bold uppercase tracking-wide text-gray-500 md:hidden">Data</span>
                        <p class="text-gray-700">{{ $pedido->criado_em?->format('d/m/Y') ?? '—' }}</p>
                        <p class="text-sm text-gray-500">{{ $pedido->criado_em?->format('H:i') ?? '' }}</p>
                    </div>

                    <div>
                        <span class="text-xs font-bold uppercase tracking-wide text-gray-500 md:hidden">Status</span>
                        <span class="inline-block rounded-full bg-yellow-100 px-3 py-1 text-xs font-bold uppercase tracking-wide text-yellow-900">
                            {{ str_replace('_', ' ', $pedido->status) }}
                        </span>
                    </div>

                    <a href="{{ route('admin.pedidos.show', $pedido) }}" class="rounded-lg bg-red-950 px-4 py-2 text-center text-sm font-bold text-white transition hover:bg-red-900">Gerenciar</a>
                </article>
            @empty
                <div class="p-10 text-center">
                    <p class="font-jersey text-4xl text-red-950">Nenhum pedido ainda</p>
                    <p class="mt-2 text-gray-600">Novos pedidos aparecerão aqui.</p>
                </div>
            @endforelse
        </section>
    </main>
</body>
</html>
