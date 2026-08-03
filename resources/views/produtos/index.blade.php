<div>
    <h1>Produtos</h1>



    @forelse ($produtos as $produto)
        <p>{{ $produto->nome}} - R$ {{ number_format($produto->preço, 2, ",", ".") }}</p>
    @empty
        <p>Nenhum produto cadastrado.</p>
    @endforelse
</div>
