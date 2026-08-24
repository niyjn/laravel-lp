import axios from 'axios';
import { useState } from 'react';

export default function Landing() {

    const [enviado, setEnviado] = useState(false);

    async function registrarClique() {
        try {
            await axios.post('/clique');

            setEnviado(true);

            setTimeout(() => {
                setEnviado(false);
            }, 2000);

        } catch (error) {
            console.error('Erro ao registrar clique:', error);
        }
    }

    return (
        <div className="min-h-screen bg-red-950">

            <header className="p-6 bg-yellow-500 shadow-lg">
                <div className="flex items-center justify-between max-w-6xl mx-auto">

                    <h1 className="font-jersey text-5xl text-black">
                        Baha Lanches
                    </h1>

                    <nav className="flex gap-8">
                        <a
                            href="#sobre"
                            className="font-bold text-black text-xl hover:text-red-900 transition"
                        >
                            Sobre
                        </a>

                        <a
                            href="#contato"
                            className="font-bold text-black text-xl hover:text-red-900 transition"
                        >
                            Contato
                        </a>
                    </nav>

                </div>
            </header>


            <main className="flex flex-col items-center justify-center h-[80vh] px-4">

                <h2 className="text-5xl md:text-6xl font-bold text-white text-center">
                    O melhor lanche
                </h2>

                <h2 className="font-jersey text-7xl text-yellow-500 text-center mt-2">
                    da cidade
                </h2>


                <p className="mt-6 font-bold text-white text-center max-w-xl">
                    R. Comendador Norberto, 1299 - Santa Cruz,
                    Guarapuava - PR
                </p>


                <button
                    onClick={registrarClique}
                    className="
                        mt-10
                        bg-yellow-500
                        hover:bg-yellow-400
                        shadow-xl
                        text-black
                        px-20
                        py-7
                        rounded-2xl
                        font-jersey
                        text-6xl
                        transition
                        hover:scale-105
                    "
                >
                    Pedir
                </button>


                {enviado && (
                    <p className="mt-6 text-yellow-400 font-bold text-xl">
                        Clique registrado! 🍔
                    </p>
                )}

            </main>


            <section
                id="sobre"
                className="bg-yellow-500 p-10 text-center"
            >
                <h3 className="font-jersey text-5xl">
                    Sobre nós
                </h3>

                <p className="mt-4 font-bold">
                    Lanches artesanais feitos com qualidade e sabor.
                </p>
            </section>


            <footer
                id="contato"
                className="bg-black text-white p-8 text-center"
            >
                <h3 className="font-jersey text-4xl text-yellow-500">
                    Contato
                </h3>

                <p className="mt-3">
                    WhatsApp: (42) 99999-9999
                </p>

                <p>
                    Guarapuava - PR
                </p>
            </footer>

        </div>
    );
}
