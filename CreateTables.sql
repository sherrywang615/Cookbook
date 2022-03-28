DROP TABLE Users;
DROP TABLE Recipe_1;
DROP TABLE Recipe_2;
DROP TABLE Recipe_3;
DROP TABLE Requires_1;
DROP TABLE Ingredient;
DROP TABLE Has_1;

CREATE TABLE Users (
userID CHAR(30),
userName CHAR(20),
password CHAR(20),
PRIMARY KEY(userID),
UNIQUE (userName))

CREATE TABLE Recipe_1(
recipeID CHAR(30),
recipeName CHAR(20),
PRIMARY KEY (recipeID),
FOREIGN KEY (recipeName) REFERENCES Recipe_2
ON DELETE CASCADE)

CREATE TABLE Recipe_2 (
recipeName CHAR(20),
preparationTime INTEGER,
PRIMARY KEY(recipeName),
FOREIGN KEY (preparationTime) REFERENCES Recipe_3
ON DELETE CASCADE)

CREATE TABLE Recipe_3(
preparationTime INTEGER,
difficulty INTEGER,
PRIMARY KEY(preparationTime))

CREATE TABLE Requires_1 ( 
recipeID INTEGER,
ingredientID INTEGER,
PRIMARY KEY (recipeID, ingredientID),
FOREIGN KEY (ingredientID) REFERENCES Ingredient,
FOREIGN KEY (recipeID) REFERENCES Recipe
ON DELETE CASCADE)

CREATE TABLE Ingredient (
ingredientID CHAR(30), 
ingredientName CHAR(20), 
amount INTEGER, 
unit CHAR(20),
PRIMARY KEY (ingredientID))

CREATE TABLE Has_1 (
userID CHAR(30),
recipeID CHAR(30),
PRIMARY KEY (userID, recipeID),
FOREIGN KEY (userID) REFERENCES Users,
FOREIGN KEY (recipeID) REFERENCES Recipe
ON DELETE CASCADE)


INSERT INTO Users VALUES ('user_1', 'qwe', '123');
INSERT INTO Users VALUES ('user_2', 'asd', '1234');
INSERT INTO Users VALUES ('user_3', 'zxc', '12345');
INSERT INTO Users VALUES ('user_4', 'rty', '123456');
INSERT INTO Users VALUES ('user_5', 'vbn', '1234567');

INSERT INTO Recipe_1 VALUES ('rec_1', 'Bread');
INSERT INTO Recipe_1 VALUES ('rec_1', 'Pizza');
INSERT INTO Recipe_1 VALUES ('rec_1', 'Cake');
INSERT INTO Recipe_1 VALUES ('rec_1', 'Taco');
INSERT INTO Recipe_1 VALUES ('rec_1', 'Noodles');

INSERT INTO Recipe_2 VALUES ('Bread', '10');
INSERT INTO Recipe_2 VALUES ('Piazza', '30');
INSERT INTO Recipe_2 VALUES ('Cake', '50');
INSERT INTO Recipe_2 VALUES ('Taco', '20');
INSERT INTO Recipe_2 VALUES ('Noodles', '40');

INSERT INTO Recipe_3 VALUES ('10', '1');
INSERT INTO Recipe_3 VALUES ('30', '3');
INSERT INTO Recipe_3 VALUES ('50', '5');
INSERT INTO Recipe_3 VALUES ('20', '2');
INSERT INTO Recipe_3 VALUES ('40', '4');

