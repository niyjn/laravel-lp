<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pedido #{{ $pedido->id }} — Baha Lanches</title>
    <link rel="icon" href="{{ asset('fav.ico') }}" sizes="any">
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-red-950 text-white">
    <header class="bg-yellow-500 px-4 py-5 shadow-lg sm:px-6">
        <div class="mx-auto flex max-w-5xl items-center justify-between gap-4">
            <a href="{{ route('home') }}" class="font-jersey text-4xl text-black sm:text-5xl">Baha Lanches</a>
            <a href="{{ route('pedidos.index') }}" class="font-bold text-black hover:underline">← Meus pedidos</a>
        </div>
    </header>

    <main class="mx-auto max-w-5xl px-4 py-12 sm:px-6">
        @if (session('success'))
            <div class="mb-6 rounded-lg border border-green-300 bg-green-100 px-4 py-3 font-semibold text-green-900">
                {{ session('success') }}
            </div>
            <script>localStorage.removeItem('baha-carrinho');</script>
        @endif

        <div class="flex flex-wrap items-end justify-between gap-5">
            <div>
                <p class="font-bold uppercase tracking-[0.2em] text-yellow-500">Pedido #{{ $pedido->id }}</p>
                <h1 class="mt-1 font-jersey text-5xl sm:text-6xl">Detalhes do pedido</h1>
                <p class="mt-3 text-red-100">Feito em {{ $pedido->criado_em?->format('d/m/Y \à\s H:i') ?? 'data indisponível' }}.</p>
            </div>
            <span class="rounded-full bg-yellow-500 px-4 py-2 text-sm font-bold uppercase tracking-wide text-red-950">
                {{ str_replace('_', ' ', $pedido->status) }}
            </span>
        </div>

        <div class="mt-10 grid gap-6 lg:grid-cols-[1.35fr_0.85fr]">
            <section class="rounded-2xl bg-white p-6 text-black shadow-2xl sm:p-8">
                <p class="font-bold uppercase tracking-[0.2em] text-red-950">Resumo</p>
                <h2 class="mt-1 font-jersey text-4xl text-red-950">Itens pedidos</h2>

                <div class="mt-6 divide-y divide-gray-200">
                    @foreach ($pedido->itens as $item)
                        <article class="flex items-center justify-between gap-4 py-4 first:pt-0">
                            <div>
                                <h3 class="font-jersey text-2xl text-red-950">{{ $item->produto->nome }}</h3>
                                <p class="mt-1 text-sm text-gray-600">
                                    {{ $item->quantidade }}× R$ {{ number_format($item->preco_unitario, 2, ',', '.') }}
                                </p>
                                @if ($item->observacao)
                                    <p class="mt-2 rounded-lg bg-yellow-50 px-3 py-2 text-sm text-yellow-900">{{ $item->observacao }}</p>
                                @endif
                            </div>
                            <strong class="text-lg text-red-950">
                                R$ {{ number_format($item->quantidade * $item->preco_unitario, 2, ',', '.') }}
                            </strong>
                        </article>
                    @endforeach
                </div>

                <div class="mt-6 flex items-center justify-between border-t-2 border-red-950 pt-5">
                    <span class="font-jersey text-3xl text-red-950">Total</span>
                    <strong class="font-jersey text-4xl text-red-950">R$ {{ number_format($pedido->valor, 2, ',', '.') }}</strong>
                </div>
            </section>

            <aside class="space-y-6">
                <section class="rounded-2xl bg-white p-6 text-black shadow-2xl sm:p-8">
                    <p class="font-bold uppercase tracking-[0.2em] text-red-950">Entrega</p>
                    <h2 class="mt-1 font-jersey text-4xl text-red-950">Endereço</h2>

                    @if ($pedido->endereco)
                        <div class="mt-6 rounded-xl bg-gray-100 p-4">
                            <p class="font-bold text-red-950">{{ $pedido->endereco->logradouro }}, {{ $pedido->endereco->numero }}</p>
                            <p class="mt-1 text-gray-700">{{ $pedido->endereco->bairro }}</p>
                            <p class="text-gray-700">{{ $pedido->endereco->cidade }}/{{ $pedido->endereco->estado }}</p>
                            <p class="mt-1 text-sm text-gray-500">CEP {{ $pedido->endereco->cep }}</p>
                            @if ($pedido->endereco->complemento)
                                <p class="mt-3 text-sm text-gray-600">{{ $pedido->endereco->complemento }}</p>
                            @endif
                        </div>
                    @else
                        <p class="mt-6 text-gray-600">Endereço não disponível.</p>
                    @endif

                    <a href="{{ route('home') }}#produtos" class="mt-6 block rounded-lg bg-yellow-500 px-4 py-3 text-center font-bold text-black transition hover:bg-yellow-400">Fazer novo pedido</a>
                </section>

                @php
                    $numeroWhatsapp = preg_replace('/\D/', '', (string) config('services.whatsapp.number'));
                    $linhas = $pedido->itens->map(function ($item) {
                        $subtotal = $item->quantidade * $item->preco_unitario;

                        return "{$item->quantidade}x {$item->produto->nome} — R$ ".number_format($subtotal, 2, ',', '.');
                    })->implode("\n");
                    $mensagem = "Olá! Fiz o pedido #{$pedido->id}:\n\n{$linhas}\n\nTotal: R$ ".number_format($pedido->valor, 2, ',', '.');
                @endphp

                <section class="rounded-2xl bg-white p-6 text-black shadow-2xl sm:p-8">
                    <p class="font-bold uppercase tracking-[0.2em] text-red-950">Pagamento</p>
                    <h2 class="mt-1 font-jersey text-4xl text-red-950">Confirmação manual</h2>
                    <p class="mt-4 text-gray-700">Seu pedido foi recebido e aguarda confirmação da loja. O pagamento não é confirmado automaticamente pelo site.</p>

                    @if ($numeroWhatsapp)
                        <a href="https://wa.me/{{ $numeroWhatsapp }}?text={{ urlencode($mensagem) }}" target="_blank" rel="noopener noreferrer" class="mt-5 block rounded-lg bg-green-600 px-4 py-3 text-center font-bold text-white transition hover:bg-green-700">
                            Enviar pedido no WhatsApp
                        </a>
                    @else
                        <p class="mt-5 rounded-lg bg-yellow-100 p-3 text-sm text-yellow-900">WhatsApp da loja ainda não foi configurado.</p>
                    @endif
                </section>
            </aside>
        </div>
    </main>
</body>
</html>
