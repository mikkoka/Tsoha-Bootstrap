-- Lisää CREATE TABLE lauseet tähän tiedostoon

CREATE TABLE Ohjaaja (
    id SERIAL PRIMARY KEY,
    enimi VARCHAR(40),
    snimi VARCHAR(40) NOT NULL,
    salasana VARCHAR(100) NOT NULL,
    sposti VARCHAR(80)
);

CREATE TABLE Aihe(
    id SERIAL PRIMARY KEY,
    luotu TIMESTAMP WITHOUT TIME ZONE NOT NULL,
    luoja INTEGER REFERENCES Ohjaaja(id),
    otsikko VARCHAR(300) NOT NULL,
    kuvaus VARCHAR(3000),
    tekija_nimi VARCHAR(80),
    opnro INTEGER,
    linkki VARCHAR(400)    
);

CREATE TABLE Tapahtumatyyppi (
    id SERIAL PRIMARY KEY,
    nimi VARCHAR(90) NOT NULL
);

CREATE TABLE Edistymistapahtuma (
    aihe INTEGER REFERENCES Aihe NOT NULL,
    tyyppi INTEGER REFERENCES Tapahtumatyyppi NOT NULL,
    merkitsija INTEGER REFERENCES Ohjaaja(id) NOT NULL,
    aika TIMESTAMP WITHOUT TIME ZONE NOT NULL,
    kommentti TEXT,    
    PRIMARY KEY(aihe, tyyppi, aika)
);

CREATE TABLE Tutkimusala(
    id SERIAL PRIMARY KEY,
    nimi VARCHAR(90) NOT NULL
);

CREATE TABLE Aiheen_luokitus(
    aihe INTEGER REFERENCES Aihe(id) NOT NULL,
    ala INTEGER REFERENCES Tutkimusala(id) NOT NULL,
    PRIMARY KEY(aihe, ala)
);


CREATE TABLE Aiheen_ohjaaja (
    aihe INTEGER REFERENCES Aihe(id) NOT NULL,
    ohjaaja INTEGER REFERENCES Ohjaaja(id) NOT NULL, 
    PRIMARY KEY(aihe, ohjaaja)
);
