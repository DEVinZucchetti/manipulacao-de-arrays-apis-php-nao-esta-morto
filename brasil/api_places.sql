CREATE TABLE "places" (
  "id" serial PRIMARY KEY,
  "name" varchar(150) NOT NULL,
  "contact" varchar(20),
  "opening_hours" varchar(100),
  "description" text,
  "latitude" float UNIQUE NOT NULL,
  "longitude" float UNIQUE NOT NULL,
  "created_at" timestamp with time zone default now()
);


create type status_reviews as enum('PENDENTE', 'APROVADO', 'REJEITADO');

CREATE TABLE "reviews" (
  "id" serial PRIMARY KEY,
  "place_id" integer,
  "name" text NOT NULL,
  "email" varchar(150) NOT NULL,
  "stars" decimal(2,1),
  "date" timestamp,
  "status" status_reviews DEFAULT 'PENDENTE',
  "created_at" timestamp with time zone default now(),
  FOREIGN KEY ("place_id") REFERENCES "places" ("id")
);

insert into places (
name,
contact,
opening_hours,
description,
latitude,
longitude
)
values 
(
'Praça do Drew',
'41 99999-9999',
'Apenas de Madrugada',
'.....',
-25.4896197,
-49.2155198
);

select * from places p 
select id from places

select * from places where id = 1

select * from places 
where extract (month from created_at) = extract(month from now())


delete from places where id = 1

update places 
 set description = 'Praça Drew',
 opening_hours  = 'Aberto de Madruga'
 where id = 1 

delete from reviews  where id = 1
 
 insert into reviews (
name,
email,
stars,
date, 
status 
)
values 
(
'Praça do Drew',
'Drew@adm.com',
4,
'2023-10-22', 
'APROVADO'
);


select r.id, r.name, r.email, r.starts, r.status, r.date, p.place_name 
from reviews AS r 
INNER JOIN places AS p ON r.place_id = p.id; 