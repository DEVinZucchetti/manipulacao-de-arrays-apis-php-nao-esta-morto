-- exercício 1 - Criação do banco de dados - comando utilizado:
-- docker run -- name api_places -e POSTGRESQL_USERNAME=bolivia_places -e POSTGRESQL_PASSWORD=bolivia -e POSTGRESQL_DATABASE=api_places -p 5432:5432 bitnami/postgresql

-- exercício 2 - Tabela Places
CREATE TABLE places (
	id serial PRIMARY KEY,
	name varchar(150) NOT NULL,
	contact varchar(20),
	opening_hours varchar(100),
	description TEXT,
	latitude float UNIQUE NOT NULL,
	longitude float UNIQUE NOT NULL,
	created_at timestamp WITH time zone DEFAULT NOW()
);

-- exercício 3 - Tabela Reviews
CREATE TYPE status_reviews AS enum('PENDENTE', 'APROVADO', 'REJEITADO');

CREATE TABLE reviews(
	id serial PRIMARY KEY,
	place_id integer,
	name text NOT NULL,
	email varchar(150),
	stars decimal(2,1),
	date timestamp,
	status status_reviews DEFAULT 'PENDENTE',
	created_at timestamp WITH time zone DEFAULT NOW(),
	FOREIGN KEY (place_id) REFERENCES places(id)
)

-- exercício 4 - INSERT e SELECT - Places
--4.1 SQL para Inserir Dados na Tabela Places:
INSERT INTO places(
	name, 
	contact , 
	opening_hours, 
	description, 
	latitude, 
	longitude
	)
VALUES(
	'Praça do Japão',
	'(41) 3343-2936',
	'Aberto 24h por dia 7 dias por semana',
	'Linda praça com estilo japonês em Curitiba',
	-25.445928, 
	-49.287145
	);	

--4.2 SQL para Listar Todas as Informações na Tabela Places:
SELECT * FROM places

--4.3 SQL para Listar uma Informação Específica com Base no ID na Tabela Places:
SELECT * FROM places WHERE id = 1