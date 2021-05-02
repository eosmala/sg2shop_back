drop database if exists webshop;
create database webshop;
use webshop;

create table category (
    category_id int primary key auto_increment,
    category_name varchar(50) not null
);

insert into category(category_name) 
value ('Koirat'), ('Kissat'), ('Pieneläimet'), ('Tarjoukset');

create table product (
    product_id int primary key auto_increment,
    product_name varchar(100) not null,
    price double (10,2) not null,
    stock_amount int,
    image varchar(50),
    category_id int not null,
    description varchar(255),
    index category_id(category_id),
    foreign key (category_id) references category(category_id)
    on delete restrict
);

insert into product (product_name, price, image, category_id, description, stock_amount) 
values 
    ('Hihna', 16.99, "hihna.png", 1, 'Remmi koirasi ulkoilutukseen.', 50),
    ('Ruokanappulat', 19.90, "ruokanappulat.png", 1, 'Herkullisia rehunappeja koirallesi.', 300),
    ('Tennispallo', 2.00, "tennispallo.png", 1, 'Loputonta leikin iloa koirallesi.', 29),
    ('Raapimapuu', 79.90, "raapimapuu.png", 2, 'Kissan unelma raapimishommiin.', 50),
    ('Laserosoitin', 5.90, "laserosoitin.png", 2, 'Laita kissasi jahtaamaan punaista valoa.', 80),
    ('Peti', 12.90, "peti.png", 2, 'Muhkea peti kissan loikoiluun.', 124),
    ('Terraario', 120.00, "terraario.png", 3, 'Terraario käärmeelle tai mille keksitkään.', 154),
    ('Siemenet', 4.90, "siemenet.png", 3, 'Herkullisia siemeniä lintuystävillesi.', 447),
    ('Tekokasvi', 5.00, "tekokasvi.png", 3, 'Upea tekokasvi akvaarioon.', 186),
    ('Kissanhiekka', 5.90, "kissanhiekka.png", 4, 'Mieluisat hiekat kissojen tarpeiden tekoon.', 458),
    ('Mega-puruluu', 2.50, "puruluu.png", 4, 'Pureskeltavaa jopa isommalle koiralle.', 475),
    ('Kalanruoka', 3.90, "kalanruoka.png", 4, 'Maukasta apetta kalakavereille.', 288);


create table customer (
  	customer_id INT primary key AUTO_INCREMENT,
    username varchar(100) NOT NULL,
    email varchar(100) NOT NULL UNIQUE,
    password varchar(100) NOT NULL,
    added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    firstName varchar(50),
    lastName varchar(50),
    streetAddress varchar(50),
    zipcode varchar(10),
    city varchar(50),
    country varchar(20),
    phonenumber varchar(20)
);

create table product_order (
    ordernumber SMALLINT primary key AUTO_INCREMENT,
    customer_id INT NOT NULL,
    orderdate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    shipping_date DATETIME,
    orderstatus varchar(10),
    foreign key (customer_id) references customer(customer_id)
);

create table order_items (
    ordernumber SMALLINT NOT NULL,
    line_number SMALLINT NOT NULL,
    product_id INT NOT NULL,
    quantity INT,
    PRIMARY KEY (ordernumber, line_number),
    foreign key (product_id) references product(product_id),
    foreign key (ordernumber) references product_order(ordernumber)
);