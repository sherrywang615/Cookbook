DROP TABLE Users;
DROP TABLE Recipe_1;
DROP TABLE Recipe_2;
DROP TABLE Recipe_3;
DROP TABLE Requires_1;
DROP TABLE Ingredient;

CREATE TABLE Users (
userID CHAR(30),
userName CHAR(20),
userPassword CHAR(20),
PRIMARY KEY(userID),
UNIQUE (userName));

CREATE TABLE Recipe_3(
preparationTime INTEGER,
difficulty INTEGER,
PRIMARY KEY(preparationTime));

CREATE TABLE Recipe_2 (
recipeName CHAR(20),
preparationTime INTEGER,
PRIMARY KEY(recipeName),
FOREIGN KEY (preparationTime) REFERENCES Recipe_3
ON DELETE CASCADE);

CREATE TABLE Recipe_1(
recipeID CHAR(30),
recipeName CHAR(20),
PRIMARY KEY (recipeID),
FOREIGN KEY (recipeName) REFERENCES Recipe_2
ON DELETE CASCADE);

CREATE TABLE Ingredient (
ingredientID CHAR(30), 
ingredientName CHAR(20), 
amount INTEGER, 
unit CHAR(20),
PRIMARY KEY (ingredientID));

CREATE TABLE Requires_1 ( 
recipeID CHAR(30),
ingredientID CHAR(30),
PRIMARY KEY (recipeID, ingredientID),
FOREIGN KEY (recipeID) REFERENCES Recipe_1
ON DELETE CASCADE,
FOREIGN KEY (ingredientID) REFERENCES Ingredient
ON DELETE CASCADE);

INSERT INTO Users VALUES ('user_1', 'qwe', '123');
INSERT INTO Users VALUES ('user_2', 'asd', '1234');
INSERT INTO Users VALUES ('user_3', 'zxc', '12345');
INSERT INTO Users VALUES ('user_4', 'rty', '123456');
INSERT INTO Users VALUES ('user_5', 'vbn', '1234567');

INSERT INTO Recipe_3 VALUES ('10', '1');
INSERT INTO Recipe_3 VALUES ('30', '3');
INSERT INTO Recipe_3 VALUES ('50', '5');
INSERT INTO Recipe_3 VALUES ('20', '2');
INSERT INTO Recipe_3 VALUES ('40', '4');

INSERT INTO Recipe_2 VALUES ('Bread', '40');
INSERT INTO Recipe_2 VALUES ('Pizza', '30');
INSERT INTO Recipe_2 VALUES ('Mango Cake', '50');
INSERT INTO Recipe_2 VALUES ('Banana Smoothie', '10');
INSERT INTO Recipe_2 VALUES ('Noodles', '20');

INSERT INTO Recipe_1 VALUES ('rec_1', 'Bread');
INSERT INTO Recipe_1 VALUES ('rec_2', 'Pizza');
INSERT INTO Recipe_1 VALUES ('rec_3', 'Mango Cake');
INSERT INTO Recipe_1 VALUES ('rec_4', 'Banana Smoothie');
INSERT INTO Recipe_1 VALUES ('rec_5', 'Noodles');

INSERT INTO Ingredient VALUES ('ing_1', 'Flour', '400', 'g');
INSERT INTO Ingredient VALUES ('ing_2', 'Banana', '200', 'g');
INSERT INTO Ingredient VALUES ('ing_3', 'Mango', '80', 'g');
INSERT INTO Ingredient VALUES ('ing_4', 'Sugar', '50', 'g');
INSERT INTO Ingredient VALUES ('ing_5', 'Water', '400', 'ml');
INSERT INTO Ingredient VALUES ('ing_6', 'Bacon', '100', 'g');
INSERT INTO Ingredient VALUES ('ing_7', 'Tomato', '150', 'g');
INSERT INTO Ingredient VALUES ('ing_8', 'Noodles', '500', 'g');
INSERT INTO Ingredient VALUES ('ing_9', 'Milk', '200', 'ml');

INSERT INTO Requires_1 VALUES ('rec_1', 'ing_1');
INSERT INTO Requires_1 VALUES ('rec_1', 'ing_9');
INSERT INTO Requires_1 VALUES ('rec_1', 'ing_5');

INSERT INTO Requires_1 VALUES ('rec_2', 'ing_1');
INSERT INTO Requires_1 VALUES ('rec_2', 'ing_6');
INSERT INTO Requires_1 VALUES ('rec_2', 'ing_7');
INSERT INTO Requires_1 VALUES ('rec_2', 'ing_5');

INSERT INTO Requires_1 VALUES ('rec_3', 'ing_1');
INSERT INTO Requires_1 VALUES ('rec_3', 'ing_4');
INSERT INTO Requires_1 VALUES ('rec_3', 'ing_5');
INSERT INTO Requires_1 VALUES ('rec_3', 'ing_3');

INSERT INTO Requires_1 VALUES ('rec_4', 'ing_5');
INSERT INTO Requires_1 VALUES ('rec_4', 'ing_2');

INSERT INTO Requires_1 VALUES ('rec_5', 'ing_8');
INSERT INTO Requires_1 VALUES ('rec_5', 'ing_5');