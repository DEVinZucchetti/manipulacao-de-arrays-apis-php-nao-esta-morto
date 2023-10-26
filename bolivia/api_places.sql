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