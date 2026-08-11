<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Produtos — Baha Lanches</title>
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-red-950 text-white">
    <header class="bg-yellow-500 px-4 py-5 shadow-lg sm:px-6">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-4">
            <a href="{{ route('home') }}" class="font-jersey text-4xl text-black sm:text-5xl">Baha Lanches</a>
            <a href="{{ route('home') }}#produtos" class="font-bold text-black hover:underline">Cardápio</a>
        </div>
    </header>

    <main class="mx-auto max-w-6xl px-4 py-12 sm:px-6">
        <div class="flex flex-wrap items-end justify-between gap-5">
            <div>
                <p class="font-bold uppercase tracking-[0.2em] text-yellow-500">Cardápio</p>
                <h1 class="mt-1 font-jersey text-5xl sm:text-6xl">Produtos</h1>
                <p class="mt-3 text-red-100">Conheça os lanches disponíveis hoje.</p>
            </div>

            @can('gerenciar-produtos')
                <a href="{{ route('produtos.create') }}" class="rounded-lg bg-yellow-500 px-5 py-3 font-bold text-black transition hover:bg-yellow-400">
                    + Novo produto
                </a>
            @endcan
        </div>

        @if (session('success'))
            <div class="mt-8 rounded-lg border border-green-300 bg-green-100 px-4 py-3 font-semibold text-green-900">
                {{ session('success') }}
            </div>
        @endif

        <section class="mt-10 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($produtos as $produto)
                <article class="overflow-hidden rounded-2xl bg-white text-black shadow-xl transition hover:-translate-y-1">
                    <div class="flex h-36 items-center justify-center bg-gradient-to-br from-yellow-300 to-orange-500 text-6xl">🍔</div>
                    <div class="p-5">
                        <h2 class="font-jersey text-3xl text-red-950">{{ $produto->nome }}</h2>
                        <p class="mt-2 min-h-12 text-sm text-gray-600">{{ $produto->descricao }}</p>
                        <p class="mt-5 text-xl font-bold text-red-950">R$ {{ number_format($produto->preco, 2, ',', '.') }}</p>

                        <div class="mt-5 flex items-center justify-between gap-3">
                            <a href="{{ route('produtos.show', $produto) }}" class="font-bold text-red-950 hover:underline">Ver detalhes</a>
                            @can('gerenciar-produtos')
                                <button
                                    type="button"
                                    class="js-abrir-edicao rounded-lg bg-red-950 px-4 py-2 text-sm font-bold text-white transition hover:bg-red-900"
                                    data-id="{{ $produto->id }}"
                                    data-nome="{{ $produto->nome }}"
                                    data-descricao="{{ $produto->descricao }}"
                                    data-preco="{{ $produto->preco }}"
                                    data-ativo="{{ $produto->ativo ? '1' : '0' }}"
                                >Editar</button>
                            @endcan
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full rounded-2xl border border-red-800 bg-red-900/40 p-10 text-center">
                    <p class="font-jersey text-4xl text-yellow-500">Ainda não há produtos</p>
                    <p class="mt-2 text-red-100">Volte em breve para conferir o cardápio.</p>
                </div>
            @endforelse
        </section>
    </main>

    @can('gerenciar-produtos')
        <div id="modal-edicao" class="fixed inset-0 z-50 hidden items-end justify-center bg-black/70 p-4 sm:items-center" aria-hidden="true">
            <section role="dialog" aria-modal="true" aria-labelledby="titulo-modal-edicao" class="w-full max-w-xl rounded-2xl bg-white p-6 text-black shadow-2xl sm:p-8">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="font-bold uppercase tracking-[0.2em] text-red-950">Administração</p>
                        <h2 id="titulo-modal-edicao" class="mt-1 font-jersey text-4xl text-red-950">Editar produto</h2>
                    </div>
                    <button id="fechar-modal-edicao" type="button" class="rounded-lg px-3 py-1 text-2xl text-gray-500 hover:bg-gray-100" aria-label="Fechar">×</button>
                </div>

                <form id="form-edicao" method="POST" class="mt-6 space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label for="edicao-nome" class="mb-1 block font-semibold text-gray-800">Nome</label>
                        <input id="edicao-nome" name="nome" required class="w-full rounded-lg border border-gray-300 px-3 py-2 outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200">
                    </div>
                    <div>
                        <label for="edicao-descricao" class="mb-1 block font-semibold text-gray-800">Descrição</label>
                        <textarea id="edicao-descricao" name="descricao" rows="4" required class="w-full rounded-lg border border-gray-300 px-3 py-2 outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200"></textarea>
                    </div>
                    <div>
                        <label for="edicao-preco" class="mb-1 block font-semibold text-gray-800">Preço</label>
                        <input id="edicao-preco" type="number" name="preco" min="0" step="0.01" required class="w-full rounded-lg border border-gray-300 px-3 py-2 outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200">
                    </div>
                    <label class="flex cursor-pointer items-center gap-3 rounded-lg bg-gray-100 p-3 font-semibold text-gray-800">
                        <input id="edicao-ativo" type="checkbox" name="ativo" value="1" class="h-4 w-4 rounded border-gray-300 text-red-950 focus:ring-yellow-500">
                        Disponibilizar este produto no cardápio
                    </label>

                    <div class="flex flex-col-reverse gap-3 pt-2 sm:flex-row sm:justify-end">
                        <button id="cancelar-edicao" type="button" class="rounded-lg px-5 py-3 font-bold text-red-950 hover:bg-red-50">Cancelar</button>
                        <button type="submit" class="rounded-lg bg-yellow-500 px-5 py-3 font-bold text-black transition hover:bg-yellow-400">Salvar alterações</button>
                    </div>
                </form>
            </section>
        </div>

        <script>
            const modalEdicao = document.querySelector('#modal-edicao');
            const formEdicao = document.querySelector('#form-edicao');
            const urlAtualizacao = @json(route('produtos.update', ['produto' => '__PRODUTO_ID__']));

            function fecharModalEdicao() {
                modalEdicao.classList.add('hidden');
                modalEdicao.classList.remove('flex');
                modalEdicao.setAttribute('aria-hidden', 'true');
            }

            document.querySelectorAll('.js-abrir-edicao').forEach((botao) => {
                botao.addEventListener('click', () => {
                    // Os data-* do botão preenchem o único formulário reutilizável do modal.
                    document.querySelector('#edicao-nome').value = botao.dataset.nome;
                    document.querySelector('#edicao-descricao').value = botao.dataset.descricao;
                    document.querySelector('#edicao-preco').value = botao.dataset.preco;
                    document.querySelector('#edicao-ativo').checked = botao.dataset.ativo === '1';

                    // O form passa a enviar PATCH /produtos/{id} do item que foi clicado.
                    formEdicao.action = urlAtualizacao.replace('__PRODUTO_ID__', botao.dataset.id);
                    modalEdicao.classList.remove('hidden');
                    modalEdicao.classList.add('flex');
                    modalEdicao.setAttribute('aria-hidden', 'false');
                    document.querySelector('#edicao-nome').focus();
                });
            });

            document.querySelector('#fechar-modal-edicao').addEventListener('click', fecharModalEdicao);
            document.querySelector('#cancelar-edicao').addEventListener('click', fecharModalEdicao);
            modalEdicao.addEventListener('click', (evento) => {
                if (evento.target === modalEdicao) fecharModalEdicao();
            });
            document.addEventListener('keydown', (evento) => {
                if (evento.key === 'Escape') fecharModalEdicao();
            });
        </script>
    @endcan
</body>
</html>
