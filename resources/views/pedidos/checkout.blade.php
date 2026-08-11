<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout — Baha Lanches</title>
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-red-950 text-white">
    <header class="bg-yellow-500 px-4 py-5 shadow-lg sm:px-6">
        <div class="mx-auto flex max-w-5xl items-center justify-between gap-4">
            <a href="{{ route('home') }}" class="font-jersey text-4xl text-black sm:text-5xl">Baha Lanches</a>
            <a href="{{ route('home') }}#produtos" class="font-bold text-black hover:underline">← Cardápio</a>
        </div>
    </header>

    <main class="mx-auto max-w-5xl px-4 py-12 sm:px-6">
        <div class="mb-8">
            <p class="font-bold uppercase tracking-[0.2em] text-yellow-500">Pedido</p>
            <h1 class="mt-1 font-jersey text-5xl sm:text-6xl">Finalizar checkout</h1>
            <p class="mt-3 text-red-100">Revise os itens e escolha onde deseja receber seu pedido.</p>
        </div>

        @if (session('success'))
            <div class="mb-6 rounded-lg border border-green-300 bg-green-100 px-4 py-3 font-semibold text-green-900">
                {{ session('success') }}
            </div>
            <script>localStorage.removeItem('baha-carrinho');</script>
        @endif

        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-red-300 bg-red-100 px-4 py-3 text-red-900">
                <p class="font-bold">Não foi possível criar seu pedido.</p>
                <ul class="mt-2 list-inside list-disc text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="form-checkout" method="POST" action="{{ route('pedidos.store') }}" class="grid gap-6 lg:grid-cols-[1.4fr_0.9fr]">
            @csrf

            <section class="rounded-2xl bg-white p-6 text-black shadow-2xl sm:p-8">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="font-bold uppercase tracking-[0.2em] text-red-950">Seu pedido</p>
                        <h2 class="mt-1 font-jersey text-4xl text-red-950">Itens do carrinho</h2>
                    </div>
                    <span id="quantidade-itens" class="rounded-full bg-yellow-500 px-3 py-1 text-sm font-bold text-red-950"></span>
                </div>

                <div id="lista-itens" class="mt-6 space-y-4"></div>
                <div id="mensagem-carrinho-vazio" class="mt-6 hidden rounded-lg bg-gray-100 p-5 text-center text-gray-600">
                    Seu carrinho está vazio. <a href="{{ route('home') }}#produtos" class="font-bold text-red-950 underline">Escolher produtos</a>
                </div>
            </section>

            <aside class="h-fit rounded-2xl bg-white p-6 text-black shadow-2xl sm:p-8">
                <p class="font-bold uppercase tracking-[0.2em] text-red-950">Entrega</p>
                <h2 class="mt-1 font-jersey text-4xl text-red-950">Endereço</h2>

                @if ($enderecos->isNotEmpty())
                    <label for="endereco_id" class="mt-6 mb-1 block font-semibold text-gray-800">Escolha um endereço</label>
                    <select id="endereco_id" name="endereco_id" required class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200">
                        <option value="">Selecione</option>
                        @foreach ($enderecos as $endereco)
                            <option value="{{ $endereco->id }}" @selected(old('endereco_id') == $endereco->id)>
                                {{ $endereco->logradouro }}, {{ $endereco->numero }} — {{ $endereco->bairro }}
                            </option>
                        @endforeach
                    </select>
                    @error('endereco_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                @else
                    <div class="mt-6 rounded-lg bg-yellow-100 p-4 text-sm text-yellow-900">
                        Você precisa cadastrar um endereço antes de finalizar o pedido.
                    </div>
                @endif

                <div class="mt-8 border-t border-gray-200 pt-5">
                    <div class="flex items-center justify-between text-gray-600">
                        <span>Subtotal estimado</span>
                        <span id="subtotal-checkout">R$ 0,00</span>
                    </div>
                    <div class="mt-3 flex items-center justify-between text-xl font-bold text-red-950">
                        <span>Total estimado</span>
                        <strong id="total-checkout">R$ 0,00</strong>
                    </div>
                    <p class="mt-2 text-xs text-gray-500">O preço e a disponibilidade serão confirmados pelo sistema ao criar o pedido.</p>
                </div>

                <div id="itens-enviados"></div>
                <button id="botao-confirmar" type="submit" @disabled($enderecos->isEmpty()) class="mt-6 w-full rounded-lg bg-yellow-500 px-4 py-3 font-bold text-black transition hover:bg-yellow-400 disabled:cursor-not-allowed disabled:opacity-50">
                    Confirmar pedido
                </button>
            </aside>
        </form>
    </main>

    <script>
        const chaveCarrinho = 'baha-carrinho';
        const listaItens = document.querySelector('#lista-itens');
        const itensEnviados = document.querySelector('#itens-enviados');
        const botaoConfirmar = document.querySelector('#botao-confirmar');

        let carrinho;

        try {
            carrinho = new Map(JSON.parse(localStorage.getItem(chaveCarrinho) || '[]'));
        } catch {
            carrinho = new Map();
        }

        function formatarPreco(valor) {
            return valor.toLocaleString('pt-BR', {
                style: 'currency',
                currency: 'BRL',
            });
        }

        function salvarCarrinho() {
            localStorage.setItem(chaveCarrinho, JSON.stringify([...carrinho.entries()]));
        }

        function escaparHtml(valor) {
            const elemento = document.createElement('span');
            elemento.textContent = valor;
            return elemento.innerHTML;
        }

        function alterarQuantidade(id, variacao) {
            const item = carrinho.get(id);
            item.quantidade += variacao;

            if (item.quantidade <= 0) carrinho.delete(id);

            salvarCarrinho();
            renderizarCheckout();
        }

        function renderizarCheckout() {
            const itens = [...carrinho.entries()];
            const quantidade = itens.reduce((total, [, item]) => total + item.quantidade, 0);
            const subtotal = itens.reduce((total, [, item]) => total + Number(item.preco) * item.quantidade, 0);

            document.querySelector('#quantidade-itens').textContent = `${quantidade} ${quantidade === 1 ? 'item' : 'itens'}`;
            document.querySelector('#subtotal-checkout').textContent = formatarPreco(subtotal);
            document.querySelector('#total-checkout').textContent = formatarPreco(subtotal);
            document.querySelector('#mensagem-carrinho-vazio').classList.toggle('hidden', itens.length > 0);
            botaoConfirmar.disabled = itens.length === 0 || {{ $enderecos->isEmpty() ? 'true' : 'false' }};

            listaItens.innerHTML = itens.map(([id, item]) => `
                <article class="flex items-center justify-between gap-4 rounded-xl bg-gray-100 p-4">
                    <div class="min-w-0">
                        <h3 class="truncate font-jersey text-2xl text-red-950">${escaparHtml(item.nome)}</h3>
                        <p class="text-sm text-gray-600">${formatarPreco(Number(item.preco))} cada</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <button type="button" class="rounded bg-white px-3 py-1 font-bold text-red-950 shadow" data-id="${id}" data-variacao="-1">−</button>
                        <span class="w-5 text-center font-bold">${item.quantidade}</span>
                        <button type="button" class="rounded bg-white px-3 py-1 font-bold text-red-950 shadow" data-id="${id}" data-variacao="1">+</button>
                    </div>
                </article>
            `).join('');

            listaItens.querySelectorAll('button[data-id]').forEach((botao) => {
                botao.addEventListener('click', () => {
                    alterarQuantidade(botao.dataset.id, Number(botao.dataset.variacao));
                });
            });
        }

        document.querySelector('#form-checkout').addEventListener('submit', (evento) => {
            if (carrinho.size === 0) {
                evento.preventDefault();
                return;
            }

            // Converte o Map do localStorage em campos que o Laravel entende como itens[0][produto_id].
            itensEnviados.replaceChildren();
            [...carrinho.entries()].forEach(([produtoId, item], indice) => {
                [['produto_id', produtoId], ['quantidade', item.quantidade]].forEach(([campo, valor]) => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = `itens[${indice}][${campo}]`;
                    input.value = valor;
                    itensEnviados.appendChild(input);
                });
            });
        });

        renderizarCheckout();
    </script>
</body>
</html>
