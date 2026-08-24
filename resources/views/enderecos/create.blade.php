<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Novo endereço — Baha Lanches</title>
    <link rel="icon" href="{{ asset('fav.ico') }}" sizes="any">
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-red-950 text-white">
    <header class="bg-yellow-500 px-4 py-5 shadow-lg sm:px-6">
        <div class="mx-auto flex max-w-3xl items-center justify-between gap-4">
            <a href="{{ route('home') }}" class="font-jersey text-4xl text-black sm:text-5xl">Baha Lanches</a>
            <a href="{{ route('enderecos.index') }}" class="font-bold text-black hover:underline">← Endereços</a>
        </div>
    </header>

    <main class="mx-auto max-w-3xl px-4 py-12 sm:px-6">
        <section class="rounded-2xl bg-white p-6 text-black shadow-2xl sm:p-8">
            <p class="font-bold uppercase tracking-[0.2em] text-red-950">Entrega</p>
            <h1 class="mt-1 font-jersey text-5xl text-red-950">Novo endereço</h1>
            <p class="mt-2 text-gray-600">Informe onde deseja receber seus pedidos.</p>

            <form method="POST" action="{{ route('enderecos.store') }}" class="mt-8 space-y-5">
                @csrf

                <div class="grid gap-5 sm:grid-cols-[1fr_9rem]">
                    <div>
                        <label for="logradouro" class="mb-1 block font-semibold text-gray-800">Logradouro</label>
                        <input id="logradouro" name="logradouro" value="{{ old('logradouro') }}" required autocomplete="street-address" class="w-full rounded-lg border border-gray-300 px-3 py-2 outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200">
                        @error('logradouro') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="numero" class="mb-1 block font-semibold text-gray-800">Número</label>
                        <input id="numero" name="numero" value="{{ old('numero') }}" required class="w-full rounded-lg border border-gray-300 px-3 py-2 outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200">
                        @error('numero') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="bairro" class="mb-1 block font-semibold text-gray-800">Bairro</label>
                    <input id="bairro" name="bairro" value="{{ old('bairro') }}" required class="w-full rounded-lg border border-gray-300 px-3 py-2 outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200">
                    @error('bairro') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid gap-5 sm:grid-cols-[1fr_7rem]">
                    <div>
                        <label for="cidade" class="mb-1 block font-semibold text-gray-800">Cidade</label>
                        <input id="cidade" name="cidade" value="{{ old('cidade') }}" required autocomplete="address-level2" class="w-full rounded-lg border border-gray-300 px-3 py-2 outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200">
                        @error('cidade') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="estado" class="mb-1 block font-semibold text-gray-800">Estado</label>
                        <input id="estado" name="estado" value="{{ old('estado') }}" required maxlength="2" placeholder="PR" autocomplete="address-level1" class="w-full rounded-lg border border-gray-300 px-3 py-2 uppercase outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200">
                        @error('estado') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="cep" class="mb-1 block font-semibold text-gray-800">CEP</label>
                    <input id="cep" name="cep" value="{{ old('cep') }}" required maxlength="9" placeholder="00000-000" autocomplete="postal-code" class="w-full rounded-lg border border-gray-300 px-3 py-2 outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200">
                    @error('cep') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="complemento" class="mb-1 block font-semibold text-gray-800">Complemento <span class="font-normal text-gray-500">(opcional)</span></label>
                    <input id="complemento" name="complemento" value="{{ old('complemento') }}" maxlength="100" placeholder="Apartamento, bloco, referência..." class="w-full rounded-lg border border-gray-300 px-3 py-2 outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200">
                    @error('complemento') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="w-full rounded-lg bg-yellow-500 px-4 py-3 font-bold text-black transition hover:bg-yellow-400">Salvar endereço</button>
            </form>
        </section>
    </main>
</body>
</html>
