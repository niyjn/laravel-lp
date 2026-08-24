<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administrar pedido #{{ $pedido->id }} — Baha Lanches</title>
    <link rel="icon" href="{{ asset('fav.ico') }}" sizes="any">
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-red-950 text-white">
    <header class="bg-yellow-500 px-4 py-5 shadow-lg sm:px-6">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-4">
            <a href="{{ route('home') }}" class="font-jersey text-4xl text-black sm:text-5xl">Baha Lanches</a>
            <a href="{{ route('admin.pedidos.index') }}" class="font-bold text-black hover:underline">← Administrar pedidos</a>
        </div>
    </header>

    <main class="mx-auto max-w-6xl px-4 py-12 sm:px-6">
        @if (session('success'))
            <div class="mb-6 rounded-lg border border-green-300 bg-green-100 px-4 py-3 font-semibold text-green-900">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-wrap items-end justify-between gap-5">
            <div>
                <p class="font-bold uppercase tracking-[0.2em] text-yellow-500">Administração · Pedido #{{ $pedido->id }}</p>
                <h1 class="mt-1 font-jersey text-5xl sm:text-6xl">Gerenciar pedido</h1>
                <p class="mt-3 text-red-100">Feito em {{ $pedido->criado_em?->format('d/m/Y \à\s H:i') ?? 'data indisponível' }}.</p>
            </div>
            <strong class="font-jersey text-4xl text-yellow-500">R$ {{ number_format($pedido->valor, 2, ',', '.') }}</strong>
        </div>

        <div class="mt-10 grid gap-6 lg:grid-cols-[1.35fr_0.85fr]">
            <section class="rounded-2xl bg-white p-6 text-black shadow-2xl sm:p-8">
                <p class="font-bold uppercase tracking-[0.2em] text-red-950">Pedido</p>
                <h2 class="mt-1 font-jersey text-4xl text-red-950">Itens</h2>

                <div class="mt-6 divide-y divide-gray-200">
                    @foreach ($pedido->itens as $item)
                        <article class="flex items-center justify-between gap-4 py-4 first:pt-0">
                            <div>
                                <h3 class="font-jersey text-2xl text-red-950">{{ $item->produto->nome }}</h3>
                                <p class="mt-1 text-sm text-gray-600">{{ $item->quantidade }}× R$ {{ number_format($item->preco_unitario, 2, ',', '.') }}</p>
                                @if ($item->observacao)
                                    <p class="mt-2 rounded-lg bg-yellow-50 px-3 py-2 text-sm text-yellow-900">{{ $item->observacao }}</p>
                                @endif
                            </div>
                            <strong class="text-lg text-red-950">R$ {{ number_format($item->quantidade * $item->preco_unitario, 2, ',', '.') }}</strong>
                        </article>
                    @endforeach
                </div>
            </section>

            <aside class="space-y-6">
                <section class="rounded-2xl bg-white p-6 text-black shadow-2xl sm:p-8">
                    <p class="font-bold uppercase tracking-[0.2em] text-red-950">Andamento</p>
                    <h2 class="mt-1 font-jersey text-4xl text-red-950">Status</h2>

                    <form action="{{ route('admin.pedidos.status.update', $pedido) }}" method="POST" class="mt-6">
                        @csrf
                        @method('PATCH')

                        <label for="status" class="mb-1 block font-semibold text-gray-800">Atualizar status</label>
                        <select id="status" name="status" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200">
                            @foreach (['aguardando_confirmacao', 'confirmado', 'em_preparo', 'enviado', 'entregue', 'cancelado'] as $status)
                                <option value="{{ $status }}" @selected($pedido->status === $status)>
                                    {{ str_replace('_', ' ', $status) }}
                                </option>
                            @endforeach
                        </select>

                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        <button type="submit" class="mt-4 w-full rounded-lg bg-yellow-500 px-4 py-3 font-bold text-black transition hover:bg-yellow-400">Salvar status</button>
                    </form>
                </section>

                <section class="rounded-2xl bg-white p-6 text-black shadow-2xl sm:p-8">
                    <p class="font-bold uppercase tracking-[0.2em] text-red-950">Cliente</p>
                    <h2 class="mt-1 font-jersey text-4xl text-red-950">Entrega</h2>

                    <div class="mt-5">
                        <p class="font-bold text-red-950">{{ $pedido->cliente->nome }}</p>
                        <p class="text-sm text-gray-600">{{ $pedido->cliente->email }}</p>
                    </div>

                    @if ($pedido->endereco)
                        <div class="mt-5 rounded-xl bg-gray-100 p-4 text-sm text-gray-700">
                            <p class="font-bold text-red-950">{{ $pedido->endereco->logradouro }}, {{ $pedido->endereco->numero }}</p>
                            <p>{{ $pedido->endereco->bairro }}</p>
                            <p>{{ $pedido->endereco->cidade }}/{{ $pedido->endereco->estado }}</p>
                            <p class="mt-1 text-gray-500">CEP {{ $pedido->endereco->cep }}</p>
                            @if ($pedido->endereco->complemento)
                                <p class="mt-3">{{ $pedido->endereco->complemento }}</p>
                            @endif
                        </div>
                    @endif
                </section>
            </aside>
        </div>
    </main>
</body>
</html>
