CREATE TABLE cliente (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(60) NOT NULL,
    email VARCHAR(100) NOT NULL,
    senha_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE produto (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(60) NOT NULL,
    descricao VARCHAR(60) NOT NULL,
    preco DECIMAL(10, 2) NOT NULL,
    ativo BOOLEAN NOT NULL DEFAULT TRUE
);

CREATE TABLE endereco (
	id SERIAL primary key,
	id_cliente integer not null,
	logradouro VARCHAR(60) not null,
	numero VARCHAR(15) not null,
	bairro VARCHAR(30) not null,
	cidade VARCHAR(30) not null,
	estado VARCHAR(30) not null,
	cep VARCHAR(9) not null,
	complemento VARCHAR(100),

	constraint fk_cliente_endereco
    	foreign key (id_cliente)
    	references cliente(id)
);

create table pedido (
	id SERIAL primary key,
	id_endereco integer not null,
	id_cliente integer not null,
	status VARCHAR(30),
	valor decimal(10,2),
	criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	confirmado_em TIMESTAMP,
	enviado_em TIMESTAMP,

    constraint fk_cliente_pedido
    	foreign key (id_cliente)
    	references cliente(id),

    constraint fk_endereco_pedido
    	foreign key (id_endereco)
    	references endereco(id)
);

create table pagamento (
	id SERIAL primary key,
	id_pedido integer not null,
	metodo VARCHAR(30),
	status VARCHAR(30),
	pago_em timestamp default current_timestamp,

	constraint fk_pedido_pagamento
		foreign key (id_pedido)
		references pedido(id)

);

create table extrato (
	id SERIAL primary key,
	id_pedido integer not null,
	descricao VARCHAR(255),
	criado_em timestamp default current_timestamp,

	constraint fk_pedido_extrato
		foreign key (id_pedido)
		references pedido(id)

);

create table produto_pedido (
	id SERIAL primary key,
	id_pedido int not null,
	id_produto int not null,
	quantidade int not null,
 	preco_unitario decimal(10, 2) not null,
 	observacao VARCHAR(150),

 	constraint fk_pedido_produto_pedido
		foreign key (id_pedido)
		references pedido(id),

	constraint fk_produto_produto_pedido
		foreign key (id_produto)
		references produto(id)


);
