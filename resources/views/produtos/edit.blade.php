<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar {{ $produto->nome }} — Baha Lanches</title>
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
        <div class="rounded-2xl bg-white p-6 text-black shadow-2xl sm:p-8">
            <p class="font-bold uppercase tracking-[0.2em] text-red-950">Administração</p>
            <h1 class="mt-1 font-jersey text-5xl text-red-950">Editar produto</h1>
            <p class="mt-2 text-gray-600">Atualize as informações de {{ $produto->nome }}.</p>

            <form action="{{ route('produtos.update', $produto) }}" method="POST" class="mt-8 space-y-5">
                @csrf
                @method('PATCH')

                <div>
                    <label for="nome" class="mb-1 block font-semibold text-gray-800">Nome</label>
                    <input id="nome" name="nome" value="{{ old('nome', $produto->nome) }}" required class="w-full rounded-lg border border-gray-300 px-3 py-2 outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200">
                    @error('nome') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="descricao" class="mb-1 block font-semibold text-gray-800">Descrição</label>
                    <textarea id="descricao" name="descricao" rows="4" required class="w-full rounded-lg border border-gray-300 px-3 py-2 outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200">{{ old('descricao', $produto->descricao) }}</textarea>
                    @error('descricao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="preco" class="mb-1 block font-semibold text-gray-800">Preço</label>
                    <input id="preco" type="number" name="preco" value="{{ old('preco', $produto->preco) }}" min="0" step="0.01" required class="w-full rounded-lg border border-gray-300 px-3 py-2 outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200">
                    @error('preco') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <label class="flex cursor-pointer items-center gap-3 rounded-lg bg-gray-100 p-3 font-semibold text-gray-800">
                    <input type="checkbox" name="ativo" value="1" @checked(old('ativo', $produto->ativo)) class="h-4 w-4 rounded border-gray-300 text-red-950 focus:ring-yellow-500">
                    Disponibilizar este produto no cardápio
                </label>

                <button type="submit" class="w-full rounded-lg bg-yellow-500 px-4 py-3 font-bold text-black transition hover:bg-yellow-400">Salvar alterações</button>
            </form>
        </div>
    </main>
</body>
</html>
