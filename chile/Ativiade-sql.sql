create table Places(
	id serial primary key,
	name text,
	contact text,
	opening_hour text,
	description text,
	latitude float,
	longitude float
);

create  table reviews(
	id serial primary key,
	name text,
	email text,
	stars numeric(1, 5),
	date timestamp,
	status enum,
	foreign key (id) references places(id)
);

insert into places (name, contact, opening_hours, description, latitude, longitude) values ('Shopping', '11943724480', '09:00 - 18:00', 'Lugar bom para levar a família', -23.7171083, -46.5411693)

select * from places 

select * from places where id = 1

update places set name = 'Parque' where id = 1

DELETE FROM places WHERE name = 'Parque';

insert into reviews (name, email, stars, date, status) values ('Henrique', 'rossih726@gmail.com', 5.0, '2023-10-10', 'PENDENTE')

select * from reviews where id = 1