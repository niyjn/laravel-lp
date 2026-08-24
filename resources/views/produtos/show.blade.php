<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $produto->nome }} — Baha Lanches</title>
    <link rel="icon" href="{{ asset('fav.ico') }}" sizes="any">
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-red-950 text-white">
    <header class="bg-yellow-500 px-4 py-5 shadow-lg sm:px-6">
        <div class="mx-auto flex max-w-3xl items-center justify-between gap-4">
            <a href="{{ route('home') }}" class="font-jersey text-4xl text-black sm:text-5xl">Baha Lanches</a>
            <a href="{{ route('produtos.index') }}" class="font-bold text-black hover:underline">← Produtos</a>
        </div>
    </header>

    <main class="mx-auto max-w-3xl px-4 py-12 sm:px-6">
        <article class="overflow-hidden rounded-2xl bg-white text-black shadow-2xl">
            <div class="flex h-48 items-center justify-center bg-gradient-to-br from-yellow-300 to-orange-500 text-8xl">🍔</div>
            <div class="p-6 sm:p-8">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <p class="font-bold uppercase tracking-[0.2em] text-yellow-600">Cardápio</p>
                        <h1 class="mt-1 font-jersey text-5xl text-red-950 sm:text-6xl">{{ $produto->nome }}</h1>
                    </div>
                    <span class="rounded-full px-3 py-1 text-xs font-bold uppercase tracking-wide {{ $produto->ativo ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-700' }}">
                        {{ $produto->ativo ? 'Ativo' : 'Inativo' }}
                    </span>
                </div>

                <p class="mt-6 text-gray-700">{{ $produto->descricao }}</p>
                <p class="mt-6 font-jersey text-4xl text-red-950">R$ {{ number_format($produto->preco, 2, ',', '.') }}</p>

                @can('gerenciar-produtos')
                    <div class="mt-8 flex flex-wrap gap-3 border-t border-gray-200 pt-6">
                        <a href="{{ route('produtos.edit', $produto) }}" class="rounded-lg bg-red-950 px-4 py-2 font-bold text-white transition hover:bg-red-900">Editar produto</a>
                        <form action="{{ route('produtos.destroy', $produto) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Tem certeza que deseja excluir?')" class="rounded-lg border-2 border-red-800 px-4 py-2 font-bold text-red-800 transition hover:bg-red-50">Excluir produto</button>
                        </form>
                    </div>
                @endcan
            </div>
        </article>
    </main>
</body>
</html>
