drop database if exists webshop;
create database webshop;
use webshop;

create table category (
    id int primary key auto_increment,
    name varchar(50) not null
);

insert into category(name) value ('Koirat');
insert into category(name) value ('Kissat');
insert into category(name) value ('Pieneläimet');
insert into category(name) value ('Tarjoukset');

-- 30.3.2021
create table product (
    id int primary key auto_increment,
    name varchar(100) not null,
    price double (10,2) not null,
    image varchar(50),
    category_id int not null,
    index category_id(category_id),
    foreign key (category_id) references category(id)
    on delete restrict
);

--rekisteröityminen
use webshop;

drop table if exists registration;
create table registration (
  	id INT primary key AUTO_INCREMENT,
    username varchar(100) NOT NULL,
    email varchar(100) NOT NULL UNIQUE,
    password varchar(100) NOT NULL,
    added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

--8.4.
ALTER TABLE product
ADD COLUMN description varchar(255),
ADD COLUMN subcategory_id INT;

CREATE TABLE customer (
    userid INT primary key,
    firstName varchar(50) NOT NULL,
    lastName varchar(50) NOT NULL,
    streetAddress varchar(50),
    zipcode varchar(10),
    city varchar(50),
    country varchar(20),
    phonenumber varchar(20),
    FOREIGN KEY (userid)
	    REFERENCES registration(id)
);

create table subcategory (
    sub_id int primary key auto_increment,
    name varchar(50) not null
);

ALTER TABLE product
ADD CONSTRAINT sub_id
FOREIGN KEY (subcategory_id)
    REFERENCES subcategory(sub_id);

-- Lisää tuotteita, kuvat, descriptionit jne. 09.04.2021 --

-- koirat
insert into product (name, price, image, category_id, description) values ('Hihna', 16.99, "hihna.png", 1, 'Remmi koirasi ulkoilutukseen.');
insert into product (name, price, image, category_id, description) values ('Ruokanappulat', 19.90, "ruokanappulat.png", 1, 'Herkullisia rehunappeja koirallesi.');
insert into product (name, price, image, category_id, description) values ('Tennispallo', 2.00, "tennispallo.png", 1, 'Loputonta leikin iloa koirallesi.');

-- kissat
insert into product (name, price, image, category_id, description) values ('Raapimapuu', 79.90, "raapimapuu.png", 2, 'Kissan unelma raapimishommiin.');
insert into product (name, price, image, category_id, description) values ('Laserosoitin', 5.90, "laserosoitin.png", 2, 'Laita kissasi jahtaamaan punaista valoa.');
insert into product (name, price, image, category_id, description) values ('Peti', 12.90, "peti.png", 2, 'Muhkea peti kissan loikoiluun.');

-- pieneläimet
insert into product (name, price, image, category_id, description) values ('Terraario', 120.00, "terraario.png", 3, 'Terraario käärmeelle tai mille keksitkään.');
insert into product (name, price, image, category_id, description) values ('Siemenet', 4.90, "siemenet.png", 3, 'Herkullisia siemeniä lintuystävillesi.');
insert into product (name, price, image, category_id, description) values ('Tekokasvi', 5.00, "tekokasvi.png", 3, 'Upea tekokasvi akvaarioon.');

-- tarjoukset
insert into product (name, price, image, category_id, description) values ('Kissanhiekka', 5.90, "kissanhiekka.png", 4, 'Mieluisat hiekat kissojen tarpeiden tekoon.');
insert into product (name, price, image, category_id, description) values ('Mega-puruluu', 2.50, "puruluu.png", 4, 'Pureskeltavaa jopa isommalle koiralle.');
insert into product (name, price, image, category_id, description) values ('Kalanruoka', 3.90, "kalanruoka.png", 4, 'Maukasta apetta kalakavereille.');