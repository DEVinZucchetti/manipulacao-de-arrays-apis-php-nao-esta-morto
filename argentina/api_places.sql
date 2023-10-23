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
'Praça do chafariz',
'51 99999-9999',
'Aberta 24 horas',
'..........',
-3.4443434,
1.3243434
);

select * from places p 

select * from places where id = 1

select * from places 
where extract (month from created_at) = extract(month from now())


delete from places where id = 1

update places 
 set description = 'Praça linda',
 opening_hours  = 'Aberto das 8h até as 22h'
 where id = 1
 
 insert into reviews (
name,
email,
stars,
date, 
status 
)
values 
(
'Praça do chafariz',
'gabriel@gmail.com',
3,
'2023-10-23', 
'APROVADO'
);

delete from reviews  where id = 1

select * from reviews 
INNER JOIN places on reviews.place_id = places.id;