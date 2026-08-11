<div>
    <div>
        <h1>{{ $produto->nome }}</h1>

        <p>{{ $produto->descricao }}</p>

        <p><strong>Preço:</strong> R$ {{ number_format($produto->preco, 2, ',', '.') }}</p>

        <p>
            <strong>Status:</strong>
            @if ($produto->ativo)
                <span class="badge badge-success">Ativo</span>
            @else
                <span class="badge badge-secondary">Inativo</span>
            @endif
        </p>

        <div>
            <a href="{{ route('produtos.edit', $produto) }}">Editar</a>

            <form action="{{ route('produtos.destroy', $produto) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</button>
            </form>
        </div>

        <a href="{{ route('produtos.index') }}">← Voltar para a listagem</a>
    </div>
</div>
