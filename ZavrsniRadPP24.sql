drop database if exists zavrsniRadPP24;
create database zavrsniRadPP24 character set utf8;

use zavrsniRadPP24;
    
create table operater(
    sifra       int not null primary key auto_increment,
    email       varchar(50) not null,
    lozinka     varchar(60) not null,
    ime         varchar(50) not null,
    prezime     varchar(50) not null,
    uloga       varchar(10) not null
);

create table kupac(
    sifra           int not null primary key auto_increment,
    ime             varchar(50) not null,
    prezime         varchar(50) not null,
    ulica           varchar(50) not null,
    kucniBroj       varchar(5) not null,
    grad            varchar(50) not null,       
    email           varchar(50)
);

create table narudzba(
    sifra           int not null primary key auto_increment,
    kupac           int not null,
    isporuceno      boolean not null
);

create table kosarica (
    sifra       int not null primary key auto_increment,
    narudzba    int not null,
    proizvod    int not null,
    kolicina    int not null

);

create table proizvod(
    sifra           int not null primary key auto_increment,
    kategorija      varchar(50) not null,
    naziv           varchar(50) not null,
    cijena          decimal(18,2) not null
  
);


alter table narudzba add foreign key (kupac) references kupac(sifra);
alter table kosarica add foreign key (narudzba) references narudzba(sifra);
alter table kosarica add foreign key (proizvod) references proizvod(sifra);

insert into operater(email,lozinka,ime,prezime,uloga) values
('khegedus1@gmail.com','$2a$12$gcFbIND0389tUVhTMGkZYem.9rsMa733t9J9e9bZcVvZiG3PEvSla','Kristijan','Hegedus','admin');

insert into proizvod (sifra,naziv,cijena,kategorija) values
(null,'Metroid Dread',399.99,'Akcijska avantura'),
(null,'Triangle Strategy',342.99,'RPG'),
(null,'Mario Kart 3',499.99,'Utrke'),
(null,'Big Brain Academy',222.99,'Puzzle'),
(null,'Monster Hunter Rise',265.99,'Akcijski RPG'),
(null,'Super Mario Odyssey',99.99,'Avantura'),
(null,'Live A Live',499.99,'Avantura'),
(null,'Splatoon',299.99,'FPS'),
(null,'The Legend of Zelda: Skyward Sword',129.99,'Avantura'),
(null,'Donkey Kong Country Tropical Freeze',111.99,'Avantura');