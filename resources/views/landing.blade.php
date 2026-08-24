 <!DOCTYPE html>
  <html lang="pt-BR">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Baha Lanches</title>
      <link rel="icon" href="{{ asset('fav.ico') }}" sizes="any">

      @vite('resources/css/app.css')
  </head>

  <body class="bg-red-950 text-white">
      <header class="bg-yellow-500 p-6 shadow-lg">
          <div class="mx-auto flex max-w-6xl items-center justify-between">
              <a href="{{ route('home') }}" class="font-jersey text-5xl text-black">
                  Baha Lanches
              </a>

              <nav class="flex gap-8">
                  @guest
                       <a href="{{ route('login') }}" class="rounded-lg bg-red-950 px-4 py-2 font-bold text-white">
                           Entrar
                       </a>

                       <a
                           href="{{ route('register') }}"
                           class="rounded-lg bg-red-950 px-4 py-2 font-bold text-white"
                       >
                           Criar conta
                       </a>
                   @endguest

                   @auth
                       <a href="{{ route('perfil') }}" class="rounded-lg bg-red-950 px-4 py-2 font-bold text-white" >
                           Meu perfil
                       </a>

                       <a href="{{ route('pedidos.index') }}" class="rounded-lg bg-red-950 px-4 py-2 font-bold text-white">
                           Meus pedidos
                       </a>
                   @endauth

                   @can('gerenciar-produtos')
                       <a href="{{ route('admin.pedidos.index') }}" class="rounded-lg bg-red-950 px-4 py-2 font-bold text-white" >
                           Pedidos admin
                       </a>

                       <a href="{{ route('produtos.index') }}" class="rounded-lg bg-red-950 px-4 py-2 font-bold text-white" >
                           Produtos admin
                       </a>
                   @endcan


                  <button
                       id="botao-carrinho"
                       type="button"
                       onclick="abrirCarrinho()"
                       disabled
                       class="rounded-lg bg-red-950 px-4 py-2 font-bold text-white disabled:cursor-not-allowed disabled:opacity-50"
                   >
                       Carrinho (<span id="quantidade-carrinho">0</span>)
                   </button>

              </nav>
          </div>
      </header>

      <main class="flex h-[80vh] flex-col items-center justify-center px-4">
          <h1 class="text-center text-5xl font-bold md:text-6xl">
              O melhor lanche
          </h1>

          <p class="mt-2 text-center font-jersey text-7xl text-yellow-500">
              da cidade
          </p>

          <p class="mt-6 max-w-xl text-center font-bold">
              R. Profa. Leonidia, 1226 - Centro,<br>
              Guarapuava - PR, 85010-230
          </p>

          <a
              href="#produtos"
              class="mt-10 rounded-2xl bg-yellow-500 px-20 py-7 font-jersey text-6xl text-black shadow-xl transition hover:scale-105 hover:bg-yellow-400"
          >
              Pedir
          </a>


      </main>

      <section id="produtos" class="bg-red-950 px-4 py-16 sm:px-6">
            <div class="mx-auto max-w-6xl">
                <h2 class="text-center font-jersey text-6xl text-yellow-500">
                    Produtos
                </h2>

                <p class="mt-3 text-center text-white">
                    Escolha o seu lanche favorito.
                </p>

                <div class="mt-10 grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4">
                    @forelse ($produtos as $produto)
                        <article class="flex aspect-square flex-col overflow-hidden rounded-2xl bg-white text-black shadow-xl">
                            <div class="flex min-h-0 flex-1 items-center justify-center bg-gradient-to-br from-yellow-300 to-orange-500">
                                {{-- Quando houver imagem_url no banco, esta parte exibirá a foto. --}}
                                @if (! empty($produto->imagem_url))
                                    <img
                                        src="{{ $produto->imagem_url }}"
                                        alt="{{ $produto->nome }}"
                                        class="h-full w-full object-cover"
                                    >
                                @else
                                    <span class="text-6xl">🍔</span>
                                @endif
                            </div>

                            <div class="space-y-2 p-3 sm:p-4">
                                <h3 class="truncate font-jersey text-2xl text-red-950 sm:text-3xl">
                                    {{ $produto->nome }}
                                </h3>

                                <p class="font-bold text-red-950">
                                    R$ {{ number_format($produto->preco, 2, ',', '.') }}
                                </p>

                                <button
                                      type="button"
                                      class="js-adicionar block w-full rounded-lg bg-yellow-500 px-3 py-2 text-center text-sm font-bold text-black transition hover:bg-yellow-400"
                                      data-id="{{ $produto->id }}"
                                      data-nome="{{ $produto->nome }}"
                                      data-preco="{{ $produto->preco }}"
                                  >
                                      Quero pedir
                                  </button>

                            </div>
                        </article>
                    @empty
                        <p class="col-span-full text-center text-white">
                            Nenhum produto disponível no momento.
                        </p>
                    @endforelse
                </div>
            </div>
        </section>


      <section id="sobre" class="bg-yellow-500 p-10 text-center text-black">
          <h2 class="font-jersey text-5xl">Sobre nós</h2>

          <p class="mt-4 font-bold">
              Lanches artesanais feitos com qualidade e sabor.
          </p>
      </section>

      <footer id="contato" class="bg-black p-8 text-center">
          <h2 class="font-jersey text-4xl text-yellow-500">Contato</h2>

          <p class="mt-3">WhatsApp: (42) 99999-9999</p>
          <p>Guarapuava - PR</p>
      </footer>


      <div
          id="modal-carrinho"
          class="fixed inset-0 z-50 hidden items-end justify-center bg-black/60 p-4 sm:items-center"
      >
          <section class="w-full max-w-lg rounded-2xl bg-white p-6 text-black shadow-2xl">
              <div class="flex items-center justify-between">
                  <h2 class="font-jersey text-4xl text-red-950">Seu carrinho</h2>

                  <button type="button" onclick="fecharCarrinho()">×</button>
              </div>

              <div id="itens-carrinho" class="mt-6 space-y-4"></div>

              <div class="mt-6 flex justify-between border-t pt-4">
                  <span class="font-bold">Total</span>
                  <strong id="total-carrinho">R$ 0,00</strong>
              </div>

              <button
                  type="button"
                  onclick="irParaCheckout()"
                  class="mt-6 w-full rounded-lg bg-yellow-500 px-4 py-3 font-bold text-black"
              >
                  Continuar para checkout
              </button>
          </section>
      </div>


      <script>
      const chaveCarrinho = 'baha-carrinho';

        const carrinhoSalvo = JSON.parse(
            localStorage.getItem(chaveCarrinho) || '[]',
        );

        const carrinho = new Map(carrinhoSalvo);

        function salvarCarrinho() {
            localStorage.setItem(
                chaveCarrinho,
                JSON.stringify([...carrinho.entries()]),
            );
        }


          function formatarPreco(valor) {
              return valor.toLocaleString('pt-BR', {
                  style: 'currency',
                  currency: 'BRL',
              });
          }

          function atualizarQuantidadeCarrinho() {
              const quantidade = [...carrinho.values()].reduce(
                  (total, item) => total + item.quantidade,
                  0,
              );

              document.querySelector('#quantidade-carrinho').textContent = quantidade;
              document.querySelector('#botao-carrinho').disabled = quantidade === 0;
          }

          document.querySelectorAll('.js-adicionar').forEach((botao) => {
              botao.addEventListener('click', () => {
                  const id = botao.dataset.id;
                  const nome = botao.dataset.nome;
                  const preco = Number(botao.dataset.preco);

                  if (carrinho.has(id)) {
                      carrinho.get(id).quantidade++;
                  } else {
                      carrinho.set(id, { nome, preco, quantidade: 1 });
                  }
                  salvarCarrinho();
                  atualizarQuantidadeCarrinho();
              });
          });

          function abrirCarrinho() {
              if (carrinho.size === 0) {
                  alert('Seu carrinho está vazio.');
                  return;
              }

              renderizarCarrinho();

              document.querySelector('#modal-carrinho').classList.remove('hidden');
              document.querySelector('#modal-carrinho').classList.add('flex');
          }

          function fecharCarrinho() {
              document.querySelector('#modal-carrinho').classList.add('hidden');
              document.querySelector('#modal-carrinho').classList.remove('flex');
          }

          function alterarQuantidade(id, variacao) {
              const item = carrinho.get(id);

              item.quantidade += variacao;

              if (item.quantidade <= 0) {
                  carrinho.delete(id);
              }
              salvarCarrinho();
              atualizarQuantidadeCarrinho();
              renderizarCarrinho();

              if (carrinho.size === 0) {
                  fecharCarrinho();
              }
          }

          function renderizarCarrinho() {
              const itens = [...carrinho.entries()];
              const lista = document.querySelector('#itens-carrinho');

              lista.innerHTML = itens.map(([id, item]) => `
                  <div class="flex items-center justify-between gap-4">
                      <div>
                          <p class="font-bold">${item.nome}</p>
                          <p class="text-sm text-gray-600">${formatarPreco(item.preco)} cada</p>
                      </div>

                      <div class="flex items-center gap-3">
                          <button type="button" onclick="alterarQuantidade('${id}', -1)">−</button>

                          <span>${item.quantidade}</span>

                          <button type="button" onclick="alterarQuantidade('${id}', 1)">+</button>
                      </div>
                  </div>
              `).join('');

              const total = itens.reduce(
                  (soma, [, item]) => soma + item.preco * item.quantidade,
                  0,
              );

              document.querySelector('#total-carrinho').textContent = formatarPreco(total);
          }

          function irParaCheckout() {
              if (carrinho.size === 0) {
                  alert('Seu carrinho está vazio.');
                  return;
              }

              // Se não houver sessão, o middleware auth levará ao login.
              // O carrinho continua salvo no localStorage durante esse fluxo.
              window.location.href = @json(route('checkout'));
          }
      </script>

  </body>
  </html>
