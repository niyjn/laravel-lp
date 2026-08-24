<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Meus pedidos — Baha Lanches</title>
    <link rel="icon" href="{{ asset('fav.ico') }}" sizes="any">
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-red-950 text-white">
    <header class="bg-yellow-500 px-4 py-5 shadow-lg sm:px-6">
        <div class="mx-auto flex max-w-5xl items-center justify-between gap-4">
            <a href="{{ route('home') }}" class="font-jersey text-4xl text-black sm:text-5xl">Baha Lanches</a>
            <nav class="flex items-center gap-4">
                <a href="{{ route('perfil') }}" class="font-bold text-black hover:underline">← Perfil</a>
                <a href="{{ route('home') }}#produtos" class="rounded-lg bg-red-950 px-3 py-2 text-sm font-bold text-white">Pedir agora</a>
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-5xl px-4 py-12 sm:px-6">
        <div>
            <p class="font-bold uppercase tracking-[0.2em] text-yellow-500">Histórico</p>
            <h1 class="mt-1 font-jersey text-5xl sm:text-6xl">Meus pedidos</h1>
            <p class="mt-3 text-red-100">Acompanhe os pedidos feitos na Baha Lanches.</p>
        </div>

        <section class="mt-10 space-y-4">
            @forelse ($pedidos as $pedido)
                <article class="rounded-2xl bg-white p-5 text-black shadow-xl sm:p-6">
                    <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <div class="flex flex-wrap items-center gap-3">
                                <h2 class="font-jersey text-3xl text-red-950">Pedido #{{ $pedido->id }}</h2>
                                <span class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-bold uppercase tracking-wide text-yellow-900">
                                    {{ str_replace('_', ' ', $pedido->status) }}
                                </span>
                            </div>
                            <p class="mt-2 text-sm text-gray-600">
                                Feito em {{ $pedido->criado_em?->format('d/m/Y \à\s H:i') ?? 'data indisponível' }}
                            </p>
                        </div>

                        <div class="flex items-center justify-between gap-6 sm:justify-end">
                            <strong class="font-jersey text-3xl text-red-950">R$ {{ number_format($pedido->valor, 2, ',', '.') }}</strong>
                            <a href="{{ route('pedidos.show', $pedido) }}" class="rounded-lg bg-red-950 px-4 py-2 font-bold text-white transition hover:bg-red-900">Ver pedido</a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="rounded-2xl border border-red-800 bg-red-900/40 p-10 text-center">
                    <p class="font-jersey text-4xl text-yellow-500">Você ainda não fez pedidos</p>
                    <p class="mt-2 text-red-100">Quando finalizar um pedido, ele aparecerá aqui.</p>
                    <a href="{{ route('home') }}#produtos" class="mt-6 inline-block rounded-lg bg-yellow-500 px-5 py-3 font-bold text-black transition hover:bg-yellow-400">Ver cardápio</a>
                </div>
            @endforelse
        </section>
    </main>
</body>
</html>
