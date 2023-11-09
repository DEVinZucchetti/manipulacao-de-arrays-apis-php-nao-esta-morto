CREATE TABLE lugares (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    endereco VARCHAR(255),
    cidade VARCHAR(100),
    estado VARCHAR(50),
    PRIMARY KEY (id)
);

CREATE TABLE reviews (
    id SERIAL PRIMARY KEY,
    lugar_id INT NOT NULL,
    usuario VARCHAR(100) NOT NULL,
    comentario TEXT,
    avaliacao INT,
    data_avaliacao DATE,
    FOREIGN KEY (lugar_id) REFERENCES lugares(id),
    PRIMARY KEY (id)
);